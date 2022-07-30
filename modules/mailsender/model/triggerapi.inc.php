<?php
namespace MailSender\Model;
use \RS\Event\Manager as EventManager;

class TriggerApi extends \RS\Module\AbstractModel\EntityList
{
    function __construct()
    {
        parent::__construct(new Orm\Trigger(), [
            'nameField' => 'title',
            'multisite' => true
        ]);
    }
    
    /**
    * Возвращает список типов триггеров
    * @return \MailSender\Model\TriggerType\AbstractType[]
    */
    public static function getTriggerTypes()
    {
        $result = [];
        $event_result = EventManager::fire('trigger.gettypes', []);
        foreach($event_result->getResult() as $item) {
            if (!($item instanceof TriggerType\AbstractType)) {
                throw new Exception(t('Тип триггера должен быть потомком класса \MailSender\Model\TriggerType\AbstractType'), Exception::BAD_TRIGGER_CLASS);
            }
            $result[$item->getId()] = $item;
        }
        return $result;
    }
    
    /**
    * Возвращает список названий типов триггеров
    * 
    * @return array
    */
    public static function getTriggerNames()
    {
        $result = [];
        $services = self::getTriggerTypes();
        foreach($services as $key => $service) {
            $result[$key] = $service->getTitle();
        }
        return $result;
    }
    
    /**
    * Возвращает новый объект типа триггера по ID
    * 
    * @param string $id - ID типа триггера
    * @return \MailSender\Model\TriggerType\AbstractType
    */
    public static function getTriggerTypeById($id)
    {
        $types = self::getTriggerTypes();
        return isset($types[$id]) ? clone $types[$id] : new TriggerType\Stub();
    }    
    
    /**
    * Запускает триггеры в системе. В случае срабатывания, триггер 
    * запускает событие trigger.exec со списком данных для каждого получателя.
    * 
    * @return integer возвращает количество срабатываний триггера
    */
    function runTriggers()
    {
        $count = 0;
        $triggers = $this->getCleanQueryObject()
                         ->where([
                            'enabled' => 1
                         ])
                         ->objects();
                         
        foreach($triggers as $trigger) {
            if ($trigger_data_list = $trigger->match()) {
                $count++;
                \RS\Event\Manager::fire('trigger.exec', [
                    'trigger' => $trigger,
                    'data' => $trigger_data_list
                ]);
            }
        }
        return $count;
    }
}
