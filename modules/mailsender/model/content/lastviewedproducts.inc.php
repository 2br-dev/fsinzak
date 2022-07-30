<?php
namespace MailSender\Model\Content;
use \MailSender\Model,
    \RS\Orm\Type;

/**
* Класс позволяет использовать в письмах список товаров, которые пользователь не купил
*/
class LastViewedProducts extends AbstractContent
{
    /**
    * Возвращает название генератора контента
    * 
    * @return string
    */
    function getTitle()
    {
        return t('Последние просмотренные пользователем товары');
    }
    
    /**
    * Возвращает описание генератора контента
    * 
    * @return string
    */
    function getDescription()
    {
        return t('Предоставляет возможность вставлять в письмо таблицу со списком товаров, которые просматривал на сайте авторизованный пользователь');
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
                'default' => '%mailsender%/content/lastviewedproducts/lastviewedproducts.tpl'
            ]),
            'limit' => new Type\Integer([
                'description' => t('Максимальное количество просмотренных товаров'),
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
        $last_viewed_products = '';

        if ($recipient->is_system_user) {
            $products = \RS\Orm\Request::make()
                ->select('P.*')
                ->from(new \Catalog\Model\Orm\Product(), 'P')
                ->join(new \Users\Model\Orm\Log(), 'L.oid=P.id', 'L')
                ->where([
                    'L.user_id' => $recipient->user_id,
                    'L.class' => 'Catalog\Model\Logtype\ShowProduct',
                ])
                ->orderby('L.dateof DESC')
                ->limit($this->settings['limit'])
                ->objects();
            
            $view = new \RS\View\Engine();
            $view->assign([
                'self' => $this,
                'recipient' => $recipient,
                'products' => $products
            ]);
            $last_viewed_products = $view->fetch($this->settings['template']);
        }
        return [
            'last_viewed_products' => $last_viewed_products
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
            'last_viewed_products' => t('Последние просмотренные товары')
        ];
    }
}