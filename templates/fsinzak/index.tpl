{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
    <main id="main">
        <section id="news">
            {moduleinsert name="\Article\Controller\Block\LastNews" category='1' pageSize=3 indexTemplate="%article%/blocks/lastnews/main_page.tpl"}
        </section>
{*        <section id="service">*}
{*            <div class="container">*}
{*                <div class="row">*}
{*                    <div class="col s12 center-align">*}
{*                        <a href="" class="btn toast-trigger" data-text="Success" data-class="toast-success">Success</a>*}
{*                        <a href="" class="btn toast-trigger" data-text="Warning" data-class="toast-warning">Warning</a>*}
{*                        <a href="" class="btn toast-trigger" data-text="Error" data-class="toast-error">Error</a>*}
{*                        <a href="" class="btn toast-trigger" data-text="Info" data-class="toast-info">Info</a>*}
{*                    </div>*}
{*                </div>*}
{*            </div>*}
{*        </section>*}
{*        {moduleinsert name="\Catalog\Controller\Block\TopProduct" dir}*}
        <section id="bakalea">
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <div class="underlined header-block">
                            <h2>Бакалея</h2>
                            <a href="./catalog.html">
                                <span class="hide-m-down">Смотреть все</span>
                                <i class="mdi mdi-chevron-double-right hide-m-up"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row flex">
                    @@loop('./parts/product_card.html', './data/bakalea_small.json')
                </div>
            </div>
        </section>
        <section id="gastronomy">
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <div class="underlined header-block">
                            <h2>Гастрономия</h2>
                            <a href="./catalog.html">
                                <span class="hide-m-down">Смотреть все</span>
                                <i class="mdi mdi-chevron-double-right hide-m-up"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row flex">
                    @@loop('./parts/product_card.html', './data/gastronomy_small.json')
                </div>
            </div>
        </section>
        <section id="popular">
            <div class="container">
                <div class="col s12 center-align"><h2>Популярные товары</h2></div>
                <div class="col s12">
                    <div class="swiper" id="popular-slider">
                        <div class="swiper-wrapper">
                            @@loop('./parts/pop-slide.html', './data/popular.json')
                        </div>
                    </div>
                    <div class="swiper-pagination" id="popular-pagination"></div>
                </div>
            </div>
        </section>
        <section id="healthy">
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <div class="underlined header-block">
                            <h2>Здоровое питание</h2>
                            <a href="./catalog.html">
                                <span class="hide-m-down">Смотреть все</span>
                                <i class="mdi mdi-chevron-double-right hide-m-up"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row flex">
                    @@loop('./parts/product_card.html', './data/healthy_small.json')
                </div>
            </div>
        </section>
    </main>
{/block}
