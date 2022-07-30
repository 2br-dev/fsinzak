<?php
namespace MailSender\Model\TriggerType;
use \RS\Orm\Type;

/**
* Триггер - пользователь, не заходивший на сайт более N дней
*/
class ChangeStatus extends AbstractType
{
    /**
    * Возвращает название триггера
    * 
    * @return string
    */
    function getTitle()
    {
        return t('Прошло N дней после смены статуса заказа в статус S');
    }
    
    /**
    * Возвращает описание триггера
    * 
    * @return string
    */
    function getDescription()
    {
        return t('Триггер срабатывает, в момент, когда проходит N дней, со дня последней смены статуса S');
    }
    
    /**
    * Возвращает объект с настройками типа триггера
    * 
    * @return \RS\Orm\FormObject | null
    */
    function getSettingsObject()
    {
        return new \RS\Orm\FormObject(new \RS\Orm\PropertyIterator([
            'days_from' => new Type\Integer([
                'description' => t('N, количество дней'),
                'default' => 30,
                'checker' => ['ChkEmpty', t('Обязательное поле')]
            ]),
            'status' => new Type\Integer([
                'description' => t('S, статус'),
                'list' => [['\Shop\Model\UserStatusApi', 'staticSelectList']],
            ]),
            'products' => new Type\ArrayList([
                'runtime' => false,
                'description' => t('Товары'),
                'dialog' => new \Catalog\Model\ProductDialog('settings[products]', false),
                'template' => '%mailsender%/form/trigger/type/product_view_products.tpl',
            ]),
        ]));
    }

    
    /**
    * Проверяет, должен ли сработать триггер сейчас.
    * Если должен, то вернется массив объектов \MailSender\Model\triggerData
    * 
    * @return \MailSender\Model\triggerData[]
    */
    function match()
    {
        $result = [];
        $date_from = strtotime('-'.$this->settings['days_from'].' day', time());
        $status = $this->settings['status'];
        $products_ids = $this->settings['products']['product'] ?? [];
        $groups_ids = $this->settings['products']['group'] ?? [];

        $q = \RS\Orm\Request::make()
            ->select('O.id AS order_id, U.id AS user_id')
            ->from(new \Users\Model\Orm\User(), 'U')
            ->join(new \Shop\Model\Orm\Order(), 'U.id = O.user_id', 'O')
            ->join(new \Shop\Model\Orm\OrderItem(), 'O.id = I.order_id', 'I')
            ->join(new \Catalog\Model\Orm\Xdir(), 'I.entity_id = X.product_id', 'X')
            ->where([
                'O.site_id' => $this->trigger['site_id'],
                'O.status' => $status,
            ])
            ->where("'#date_from' > O.dateofupdate", [
                'date_from' => date('Y-m-d H:i:s', $date_from),
            ])
            ->where(['I.type' => 'product']);

            if (!empty($products_ids)) {
                $q->openWGroup();
                $q->whereIn('I.entity_id', $products_ids);
                $q->closeWGroup();
            }
            if (!empty($groups_ids)) {
                $q->openWGroup();
                $q->whereIn('X.dir_id', $groups_ids, 'or');
                $q->closeWGroup();
            }
            
            $q->groupby('O.id');
            $keys = $q->exec()->fetchSelected('order_id', 'user_id');

            if ($keys) {
                $users = \RS\Orm\Request::make()
                    ->from(new \Users\Model\Orm\User())
                    ->whereIn('id', $keys)
                    ->objects(null, 'id');

                foreach($keys as $key=>$item) {
                    $result[] = new \MailSender\Model\TriggerData($users[$item], [
                        'status_id' => $status,
                        'order_id' => $key,
                        'products_ids' => $products_ids,
                        'groups_ids' => $groups_ids,
                    ], 'user_id-'. $users[$item]->id . ':order_id-' .$key);
                }
            }

        return $result;
    }
}
