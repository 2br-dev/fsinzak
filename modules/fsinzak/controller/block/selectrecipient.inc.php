<?php

namespace Fsinzak\Controller\Block;

use fsinzak\Model\RecipientsApi;
use RS\Application\Application;
use RS\Controller\StandartBlock;
use RS\Http\Request as HttpRequest;
use RS\Orm\ControllerParamObject;
use RS\Orm\Type;

/**
 * Блок-контроллер "Выбор получателя"
 */
class SelectRecipient extends StandartBlock
{
    protected static $controller_title = 'Выбор получателя';
    protected static $controller_description = 'Отображает выбранного получателя, а также позволяет выбрать другого или создать нового';

    protected $default_params = [
        'indexTemplate' => 'blocks/recipients/select_recipient.tpl', //Должен быть задан у наследника
    ];

    /** @var RecipientsApi */
    public $api;

    function init()
    {
        $this->api = new RecipientsApi();
        $this->api->setFilter('removed', 0);
    }

    /**
     * Возвращает ORM объект, содержащий настриваемые параметры или false в случае,
     * если контроллер не поддерживает настраиваемые параметры
     *
     * @return ControllerParamObject | false
     */
    function getParamObject()
    {
        return parent::getParamObject()->appendProperty([
            'referrer' => (new Type\Varchar())
                ->setVisible(false)
                ->setDescription(t('Адрес текущей страницы')),
        ]);
    }

    /**
     * Отображение получателей
     */
    function actionIndex()
    {
        $default_referer = $this->url->get('referer', TYPE_STRING, HttpRequest::commonInstance()->selfUri());
        $referer = $this->getParam('referer', $default_referer);
        $current_user = \RS\Application\Auth::getCurrentUser();
        if($current_user['id']){
            $this->api->setFilter('user_id', $current_user['id']);
        }
        $recipient_api = new \Fsinzak\Model\RecipientsApi();
        $current_recipient = $recipient_api::getRecipientFromCookie('fsinzak-selected-recipient');
        $cart = \Shop\Model\Cart::currentCart();
        $cart_empty = empty($cart->getProductItems()) ? true : false;
        $this->view->assign([
            'recipients' => $this->api->getList(),
            'current_recipient' => $current_recipient,
            'referer' => $referer,
            'cart_empty' => $cart_empty
        ]);
        return $this->result->setTemplate($this->getParam('indexTemplate'));
    }
}
