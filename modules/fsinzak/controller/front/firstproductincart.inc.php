<?php

namespace fsinzak\Controller\Front;

use RS\Controller\Front;
use RS\Http\Request as HttpRequest;

/**
 * Фронт контроллер
 */
class FirstProductInCart extends Front
{
    function actionIndex()
    {
        $referer = $this->url->get('referer', TYPE_STRING, '/');
        $router_id = $this->url->request('router_id', TYPE_STRING, '');
        $current_affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
        $current_recipient = \Fsinzak\Model\RecipientsApi::getCurrentRecipient();
        $product_id = $this->url->request('add', TYPE_INTEGER, 0);
        $offer_id = 0;
        if($this->url->isPost()){
            $referer = $this->request('referer', TYPE_STRING, '/');
            $product_id = $this->request('product_id', TYPE_INTEGER);
            $offer_id = $this->request('offer_id', TYPE_INTEGER);
        }

        $product = new \Catalog\Model\Orm\Product($product_id);
        $this->view->assign([
            'affiliate' => $current_affiliate,
            'recipient' => $current_recipient,
            'product' => $product,
            'referer' => $referer,
            'router_id' => $router_id,
            'offer_id' => $offer_id
        ]);

        return $this->result->setTemplate('%fsinzak%/firstproductincart.tpl');
    }
}
