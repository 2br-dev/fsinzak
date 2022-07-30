<?php
namespace MailSender\Model;
use \RS\Event\Manager as EventManager;

class FilterApi
{
    /**
    * Возвращает экземпляр класса фильтра
    * 
    * @param string $id - идентификатор фильтра
    * @return Filter\AbstractFilter
    */
    public static function getFilterByClass($id)
    {
        $types = self::getFilters();
        if (!isset($types[$id])) {
            throw new Exception(t('Неверный тип фильтра %0', [$id]), Exception::BAD_FILTER_ID);
        }
        return clone $types[$id];
    }
    
    /**
    * Возвращает список фильтров получателей рассылки, зарегистрированных в системе
    * 
    * @return Filter\AbstractFilter
    */
    public static function getFilters()
    {
        $result = [];
        $event_result = EventManager::fire('mailsender.getfilter', []);
        foreach($event_result->getResult() as $item) {
            if ($item instanceof Filter\AbstractFilter) {
                $result[$item->getId()] = $item;
            } else {
                throw new Exception(t('Фильтр должен быть потомком класса \MailSender\Model\Filter\AbstractFilter'), Exception::BAD_FILTER_CLASS);
            }
        }
        return $result;
    }
    
    /**
    * Возвращает список названий фильтров
    * 
    * @return array
    */
    public static function getFilterNames()
    {
        $result = [];
        $services = self::getFilters();
        foreach($services as $key => $service) {
            $result[$key] = $service->getTitle();
        }
        return $result;
    }    
}
