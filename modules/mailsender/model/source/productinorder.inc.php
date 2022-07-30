<?php
namespace MailSender\Model\Source;
use RS\Orm\Type;

/**
* Источник получателей рассылки - зарегистрированные пользователи
*/
class ProductInOrder extends AbstractSource
{
    /**
    * Возвращает название источника получателей
    * 
    * @return string
    */
    public function getTitle()
    {
        return t('В заказе есть указанный товар');
    }
    
    /**
    * Возвращает описание источника получателей
    * 
    * @return string
    */
    public function getDescription()
    {
        return t('Возвращает список пользователей, у которых в заказах есть товар из указанного списка');
    }
    
    /**
    * Возврашает объект с настройками источника
    * 
    * @return \RS\Orm\FormObject | null
    */
    function getSettingsObject()
    {
        return new \RS\Orm\FormObject(new \RS\Orm\PropertyIterator([
            'products' => new Type\ArrayList([
                'runtime' => false,
                'description' => t('Товары'),
                'dialog' => new \Catalog\Model\ProductDialog('sources['.$this->getId().'][settings][products]', false),
                'template' => '%mailsender%/form/trigger/type/product_view_products.tpl',
                'checker' => ['ChkEmpty', t('Не указаны товары')]
            ]),
        ]));
    }
    
    /**
    * Возвращает список объектов получателей
    * 
    * @return MailSender\Model\Orm\MailRecipient[]
    */
    public function getRecipients()
    {
        $offset = 0;
        $page_size = 100;
        $q = \RS\Orm\Request::make()
            ->from(new \Users\Model\Orm\User(), 'U')
            ->join(new \Shop\Model\Orm\Order(), 'U.id = O.user_id', 'O')
            ->join(new \Shop\Model\Orm\OrderItem(), 'O.id = I.order_id', 'I')
            ->join(new \Catalog\Model\Orm\Xdir(), 'I.entity_id = X.product_id', 'X')
            ->where(['I.type' => 'product'])
            ->openWGroup();
            if (!empty($this->settings['products']['product'])) {
                $q->whereIn('I.entity_id', $this->settings['products']['product']);
            }
            if (!empty($this->settings['products']['group'])) {
                $q->whereIn('X.dir_id', $this->settings['products']['group'], 'or');
            }
            $q->closeWGroup()
            ->groupby('U.id')
            ->limit($page_size);

        $recipients = [];
        while($users = $q->offset($offset)->objects()) {
            foreach($users as $user) {
                $recipient = new \MailSender\Model\Orm\MailRecipient();
                $recipient->makeFromUser($user, $this);
                
                $recipients[$recipient->email] = $recipient;
            }
            $offset += $page_size;
        }
        return $recipients;
    }
}
