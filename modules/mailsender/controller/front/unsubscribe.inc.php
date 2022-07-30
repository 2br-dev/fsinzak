<?php
namespace MailSender\Controller\Front;
use \MailSender\Model;

/**
* Фронт контроллер
*/
class Unsubscribe extends \RS\Controller\Front
{
    function actionIndex()
    {
        $email = $this->url->get('email', TYPE_STRING);
        $sign = $this->url->get('sign', TYPE_STRING);
        
        if (Model\StopListApi::checkUnsubscribeSign($email, $sign)) {
            $stop_list = new Model\Orm\StopList();
            $stop_list['email'] = $email;
            $stop_list->insert();
        } else {
            $this->e404(t('Неверная подпись'));
        }
        
        return $this->result->setTemplate('unsubscribe.tpl');
    }
}