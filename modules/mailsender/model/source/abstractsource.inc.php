<?php

namespace MailSender\Model\Source;

/**
 * Абстрактный класс источника получателей рассылки
 */
abstract class AbstractSource
{
    protected
        $settings = [],
        $template;

    /**
     * Возвращает название источника получателей
     *
     * @return string
     */
    abstract public function getTitle();

    /**
     * Возвращает описание источника получателей
     *
     * @return string
     */
    abstract function getDescription();

    /**
     * Возвращает массив со список объектов получателей
     *
     * @return \MailSender\Model\Orm\MailRecipient[]
     */
    abstract public function getRecipients();

    /**
     * Возврашает объект с настройками источника
     *
     * @return \RS\Orm\FormObject | null
     */
    function getSettingsObject()
    {
    }

    /**
     * Инициализирует источник получателей
     *
     * @param \MailSender\Model\Orm\MailTemplate $template
     * @return void
     */
    function init(\MailSender\Model\Orm\MailTemplate $template, $settings = [])
    {
        $this->template = $template;
        $this->settings = $settings;
    }

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
     * Возвращает параметры, установленные для данного источника
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
     * @param object $parent_object - orm объект внутри которого отображается форма
     * @return string
     * @throws \SmartyException
     */
    public function getSettingsHtml($parent_object = null)
    {
        if ($form_object = $this->getSettingsObject()) {
            if ($parent_object) {
                $form_object->setParentObject($parent_object);
            }
            $form_object->getPropertyIterator()->arrayWrap('sources[' . $this->getId() . '][settings]');
            $form_object->getFromArray($this->settings);
            $path = \Setup::$PATH . \Setup::$MODULE_FOLDER . '/mailsender' . \Setup::$MODULE_TPL_FOLDER . '/form/src_' . str_replace('\\', '_', get_class($this)) . '.auto.tpl';
            return $form_object->getForm(null, null, null, $path, '%mailsender%/admin/form_generator.tpl');
        }
        return '';
    }
}
