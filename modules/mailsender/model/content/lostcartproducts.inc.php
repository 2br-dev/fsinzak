<?php
namespace MailSender\Model\Content;
use \MailSender\Model,
    \RS\Orm\Type;

/**
* Класс позволяет использовать в письмах список товаров, которые пользователь не купил
*/
class LostCartProducts extends AbstractContent
{
    /**
    * Возвращает название генератора контента
    * 
    * @return string
    */
    function getTitle()
    {
        return t('Не купленные товары в корзине пользователя');
    }
    
    /**
    * Возвращает описание генератора контента
    * 
    * @return string
    */
    function getDescription()
    {
        return t('Предоставляет возможность вставлять в письмо таблицу со списком товаров, которые авторизованный пользователь положил в корзину, но не купил в его последней сессии.');
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
                'default' => '%mailsender%/content/lostcartproducts/lostcartproducts.tpl'
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
        $lost_cart_products = '';

        if ($recipient->is_system_user && \RS\Module\Manager::staticModuleExists('shop')) {
            $products = \RS\Orm\Request::make()
                ->select('P.*, C.*')
                ->from(new \Catalog\Model\Orm\Product(), 'P')
                ->join(new \Shop\Model\Orm\CartItem(), 'C.entity_id=P.id', 'C')
                ->where([
                    'C.user_id' => $recipient->user_id,
                    'C.type' => 'product'
                ])
                ->orderby('C.dateof DESC')
                ->limit($this->settings['limit'])
                ->objects();
            
            $view = new \RS\View\Engine();
            $view->assign([
                'self' => $this,
                'recipient' => $recipient,
                'products' => $products
            ]);
            $lost_cart_products = $view->fetch($this->settings['template']);
        }
        return [
            'lost_cart_products' => $lost_cart_products
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
            'lost_cart_products' => t('Таблица с товарами в корзине')
        ];
    }
}