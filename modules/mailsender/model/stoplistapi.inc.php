<?php
namespace MailSender\Model;

class StopListApi extends \RS\Module\AbstractModel\EntityList
{
    function __construct()
    {
        parent::__construct(new Orm\StopList(), [
            'multisite' => true
        ]);
    }
    
    /**
    * Возвращает true, если подпись верна для email'а
    * 
    * @param string $email - Email
    * @param string $sign - подпись
    * @return bool
    */
    public static function checkUnsubscribeSign($email, $sign)
    {
        return $sign === self::getUnsubscribeSign($email);
    }
    
    /**
    * Возвращает подпись для отписки email'а от рассылки
    * 
    * @param string $email
    * @return string
    */
    public static function getUnsubscribeSign($email)
    {
        return substr(md5('EMAIL'.$email.\Setup::$SECRET_KEY), 0, 10);
    }

    /**
     * Возвращает список email'ов в стоп-листе в нижнем регистре
     *
     * @return array
     */
    public function getStopEmailsInLowerCase()
    {
        $this->queryObj()->select = 'LOWER(email) as email';
        return $this->getListAsResource()->fetchSelected('email', 'email');
    }
}