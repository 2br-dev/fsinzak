<?php
namespace MailSender\Model;
use \RS\Event\Manager as EventManager;

/**
* API для образцов писем
*/
class SampleApi
{
    /**
    * Возвращает список источников пользователей, получателей рассылки
    * 
    * @return \MailSender\Model\Sample\AbstractSample[]
    */
    public static function getSamples()
    {
        static $result;
            
        if ($result === null) {
            $result = [];
            $event_result = EventManager::fire('mailsender.getsample', []);
            foreach($event_result->getResult() as $item) {
                $result[$item->getId()] = $item;
            }
        }
        return $result;
    }
    
    /**
    * Возвращает список названий образцов писем
    * 
    * @return array
    */
    public static function getSampleNames()
    {
        $result = [];
        $services = self::getSamples();
        foreach($services as $key => $service) {
            $result[$key] = $service->getTitle();
        }
        return $result;
    }
    
    /**
    * Возвращает экземпляр класса образца письма
    * 
    * @param string $class
    * @return Sample\AbstractSample
    */
    public static function getSampleByClass($class)
    {
        $samples = self::getSamples();
        if (isset($samples[$class])) {
            return clone $samples[$class];
        }
        throw new Exception(t('Неверный тип образца письма %0', [$class]), Exception::BAD_SOURCE_CLASS);
    }
}