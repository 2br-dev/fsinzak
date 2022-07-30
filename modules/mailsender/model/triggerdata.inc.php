<?php
namespace MailSender\Model;
use \Users\Model\Orm\User;

/**
* Класс с параметрами одного запуска триггера. 
* Объект данного класса передается в параметрах события trigger.exec
*/
class TriggerData
{
    private
        $user,
        $data,
        $uniq;
        
    /**
    * Конструктор
    * 
    * @param Orm\Trigger $trigger
    * @param User $user
    * @param array $data
    */
    function __construct(User $user = null, array $data = [], $uniq = null)
    {
        $this->setUser($user);
        $this->setData($data);
        $this->setUniq($uniq);
    }
        
    /**
    * Устанавливает пользователя, для которого сработал триггер
    * 
    * @param User $user
    * @return void
    */
    function setUser(User $user = null)
    {
        $this->user = $user;
    }
    
    /**
    * Устанавливает произвольные параметры для запуска триггера
    * 
    * @param array $data
    * @return void
    */
    function setData(array $data)
    {
        $this->data = $data;
    }
    
    /**
    * Устанавливает дополнительный уникальный ключ
    * 
    * @param string $uniq
    * @return void
    */
    function setUniq($uniq)
    {
        $this->uniq = $uniq;
    }
    
    /**
    * Возвращает пользователя, для которого сработал триггер
    * 
    * @return \Users\Model\Orm\user
    */
    function getUser()
    {
        return $this->user;
    }
    
    /**
    * Возвращает произвольные параметры для запуска тригггера
    * 
    * @return array
    */
    function getData()
    {
        return $this->data;
    }
    
    /**
    * Возвращает дополнительный уникальный ключ
    * 
    * @return array
    */
    function getUniq()
    {
        return $this->uniq;
    }
}
