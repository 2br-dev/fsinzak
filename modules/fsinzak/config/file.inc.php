<?php

namespace fsinzak\Config;

use RS\Orm\ConfigObject;
use RS\Orm\Type;
use RS\Orm\Type\Integer;

/**
 * Класс конфигурации модуля
 */
class File extends ConfigObject
{
    public function _init()
    {
        parent::_init()->append([
            t('Действия после оформления заказа'),
                'wait_pay_status' => new Integer(array(
                    'description' => t('Статус - Ожидание оплаты'),
                    'list' => [['\Shop\Model\UserStatusApi', 'staticSelectList'], [0 => t('Не назначено')]]
                )),
                'not_payed_status' => new Integer(array(
                    'description' => t('Статус - Не оплачено'),
                    'list' => [['\Shop\Model\UserStatusApi', 'staticSelectList'], [0 => t('Не назначено')]]
                )),
            t('Действия после оплаты заказа'),
                'in_institution_status' => new Type\Integer(array(
                    'description' => t('Статус - В обработке в учреждении'),
                    'list' => [['\Shop\Model\UserStatusApi', 'staticSelectList'], [0 => t('Не назначено')]]
                )),
                'end_status' => new Type\Integer(array(
                    'description' => t('Статус - Выполнен'),
                    'list' => [['\Shop\Model\UserStatusApi', 'staticSelectList'], [0 => t('Не назначено')]]
                )),
            t('Оформление заказа'),
                'product_commission' => new Type\Integer([
                    'description' => t('Комиссия за оплату заказа'),
                    'list' => [['\Catalog\Model\Api', 'staticSelectList']]
                ]),
                'status_to_send_pdf' => new Type\Integer([
                    'description' => t('статус заказа для отправки pdf'),
                    'list' => [['\Shop\Model\Userstatusapi', 'staticSelectList']]
                ])
        ]);
    }

    /**
     * Получаем родителя выбранного филиала
     * @param $affiliate_parent_id
     * @return \Affiliate\Model\Orm\Affiliate
     */
    public function getParentAffiliate($affiliate_parent_id)
    {
        $parent = new \Affiliate\Model\Orm\Affiliate($affiliate_parent_id);
        return $parent;
    }

    public function checkSelectRecipient()
    {

    }

    /**
     * Возвращает существующие ограничения. Первоначално проверяются ограничения Получателя. Если их нет, то возвращаются ограничения филиала
     * @return array|bool
     */
    public function getLimits()
    {
        /**
         * @var \Fsinzak\Model\Orm\Recipients $recipient
         */
        $recipient = new \Fsinzak\Model\Orm\Recipients($_COOKIE['fsinzak-selected-recipient']);
        $recipient_limits = $recipient->getRecipientLimits();
        $limits = [];
        $limit = [];
        /**
         * @var \Affiliate\Model\Orm\Affiliate $affiliate
         */
        $affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
        $affiliate_limits = $affiliate->getAffiliateLimits();

        if(empty($recipient_limits)){
            $limits = $affiliate_limits;
        }else{
            if(!empty($recipient->getRecipientLimitByType('limit_sum'))){
                $limit['type'] = 'limit_sum';
                $limit['value'] = $recipient->getRecipientLimitByType('limit_sum');
                $limits[] = $limit;
            }else{
                $limit['type'] = 'limit_sum';
                $limit['value'] = $affiliate->getAffiliateLimitByType('limit_sum');
                $limits[] = $limit;
            }
            if(!empty($recipient->getRecipientLimitByType('limit_weight'))){
                $limit['type'] = 'limit_weight';
                $limit['value'] = $recipient->getRecipientLimitByType('limit_weight');
                $limits[] = $limit;
            }else{
                $limit['type'] = 'limit_weight';
                $limit['value'] = $affiliate->getAffiliateLimitByType('limit_weight');
                $limits[] = $limit;
            }
        }
        return $limits;
    }

    /**
     * Возвращает значение ограничения по его типу. сначала проверяет у получателя потом у учреждения.
     * @param string $type
     * @return int
     */
    public function getLimitByType(string $type)
    {
        $current_recipient = \Fsinzak\Model\RecipientsApi::getCurrentRecipient();
        if($current_recipient){
            $limit = $current_recipient->getRecipientLimitByType($type);
            if(!$limit){
                $current_affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
                $limit = $current_affiliate->getAffiliateLimitByType($type);
            }
            return $limit;
        }
        return false;
    }
}
