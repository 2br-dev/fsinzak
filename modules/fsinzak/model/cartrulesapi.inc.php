<?php

namespace Fsinzak\Model;

use Affiliate\Model\AffiliateApi;
use Catalog\Model\Orm\Product;
use RS\Module\AbstractModel\BaseModel;
use Shop\Model\Cart;
use Shop\Model\Orm\AbstractCartItem;
use Shop\Model\Orm\CartItem;
use Shop\Model\Orm\OrderItem;

/**
 * Класс для организации выборок ORM объекта.
 * В этом классе рекомендуется также реализовывать любые дополнительные методы, связанные с заявленной в конструкторе моделью
 */
class CartRulesApi extends BaseModel
{
    const CART_SOURCE_CART_RULES = 'affiliate_cart_rules';

    protected $cart;
    protected $cart_data;
    protected $cart_product_items;
    protected $cart_exists_subproducts_uniq = [];
    protected $cart_exists_subproducts_uniq_all = [];
    protected $cart_total_count = [];
    protected $cart_total_weight = [];
    protected $cart_total_price = [];
    protected $cart_products_by_id = [];

    /**
     * Применяет правила для корзины для определённого филиала
     *
     * @param Cart $cart - корзина
     * @throws \RS\Exception
     */
    function applyCartRules(Cart $cart) {
        $affiliate = AffiliateApi::getCurrentAffiliate();

        $rules = $affiliate->getCartRules();

        $this->cart = $cart;
        $this->cart_data = $cart->getCartData(false, false);
        $this->cart_product_items = $cart->getProductItems();

        $this->cart_exists_subproducts_uniq_all = $this->getExistsSubProductsUniq();

        list($this->cart_total_count, $this->cart_total_price, $this->cart_total_weight) = $this->getCartTotal();

        $this->createCartProductsById();

        $match_params = [
            'cart' => $this->cart,
            'cart_products_by_id' => $this->cart_products_by_id,
            'cart_total_count' => $this->cart_total_count,
            'cart_total_weight' => $this->cart_total_weight,
            'cart_total_price' => $this->cart_total_price,
        ];

        //Удаляет скидки по правилам для корзины
        foreach ($rules as $rule) {
            if (!$this->matchRule($match_params, $rule)) {
                $this->cancelRule($this->cart);
            }
        }
        foreach ($rules as $rule) {
            if ($this->matchRule($match_params, $rule) && !empty($rule['product'])) {
                $this->applyRule($this->cart, $rule);
            }
        }
    }

    /**
     * Возвращает true, если содержимое корзины соовтетствует правилам-условиям
     *
     * @param array $match_params - параметры для проверки
     * @param array $rule - правило для проверки
     * @return bool
     */
    public function matchRule($match_params, $rule): bool
    {
        $weight = $match_params['cart_total_weight'];
        $price  = $match_params['cart_total_price'];
        $match = true;
        foreach ($rule['condition'] as $k=>$condition){
            $from = $rule['equal_from'][$k];
            $to   = $rule['equal_to'][$k];
            switch ($condition){
                case "weight": // Если проверка по весу
                    $check = $weight;
                    break;
                case "total": // Если проверка по суммеп
                    $check = $price;
                    break;
            }

            if (!empty($from) && $check < $from){
                $match = false;
            }
            if (!empty($to) && $check > $to){
                $match = false;
            }
        }
        return $match;
    }


    /**
     * Возвращает уникальный идентификатор товара для корзины
     */
    function getUniqueId(): string
    {
        return 'affiliate-product';
    }

    /**
     * Выполняет действия отменяющие влияние правил-действий на корзину
     *
     * @param Cart $cart - корзина
     * @return void
     */
    public function cancelRule(Cart $cart)
    {
        foreach ($cart->getProductItems() as $uniq => $item) {
            /** @var CartItem $cart_item */
            $cart_item = $item['cartitem'];
            $item_source = $cart_item->getExtraParam(Cart::ITEM_EXTRA_KEY_SOURCE);
            $item_unique = $cart_item->getExtraParam(Cart::ITEM_EXTRA_KEY_ADDITIONAL_UNIQUE);
            if ($item_source == CartRulesApi::CART_SOURCE_CART_RULES && strpos($item_unique, $this->getUniqueId()) !== false) {
                $cart->removeItem($uniq);
            }
        }
    }

    /**
     * Применяет к корзине правила-действия добавляя товары
     *
     * @param Cart $cart - объект корзины
     * @param array $rule - правило для корзины
     * @return void
     */
    public function applyRule(Cart $cart, $rule)
    {
        /** @var AbstractCartItem $rule_cart_item */
        $rule_cart_item = null;
        $product_items = $cart->getProductItems();

        $rule_products = [];

        //Трансформируем в удобный массив данные из правила
        foreach ($rule['product'] as $product_id){
            $rule_products[$product_id] = $rule['product_amount'][$product_id];
        }

        // Добавим товары из правила в корзину
        foreach ($rule_products as $product_id => $product_amount) {
            $rule_cart_item = null;
            foreach ($product_items as $item) {
                /** @var CartItem $cart_item */
                $cart_item = $item[Cart::CART_ITEM_KEY];
                $item_source = $cart_item->getExtraParam(Cart::ITEM_EXTRA_KEY_SOURCE);
                $item_unique = $cart_item->getExtraParam(Cart::ITEM_EXTRA_KEY_ADDITIONAL_UNIQUE);

                if ($item_source == self::CART_SOURCE_CART_RULES && $item_unique == $this->getUniqueId() . '_' . $product_id) {
                    $rule_cart_item = $cart_item;
                    break;
                }
            }

            // Если товар не в корзине - добавляем его
            if ($rule_cart_item === null) {
                $additional_unique = $this->getUniqueId() . '_' . $product_id;
                $uniq = $cart->addProduct($product_id, 0, 0, [], [], [], $additional_unique, self::CART_SOURCE_CART_RULES);
                $items = $cart->getItems();
                $rule_cart_item = $items[$uniq];
                $rule_cart_item->setForbidRemove();
                $rule_cart_item->setForbidDiscounts();
            }

            //Установим количество и цену
            $rule_cart_item->setForbidChangeAmount();
            $rule_cart_item['amount'] = $product_amount;
            $single_cost = $rule_cart_item->getEntity()->getCost(null, null, false);
            if ($rule_cart_item instanceof CartItem) {
                $rule_cart_item->setExtraParam(CartItem::EXTRA_KEY_PRICE, $single_cost * $rule_cart_item['amount']);
            } else if ($rule_cart_item instanceof OrderItem) {
                $rule_cart_item['single_cost'] = $single_cost;
            }
        }

        //Удалим товары не входящие в правило, но бывшие добавлеными
        foreach ($product_items as $key => $item) {
            /** @var CartItem $cart_item */
            $cart_item = $item[Cart::CART_ITEM_KEY];
            $item_source = $cart_item->getExtraParam(Cart::ITEM_EXTRA_KEY_SOURCE);
            $item_unique = $cart_item->getExtraParam(Cart::ITEM_EXTRA_KEY_ADDITIONAL_UNIQUE);

            if ($item_source == self::CART_SOURCE_CART_RULES && strpos($item_unique, $this->getUniqueId()) !== false) {
                $uniq_parts = explode('_', $item_unique);
                $product_id = end($uniq_parts);
                if (!isset($rule_products[$product_id])) {
                    $cart->removeItem($key);
                }
            }
        }
    }

    /**
     * Формирует массив, в который будут записаны результаты применения правил
     *
     * @return void
     */
    private function createCartProductsById()
    {
        foreach ($this->cart_product_items as $uniq => $product_item) {
            if (!in_array($uniq, $this->cart_exists_subproducts_uniq_all)) {

                $old_extra = @unserialize($product_item['cartitem']['extra']) ?: [];

                $this->addInCartProductsById($product_item['product']['id'], $product_item['cartitem']['amount'], $product_item['cartitem']['offer'], $old_extra);

                /** @var CartItem $cart_item */
                $cart_item = $product_item['cartitem'];
                $sub_products = $cart_item->getExtraParam('sub_products');
                $sub_products_amount = $cart_item->getExtraParam('sub_products_amount');
                // добавляем сопутствующие
                if (!empty($sub_products)) {
                    foreach ($sub_products as $sub_id) {
                        $amount = (isset($sub_products_amount[$sub_id])) ? $sub_products_amount[$sub_id] : $product_item['cartitem']['amount'];
                        $this->addInCartProductsById($sub_id, $amount);
                    }
                }
            }
        }
    }

    /**
     * Добавляет товар в нужном количестве в массив cart_products_by_id
     *
     * @param int $id - id товара
     * @param int $amount - количество
     * @param int $offer - индекс комплектации
     * @param array $extra - extra товара
     */
    private function addInCartProductsById($id, $amount = 1, $offer = null, $extra = [])
    {
        if (isset($this->cart_products_by_id[$id])) {
            $this->cart_products_by_id[$id]['amount'] += $amount;
        } else {
            // если указан донор - присваиваем его элементу массива, иначе - создаём новый объект
            $product = new Product($id);
            $product->fillCost();
            $this->cart_products_by_id[$id] = [
                'product' => $product,
                'amount' => $amount,
                'extra' => $extra
            ];
            if (!empty($offer)) {
                $this->cart_products_by_id[$id]['extra']['offer_discount'][$offer] = 0;
            }
        }
    }

    /**
     * Возвращает id элементов корзины, прикрепленных по правилу
     *
     * @return string[]
     */
    private function getExistsSubProductsUniq()
    {
        $result = [];
        foreach ($this->cart_product_items as $uniq => $item) {
            /** @var CartItem $cart_item */
            $cart_item = $item['cartitem'];
            $item_source = $cart_item->getExtraParam(Cart::ITEM_EXTRA_KEY_SOURCE);
            if ($item_source == self::CART_SOURCE_CART_RULES) {
                $result[] = $uniq;
            }
        }
        return $result;
    }

    /**
     * Возвращает общее количество элементов корзины, вес и сумму, без учета прикрепленных товаров.
     *
     * @return float[]
     */
    private function getCartTotal()
    {
        $total_count = 0;
        $total_weight = 0;
        $total_price = 0;
        foreach ($this->cart_data['items'] as $uniq => $data) {
            if (!in_array($uniq, $this->cart_exists_subproducts_uniq_all)) {
                $total_count += $this->cart_product_items[$uniq]['cartitem']['amount'];
                $total_weight += ($this->cart_product_items[$uniq]['product']['weight'] * $this->cart_product_items[$uniq]['cartitem']['amount']);
                $total_price += $data['base_cost'];
            }
        }
        return [$total_count, $total_price, $total_weight];
    }
}
