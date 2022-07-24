<?php

namespace fsinzak\Model;

use fsinzak\Model\Orm\Recipients;
use RS\Application\Application;
use RS\Module\AbstractModel\EntityList;

/**
 * Класс для организации выборок ORM объекта.
 * В этом классе рекомендуется также реализовывать любые дополнительные методы, связанные с заявленной в конструкторе моделью
 */
class RecipientsApi extends EntityList
{
    function __construct()
    {
        parent::__construct(new Recipients());
    }

    /**
     * Проверяет есть ли получатель с таким же данным
     * @param $name
     * @param $midname
     * @param $surname
     * @param $birthday
     * @param $user_id
     * @return bool
     */
    public function checkTheSame($name, $midname, $surname, $birthday, $user_id)
    {
        $same = \RS\Orm\Request::make()
            ->from(new \Fsinzak\Model\Orm\Recipients())
            ->where([
                'name' => $name,
                'midname' => $midname,
                'surname' => $surname,
                'birthday' => $birthday,
                'user_id' => $user_id,
                'removed' => 0
            ])->exec()->fetchRow();
        if($same){
            return true;
        }
        return false;
    }

    /**
     * Проверяет был ли получатель с такими же данными создан ранее а потом удален
     * @param $name
     * @param $midname
     * @param $surname
     * @param $birthday
     * @param $user_id
     * @return array|bool
     */
    public function checkTheSameRemoved($name, $midname, $surname, $birthday, $user_id)
    {
        $same = \RS\Orm\Request::make()
            ->from(new \Fsinzak\Model\Orm\Recipients())
            ->where([
                'name' => $name,
                'midname' => $midname,
                'surname' => $surname,
                'birthday' => $birthday,
                'user_id' => $user_id,
                'removed' => 1
            ])->exec()->fetchRow();
        if($same){
            return $same;
        }
        return false;
    }

    /**
     * Возвращает объект Получатель из данных записаных в $_COOKIE
     * @param $cookie_name
     * @return bool|Recipients
     */
    public static function getRecipientFromCookie($cookie_name)
    {
        if(isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] != ''){
            $cookie = $_COOKIE[$cookie_name];
            return new \Fsinzak\Model\Orm\Recipients($cookie);
        }
        return false;
    }

    /**
     * Возвращает выбранного получаетеля (берется из $_COOKIE['fsinzak-selected-recipient'])ы
     * @return bool|Recipients
     */
    public static function getCurrentRecipient()
    {
        if(isset($_COOKIE['fsinzak-selected-recipient']) && $_COOKIE['fsinzak-selected-recipient'] != ''){
            return new \Fsinzak\Model\Orm\Recipients($_COOKIE['fsinzak-selected-recipient']);
        }
        return false;
    }

    /**
     * Возвращает количество заказов пользователя за текущий месяц;
     * @param $recipient_id
     * @return int
     */
    public function getRecipientCountOrderPerMonth($recipient_id)
    {
        $current_month = date('m');
        $current_year = date('Y');
        $day_start = '01';
        $day_end = date('t');
        $date_start = $current_year.'-'.$current_month.'-'.$day_start;
        $date_end = $current_year.'-'.$current_month.'-'.$day_end;
        $orders_count = \RS\Orm\Request::make()
            ->from(new \Shop\Model\Orm\Order())
            ->where([
                'recipient_id' => $recipient_id
            ])
            ->where("DATE('dateof') >= {$date_start} AND DATE('dateof') <= {$date_end}")
            ->exec()->rowCount();
        return $orders_count;
    }

    /**
     * Устанавливает текущего получателя по id
     * @param int $recipient_id
     */
    public function setRecipient($recipient_id)
    {
        Application::getInstance()->headers->addCookie('fsinzak-selected-recipient', $recipient_id, time() + 60*60*24*365*10, '/');
    }
}
