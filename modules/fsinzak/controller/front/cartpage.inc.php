<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/

namespace Fsinzak\Controller\Front;

use Main\Model\StatisticEvents;
use RS\Application\Application;
use RS\Config\Loader as ConfigLoader;
use RS\Controller\Front;
use RS\Controller\Result\Standard;
use RS\Event\Manager as EventManager;
use RS\Exception as RSException;
use RS\Router\Manager as RouterManager;
use Shop\Config\File as ShopConfig;
use Shop\Model\Cart;

/**
 * Просмотр корзины
 */
class CartPage extends Front
{
    const CART_SOURCE_CART_PAGE = 'cart_page'; // источник "товар добавлен вручную"

    /** @var Cart $cart */
    public $cart;

    function init()
    {
        $this->cart = Cart::currentCart();
    }

    /**
     * Корзина
     */
    function actionIndex()
    {
        /** @var ShopConfig $config */
        $config = ConfigLoader::byModule('shop');
        $float_cart = $this->url->request('floatCart', TYPE_BOOLEAN, false);
        $id = $this->url->request('add', TYPE_INTEGER);       //id товара
        $amount = $this->url->request('amount', TYPE_FLOAT);    //Количество
        $offer = $this->url->request('offer', TYPE_STRING, $this->url->request('offer_id', TYPE_STRING));      //Комплектация
        $multioffers = $this->url->request('multioffers', TYPE_ARRAY); //Многомерные комплектации
        $concomitants = $this->url->request('concomitant', TYPE_ARRAY); //Сопутствующие товары
        $concomitants_amount = $this->url->request('concomitant_amount', TYPE_ARRAY); //Количество сопутствующих твоаров
        $additional_uniq = $this->url->request('uniq', TYPE_STRING); // Дополнительный унификатор товара
        $checkout = $this->url->request('checkout', TYPE_BOOLEAN);

        $this->app->breadcrumbs->addBreadCrumb(t('Корзина'));
        $this->app->title->addSection(t('Корзина'));

        $cart_error = [];

        if (!empty($id)) {
            /**
             * @var \Shop\Model\Cart $cart
             */
            $cart = $this->cart;
            $cart_data = $cart->getCartData();

            // Проверяем ограничения.
            // periodicity - переодичность заказов, sum - ограничение по сумме, weight - ограничение по весу корзины.
            $config_fsinzak = \RS\Config\Loader::byModule('fsinzak');
            $limits = $config_fsinzak->getLimits();
            $recipient_api = new \Fsinzak\Model\RecipientsApi();
            $recipient = $recipient_api::getRecipientFromCookie($_COOKIE['fsinzak-selected-recipient']);
            if(!empty($limits)){
                $product = new \Catalog\Model\Orm\Product($id);
                $cart_total_sum = $cart_data['total_unformatted'];
                $cart_total_weight = 0;

                foreach ($cart_data['items'] as $item){
                    $item_weight = $item['single_weight'] * $item['amount'];
                    $cart_total_weight = $cart_total_weight + $item_weight;
                }
                foreach ($limits as $limit) {
                    if($limit['type'] == 'limit_sum'){
                        if($cart_total_sum + (intval($product->getCost(null, null, false)) * $amount) > $limit['value']){
                            $cart_error[] = 'limit_sum';
                        }
                    }
                    if($limit['type'] == 'limit_weight'){
                        if($cart_total_weight + ($product['weight'] * $amount) > $limit['value']){
                            $cart_error[] = 'limit_weight';
                        }
                    }
                }
            }

            if(!empty($cart_error)){
                $this->result->addSection('cart_error', $cart_error);
                $this->result->addSection('id', $id);
                return $this->result;
            }

            $this->cart->addProduct($id, $amount, $offer, $multioffers, $concomitants, $concomitants_amount, $additional_uniq, self::CART_SOURCE_CART_PAGE, true);

            $this->result->addSection('cart_error', $cart_error);
            if (!$this->url->isAjax()) {
                $this->app->redirect($this->router->getUrl('shop-front-cartpage'));
            }
        }

        if ($config->getCheckoutType() == ShopConfig::CHECKOUT_TYPE_CART_CHECKOUT && !$this->url->isPost() && !$float_cart) {
            Application::getInstance()->redirect(RouterManager::obj()->getUrl('shop-front-checkout'));
        }

        $cart_data = $this->cart->getCartData();

        $this->view->assign([
            'cart' => $this->cart,
            'cart_data' => $cart_data,
        ]);

        if ($checkout && !$cart_data['has_error']) {
            // Фиксация события "Начало оформления заказа" для статистики
            EventManager::fire('statistic', ['type' => StatisticEvents::TYPE_SALES_CART_SUBMIT]);

            if ($config->getCheckoutType() == ShopConfig::CHECKOUT_TYPE_ONE_PAGE) {
                $this->result->setRedirect($this->router->getUrl('shop-front-checkout', ['Act' => 'freezeCart']));
            } else {
                $this->result->setRedirect($this->router->getUrl('shop-front-checkout'));
            }
        }

        $this->result->addSection('cart', $this->getCartStateData($cart_data));

        return $this->result->setTemplate('%shop%/cartpage.tpl');
    }

    /**
     * Возвращает массив с информацией о состоянии корзины
     *
     * @param $cart_data
     * @return array
     */
    protected function getCartStateData($cart_data)
    {
        return [
            'can_checkout' => !$cart_data['has_error'],
            'total_unformated' => $cart_data['total_unformatted'],
            'total_price' => $cart_data['total'],
            'items_count' => $cart_data['items_count'],
            'session_cart_products' => $_SESSION[Cart::SESSION_CART_PRODUCTS],
        ];
    }

    /**
     * Обновляет информацию о товарах, их количестве в корзине. Добавляет купон на скидку, если он задан
     */
    function actionUpdate()
    {
        if ($this->url->isPost()) {
            $products = $this->url->request('products', TYPE_ARRAY);
            $coupon = trim($this->url->request('coupon', TYPE_STRING));
            $apply_coupon = $this->cart->update($products, $coupon, true, true);

            if ($apply_coupon !== true) {
                $this->cart->addUserError($apply_coupon, false, 'coupon');

                $this->view->assign([
                    'coupon_code' => $coupon,
                ]);
            }
        }

        return $this->actionIndex();
    }

    /**
     * Удаляет товар из корзины
     *
     * @return Standard
     * @throws RSException
     */
    function actionRemoveItem()
    {
        $uniq = $this->url->request('id', TYPE_STRING);
        $this->cart->removeItem($uniq, true);
        return $this->actionIndex();
    }

    /**
     * Очищает корзину
     *
     * @return Standard
     */
    function actionCleanCart()
    {
        $this->cart->clean();
        return $this->actionIndex();
    }

    /**
     * Повторяет предыдущий заказ
     *
     * @return void
     * @throws RSException
     */
    function actionRepeatOrder()
    {
        $order_num = $this->url->request('order_num', TYPE_STRING, false); //Номер заказа

        if ($order_num) { //Если заказ найден, повторим его и переключимся в корзину
            $this->getCart()->repeatCartFromOrder($order_num);
        }
        Application::getInstance()->redirect($this->router->getUrl('shop-front-cartpage'));
    }

    /**
     * Возвращает корзину
     *
     * @return Cart
     */
    function getCart()
    {
        return $this->cart;
    }

    /**
     * Изменяет количество товара в корзине. Метод необходим для smart кнопок "В корзину",
     * которые превращаются в количество
     *
     * @return Standard
     * @throws RSException
     * @throws \RS\Db\Exception
     */
    public function actionChangeAmount()
    {
        $id = $this->url->request('id', TYPE_INTEGER);
        $amount = $this->url->request('amount', TYPE_FLOAT);

        // Проверяем ограничения.
        // periodicity - переодичность заказов, sum - ограничение по сумме, weight - ограничение по весу корзины.
        $cart_error = [];
        $cart = $this->cart;
        $cart_data = $cart->getCartData();
        $config_fsinzak = \RS\Config\Loader::byModule('fsinzak');
        $limits = $config_fsinzak->getLimits();
        $recipient_api = new \Fsinzak\Model\RecipientsApi();
        $recipient = $recipient_api::getRecipientFromCookie('fsinzak-selected-recipient');

        $product = new \Catalog\Model\Orm\Product($id);

        if(!empty($limits) && ($amount > $product->getAmountInCart())){
            $cart_total_sum = $cart_data['total_unformatted'];
            $cart_total_weight = 0;

            foreach($cart_data['items'] as $item){
                $item_weight = $item['single_weight'] * $item['amount'];
                $cart_total_weight = $cart_total_weight + $item_weight;
            }
            foreach($limits as $limit){
                if($limit['type'] == 'limit_sum'){
                    if(($cart_total_sum + $product->getCost(null, null, false)) > $limit['value']){
                        $cart_error[] = 'limit_sum';
                    }
                }
                if($limit['type'] == 'limit_weight'){
                    if(($cart_total_weight + $product['weight']) > $limit['value']){
                        $cart_error[] = 'limit_weight';
                    }
                }
            }
        }
//        exit('fdf');
        // Проверяем товарные ограничения
        $products = $cart->getCartItemsByType('product');
        $current_affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
        $product_limit = $current_affiliate->getAffiliateProductLimitByProductId($id);
        if($product_limit){

            $product_amount = 0;
            foreach ($products as $data){
                /**
                 * @var \Shop\Model\Orm\CartItem $data
                 */
                if($id == intval($data['entity_id'])){
                    $product_amount = $data['amount'];
                }
            }
            // Проверяем будет ли превшен лимит при добавлени
            //Если товар есть в корзине (количестов не 0)
            if($product_amount){
                if($amount > intval($product_limit)){
                    $cart_error[] = 'limit_product_amount';
                }
            }
        }

        if(!empty($cart_error)){
            //Получить количество этого товара в корзине, чтоб не обновлять количество в умной кнопке
            foreach ($products as $data){
                /**
                 * @var \Shop\Model\Orm\CartItem $data
                 */
                if($id == intval($data['entity_id'])){
                    $this->result->addSection('amount', $data['amount']);
                }
            }
            $this->result->addSection('cart_error', $cart_error);
            $this->result->setSuccess(false);
            return $this->result;
        }
        // Конец проверки ограничений филилала
        $products = $this->cart->getProductItems();
        $new_items = [];

        foreach ($products as $uniq => $item) {
            if ($item['cartitem']['entity_id'] == $id) {
                if ($amount == 0) {
                    $this->cart->removeItem($uniq);
                } else {
                    $products[$uniq]['cartitem']['amount'] = $amount;
                    $new_items[$uniq] = $products[$uniq]['cartitem'];
                }
            }
        }
        if ($amount != 0) {
            $this->cart->update($new_items);
        }

        return $this->result
            ->addSection('cart', $this->getCartStateData($this->cart->getCartData()))
            ->setSuccess(true);
    }
}
