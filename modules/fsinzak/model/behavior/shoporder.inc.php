<?php
namespace Fsinzak\Model\Behavior;

use Affiliate\Model\Orm\Affiliate;
use Fsinzak\Model\ExportModels\XLSX;
use RS\Behavior\BehaviorAbstract;
use Shop\Model\Orm\Order;

class ShopOrder extends BehaviorAbstract
{
    public function createXlsFile()
    {
        $order = $this->owner;
        $export_api = new \Fsinzak\Model\ExportApi(new XLSX());
        $export_api->getExportFile($order);
    }

    /**
     * Фозвращает получателя из заказа
     * @return \Fsinzak\Model\Orm\Recipients
     */
    public function getRecipient()
    {
        $order = $this->owner;
        return new \Fsinzak\Model\Orm\Recipients($order['recipient_id']);
    }

    public function getColonyTitle($with_region = true)
    {
        /**
         * @var Order $order
         */
        $order = $this->owner;
        if($order['affiliate_id']) {
            $affiliate_id = $order['affiliate_id'];
        }else {
            $affiliate = $order->getExtraInfoLine('affiliate');
            $affiliate_id = $affiliate['data']['id'];
        }
        $affiliate = new Affiliate($affiliate_id);
        if($with_region){
            $parent = $affiliate->getParentAffiliate();
            return $parent['title'] . ', ' . $affiliate['title'];
        }
        return $affiliate['title'];
    }

    public function getOrderAffiliateId()
    {
        /**
         * @var Order $order
         */
        $order = $this->owner;
        if($order['affiliate_id']) {
            return $order['affiliate_id'];
        }else {
            $affiliate = $order->getExtraInfoLine('affiliate');
            return $affiliate['data']['id'];
        }
    }

    /**
     * Возвращает адрес покупателя
     * @return mixed
     */
    public function getUserAddress()
    {
        /**
         * @var \Shop\Model\Orm\Order $order
         */
        $order = $this->owner;
        $user = $order->getUser();
        return $user->getAddress();
    }

    /**
     * Вовзращает регион заказа
     */
    public function getRegion()
    {
        $order = $this->owner;
        $affiliate_id = $order->getOrderAffiliateId();
        $affiliate = new \Affiliate\Model\Orm\Affiliate($affiliate_id);
        return $affiliate->getParentAffiliate();
    }
}
