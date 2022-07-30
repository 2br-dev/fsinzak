<?php
namespace MailSender\Model;
use \RS\Event\Manager as EventManager;

class SourceApi
{
    /**
    * Возвращает список источников пользователей, получателей рассылки
    */
    public static function getSources()
    {
        $result = [];
        $event_result = EventManager::fire('mailsender.getsource', []);
        
        foreach($event_result->getResult() as $item) {
            if ($item instanceof Source\AbstractSource) {
                $result[$item->getId()] = $item;
            } else {
                throw new Exception(t('Источник получателей рассылки должен быть потомком класса \MailSender\Model\Source\AbstractSource'), Exception::BAD_SOURCE_CLASS);
            }
        }
        return $result;
    }
    
    /**
    * Возвращает список названий источников пользователей
    */
    public static function getSourceNames()
    {
        $result = [];
        $services = self::getSources();
        foreach($services as $key => $service) {
            $result[$key] = $service->getTitle();
        }
        return $result;
    }
    
    /**
    * Возвращает экземпляр класса источника контента
    * 
    * @param string $id
    * @return Content\AbstractContent
    */
    public static function getSourceByClass($id)
    {
        $types = self::getSources();
        if (!isset($types[$id])) {
            throw new Exception(t('Неверный тип источника получателя %0', [$id]), Exception::BAD_SOURCE_ID);
        }
        return clone $types[$id];
    }        
}