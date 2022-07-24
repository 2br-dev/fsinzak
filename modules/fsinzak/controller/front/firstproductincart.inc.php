<?php

namespace fsinzak\Controller\Front;

use RS\Controller\Front;

/**
 * Фронт контроллер
 */
class FirstProductInCart extends Front
{
    function actionIndex()
    {
        return $this->result->setTemplate('test.tpl');
    }
}
