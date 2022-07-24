{addjs file="core6/rsplugins/ajaxpaginator.js" basepath="common"}
{addjs file="%catalog%/rscomponent/listproducts.js"}
{$list = $this_controller->api->addProductsDirs($list)}
{$list = $this_controller->api->addProductsMultiOffersInfo($list)}

{*<div id="first-product-in-cart">*}
{*    {moduleinsert name="\Affiliate\Controller\Block\Selectaffiliate" indexTempalte="%affiliate%/blocks/selectaffiliate/select_affiliate_first_product"}*}
{*</div>*}
<main id="main">
    <section id="catalog">
        <div id="products" class="container">
            <div class="row">
                <div class="col s12">
                    {moduleinsert name="\Main\Controller\Block\Breadcrumbs" indexTemplate="%main%/blocks/breadcrumbs/breadcrumbs-catalog.tpl"}
                    <div class="underlined header-block">
                        <h1>{if !empty($query)}{t}Результаты поиска{/t}{else}{$category.name}{/if}</h1>
                    </div>
                    {if $sub_dirs}
                        <ul class="subcategories">
                            {foreach $sub_dirs as $item}
                                <li>
                                    <a href="{urlmake category=$item._alias p=null pf=null filters=null bfilter=null}">{$item.name}</a>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                </div>
            </div>
            {function emptyList}
                <div class="text-center mt-6 container col-lg-4 col-md-6 col-sm-8">
                    <div class="mb-lg-6 mb-4">
                        <img class="empty-page-img" src="{$THEME_IMG}/decorative/search.svg" alt="{t}Ничего не найдено{/t}">
                    </div>
                    <p class="mb-lg-6 mb-5">{$reason}</p>
                    {if $button_link}
                        <a href="{$button_link|default:$SITE->getRootUrl()}" class="btn btn-primary">{$button_text|default:"{t}На главную{/t}"}</a>
                    {/if}
                </div>
            {/function}

            {if count($list) || $is_filter_active}
                {if $list}
                    {if $view_as == 'blocks'}
                        <div class="row rs-products-list flex">
                            {foreach $list as $product}
                                {include file="%catalog%/one_product.tpl"}
                            {/foreach}
                        </div>
                    {else}
                        <div class="item-list-container rs-products-list">
                            {foreach $list as $product}
                                {include file="%catalog%/one_table_product.tpl"}
                            {/foreach}
                        </div>
                    {/if}

{*                    {include file="%catalog%/list_products_paginator.tpl"}*}

                {else}
                    {emptyList reason="{t}По вашему запросу ничего не найдено. Проверьте правильность установленных фильтров{/t}"
                        button_link="{urlmake filters=null pf=null bfilter=null p=null}" button_text="{t}Сбросить фильтры{/t}"}
                {/if}
            {else}
                {if $query === ""}
                    {emptyList button_link=false reason="{t}В этой категории нет товаров. Попробуйте найти ваш товар в другой категории.{/t}"}
                {else}
                    {emptyList reason="{t}По вашему запросу ничего не найдено. Проверьте правильность введенного запроса{/t}"}
                {/if}
            {/if}
        </div>
    </section>
</main>
