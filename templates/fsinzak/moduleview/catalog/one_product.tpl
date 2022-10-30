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


<div
    class="item-card rs-product-item product-card
    {if !$product->isAvailable($only_main_offer)} rs-not-avaliable{/if}
    {if $product->canBeReserved()} rs-can-be-reserved{/if}
    {if $product.reservation == 'forced'} rs-forced-reserve{/if}"
    {$product->getDebugAttributes()}
    data-id="{$product.id}"
>
    {include file="%catalog%/product_card.tpl" product=$product}
</div>
{/if}
