<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/

namespace Shop\Controller\Block;

use Catalog\Model\CurrencyApi;
use RS\Controller\Result\Standard;
use RS\Controller\StandartBlock;
use RS\Exception as RSException;
use Shop\Model\Cart;

/**
 * Блок-контроллер Корзина
 */
class CartFull extends StandartBlock
{
    protected static $controller_title = 'Корзина';
    protected static $controller_description = 'Отображает корзину';

    protected $action_var = 'action';
    protected $default_params = [
        'indexTemplate' => 'blocks/cart/cart_full.tpl',
    ];

    /** @var \Shop\Model\Cart $cart */
    public $cart;

    function init()
    {
        $this->cart = \Shop\Model\Cart::currentCart();
    }

    /**
     * @return Standard
     * @throws RSException
     */
    function actionIndex()
    {
        $cart = \Shop\Model\Cart::currentCart();
        $cart_data = $cart->getCartData();
        $this->view->assign([
            'cart' => $cart,
            'cart_data' => $cart_data,
            'cart_info' => $cart->getCurrentInfo(),
            'currency' => CurrencyApi::getCurrentCurrency(),
        ]);
        $section_cart = [
            'can_checkout' => !$cart_data['has_error'],
            'total_unformated' => $cart_data['total_unformatted'],
            'total_price' => $cart_data['total'],
            'items_count' => $cart_data['items_count'],
            'session_cart_products' => $_SESSION[Cart::SESSION_CART_PRODUCTS],
        ];
        return $this->result->setTemplate($this->getParam('indexTemplate'))->addSection('cart', $section_cart);
    }

    /**
     * Обновляет информацию о товарах, их количестве в корзине. Добавляет купон на скидку, если он задан
     */
    function actionUpdate()
    {
        if ($this->url->isPost()) {
            $products = $this->url->request('products', TYPE_ARRAY);
            $coupon = trim($this->url->request('coupon', TYPE_STRING));

            //Проверка ограничений
            $cart = $this->cart;
            $cart_products = $cart->getProductItems();

            $new_total_cost = 0;
            $new_total_weight = 0;

            $config_fsinzak = \RS\Config\Loader::byModule('fsinzak');
            $limits = $config_fsinzak->getLimits();

            $limit_error = '';

            // Проверяем товарные ограничения
//            $products = $cart->getCartItemsByType('product');
            $current_affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
            $product_limit = $current_affiliate->getAffiliateProductLimit();

            foreach ($cart_products as $index => $item) {
                if(isset($products[$index])) {
                    //Новое количество товара в корзине
                    $new_amount = $products[$index]['amount'];
                    /**
                     * @var \Catalog\Model\Orm\Product $product
                     */
                    $product = $item['product'];

                    $product_single_cost = $product->getCost(null, null, false);
                    $product_single_weight = $product['weight'];

                    $product_cost = floatval($product_single_cost) * intval($new_amount);
                    $product_weight = floatval($product_single_weight) * intval($new_amount);

                    $new_total_cost += $product_cost;
                    $new_total_weight += $product_weight;
                }
            }

            if(!empty($limits)){

                foreach ($limits as $limit){
                    if($limit['type'] == 'limit_sum' && $limit['value'] < $new_total_cost){
                        $limit_error = 'sum';
                    }
                    if($limit['type'] == 'limit_weight' && $limit['value'] < $new_total_weight){
                        $limit_error = 'weight';
                    }
                }
            }
            // Если не достигнуты ограничения учреждения либо получателя, то проверим товарные ограничения
            if($limit_error == ''){
                foreach($cart_products as $index => $item){
                    $product = $item['product'];
                    foreach($product_limit as $limit){
                        if($limit['product'] == $product['id']){
                            $new_amount = $products[$index]['amount'];
                            if($new_amount > $limit['amount']){
                                $limit_error = 'product';
                            }
                        }
                    }
                }
            }

            if($limit_error == ''){
                $apply_coupon = $this->cart->update($products, $coupon, true, true);
            }else{
                $apply_coupon = true;
            }

            if ($apply_coupon !== true) {
                $this->cart->addUserError($apply_coupon, false, 'coupon');

                $this->view->assign([
                    'coupon_code' => $coupon,
                ]);
            }
            $this->result->addSection('limit_error', $limit_error);
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
     * @throws RSException
     */
    function actionCleanCart()
    {
        $this->cart->clean();
        return $this->actionIndex();
    }
}
