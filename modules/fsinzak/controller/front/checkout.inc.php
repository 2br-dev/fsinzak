<?php

namespace fsinzak\Controller\Front;

use RS\Controller\Front;

/**
 * Фронт контроллер
 */
class Checkout extends Front
{
    function actionIndex()
    {
        return $this->result->setTemplate('test.tpl');
    }

    public function actionCheckoutUserEdit()
    {
        return $this->result->setTemplate('%fsinzak%/checkout-user-edit.tpl');
    }
}
