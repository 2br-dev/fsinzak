<?php
namespace Fsinzak\Model\Behavior;

use Catalog\Model\Orm\WareHouse;
use Catalog\Model\ProductDialog;
use RS\Behavior\BehaviorAbstract;
use RS\Orm\Request;

class AffiliateAffiliate extends BehaviorAbstract
{
    /**
     * Проверяем ограничения филиала. Если ограничений филиала нет - то проверяем ограничения у его родителя (региона)
     * @return array
     */
    public function getAffiliateLimits()
    {
        $affiliate = $this->owner;
        $limits =  [];
        $limit = [];
        if($affiliate['limit_sum'] != 0){
            $limit['type'] = 'limit_sum';
            $limit['value'] = $affiliate['limit_sum'];
            $limits[] = $limit;
//            $limits[]['type'] = 'limit_sum';
//            $limits[]['value'] = $affiliate['limit_sum'];
        }else{
            $parent_affiliate = new \Affiliate\Model\Orm\Affiliate($affiliate['parent_id']);
            if($parent_affiliate['limit_sum']){
                $limit['type'] = 'limit_sum';
                $limit['value'] = $parent_affiliate['limit_sum'];
                $limits[] = $limit;
//                $limits[][]['type'] = 'limit_sum';
//                $limits[][]['value'] = $parent_affiliate['limit_sum'];
            }
        }
        $limit = [];
        if($affiliate['limit_weight'] != 0){
            $limit['type'] = 'limit_weight';
            $limit['value'] = $affiliate['limit_weight'];
            $limits[] = $limit;
        }else{
            $parent_affiliate = new \Affiliate\Model\Orm\Affiliate($affiliate['parent_id']);
            if($parent_affiliate['limit_weight']){
                $limit['type'] = 'limit_weight';
                $limit['value'] = $parent_affiliate['limit_weight'];
                $limits[] = $limit;
            }
        }
        $limit = [];
        if($affiliate['periodicity'] != 0){
            $limit['type'] = 'periodicity';
            $limit['value'] = $affiliate['periodicity'];
            $limits[] = $limit;
        }else{
            $parent_affiliate = new \Affiliate\Model\Orm\Affiliate($affiliate['parent_id']);
            if($parent_affiliate['periodicity']){
                $limit['type'] = 'periodicity';
                $limit['value'] = $parent_affiliate['periodicity'];
                $limits[] = $limit;
            }
        }

        return $limits;
    }

    /**
     * Возвращает ограничение филиала по Типу огарничения
     * @param string $type
     * @return int
     */
    public function getAffiliateLimitByType($type)
    {
        $affiliate = $this->owner;
        $limit = 0;
        if($affiliate[$type] != 0){
            $limit = $affiliate[$type];
        }else{
            $parent_affiliate = new \Affiliate\Model\Orm\Affiliate($affiliate['parent_id']);
            if($parent_affiliate['limit_weight'] != 0){
                $limit = $parent_affiliate['limit_weight'];
            }
        }
        return $limit;
    }

    /**
     * Возвращает HTML код для блока "сопутствующие товары"
     * @return ProductDialog
     */
    function getProductsDialogConcomitant()
    {
        $_this = $this->owner;
        $product_dialog = new ProductDialog('concomitant_arr', true, @(array)$_this['concomitant_arr']);
        $product_dialog->setTemplate('%fsinzak%/dialog/view_selected_concomitant.tpl');
        return $product_dialog;
    }

    /**
     * Возвращает верхний уровень учречдения - регион
     * @return \Affiliate\Model\Orm\Affiliate
     */
    function getParentAffiliate()
    {
        $current_affiliate = $this->owner;
        return new \Affiliate\Model\Orm\Affiliate($current_affiliate['parent_id']);
    }

    /**
     * Возвращает список учрежедений по Id родителя
     * @return array
     */
    function getAffiliatesByParentId()
    {
        $current_affiliate = $this->owner;
        $affiliate_api = new \Affiliate\Model\AffiliateApi();
        $list = $affiliate_api->setFilter('public', 1)->setFilter('parent_id', $current_affiliate['id'])->getListAsArray();
        return $list;
    }

    /**
     * Возвращает информацию о доставке филиала. Если у филиала нет информации - возвращает информацию о доставке региона
     * @return mixed|\RS\Orm\Type\AbstractType|string
     */
    function getAffiliateDeliveryInfo()
    {
        $affiliate = $this->owner;
        $delivery_info = '';
        if($affiliate['delivery_info']){
            $delivery_info = $affiliate['delivery_info'];
        }else{
            $parent = new \Affiliate\Model\Orm\Affiliate($affiliate['parent_id']);
            if($parent['delivery_info']){
                $delivery_info = $parent['delivery_info'];
            }
        }
        return $delivery_info;
    }

    /**
     * Возвращает информацию о наименовании цены из справочника цен прявязанной к филиалу
     * @return mixed
     */
    function getAffiliateCost()
    {
        $affiliate = $this->owner;
        return $affiliate['cost_id'];
    }

    /**
     * Возвращает есть ли ограничение у филиала по id товара
     * @param $product_id
     * @return bool|int
     */
    function getAffiliateProductLimitByProductId($product_id)
    {
        $affiliate = $this->owner;
        $affiliate_product_limits = unserialize($affiliate['concomitant']);
        if(isset($affiliate_product_limits['limit_amount'][$product_id])){
            return intval($affiliate_product_limits['limit_amount'][$product_id]);
        }
        return false;
    }

    /**
     * Возвращает продуктовые ограничения филиала
     * @return bool|mixed
     */
    function getAffiliateProductLimit()
    {
        $affiliate = $this->owner;
        $affiliate_product_limit = unserialize($affiliate['concomitant']);
        $product_limit = [];
        $limit = [];
        if(!empty($affiliate_product_limit)){
            foreach ($affiliate_product_limit['limit_amount'] as $key => $value){
                $limit['product'] = $key;
                $limit['amount'] = intval($value);
                $product_limit[] = $limit;

            }
        }
        return $product_limit;
    }

    /**
     * Возвращает коммиссию учреждения. Если у учреждения не заполенено значение коммиссии, то берется у региона.
     * @return array
     */
    function getAffiliateCommission()
    {
        $affiliate = $this->owner;
        $commission = [];
        $parent_affiliate = new \Affiliate\Model\Orm\Affiliate($affiliate['parent_id']);

        if($affiliate['commission_fixed']){
            $commission['fixed'] = $affiliate['commission_fixed'];
        }else{
            $commission['fixed'] = $parent_affiliate['commission_fixed'];
        }
        if($affiliate['commission_percent']){
            $commission['percent'] = $affiliate['commission_percent'];
        }else{
            $commission['percent'] = $parent_affiliate['commission_percent'];
        }
        return $commission;
    }

    /**
     * Возвращает правила для корзины
     *
     * @return array|null
     */
    function getCartRules(): ?array
    {
        /**
         * @var Affiliate $affiliate
         */
        $affiliate = $this->owner;

        if (!empty($affiliate['cartrules_arr'])){
            return $affiliate['cartrules_arr'];
        }
        if (!empty($affiliate['parent_id'])){
            $parent = $this->getParentAffiliate();
            return $parent->getCartRules();
        }
        return null;
    }

    /*
     * Возвращает id склада Учреждения
     */
    public function getAffiliateWarehouse()
    {
        $affiliate = $this->owner;
        $site_id = \RS\Site\Manager::getSiteId();
        $warehouse_id = Request::make()
            ->select('id')
            ->from(new WareHouse())
            ->where([
                'site_id' => $site_id,
                'affiliate_id' => $affiliate['id']
            ])
            ->exec()->getOneField('id');

        return intval($warehouse_id);
    }

    /**
     * Возвращает емейл для оптарвки pdf заказа
     * @return string
     */
    public function getEmailForSendPdf()
    {
        return $this->getValueByName('email_for_pdf');
    }

    /**
     * Возвращает время через которое переводить заказ со статусом Ожидает оплату в статус Не оплачен
     * @return mixed
     */
    public function getTimeToNotPaid()
    {
        return $this->getValueByName('time_to_not_payed_status');
    }

    /**
     * Возвращает значени колонки из дб Филиала либо его родителя
     * @param $name
     * @return mixed
     */
    public function getValueByName($name)
    {
        $affiliate = $this->owner;
        if($affiliate[$name]){
            return $affiliate[$name];
        }else{
            $parent_affiliate = $affiliate->getParrentAffiliate();
            return $parent_affiliate[$name];
        }
    }

    public function getManagerForNotPaid()
    {
        return $this->getValueByName('manager_for_not_payment');
    }

    public function getTimeToCheckStatusProcess()
    {
        return $this->getValueByName('status_to_success_days');
    }

    public function getManagerToCheckOrderProcessStatus()
    {
        return $this->getValueByName('manager_for_check_status');
    }
}
