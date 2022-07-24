<?php
namespace Fsinzak\Model;

use Affiliate\Model\Orm\Affiliate;
use RS\Application\Auth as AppAuth;
use RS\Exception;
use RS\Helper\Tools as HelperTools;
use RS\Module\AbstractModel\EntityList;
use RS\Orm\Request as OrmRequest;
use Users\Model\Orm\User;

class OrderApi extends EntityList
{
    protected static $instance;
    protected $config;
    protected $key_errors = [];
    protected $order_allow_fields = [ //массив полей заказа, значение из которых можно записать в заказ
        'recipient_surname',
        'recipient_name',
        'recipient_midname',
        'recipient_year'
    ];
    protected $order_user_allow_fields = [ //массив полей пользователя, значение из которых нужно проверерить
        'user_phone',
        'user_fio',
        'user_email',
    ];

    function __construct()
    {
        parent::__construct(new \Shop\Model\Orm\Order(), array(
            'multisite' => true,
            'defaultOrder' => 'dateof DESC'
        ));
        $this->config = \RS\Config\Loader::byModule($this);
    }

    public static function getInstance($key = 'default')
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Проверяет заказы, которые нужно поменять в статус Не оплачен
     *
     * @param integer $site_id - id сайта
     */
    function checkOrdersWaitToPay($site_id)
    {
        $orders = \RS\Orm\Request::make()
                        ->from(new \Shop\Model\Orm\Order())
                        ->where([
                            'site_id' => $site_id,
                            'status' => $this->config['wait_pay_status']
                        ])
//                        ->where("dateof_payed <= '$date_check'")
                        ->objects();

        foreach ($orders as $order)
        {
            /**
             * @var \Shop\Model\Orm\Order $order
             */
            $affiliate_id = $order->getOrderAffiliateId();
            $affiliate = new Affiliate($affiliate_id);
            $time_to_not_payed_status = intval($affiliate->getTimeToNotPaid());
            $interval = time() - strtotime($order['dateof']); // сколько времени в секундах прошло после оформления заказа
            if($interval > $time_to_not_payed_status * 60){
                $order['status'] = $this->config['not_payed_status'];
                $order->update();

                //Создадим задачу в CRM, если менеджер есть
                if ($affiliate->getManagerForNotPaid()){
                    $this->createCRMEventForNotPayed($order, $affiliate->getManagerForNotPaid(), $time_to_not_payed_status);
                }
            }
        }
    }

    /**
     * Создаёт задачу для не оплаченного заказа для менеджера
     *
     * @param \Shop\Model\Orm\Order $order - объект заказа
     * @param \Users\Model\Orm\User $manager - менеджер для задачи
     */
    function createCRMEventForNotPayed($order, $manager, $time)
    {
        $crm_event = new \CRM\Model\Orm\Task();
        $crm_event['task_num'] = HelperTools::generatePassword(8, range('0', '9'));
        $crm_event['title'] = t('Обработать не оплаченный заказ №%0', [
            $order['order_num']
        ]);
        $links = [];
        $description = t('Обработать не оплаченный заказ №%0. 
                        Прошло более %1 часов с момента создания заказа и он перееден в статус Не оплачен. 
                        Необходимо связаться с пользователем. ', [
            $order['order_num'],
            $time
        ]);
        $user = $order->getUser();
        if ($user['id']){
            $links['crm-linktypeuser'][] = $user['id'];
        }
        $description .= t("Данные для связи с %0 \nТелефон: %1 \nE-mail: %2", [
            $user->getFio(),
            $user['phone'],
            $user['e_mail']
        ]);
        $crm_event['description'] = $description;
        $links['crm-linktypeorder'][] = $order['id'];
        $crm_event['links'] = $links;
        $crm_event['creator_user_id'] = 1;
        $crm_event['status_id']       = 1;
        $crm_event['expiration_notice_time'] = 300;
        $crm_event['date_of_create']  = date('Y-m-d H:i:s');
        $crm_event['implementer_user_id'] = $manager;
        $crm_event->insert();
    }

    /**
     * Проверяет заказы, которые находятся в статусе В обработке более определенного времени
     *
     * @param integer $site_id - id сайта
     */
    function checkOrdersProcessToColony($site_id)
    {
        $orders = \RS\Orm\Request::make()
            ->from(new \Shop\Model\Orm\Order())
            ->where([
                'site_id' => $site_id,
                'status' => $this->config['in_institution_status'],
                'create_crm_to_check_status_process' => 0
            ])
//                        ->where("dateof_payed <= '$date_check'")
            ->objects();

        foreach ($orders as $order)
        {
            /**
             * @var \Shop\Model\Orm\Order $order
             */
            $affiliate_id = $order->getOrderAffiliateId();
            $affiliate = new Affiliate($affiliate_id);
            $time_check_status_process = intval($affiliate->getTimeToCheckStatusProcess());
            $interval = time() - strtotime($order['change_status_process']); // сколько времени в секундах прошло после перевода заказа в статус Оплачен. В обработке

            if($interval > $time_check_status_process * 24 * 60){
//                $order['status'] = $this->config['not_payed_status'];
//                $order->update();

                //Создадим задачу в CRM, если менеджер есть
                if ($affiliate->getManagerToCheckOrderProcessStatus()){
                    $this->createCRMEventForProcessStatus($order, $affiliate->getManagerToCheckOrderProcessStatus(), $time_check_status_process);
                    $order['create_crm_to_check_status_process'] = 1;
                    $order->update();
                }
            }
        }
    }

    /**
     * Создаёт задачу для заказа Передан в учреждение для менеджера
     *
     * @param \Shop\Model\Orm\Order $order - объект заказа
     * @param \Users\Model\Orm\User $manager - менеджер для задачи
     * @param int $time - параметр филиала (время после котороо должна создаться задача)
     */
    function createCRMEventForProcessStatus($order, $manager, $time)
    {
        $crm_event = new \CRM\Model\Orm\Task();
        $crm_event['task_num'] = HelperTools::generatePassword(8, range('0', '9'));
        $crm_event['title'] = t('Обработать заказ №%0. Связаться с сотрудником магазина', [
            $order['order_num']
        ]);
        $links = [];
        $description = t('Обработать заказ №%0. 
                        Прошло более %1 дней с момента перевода в статус В обработке на учреждении. 
                        Необходимо связаться с сотрудником магазина для уточнения информации и перевода заказа в статус Выполнен. ', [
            $order['order_num'],
            $time
        ]);
        $user = $order->getUser();
        if ($user['id']){
            $links['crm-linktypeuser'][] = $user['id'];
        }
//        $description .= t("Данные для связи с %0 \nТелефон: %1 \nE-mail: %2", [
//            $user->getFio(),
//            $user['phone'],
//            $user['e_mail']
//        ]);
        $crm_event['description'] = $description;
        $links['crm-linktypeorder'][] = $order['id'];
        $crm_event['links'] = $links;
        $crm_event['creator_user_id'] = 1;
        $crm_event['status_id']       = 1;
        $crm_event['expiration_notice_time'] = 300;
        $crm_event['date_of_create']  = date('Y-m-d H:i:s');
        $crm_event['implementer_user_id'] = $manager;
        $crm_event->insert();
    }
}
