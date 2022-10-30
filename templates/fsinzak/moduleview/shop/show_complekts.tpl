{* Диалог выбора комплектации товара, вызывается всегда, когда из списка товаров происходит добавление в корзину *}
{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}

{block "title"}{t}Комплектация{/t}{/block}
{block "body"}
    {$catalog_config = ConfigLoader::byModule('catalog')}

    {* Загружаем все сведения о комплектациях из кэш данных *}
    {$offers_data = $product->getOffersJson(['images' => []], true)}

    <div class="product-variant-second rs-multi-complectations
            {if !$product->isAvailable()} rs-not-avaliable{/if}
            {if $product->canBeReserved()} rs-can-be-reserved{/if}
            {if $product.reservation == 'forced'} rs-forced-reserve{/if}" data-id="{$product.id}">

            <div class="modal-item">
                <div>{$product.title}</div>
{*                <div class="mb-2 text-gray fs-5">{t}Артикул{/t}: <span class="rs-product-barcode">{$product.barcode}</span></div>*}

                <div>
                    {include "%catalog%/product_offers.tpl"}
                </div>
                {$current_affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate()}
                {if $current_affiliate}
                    {$affiliate_cost = $current_affiliate->getAffiliateCost()}
                    {$affiliate_warehouse = $current_affiliate->getAffiliateWarehouse()}
                {/if}
                {$stocks = $product->getWarehouseStock()}
                <p class="offer-stock-line">В наличии: <span class="offer-stock">{intval($stocks[$affiliate_warehouse][0]['stock'])}</span> {$product->getUnit()->stitle}</p>
                <div class="d-flex align-items-center justify-content-end mb-2">
                    {$old_cost = $product->getOldCost()}
                    {$new_cost = $product->getCost()}
                    {if $old_cost && $new_cost != $old_cost}
                        <span class="text-decoration-line-through text-gray fs-5 me-3">
                            <span class="rs-price-old">{$old_cost}</span>
                            {$product->getCurrency()}
                        </span>
                    {/if}
                    <span class="fs-3 fw-bold">
                        <span class="rs-price-new">{$new_cost}</span>
                        {$product->getCurrency()}{if $catalog_config.use_offer_unit}<span class="rs-unit-block">/<span class="rs-unit">{$product->getMainOffer()->getUnit()->stitle}</span></span>{/if}
                    </span>
                </div>
            </div>

            <div>
                <a data-href="{$router->getUrl('fsinzak-front-cartpage', ["add" => $product.id])}"
                   class="btn btn-primary w-100 rs-buy rs-to-cart rs-no-modal-cart">
                    <i class="mdi mdi-cart-arrow-down"></i>
                    <span>{t}В корзину{/t}</span>
                </a>

{*                <a data-href="{$router->getUrl('shop-front-reservation', ["product_id" => $product.id])}"*}
{*                   class="w-100 btn btn-outline-primary outline-primary-svg rs-reserve rs-in-dialog rs-no-modal-cart">*}
{*                    {include "%THEME%/helper/svg/reserve.tpl"}*}
{*                    <span class="ms-2">{t}Заказать{/t}</span>*}
{*                </a>*}

{*                <div class="item-card__not-available rs-unobtainable">{t}Нет в наличии{/t}</div>*}
            </div>
    </div>
{/block}
