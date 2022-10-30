{* Корзина, совмещенная с оформлением заказа *}
{addjs file="%shop%/rscomponent/cart.js"}

{$shop_config = ConfigLoader::byModule('shop')}
{$users_config = ConfigLoader::byModule('users')}
{$cart_checkout = $shop_config->getCheckoutType() == 'cart_checkout'}
{$product_items = $cart->getProductItems()}

<div id="rs-cart-page">
    {if !$is_auth}
        <div class="checkout-auth col s12">
            {t url=$users_config->getAuthorizationUrl()}Если Вы регистрировались ранее, пожалуйста, <a href="%url" class="rs-in-dialog">авторизуйтесь</a>.{/t}
        </div>
    {/if}
    <form method="POST" action="{$router->getUrl('shop-block-cartfull', ["action" => "update", '_block_id' => $_block_id])}" id="rs-cart-form">
        {hook name="shop-block-cartfull:block" title="{t}Корзина заказа полная:блок{/t}"}
            <div class="row flex vcenter">
                <div class="col xs12 s5">
                    <h1>Корзина</h1>
                </div>
                <div class="col s7 xs12 right-align align-left-s-down">
                    <a class="btn-outlined return-link rs-go-back">
                        Вернуться
                        <span class="hide-m-down">к покупкам</span>
                    </a>
                    <a href="{$router->getUrl('shop-block-cartfull', ["action" => "cleanCart", '_block_id' => $_block_id])}" class="btn-outlined cart-checkout-clear rs-clean">
                        <i class="mdi mdi-cart-remove hide-l-up"></i>
                        <span class="hide-l-down">Очистить корзину</span>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="last-child-margin-remove col s12">
                    {hook name="shop-block-cartfull:products" title="{t}Корзина заказа полная:товары{/t}"}
                        <h2>Содержание заказа</h2>
                        <p class="info">
                            На этой странице представлено содержание корзины заказа.
                        </p>
                        <table class="orders zebra">
                            <thead>
                                <tr class="main-row-header">
                                    <th>Наименование</th>
                                    <th>Количество</th>
                                    <th>Цена за ед.</th>
                                    <th>Стоимость</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $cart_data.items as $index => $item}
                                    {$product = $product_items[$index].product}
                                    {$cartitem = $product_items[$index].cartitem}
                                    {if !empty($cartitem.multioffers)}
                                        {$multioffers = unserialize($cartitem.multioffers)}
                                    {/if}
                                    <tr class="details-row cart-checkout-item rs-cart-item {if $item.amount_error} cart-checkout-item_error{/if}" data-id="{$cartitem.entity_id}" data-uniq="{$index}">
                                        <td data-before="Название" class="name">
                                            <a class="checkout-product-link" href="{$product->getUrl()}">
                                                {$cartitem.title}
                                            </a>
                                            <div class="cart-equipments">
                                                {if $product->isMultiOffersUse()}
                                                    {foreach $product.multioffers.levels as $level}
                                                        {if !empty($level.values)}
                                                            <div class="catalog-select catalog-select_cart">
                                                                <div class="catalog-select__label">{if $level.title}{$level.title}{else}{$level.prop_title}{/if}</div>
                                                                <div class="catalog-select__options">
                                                                    <select class="select rs-multioffer" name="products[{$index}][multioffers][{$level.prop_id}]" data-prop-title="{if $level.title}{$level.title}{else}{$level.prop_title}{/if}">
                                                                        {foreach $level.values as $value}
                                                                            <option {if $multioffers[$level.prop_id].value == $value.val_str}selected="selected"{/if} value="{$value.val_str}">{$value.val_str}</option>
                                                                        {/foreach}
                                                                    </select>
                                                                    <div class="catalog-select__value"></div>
                                                                </div>
                                                            </div>
                                                        {/if}
                                                    {/foreach}

                                                    {if $product->isOffersUse()}
                                                        {$offers = $product->getOffers()}
                                                        {foreach $offers as $key => $offer}
                                                            <input id="offer_{$key}" type="hidden" class="rs-hidden-multioffer" value="{$key}" data-info='{$offer->getPropertiesJson()}' data-num="{$offer.num}"/>
                                                        {/foreach}
                                                        <input type="hidden" name="products[{$index}][offer]" value="{if isset($offers[$cartitem.offer])}{$cartitem.offer}{else}0{/if}" class="rs-offer"/>
                                                    {/if}
                                                {elseif $product->isOffersUse()}
                                                    <div class="cart-product-offer">
                                                        <span class="cart-offer-title">{$product.offer_caption|default:"{t}Комплектация{/t}"}:</span>
                                                        <span class="cart-offer-value">
                                                            {foreach $product->getOffers() as $key => $offer}
                                                                {if $cartitem.offer==$key}
                                                                    {$offer.title}
                                                                {/if}
                                                            {/foreach}
                                                        </span>
                                                    </div>
                                                {/if}
                                            </div>
                                        </td>
                                        <td data-before="Количество" class="count">
                                            {$min = $product->getAmountStep($cartitem.offer)}
                                            {$step = $product->getAmountStep($cartitem.offer)}
                                            {$amount = $cartitem.amount}
                                            <div class="cart-amount rs-number-input pm-block">
                                                <a class="rs-number-down minus {if $cartitem->getForbidRemove()}disabled{/if}">
                                                    <i class="mdi mdi-minus"></i>
                                                </a>
                                                <div class="cart-amount__input">
                                                    <input type="number" value="{$amount}" min="{$min}" step="{$step}" name="products[{$index}][amount]"
                                                       {if $shop_config.allow_buy_all_stock_ignoring_amount_step}data-break-point="{$product->getNum()}"{/if}
                                                        {if $cartitem->getForbidChangeAmount()}disabled{/if} class="rs-amount">
                                                </div>
                                                <a class="rs-number-up plus {if $cartitem->getForbidRemove()}disabled{/if}">
                                                    <i class="mdi mdi-plus"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td data-before="Цена за единицу" class="count">{$product->getCost()}₽</td>
                                        <td data-before="Стоимость" class="price">{$item.cost|mb_substr:0:-2}₽</td>
                                        <td>
                                            {if !$cartitem->getForbidRemove()}
                                                <a class="cart-checkout-item__del rs-remove btn-flat" href="{$router->getUrl('shop-block-cartfull', ["action" => "removeItem", 'id' => $index, '_block_id' => $_block_id])}">
                                                    <i class="mdi mdi-delete hide-m-down"></i><span class="hide-m-up">Удалить</span>
                                                </a>
                                            {/if}
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    {/hook}
                </div>
                {if !empty($cart_data.errors)}
                    <div class="text-danger mb-4 fs-5">
                        {foreach $cart_data.errors as $error}
                            {$error}<br>
                        {/foreach}
                    </div>
                {/if}
            </div>
        {/hook}
    </form>
</div>
