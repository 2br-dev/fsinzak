
    <div class="product-image-wrapper">
        <a class="lazy h" data-src="{$product->getMainImage()->getUrl('757', '1000', 'xy')}" href="{$product->getUrl()}"></a>
    </div>
    <div class="product-data-wrapper">
        <a class="title" href="{$product->getUrl()}">{$product['title']}</a>
        {$has_any_offers = ($offers_data.offers && count($offers_data.offers) > 1) || ($offers_data.levels && !$offers_data.virtual)}
        {if $has_any_offers || !$THEME_SETTINGS.button_as_amount}
            <div class="remains success">В наличии: ассортимент</div>
        {else}
            <div class="remains success">В наличии: {intval($stocks[$affiliate_warehouse][0]['stock'])}</div>
        {/if}
        <div class="price">{$product->getCost($affiliate_cost)}₽{if  $product->getUnit()->stitle}/{$product->getUnit()->stitle}{/if}</div>
        <div class="product-card-footer">
            {include file="%catalog%/product_cart_button.tpl"}
            {if $THEME_SETTINGS.enable_favorite}
                <div class="pcf-right">
                    <div class="fav-wrapper">
                        <a
                            class="fav rs-favorite {if $product->inFavorite()}rs-in-favorite{/if}"
                            data-title="{t}В избранное{/t}"
                            data-already-title="{t}В избранном{/t}">
                        </a>
                    </div>
                </div>
            {/if}
        </div>
    </div>

