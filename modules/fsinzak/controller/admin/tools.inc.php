<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Fsinzak\Controller\Admin;

/**
* Содержит действия по обслуживанию
*/
class Tools extends \RS\Controller\Admin\Front
{
    function actionSentOrderBlank()
    {
        $order_id = $this->url->request('order_id', TYPE_INTEGER);
        $order = new \Shop\Model\Orm\Order($order_id);
        return $this->result->setSuccess(true)->addMessage(t('Бланк отправлен'));
    }
    /**
    * Обработка переключателя - Допущен к работе с заказами в админ. части - учетные записи пользователи
    */
    function actionAjaxToggleUserAllowedToOrder()
    {
        $id = $this->url->request('id', TYPE_INTEGER, 0);
        $user = new \Users\Model\Orm\User($id);  
        $user['allowed_to_orders'] = !$user['allowed_to_orders'];
        $user->update();

        return $this->result->setSuccess(true)->addMessage(t('Сохранено'));
    }
}
