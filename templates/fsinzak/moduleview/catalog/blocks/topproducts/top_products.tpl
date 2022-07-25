{if $products}
    {nocache}
        {addjs file="%catalog%/rscomponent/productslider.js"}
    {/nocache}
{*    <div class="h1 mb-4">{if $block_title}{$block_title}{else}<a href="{$dir->getUrl()}" class="text-decoration-none text-dark">{$dir.name}</a>{/if}</div>*}
{*    <div class="product-slider">*}
{*        <div class="product-slider__container">*}
{*            <div class="swiper-container swiper-products">*}
{*                <div class="swiper-wrapper" >*}
{*                    {foreach $products as $product}*}
{*                        <div class="swiper-slide">*}
{*                            {include file="%catalog%/one_product.tpl"}*}
{*                        </div>*}
{*                    {/foreach}*}
{*                </div>*}
{*                <div class="swiper-button-prev"></div>*}
{*                <div class="swiper-button-next"></div>*}
{*            </div>*}
{*        </div>*}
{*    </div>*}


    <section id="bakalea">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="underlined header-block">
                        <h2>{if $block_title}{$block_title}{else}<a href="{$dir->getUrl()}">{$dir.name}</a>{/if}</h2>
                        <a href="{$dir->getUrl()}">
                            <span class="hide-m-down">Смотреть все</span>
                            <i class="mdi mdi-chevron-double-right hide-m-up"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row flex">
                {foreach $products as $product}
                    {include file="%catalog%/one_product.tpl"}
                {/foreach}
            </div>
        </div>
    </section>
{/if}
