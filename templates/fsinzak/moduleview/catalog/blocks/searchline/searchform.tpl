{addjs file="%catalog%/rscomponent/searchline.js"}
<form class="head-search rs-search-line search-wrapper" id="search" action="{$router->getUrl('catalog-front-listproducts', [])}" method="GET">
    <div class="input-wrapper">
        <input type="text" class="form-control {if !$param.hideAutoComplete} rs-autocomplete{/if}" placeholder="{t}Поиск{/t}" name="query" value="{$query}" autocomplete="off" data-source-url="{$router->getUrl('catalog-block-searchline', ['sldo' => 'ajaxSearchItems', _block_id => $_block_id])}">
        <div class="head-search__dropdown rs-autocomplete-result"></div>
        <button type="button" class="head-search__clear rs-autocomplete-clear {if !$query}d-none{/if}">
            <img src="{$THEME_IMG}/icons/close.svg" alt="">
        </button>
        <button class="head-search__btn btn" type="submit">
            <i class="mdi mdi-magnify"></i>
        </button>
    </div>
</form>
