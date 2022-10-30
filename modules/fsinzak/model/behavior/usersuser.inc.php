<?php
namespace Fsinzak\Model\Behavior;

use fsinzak\Model\ReviewApi;
use RS\Behavior\BehaviorAbstract;

class UsersUser extends BehaviorAbstract
{
    /**
     * Возвращает получаетелей пользователя
     * @return \RS\Orm\AbstractObject[]
     */
    public function getRecipients()
    {
        /**
         * @var \Users\Model\Orm\User $user
         */
        $user = $this->owner;
        $recipient_api = new \Fsinzak\Model\RecipientsApi();
        $recipients = $recipient_api->setFilter('user_id', $user['id'])
                                    ->setFilter('removed', 0)
                                    ->getList();
        return $recipients;
    }

    /**
     * возвращает адрес Покупателя
     * @return string
     */
    public function getAddress()
    {
        $user = $this->owner;
        $user_unserialized = unserialize($user['_serialized']);
        return $user_unserialized['country'].', '
                .$user_unserialized['region'].', '
                .$user_unserialized['city'].', '
                .$user_unserialized['address'];
    }

    /**
     * Возвращает Гражданство покупателя
     * @return mixed
     */
    public function getCitizen()
    {
        $user = $this->owner;
        $user_unserialized = unserialize($user['_serialized']);
        return $user_unserialized['citizen'];
    }

    /**
     * Возвращает паспорт Покупателя
     * @return mixed
     */
    public function getPasport()
    {
        $user = $this->owner;
        $user_unserialized = unserialize($user['_serialized']);
        return $user_unserialized['pasport'];
    }

    /**
     * Возвращает последний заказ пользователя
     * @return \RS\Orm\AbstractObject|null
     */
    public function getLastOrder()
    {
        $user = $this->owner;
        $order_api = new \Shop\Model\OrderApi();
        $last_order = $order_api->setFilter('user_id', $user['id'])->getFirst();
        return $last_order;
    }

    /**
     * Проверяет оставлял ли пользователь отзыв
     */
    public function checkReview()
    {
        $user = $this->owner;
        $review_api = new ReviewApi();
        $review = $review_api->setFilter('user_id', $user['id'])->getListCount();
        return $review ? true : false;
    }
}
