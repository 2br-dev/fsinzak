<?php
namespace MailSender\Model\TriggerType;
use \RS\Orm\Type;

/**
* Триггер - пользователь, не заходивший на сайт более N дней
*/
class LostUser extends AbstractType
{
    /**
    * Возвращает название триггера
    * 
    * @return string
    */
    function getTitle()
    {
        return t('Пользователь, не заходивший на сайт определенное время');
    }
    
    /**
    * Возвращает описание триггера
    * 
    * @return string
    */
    function getDescription()
    {
        return t('Триггер срабатывает в момент, когда зарегистрированный пользователь не посещает сайт от N до M дней.');
    }
    
    /**
    * Возвращает объект с настройками типа триггера
    * 
    * @return \RS\Orm\FormObject | null
    */
    function getSettingsObject()
    {
        return new \RS\Orm\FormObject(new \RS\Orm\PropertyIterator([
            'days_from' => new Type\Integer([
                'description' => t('N, количество дней'),
                'default' => 30,
                'checker' => ['ChkEmpty', t('Обязательное поле')]
            ]),
            'days_to' => new Type\Integer([
                'description' => t('M, количество дней'),
                'default' => 35,
                'checker' => ['ChkEmpty', t('Обязательное поле')],
                ' checker' => [function($_this, $value) {
                    if ($_this['days_from'] > $value) {
                        return t('M должно быть больше N');
                    }
                    return true;
                }]
            ])
        ]));
    }
    
    /**
    * Проверяет, должен ли сработать триггер сейчас.
    * Если должен, то вернется массив объектов \MailSender\Model\triggerData
    * 
    * @return \MailSender\Model\triggerData[]
    */
    function match()
    {
        $date_from = strtotime('-'.$this->settings['days_from'].' day', time());
        $date_to = strtotime('-'.$this->settings['days_to'].' day', time());
        
        $users = \RS\Orm\Request::make()
            ->from(new \Users\Model\Orm\User())
            ->where("'#date_to' < last_visit AND last_visit < '#date_from'", [
                'date_from' => date('Y-m-d H:i:s', $date_from),
                'date_to' => date('Y-m-d H:i:s', $date_to),
            ])->objects();
        
        $result = [];
        foreach($users as $user) {
            $result[] = new \MailSender\Model\TriggerData($user);
        }
        return $result;
    }
}
