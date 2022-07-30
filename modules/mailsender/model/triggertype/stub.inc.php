<?php
namespace MailSender\Model\TriggerType;
use \RS\Orm\Type;

/**
* Триггер - заглушка. Необходим для замены несуществующих триггеров
*/
class Stub extends AbstractType
{    
    /**
    * Возвращает название триггера
    * 
    * @return string
    */
    function getTitle()
    {
        return t('Тип триггера был удален из системы');
    }
    
    /**
    * Возвращает описание триггера
    * 
    * @return string
    */
    function getDescription()
    {
        return '';
    }
    
    /**
    * Выполнит событие trigger.exec, для каждого пользователя, 
    * для которого были соблюдены условия триггера
    */
    function match()
    {
        
    }
}
