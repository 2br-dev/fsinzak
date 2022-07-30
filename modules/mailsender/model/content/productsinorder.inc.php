<?php
namespace MailSender\Model\Content;
use \MailSender\Model,
    \RS\Orm\Type;

/**
* Класс позволяет использовать в письмах список товаров, которые пользователь не купил
*/
class ProductsInOrder extends AbstractContent
{
    /**
    * Возвращает название генератора контента
    * 
    * @return string
    */
    function getTitle()
    {
        return t('Товары, которые были в заказе');
    }
    
    /**
    * Возвращает описание генератора контента
    * 
    * @return string
    */
    function getDescription()
    {
        return t('Предоставляет возможность вставлять в письмо таблицу со списком товаров, на которые пользователь оформил заказ. Список товаров формируется только для триггера - Прошло N дней после смены статуса заказа в статус S');
    }
    
    /**
    * Возвращает настройки генератора контента
    * 
    * @return \RS\Orm\FormObject
    */
    function getSettingsObject()
    {
        return new \RS\Orm\FormObject(new \RS\Orm\PropertyIterator([
            'template' => new Type\Template([
                'description' => t('Шаблон'),
                'default' => '%mailsender%/content/productsinorder/productsinorder.tpl'
            ]),
            'limit' => new Type\Integer([
                'description' => t('Максимальное количество не купленных товаров'),
                'default' => 10
            ])
        ]));
    }
    
    /**
    * Возвращает переменные для замены, которые которые можно будет использовать в шаблонах
    * 
    * @param \MailSender\Model\Orm\MailTemplate $template
    * @param \MailSender\Model\Orm\MailRecipient $recipient
    * @return array
    */
    function getReplaceVars(Model\Orm\MailRecipient $recipient)
    {
        $extra = @unserialize($recipient['_user_extra']);
        $status_id = $extra['status_id'] ?? '';
        $order_id = $extra['order_id'] ?? '';
        $products_ids = $extra['products_ids'] ?? [];
        $groups_ids = $extra['groups_ids'] ?? [];

        $products_in_order = '';
        if ($recipient->is_system_user && \RS\Module\Manager::staticModuleExists('shop') && !empty($status_id) && !empty($order_id)) {
            $products = \RS\Orm\Request::make()
                ->select('P.*')
                ->from(new \Catalog\Model\Orm\Product(), 'P')
                ->join(new \Shop\Model\Orm\OrderItem(), 'OI.entity_id=P.id', 'OI')
                ->join(new \Shop\Model\Orm\Order(), 'O.id=OI.order_id', 'O')
                ->join(new \Catalog\Model\Orm\Xdir(), 'OI.entity_id = X.product_id', 'X')
                ->where([
                    'O.user_id' => $recipient->user_id,
                    'OI.type' => 'product',
                    'O.status' => $status_id,
                    'O.id' => $order_id,
                ]);

                if (!empty($products_ids)) {
                    $products->openWGroup();
                    $products->whereIn('OI.entity_id', $products_ids);
                    $products->closeWGroup();
                }
                if (!empty($groups_ids)) {
                    $products->openWGroup();
                    $products->whereIn('X.dir_id', $groups_ids, 'or');
                    $products->closeWGroup();
                }

                $products->groupby('P.id')
                ->limit($this->settings['limit']);

            $view = new \RS\View\Engine();
            $view->assign([
                'self' => $this,
                'recipient' => $recipient,
                'products' => $products->objects()
            ]);
            $products_in_order = $view->fetch($this->settings['template']);
        }
        return [
            'products_in_order' => $products_in_order
        ];
    }
    
    /**
    * Возвращает подпись к переменным, которые можно будет использовать для замены в шаблонах
    * 
    * @return array
    */
    function getReplaceVarsTitle()
    {
        return [
            'products_in_order' => t('Таблица с товарами в корзине (Список товаров формируется только для триггера "Прошло N дней после смены статуса заказа в статус S")')
        ];
    }
}