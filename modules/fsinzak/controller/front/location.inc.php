<?php

namespace fsinzak\Controller\Front;

use RS\Controller\Front;

/**
 * Фронт контроллер
 */
class Location extends Front
{
    function actionIndex()
    {
        return $this->result->setTemplate('test.tpl');
    }

    /**
     * Возвращает список Учреждений по id выбранного региона
     * @return \RS\Controller\Result\Standard
     */
    function actionGetInstitutionsList()
    {
        $region_id = $this->request('id', TYPE_INTEGER);
        $referer = $this->request('referer', TYPE_STRING);
        $affiliate_api = new \Affiliate\Model\AffiliateApi();
        $institutions = $affiliate_api
                            ->setFilter('public', 1)
                            ->setFilter('parent_id', $region_id)
                            ->getListAsArray();
        $router = \RS\Router\Manager::obj();
        foreach ($institutions as $key => $institution){
            $affiliate = new \Affiliate\Model\Orm\Affiliate($institution['id']);
            $institutions[$key]['url'] = $router->getUrl('fsinzak-front-location', ['Act' => 'getInstitutionData']);
            $institutions[$key]['redirect'] = $affiliate->getChangeAffiliateUrl($referer);
            $institutions[$key]['limits'] = $affiliate->getAffiliateLimits();
            $institutions[$key]['delivery'] = $affiliate->getAffiliateDeliveryInfo();
        }

        $this->result->addSection('institutions', $institutions);
        $this->result->addSection('referer', $referer);
        return $this->result;
    }

    /**
     * Получение данных учреждения для заполенения данных ограничений и доставк и смены филиала (учреждения)
     * @return \RS\Controller\Result\Standard
     */
    function actionGetInstitutionData()
    {
        $institution_id = $this->request('id', TYPE_INTEGER);
        $referer = $this->request('referer', TYPE_STRING);
        $institution = new \Affiliate\Model\Orm\Affiliate($institution_id);
        $redirect = $institution->getChangeAffiliateUrl($referer);
        $limits = $institution->getAffiliateLimits();
        $delivery = $institution->getAffiliateDeliveryInfo();

        $this->result->addSection([
            'institution' => $institution->getValues(),
            'limits' => $limits,
            'delivery' => $delivery,
            'redirect' => $redirect
        ]);
        return $this->result;
    }
}
