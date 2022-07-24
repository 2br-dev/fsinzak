{* Страница со списком избранных товаров *}
{$shop_config = ConfigLoader::byModule('shop')}
{$check_quantity = $shop_config->check_quantity}
{$list = $this_controller->api->addProductsMultiOffersInfo($list)}
{addjs file="%catalog%/rscomponent/listproducts.js"}

<main id="main">
    <section id="catalog">
        <div id="products" class="container">
            <div class="row">
                <div class="col s12">
                    <h1 class="mb-md-5 mb-4">{t}Избранное{/t}</h1>
                </div>
            </div>
            {if $list}
                {if !in_array($view_as, ['blocks', 'table'])}{$view_as = 'blocks'}{/if}
                {if $view_as == 'blocks'}
                    <div class="row rs-products-list flex">
                        {foreach $list as $product}
                            {include file="%catalog%/one_product.tpl"}
                        {/foreach}
                    </div>
                {else}
                    <div class="item-list-container">
                        {foreach $list as $product}
                            {include file="%catalog%/one_table_product.tpl"}
                        {/foreach}
                    </div>
                {/if}
                <div class="row">
                    {include file="%THEME%/paginator.tpl"}
                </div>
            {else}
                {include file="%THEME%/helper/usertemplate/include/empty_product_list.tpl" reason="{t}Нет товаров в избранном{/t}"}
            {/if}
        </div>
    </section>
</main>
