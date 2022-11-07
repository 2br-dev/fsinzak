<?php

namespace fsinzak\Controller\Front;

use RS\Controller\Front;

/**
 * Фронт контроллер
 */
class Affiliate extends Front
{
    function actionIndex()
    {
        return $this->result->setTemplate('test.tpl');
    }

    public function actionGetAffiliateLimitsModal()
    {
        $current_affiliate_id = $this->url->request('current_affiliate', TYPE_INTEGER);
        $current_affiliate = new \Affiliate\Model\Orm\Affiliate($current_affiliate_id);
        $affiliate_limits = $current_affiliate->getAffiliateLimits();
        $parent_affiliate = $current_affiliate->getParentAffiliate();
        $this->view->assign([
            'limits' => $affiliate_limits,
            'current_affiliate' => $current_affiliate,
            'parent_affiliate' => $parent_affiliate
        ]);
        return $this->result->setTemplate('%fsinzak%/affiliate_limits_modal.tpl');
    }
}
