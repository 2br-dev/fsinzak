<?php
namespace MailSender\Model\Filter;
use \MailSender\Model\Orm\MailRecipient;

/**
* Абстрактный класс фильтра получателей
* Фильтр, позволит фильтровать получателей рассылки по определенным параметрам.
* Фильтр запускается непосредственно перед отправкой письма для каждого получателя
* Фильтр действует и на отправку вручную и на отправку по триггеру.
*/
abstract class AbstractFilter
{    
    protected
        $mail_template,
        $settings = [];
    
    /**
    * Конструктор
    * 
    * @param \Mailsender\Model\Orm\MailTemplate $mail_template
    * @param array $settings
    */
    function __construct($mail_template = null, array $settings = [])
    {
        $this->init($mail_template, $settings);
    }
    
    /**
    * Устанавливает настройки фильтра
    * 
    * @param \Mailsender\Model\Orm\MailTemplate $mail_template
    * @param array $settings
    * @return AbstractFilter
    */
    function init($mail_template = null, array $settings = [])
    {
        $this->mail_template = $mail_template;
        $this->settings = $settings;
        return $this;
    }
    
    /**
    * Возвращает название фильтра
    * 
    * @return string
    */
    abstract public function getTitle();
    
    /**
    * Возвращает true, если письмо можно направить получателю $recipient
    * 
    * @param MailRecipient $recipient
    * @return bool
    */
    abstract public function canSendToRecipient(MailRecipient $recipient);
    
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
    * Возвращает объект с настройками фильтра
    * 
    * @return \RS\Orm\FormObject | null
    */
    public function getSettingsObject()
    {
        return null;
    }
            
    /**
    * Возвращает HTML код блока фильтра для административной панели
    * 
    * @param string $key - индекс фильтра
    * @return string
    */
    public function getView($key = null)
    {
        $key = $key !== null ? $key : uniqid();
        $filter_api = new \Mailsender\Model\FilterApi();
        $all_filters = $filter_api->getFilterNames();
        
        $view = new \RS\View\Engine();
        $view->assign([
            'self_class' => $this->getId(),
            'all_filters' => $all_filters,
            'filter_settings_html' => $this->getSettingsHtml($key),
            'key' => $key
        ]);
        return $view->fetch('%mailsender%/form/mailtemplate/one_filter.tpl');
    }
    
    /**
    * Возвращает параметры, установленные для данного фильтра
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
    public function getSettingsHtml($key)
    {
        if ($settings_object = $this->getSettingsObject()) {
            $settings_object->getPropertyIterator()->arrayWrap("filters[$key][settings]");
            $settings_object->getFromArray($this->getSettings());
            $path = \Setup::$PATH . \Setup::$MODULE_FOLDER . '/mailsender'. \Setup::$MODULE_TPL_FOLDER.'/form/filter_'.str_replace('\\','_', get_class($this)).'.auto.tpl';
            
            return $settings_object->getForm(null, null, false, strtolower($path), '%system%/coreobject/tr_form.tpl');
        }
    }
}