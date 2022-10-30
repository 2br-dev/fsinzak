<?php

namespace fsinzak\Config;

use RS\Module\AbstractModel\TreeList\AbstractTreeListIterator;
use RS\Orm\ConfigObject;
use RS\Orm\Type;
use RS\Orm\Type\Integer;

/**
 * Класс конфигурации модуля
 */
class File extends ConfigObject
{
    public function _init()
    {
        parent::_init()->append([
            t('Действия после оформления заказа'),
                'wait_pay_status' => new Integer(array(
                    'description' => t('Статус - Ожидание оплаты'),
                    'list' => [['\Shop\Model\UserStatusApi', 'staticSelectList'], [0 => t('Не назначено')]]
                )),
                'not_payed_status' => new Integer(array(
                    'description' => t('Статус - Не оплачено'),
                    'list' => [['\Shop\Model\UserStatusApi', 'staticSelectList'], [0 => t('Не назначено')]]
                )),
            t('Действия после оплаты заказа'),
                'in_institution_status' => new Type\Integer(array(
                    'description' => t('Статус - В обработке в учреждении'),
                    'list' => [['\Shop\Model\UserStatusApi', 'staticSelectList'], [0 => t('Не назначено')]]
                )),
                'end_status' => new Type\Integer(array(
                    'description' => t('Статус - Выполнен'),
                    'list' => [['\Shop\Model\UserStatusApi', 'staticSelectList'], [0 => t('Не назначено')]]
                )),
            t('Оформление заказа'),
                'product_commission' => new Type\Integer([
                    'description' => t('Комиссия за оплату заказа'),
                    'list' => [['\Catalog\Model\Api', 'staticSelectList']]
                ]),
                'status_to_send_pdf' => new Type\Integer([
                    'description' => t('статус заказа для отправки pdf'),
                    'list' => [['\Shop\Model\Userstatusapi', 'staticSelectList']]
                ]),
            t('Главная страница'),
                'dirs_to_main_page' => new Type\ArrayList([
                    'runtime' => false,
                    'description' => t('Список категорий на главную страницу'),
                    'hint' => t('Какие категории выводить на главной странице'),
                    'tree' => [['\Catalog\Model\DirApi', 'staticTreeList']],
                    'attr' => [[
                        AbstractTreeListIterator::ATTRIBUTE_MULTIPLE => true,
                    ]],
                    'visible' => true
                ]),
        ]);
    }

    /**
     * Получаем родителя выбранного филиала
     * @param $affiliate_parent_id
     * @return \Affiliate\Model\Orm\Affiliate
     */
    public function getParentAffiliate($affiliate_parent_id)
    {
        $parent = new \Affiliate\Model\Orm\Affiliate($affiliate_parent_id);
        return $parent;
    }

    public function checkSelectRecipient()
    {

    }

    /**
     * Возвращает существующие ограничения. Первоначално проверяются ограничения Получателя. Если их нет, то возвращаются ограничения филиала
     * @return array|bool
     */
    public function getLimits()
    {
        /**
         * @var \Fsinzak\Model\Orm\Recipients $recipient
         */
        $recipient = new \Fsinzak\Model\Orm\Recipients($_COOKIE['fsinzak-selected-recipient']);
        $recipient_limits = $recipient->getRecipientLimits();
        $limits = [];
        $limit = [];
        /**
         * @var \Affiliate\Model\Orm\Affiliate $affiliate
         */
        $affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
        $affiliate_limits = $affiliate->getAffiliateLimits();

        if(empty($recipient_limits)){
            $limits = $affiliate_limits;
        }else{
            if(!empty($recipient->getRecipientLimitByType('limit_sum'))){
                $limit['type'] = 'limit_sum';
                $limit['value'] = $recipient->getRecipientLimitByType('limit_sum');
                $limits[] = $limit;
            }else{
                $limit['type'] = 'limit_sum';
                $limit['value'] = $affiliate->getAffiliateLimitByType('limit_sum');
                $limits[] = $limit;
            }
            if(!empty($recipient->getRecipientLimitByType('limit_weight'))){
                $limit['type'] = 'limit_weight';
                $limit['value'] = $recipient->getRecipientLimitByType('limit_weight');
                $limits[] = $limit;
            }else{
                $limit['type'] = 'limit_weight';
                $limit['value'] = $affiliate->getAffiliateLimitByType('limit_weight');
                $limits[] = $limit;
            }
            if(!empty($recipient->getRecipientLimitByType('periodicity'))){
                $limit['type'] = 'limit_weight';
                $limit['value'] = $recipient->getRecipientLimitByType('periodicity');
                $limit['value_month'] = $recipient['periodicity_month'];
                $limits[] = $limit;
            }else{
                $limit['type'] = 'limit_weight';
                $limit['value'] = $affiliate->getRecipientLimitByType('periodicity');
                $limit['value_month'] = $affiliate['periodicity_month'];
                $limits[] = $limit;
            }
        }
        return $limits;
    }

    /**
     * Возвращает значение ограничения по его типу. сначала проверяет у получателя потом у учреждения.
     * @param string $type
     * @return int
     */
    public function getLimitByType(string $type)
    {
        $current_recipient = \Fsinzak\Model\RecipientsApi::getCurrentRecipient();
        if($current_recipient){
            $limit = $current_recipient->getRecipientLimitByType($type);
            if(!$limit){
                $current_affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
                $limit = $current_affiliate->getAffiliateLimitByType($type);
            }
            return $limit;
        }
        return false;
    }

    public function getDirsToMainPage()
    {
        return $this['dirs_to_main_page'];
    }

    public function getPeriodicity()
    {
        /**
         * @var \Fsinzak\Model\Orm\Recipients $recipient
         */
        $recipient = new \Fsinzak\Model\Orm\Recipients($_COOKIE['fsinzak-selected-recipient']);
        if(!empty($recipient->getPeriodicity())){
            return $recipient->getPeriodicity();
        }
        /**
         * @var \Affiliate\Model\Orm\Affiliate $affiliate
         */
        $affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
        return $affiliate->getAffiliatePeriodicity();
    }

    /**
     * Провереяте можно ли сделать заказа Для получателя на ограничение периодичности
     * @return bool
     */
    public function canOrderDo()
    {
        $periodicity = $this->getPeriodicity();
        $recipient = new \Fsinzak\Model\Orm\Recipients($_COOKIE['fsinzak-selected-recipient']);
        $order_count = $recipient->getRecipientCountOrderForPeriod();
        if($periodicity['value'] > $order_count){
            return true;
        }
        return false;
    }
}
