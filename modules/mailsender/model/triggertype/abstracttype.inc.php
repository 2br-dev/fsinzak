<?php
namespace MailSender\Model\TriggerType;
use \MailSender\Model\Orm\Trigger;

/**
* Абстрактный класс типа триггера
*/
abstract class AbstractType
{
    protected
        $trigger,
        $settings = [];
    
    /**
    * Возвращает название триггера
    * 
    * @return string
    */
    abstract function getTitle();
    
    /**
    * Возвращает описание триггера
    * 
    * @return string
    */
    abstract function getDescription();
    
    /**
    * Возвращает список объектов triggerData
    * объект triggerData - содержит всю информацию для одного получателя 
    * 
    * @return \MailSender\Model\TriggerData[]
    */
    abstract function match();
        
    /**
    * Устанавливает параметры для триггера
    * 
    * @param array $settings - значения параметров
    * @param Trigger $trigger - ORM объект триггера
    * @return void
    */
    function init(array $settings, Trigger $trigger = null)
    {        
        $this->settings = $settings;
        $this->trigger = $trigger;
    }
    
    /**
    * Возвращает ID типа триггера
    * 
    * @return string
    */
    function getId()
    {
        $class = strtolower(get_class($this));
        return str_replace(['\\', '-model'], ['-', ''], $class);
    }
    
    /**
    * Возвращает объект с настройками типа триггера
    * 
    * @return \RS\Orm\FormObject | null
    */
    function getSettingsObject()
    {}
    
    /**
    * Возвращает параметры, установленные для данного триггера
    * 
    * @return array
    */
    public function getSettings()
    {
        return $this->settings;
    }    
    
    /**
    * Возвращает HTML форму данного типа оплаты, для ввода дополнительных параметров
    * 
    * @return string
    */
    function getFormHtml()
    {
        if ($settings_object = $this->getSettingsObject()) {
            $settings_object->getPropertyIterator()->arrayWrap("settings");
            $settings_object->getFromArray($this->settings);
            $path = \Setup::$PATH . \Setup::$MODULE_FOLDER . '/mailsender'. \Setup::$MODULE_TPL_FOLDER.'/form/trigger_'.str_replace('\\','_', get_class($this)).'.auto.tpl';
            
            return $settings_object->getForm(null, null, false, strtolower($path), '%system%/coreobject/tr_form.tpl');
        }
    }    
}
