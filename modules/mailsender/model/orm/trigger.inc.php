<?php
namespace MailSender\Model\Orm;
use \RS\Orm\Type;

/**
 * ORM объект - триггер
 * --/--
 * @property integer $id Уникальный идентификатор (ID)
 * @property integer $site_id ID сайта
 * @property string $title Наименование
 * @property string $type_class Тип триггера
 * @property string $type_settings Параметры тригера
 * @property array $settings Параметры тригера
 * @property integer $enabled Включен
 * --\--
 */
class Trigger extends \RS\Orm\OrmObject
{
    protected static
        $table = 'trigger';
    
    function _init()
    {
        parent::_init()->append([
            'site_id' => new Type\CurrentSite(),
            'title' => new Type\Varchar([
                'description' => t('Наименование'),
            ]),
            'type_class' => new Type\Varchar([
                'description' => t('Тип триггера'),
                'list' => [['\MailSender\Model\TriggerApi', 'getTriggerNames']],
                'template' => '%mailsender%/form/trigger/other.tpl'
            ]),
            'type_settings' => new Type\Text([
                'description' => t('Параметры тригера'),
                'visible' => false,
            ]),
            'settings' => new Type\ArrayList([
                'description' => t('Параметры тригера'),
                'visible' => false,
            ]),
            'enabled' => new Type\Integer([
                'description' => t('Включен'),
                'default' => 1,
                'checkboxView' => [1,0]
            ])
        ]);
    }
    
    function beforeWrite($flag)
    {
        $this['type_settings'] = serialize($this['settings']);
        $settings = $this->getTypeObject()->getSettingsObject();
        /**
        * @var \RS\Orm\FormObject
        */
        $settings->getFromArray($this['settings']);
        if (!$settings->validate()) {
            foreach($settings->getFormError() as $field) {
                $error = $settings->getErrorsByForm($field);
                $this->addError($error, $settings['__'.$field]->getDescription());
            }
            return false;
        }
    }
    
    function afterObjectLoad()
    {
        $this['settings'] = unserialize($this['type_settings']);
    }
    
    function getTypeObject()
    {
        $type_object = \MailSender\Model\TriggerApi::getTriggerTypeById($this['type_class']);
        $type_object->init((array)$this['settings'], $this);
        return $type_object;
    }
    
    function match()
    {
        return $this->getTypeObject()->match();
    }
    
    function getRecipientsArray()
    {
        $result = [];
        foreach($this->match() as $item) {
            if ($user = $item->getUser()) {
                $result[] = $user;
            }
        }
        return $result;
    }
}