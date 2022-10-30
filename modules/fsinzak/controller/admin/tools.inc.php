<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Fsinzak\Controller\Admin;

use fsinzak\Model\Orm\HowOrder;

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
    * Обработка переключателя - опубликован Faq (Часто задаваемые вопросы)
    */
    function actionAjaxToggleFaqPublic()
    {
        $id = $this->url->request('id', TYPE_INTEGER, 0);
        $faq = new \Fsinzak\Model\Orm\Faq($id);
        $faq['public'] = !$faq['public'];
        $faq->update();

        return $this->result->setSuccess(true)->addMessage(t('Сохранено'));
    }

    /**
     * Обработка переключателя - опубликован Отзыва
     */
    function actionAjaxToggleReviewPublic()
    {
        $id = $this->url->request('id', TYPE_INTEGER, 0);
        $review = new \Fsinzak\Model\Orm\Faq($id);
        $review['public'] = !$review['public'];
        $review->update();

        return $this->result->setSuccess(true)->addMessage(t('Сохранено'));
    }

    /**
     * Обработка переключателя - опубликован Текстовые Блоки -> Как сделать заказ?
     */
    function actionAjaxToggleHowOrderPublic()
    {
        $id = $this->url->request('id', TYPE_INTEGER, 0);
        $orm = new HowOrder($id);
        $orm['public'] = !$orm['public'];
        $orm->update();

        return $this->result->setSuccess(true)->addMessage(t('Сохранено'));
    }
}
