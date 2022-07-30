<?php
namespace MailSender\Model;
use \RS\Event\Manager as EventManager;

/**
* API генераторов переменных, которые можно будет использовать в теле писем
*/
class ContentApi
{
    /**
    * Возвращает список генераторов контента
    * 
    * @return Content\AbstractContent[]
    */
    public static function getContents()
    {
        $result = [];
        $event_result = EventManager::fire('mailsender.getcontent', []);
        foreach($event_result->getResult() as $item) {
            if ($item instanceof Content\AbstractContent) {
                $result[$item->getId()] = $item;
            } else {
                throw new Exception(t('Генератор контента должен быть потомком класса \MailSender\Model\Content\AbstractContent'), Exception::BAD_CONTENT_CLASS);
            }
        }
        return $result;
    }
    
    /**
    * Возвращает список названий генераторов контента
    * 
    * @return array
    */
    public static function getContentNames()
    {
        $result = [];
        $services = self::getContents();
        foreach($services as $key => $service) {
            $result[$key] = $service->getTitle();
        }
        return $result;
    }
    
    /**
    * Возвращает экземпляр класса генератора контента
    * 
    * @param string $class
    * @return Content\AbstractContent
    */
    public static function getContentByClass($id)
    {
        $types = self::getContents();
        if (!isset($types[$id])) {
            throw new Exception(t('Неверный тип генератора контента %0', [$id]), Exception::BAD_CONTENT_ID);
        }
        return clone $types[$id];
    }
}