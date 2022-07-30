<?php
namespace MailSender\Model\Content;
use \MailSender\Model;

/**
* Абстрактный класс генератора контента.
* Генератор контента может привносить собственные переменные, которые можно использовать в шаблонах писем
*/
abstract class AbstractContent
{
    protected
        $template,
        $settings = [];
    
    /**
    * Устанавливает значения настроек генератора контента
    * 
    * @param array $settings
    * @return AbstractContent
    */
    function init(Model\Orm\MailTemplate $template, $settings = null)
    {
        $this->template = $template;
        
        if ($settings) {
            $this->settings = $settings;
        }
        return $this;
    }
    
    /**
    * Возвращает название генератора контента
    * 
    * @return string
    */
    abstract function getTitle();
    
    /**
    * Возвращает описание генератора контента
    * 
    * @return string
    */
    abstract function getDescription();
    
    /**
    * Возвращает уникальный идентификатор источника получателей
    * 
    * @return string
    */
    function getId()
    {
        $class = strtolower(get_class($this));
        return str_replace(['\\', '-model'], ['-', ''], $class);
    }    
    
    /**
    * Возвращает настройки генератора контента
    * 
    * @return \RS\Orm\FormObject
    */
    abstract function getSettingsObject();
    
    /**
    * Возвращает переменные для замены, которые которые можно будет использовать в шаблонах
    * 
    * @param Model\Orm\MailTemplate $template
    * @param Model\Orm\MailRecipient $recipient
    * @return array
    */
    abstract function getReplaceVars(Model\Orm\MailRecipient $recipient);
    
    /**
    * Возвращает подпись к переменным, которые можно будет использовать для замены в шаблонах
    * 
    * @return array
    */
    abstract function getReplaceVarsTitle();
    
    /**
    * Возвращает параметры, установленные для данного генератора контента
    * 
    * @return array
    */
    public function getSettings()
    {
        return $this->settings;
    }    
    
    /**
    * Возвращает готовый HTML блок настроек
    * 
    * @return string
    */
    public function getSettingsHtml()
    {
        $form_object = $this->getSettingsObject();
        $form_object->getPropertyIterator()->arrayWrap('contents['.$this->getId().'][settings]');
        $form_object->getFromArray($this->settings);
        $path = \Setup::$PATH . \Setup::$MODULE_FOLDER . '/mailsender'. \Setup::$MODULE_TPL_FOLDER.'/form/cnt_'.str_replace('\\','_', get_class($this)).'.auto.tpl';
        return $form_object->getForm(null, null, null, $path, '%mailsender%/admin/form_generator.tpl');
    }
}
