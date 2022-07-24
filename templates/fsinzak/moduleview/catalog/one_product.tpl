{$shop_config = ConfigLoader::byModule('shop')}
{$catalog_config = ConfigLoader::byModule('catalog')}
{$offers_data = $product->getOffersJson(['noVirtual' => true], true)}
{$only_main_offer = $THEME_SETTINGS.show_offers_in_list}
{$current_affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate()}
{if $current_affiliate}
    {$affiliate_cost = $current_affiliate->getAffiliateCost()}
    {$affiliate_warehouse = $current_affiliate->getAffiliateWarehouse()}
{/if}
{$stocks = $product->getWarehouseStock()}


{if intval($stocks[$affiliate_warehouse][0]['stock']) && $product->getCost()}


<div class="item-card rs-product-item col xl2 l3 m4 s6 xs6 t12
                {if !$product->isAvailable($only_main_offer)} rs-not-avaliable{/if}
                {if $product->canBeReserved()} rs-can-be-reserved{/if}
                {if $product.reservation == 'forced'} rs-forced-reserve{/if}" {$product->getDebugAttributes()} data-id="{$product.id}">
    <div class="item-card__inner product-card">
        <div class="product-image-wrapper">
            <a class="lazy h" data-src="{$product->getMainImage()->getUrl('757', '1000', 'xy')}" href="{$product->getUrl()}"></a>
        </div>
        <div class="product-data-wrapper">
            <a class="title" href="{$product->getUrl()}">{$product['title']}</a>
            <div class="remains success">В наличии: {intval($stocks[$affiliate_warehouse][0]['stock'])}</div>
            <div class="price">{$product->getCost($affiliate_cost)}₽</div>
            <div class="product-card-footer">
{*                <div class="pcf-left card-basket-wrapper">*}
{*                    <a href="" class="btn basket-add">*}
{*                       В корзину*}
{*                    </a>*}
{*                    <div class="basket-count hidden">*}
{*                        <div class="minus-wrapper"><a href="" class="btn outlined basket-minus"><i class="mdi mdi-minus"></i></a></div>*}
{*                        <div class="counter-wrapper"><input type="number" value=1></div>*}
{*                        <div class="plus-wrapper"><a href="" class="btn basket-plus"><i class="mdi mdi-plus"></i></a></div>*}
{*                    </div>*}

                    {include file="%catalog%/product_cart_button.tpl"}
{*                </div>*}
                {if $THEME_SETTINGS.enable_favorite}
                    <div class="pcf-right">
                        <div class="fav-wrapper">
                            <a
                                class="fav rs-favorite {if $product->inFavorite()}rs-in-favorite{/if}"
                                data-title="{t}В избранное{/t}"
                                data-already-title="{t}В избранном{/t}">
                            </a>


{*                            <input type="checkbox" class="like" id="@@id"><label for="@@id"></label>*}
                        </div>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>
{/if}
