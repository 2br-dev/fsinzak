<?php

namespace fsinzak\Model\Orm;

use RS\Orm\OrmObject;
use RS\Orm\Type;
use RS\Orm\Type\Double;
use RS\Orm\Type\Integer;

/**
 * ORM объект
 */
class Recipients extends OrmObject
{
    protected static $table = 'recipients';

    function _init()
    {
        parent::_init()->append([
            t('Основные'),
                'name' => new Type\Varchar([
                    'description' => t('Имя'),
//                    'checker' => [[__CLASS__, 'checkRecipientNameField'], t('Укажите, пожалуйста, Имя'), 'name'],
                ]),
                'surname' => new Type\Varchar([
                    'description' => t('Фамилия'),
//                    'checker' => [[__CLASS__, 'checkRecipientNameField'], t('Укажите, пожалуйста, Фамилию'), 'surname'],
                ]),
                'midname' => new Type\Varchar([
                    'description' => t('Отчество'),
                ]),
                'user_id' => new Type\Integer([
                    'description' => t('Пользователь (id владелеца)'),
                    'visible' => false
                ]),
                'birthday' => new Type\Date([
                    'description' => t('День рождения')
                ]),
                'removed' => new Integer([
                    'description' => t('Помечен на удаление'),
                    'checkBoxView' => [1,0],
                    'default' => 0
                ]),
            t('Ограничения'),
                'limit_sum' => new Double([
                    'description' => t('Ограничение суммы заказа (руб)'),
                    'default' => 0
                ]),
                'limit_weight' => new Double([
                    'description' => t('Ограничение веса заказа (г)'),
                    'default' => 0
                ]),
                'periodicity' => new Integer([
                    'description' => t('Количество заказов в месяц'),
                    'hint' => t('Ограничение количество заказов для этого получателя в месяц'),
                    'default' => 0
                ]),
                'periodicity_month' => new Integer([
                    'description' => t('Количество месяцев (N) для ограничения заказов'),
                    'hint' => t('Количество месяцев для следующиего пункта')
                ]),
        ]);
    }

    /**
     * Проверяет Имя или Фамилию на заполненность, если соответствующие опции включены
     *
     * @param $_this
     * @param mixed $value
     * @param string $error_text
     * @param string $field
     *
     * @return bool|string
     */
    public static function checkRecipientNameField($_this, $value, $error_text, $field)
    {
        if (empty($_this['fio'] && $value == '')) {
            return $error_text;
        }
        return true;
    }

    /**
     * Возвращает возраст получателя
     * @return float
     */
    public function getAge()
    {
        $current_date = strtotime(date('Y-m-d'));
        $recipient_date = strtotime($this['birthday']);
        $age = ($current_date-$recipient_date) / (60*60*24*365);
        return floor($age);
    }

    /**
     * Возвращает индивидуальные ограничения получателя
     * @return array
     */
    public function getRecipientLimits()
    {
        $limits = [];
        $limit = [];
        if($this['limit_sum'] != 0){
            $limit['type'] = 'limit_sum';
            $limit['value'] = $this['limit_sum'];
            $limits[] = $limit;
        }
        if($this['limit_weight'] != 0){
            $limit['type'] = 'limit_weight';
            $limit['value'] = $this['limit_weight'];
            $limits[] = $limit;
        }
        if($this['periodicity'] != 0){
            $limit['type'] = 'periodicity';
            $limit['value'] = $this['periodicity'];
            $limit['value_month'] = $this['periodicity_month'];
            $limits[] = $limit;
        }
        return $limits;
    }

    /**
     * Возвращает ограничение получателя по типу ограничения
     * @param string $type
     * @return int
     */
    public function getRecipientLimitByType($type)
    {
        $limit = 0;
        if($this[$type] != 0){
            $limit = $this[$type];
        }
        return $limit;
    }

    /**
     * Возвращает количество заказов на получателя в текущем месяце
     * @return int
     */
    public function getRecipientCountOrderForPeriod()
    {
        $config = \RS\Config\Loader::byModule('fsinzak');
        $periodicity = $config->getPeriodicity();
        $date_start = date('Y-m-d');
        $date_end = date('Y-m-d', strtotime("-".$periodicity['value_month']." month", strtotime($date_start)));
        $orders_count = \RS\Orm\Request::make()
            ->from(new \Shop\Model\Orm\Order())
            ->where([
                'recipient_id' => $this['id']
            ])
            ->where('`status` = 9 OR `status` = 6')
            ->where("DATE(`dateof`) <= '{$date_start}' AND DATE(`dateof`) >= '{$date_end}'")
            ->exec()->rowCount();
        return $orders_count;
    }

    /**
     * Возвращает Фамилию, имя, отчество в одну строку
     *
     * @return string
     * @param $full - выводить полностью или Фамилия И.О.
     */
    public function getFio($full = true)
    {
        if($full){
            return trim($this['surname'] . ' ' . $this['name'] . ' ' . $this['midname']);
        }
        return trim($this['surname'] . ' ' . mb_substr($this['name'], 0,1) . '. ' . mb_substr($this['midname'], 0,1) . '.');
    }

    public function getBirthday($format)
    {
        return date($format, strtotime($this['birthday']));
    }

    /**
     * Вовзращает ограничение по периодичности заказов (личные ограничения)
     * @return array
     */
    public function getPeriodicity()
    {
        $periodicity = [];
        if($this['periodicity']){
            $periodicity['value'] = $this['periodicity'];
            $periodicity['value_month'] = $this['periodicity_month'];
        }
        return $periodicity;
    }
}
