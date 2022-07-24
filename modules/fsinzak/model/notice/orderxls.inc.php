<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Fsinzak\Model\Notice;

use RS\Config\Loader;
use Shop\Model\Orm\Order;
use Site\Model\Orm\Site;

/**
* Уведомление - заказ был изменен
*/
class OrderXls extends \Alerts\Model\Types\AbstractNotice
    implements \Alerts\Model\Types\InterfaceEmail
{
    /**
     * @var $order Order
     */
    public $order;
    public $config;
    public $email;
        
    /**
    * Возвращает название уведомления
    *     
    */
    public function getDescription()
    {
        return t('Заказ в формает xls');
    } 
    
    /**
    * Инициализация уведомления
    * 
    * @param \Shop\Model\Orm\Order $order - объект заказа
    */    
    function init(\Shop\Model\Orm\Order $order, \Affiliate\Model\Orm\Affiliate $affiliate)
    {
        $this->order = $order;
        $this->config  = Loader::byModule('fsinzak');
        $this->email = $affiliate->getEmailForSendPdf();
    }
    
    /**
    * Получаение информации о письме
    * 
    * @return \Alerts\Model\Types\NoticeDataEmail|false
    */
    function getNoticeDataEmail()
    {
        $notice_data = new \Alerts\Model\Types\NoticeDataEmail();
        
        $email_to_user = new \Alerts\Model\Types\NoticeDataEmail();
        
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)){ //Если задан E-mail
            $notice_data->email = $this->email;
        }else{ //Если E-mail нет
            return false;
        }

        $site = new Site($this->order->site_id);
        $domain = $site->getMainDomain();

        $notice_data->subject   = t('Заказ N%0 дата:%1 (xls)', [$this->order['order_num'], $this->order['dateof']]);
        $notice_data->vars      = $this;
        
        return $notice_data;
    }
    
    /**
    * Возвращает шаблон письма
    * 
    * @return string
    */
    function getTemplateEmail()
    {
        return '%fsinzsk%/notice/order_xls.tpl';
    }
}
