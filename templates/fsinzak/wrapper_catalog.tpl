{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
    <main>
        <section id="catalog">
            <div class="container">
                <div class="row flex">
                    <div class="col s12">
                        {moduleinsert name="\Main\Controller\Block\Breadcrumbs" indexTemplate="%main%/blocks/breadcrumbs/breadcrumbs-catalog.tpl"}
                        <div class="underlined header-block">
                            <h1>{if !empty($query)}{t}Результаты поиска{/t}{else}Каталог продукции{/if}</h1>
                        </div>
                    </div>
                </div>
                <div class="row rs-products-list flex">
                    <div class="col xl3 l3 hide-l-down">
                        <div class="catalog-sidebar">
                            <ul class="tabs catalog-tabs">
                                <li class="tab"><a href="#navi" class="active">Категории</a></li>
                                <li class="tab"><a href="#filters">Фильтры</a></li>
                            </ul>
                            <div id="navi">
                                {moduleinsert name="\Catalog\Controller\Block\Category" indexTemplate="%catalog%/blocks/category/category_listproducts.tpl"}
                            </div>
                            <div id="filters">
                                {moduleinsert name="\Catalog\Controller\Block\Sidefilters"}
                            </div>
                        </div>
                    </div>
                    {$app->blocks->getMainContent()}
                </div>
            </div>
        </section>
    </main>
    <div class="sidenav" id="cat-nav">
        <a href="#close" class="close-sidenav"><i class="mdi mdi-close"></i></a>
        <ul class="tabs catalog-tabs">
            <li class="tab"><a href="#sn_navi" class="active">Категории</a></li>
            <li class="tab"><a href="#sn_filters">Фильтры</a></li>
        </ul>
        <div id="sn_navi">
            {moduleinsert name="\Catalog\Controller\Block\Category" indexTemplate="%catalog%/blocks/category/category_listproducts.tpl"}
        </div>
        <div id="sn_filters">
            {moduleinsert name="\Catalog\Controller\Block\Sidefilters"}
        </div>
    </div>
{/block}
