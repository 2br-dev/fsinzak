{addjs file="core6/rsplugins/ajaxpaginator.js" basepath="common"}
{addjs file="%catalog%/rscomponent/listproducts.js"}
{$list = $this_controller->api->addProductsDirs($list)}
{$list = $this_controller->api->addProductsMultiOffersInfo($list)}

{*<div id="first-product-in-cart">*}
{*    {moduleinsert name="\Affiliate\Controller\Block\Selectaffiliate" indexTempalte="%affiliate%/blocks/selectaffiliate/select_affiliate_first_product"}*}
{*</div>*}
<div class="col xl9 l9 m12" id="products">
    <h2>
        <a href="#cat-nav" class="hide-l-up sidenav-trigger mobile-filter-trigger">
            <i class="mdi mdi-tune"></i><span>Фильтры</span>
        </a>
        {if !empty($query)}{t}Результаты поиска{/t}{else}{$category['name']}{/if}
    </h2>

    <div class="helpers">
        <div class="catalog-bar">
            <div class="catalog-select">
                <div class="catalog-select__label d-md-block">{t}Сортировать{/t}:</div>
                <div class="catalog-select__options">
                    <select class="rs-list-sort-change">
                        <option value="sortn" data-nsort="asc" {if $cur_sort=='sortn'}selected{/if}>{t}умолчанию{/t}</option>
                        <option value="cost" data-nsort="asc" {if $cur_sort == 'cost' && $cur_n == 'asc'}selected{/if}>{t}возрастанию цены{/t}</option>
                        <option value="cost" data-nsort="desc" {if $cur_sort == 'cost' && $cur_n == 'desc'}selected{/if}>{t}убыванию цены{/t}</option>
                        <option value="dateof" data-nsort="desc" {if $cur_sort == 'dateof'}selected{/if}>{t}новизне{/t}</option>
                        <option value="title" data-nsort="asc" {if $cur_sort == 'title'}selected{/if}>{t}названию{/t}</option>
                    </select>
                    <div class="catalog-select__value"></div>
                </div>
            </div>

        </div>
    </div>

{*    <div class="helpers">*}
{*        <div class="filters">*}
{*            <ul class="filter" id="sort">*}
{*                <li>*}
{*                    <i class="mdi mdi-sort-variant"></i>*}
{*                    <span>Сортировка:</span>*}
{*                    <span id="current">По цене</span>*}
{*                    <i class="mdi mdi-menu-down"></i>*}
{*                    <ul>*}
{*                        <li>По цене</li>*}
{*                        <li>По популярности</li>*}
{*                        <li>По рейтингу</li>*}
{*                        <li>*}
{*                            <div class="divider"></div>*}
{*                        </li>*}
{*                        <li>По возрастанию</li>*}
{*                        <li>По убыванию</li>*}
{*                    </ul>*}
{*                </li>*}
{*            </ul>*}
{*        </div>*}
{*        <div class="viewes">*}
{*            <a class="view-switcher active" id="card" href=""><i class="mdi mdi-view-module"></i></a>*}
{*            <a class="view-switcher" id="list" href=""><i class="mdi mdi-view-list"></i></a>*}
{*        </div>*}
{*    </div>*}
    {function emptyList}
        <div class="row">
            <div class="col s12">
                <img class="empty-page-img" src="{$THEME_IMG}/decorative/search.svg" alt="{t}Ничего не найдено{/t}">
                <p class="mb-lg-6 mb-5">{$reason}</p>
                {if $button_link}
                    <a href="{$button_link|default:$SITE->getRootUrl()}" class="btn btn-primary">{$button_text|default:"{t}На главную{/t}"}</a>
                {/if}
            </div>
        </div>
    {/function}
    {if count($list) || $is_filter_active}
        {if $list}
            {if $view_as == 'blocks'}

                <div class="catalog" id="catalog-content">
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

            {include file="%catalog%/list_products_paginator.tpl"}

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
