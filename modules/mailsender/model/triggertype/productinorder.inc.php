<?php
namespace MailSender\Model\TriggerType;
use \RS\Orm\Type;

/**
* Триггер - Пользователь, просматривавший товары в определенный промежуток времени
*/
class ProductInOrder extends AbstractType
{
    /**
    * Возвращает название триггера
    * 
    * @return string
    */
    function getTitle()
    {
        return t('Пользователь, у которого в заказе есть определённый товар');
    }
    
    /**
    * Возвращает описание триггера
    * 
    * @return string
    */
    function getDescription()
    {
        return t('Триггер срабатывает, в момент, когда пользователь оформляет заказ, в составе которого есть товар из указанного списка');
    }
    
    /**
    * Возвращает объект с настройками типа триггера
    * 
    * @return \RS\Orm\FormObject | null
    */
    function getSettingsObject()
    {
        return new \RS\Orm\FormObject(new \RS\Orm\PropertyIterator([
            'products' => new Type\ArrayList([
                'runtime' => false,
                'description' => t('Товары'),
                'dialog' => new \Catalog\Model\ProductDialog('settings[products]', false),
                'template' => '%mailsender%/form/trigger/type/product_view_products.tpl',
                'checker' => ['ChkEmpty', t('Не указаны товары')]
            ]),
            'date_from' => new Type\Datetime([
                'description' => t('Дата начала'),
                'hint' => t('Тригер сработает только на заказы, которые оформлены после указанной даты'),
                'checker' => ['ChkEmpty', t('Обязательное поле')]
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
        $q = \RS\Orm\Request::make()
            ->select('O.id as order_id, U.id as user_id')
            ->from(new \Users\Model\Orm\User(), 'U')
            ->join(new \Shop\Model\Orm\Order(), 'U.id = O.user_id', 'O')
            ->join(new \Shop\Model\Orm\OrderItem(), 'O.id = I.order_id', 'I')
            ->join(new \Catalog\Model\Orm\Xdir(), 'I.entity_id = X.product_id', 'X')
            ->where('O.dateof >= "#date_from"', ['date_from' => $this->settings['date_from']])
            ->where(['I.type' => 'product'])
            ->openWGroup();
            if (!empty($this->settings['products']['product'])) {
                $q->whereIn('I.entity_id', $this->settings['products']['product']);
            }
            if (!empty($this->settings['products']['group'])) {
                $q->whereIn('X.dir_id', $this->settings['products']['group'], 'or');
            }
            $q->closeWGroup()
            ->groupby('O.id');
            
        $keys = $q->exec()->fetchSelected('order_id', 'user_id');
        $users = \RS\Orm\Request::make()
            ->from(new \Users\Model\Orm\User())
            ->whereIn('id', $keys)
            ->objects(null, 'id');
        
        foreach($keys as $key=>$item) {
            $result[] = new \MailSender\Model\TriggerData($users[$item], [], "order_id=$key");
        }
        
        return $result;
    }
}