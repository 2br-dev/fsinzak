{$shop_config = ConfigLoader::byModule('shop')}
{$catalog_config = ConfigLoader::byModule('catalog')}

{$only_main_offer = $THEME_SETTINGS.show_offers_in_list}
{$current_affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate()}
{if $current_affiliate}
    {$affiliate_cost = $current_affiliate->getAffiliateCost()}
    {$affiliate_warehouse = $current_affiliate->getAffiliateWarehouse()}
{/if}


{if $products}
    <section id="popular">
        <div class="container">
            <div class="row header-row">
                <div class="col m9 align-center-m-down"><h2>Реко&shy;мен&shy;ду&shy;емые товары</h2></div>
{*                <div class="col m3 s12 align-center-m-down align-right-m-up"><a href="/catalog.html">Смотреть все</a></div>*}
                <div class="col s12">
                    <div class="divider"></div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="slider-container">
                        <i class="hide-l-down pop-left mdi mdi-chevron-left"></i>
                        <i class="hide-l-down pop-right mdi mdi-chevron-right"></i>
                        <div class="swiper" id="popular-slider">
                            <div class="swiper-wrapper">
                                {foreach $products as $product}
                                    {$offers_data = $product->getOffersJson(['noVirtual' => true], true)}
                                    {$stocks = $product->getWarehouseStock()}
                                    {if intval($stocks[$affiliate_warehouse][0]['stock']) && $product->getCost()}
                                        <div class="swiper-slide" data-id="{$product.id}">
                                            <div class="product-card">
                                                {include file="%catalog%/product_card.tpl" product=$product}
                                            </div>
                                        </div>
                                    {/if}
                                {/foreach}
                            </div>
                        </div>
                        <div class="swiper-pagination" id="popular-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}
