<?php
namespace MailSender\Model\Content;
use Catalog\Model\CostApi;
use \MailSender\Model,
    \RS\Orm\Type;
use Users\Model\Orm\User;

class Products extends AbstractContent
{
    const COST_TYPE_DEFAULT  = 0;
    const COST_TYPE_USER = -1;
    /**
    * Возвращает название генератора контента
    * 
    * @return string
    */
    function getTitle()
    {
        return t('Товары из списка');
    }
    
    /**
    * Возвращает описание генератора контента
    * 
    * @return string
    */
    function getDescription()
    {
        return t('Добавляет возможность использовать в письме указанные вручную товары');
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
                'default' => '%mailsender%/content/products/products.tpl'
            ]),
            'cost_id' => new Type\Integer([
                'description' => t('Тип цены'),
                'list' => [['\Catalog\Model\CostApi', 'staticSelectList'], [
                    self::COST_TYPE_DEFAULT => t('-- По умолчанию --'),
                    self::COST_TYPE_USER => t('-- Цена пользователя --')]]
            ]),
            'products' => new Type\ArrayList([
                'runtime' => false,
                'description' => t('Товары'),
                'dialog' => new \Catalog\Model\ProductDialog('contents['.$this->getId().'][settings][products]', false),
                'template' => '%mailsender%/content/products/dialog_field.tpl',
            ]),
        ]));
    }
    
    /**
    * Возвращает переменные для замены, которые которые можно будет использовать в шаблонах
    * 
    * @param Model\Orm\MailTemplate $template
    * @param Model\Orm\MailRecipient $recipient
    * @return array
    */
    function getReplaceVars(Model\Orm\MailRecipient $recipient)
    {
        $view = new \RS\View\Engine();
                
        $products_html = '';
        
        if (!empty($this->settings['products']['product']) 
            || !empty($this->settings['products']['group'])) 
        {
            $q = \RS\Orm\Request::make()
                ->from(new \Catalog\Model\Orm\Product());
            
            if (!empty($this->settings['products']['product'])) {
                $q->whereIn('id', $this->settings['products']['product']);
            }
            
            if (!empty($this->settings['products']['group'])) {
                $q->whereIn('maindir', $this->settings['products']['group'], 'OR');
            }

            switch ($this->settings['cost_id']) {
                case self::COST_TYPE_DEFAULT:
                                $cost_id = null;
                                break;
                case self::COST_TYPE_USER:
                                $cost_id = CostApi::getUserCost(new User($recipient->user_id));
                                break;
                default:
                    $cost_id = $this->settings['cost_id'];
            }
            
            $view->assign([
                'self' => $this,
                'recipient' => $recipient,
                'products' => $q->objects(),
                'cost_id' => $cost_id
            ]);
            
            $products_html = $view->fetch($this->settings['template']);
        }

        return [
            'selected_products' => $products_html
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
            'selected_products' => t('Выбранные товары')
        ];
    }
    
}
