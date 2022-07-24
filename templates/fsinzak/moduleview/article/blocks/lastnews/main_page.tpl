{if $category && $news}
    <div class="container">
        <div class="row">
            <div class="news-wrapper">
                {foreach $news as $item}
                    <div class="news-entry-wrapper">
                        <div class="news-entry">
                            <div class="data-wrapper">
                                <div class="date">{$item.dateof|dateformat:"%d %v %Y"}</div>
                                <div class="title">{$item.title}</div>
                                <div class="intro">{$item->getPreview(200)}</div>
                            </div>
                            <div class="link-wrapper">
                                <a href="{$item->getUrl()}" class="btn">Подробнее</a>
                            </div>
                            <div class="lazy" data-src="{$THEME_IMG}/news-entry.svg"></div>
                        </div>
                    </div>
                {/foreach}
            </div>
            <div class="swiper" id="news-slider">
                <div class="swiper-wrapper">
                    {foreach $news as $item}
                        <div class="swiper-slide">
                            <div class="news-entry-wrapper">
                                <div class="news-entry">
                                    <div class="data-wrapper">
                                        <div class="date">{$item.dateof|dateformat:"%d %v %Y"}</div>
                                        <div class="title">{$item.title}</div>
                                    </div>
                                    <div class="link-wrapper">
                                        <a href="{$item->getUrl()}" class="btn">Подробнее</a>
                                    </div>
                                    {if $item['image']}
                                        <div class="lazy" data-src="{$item.__image->getUrl('800', '600', 'axy')}"></div>
                                    {else}
                                        <div class="lazy" data-src="{$THEME_IMG}/news-entry.svg"></div>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
                <div class="swiper-pagination" id="news-pagination"></div>
            </div>
        </div>
        <div class="col s12 center-align"><a href="{$router->getUrl('article-front-previewlist', [category => $category->getUrlId()])}" class="btn">Все новости</a></div>
    </div>
{else}
    <div class="h1 m-0 mb-4">{t}Новости{/t}</div>

    {capture assign = "skeleton_html"}
        <div class="row row-cols-lg-4 row-cols-sm-2 g-lg-4 g-3">
            <div>
                <img class="w-100" width="359" height="315" src="{$THEME_IMG}/skeleton/skeleton-news.svg" alt="">
            </div>
            <div>
                <img class="w-100" width="359" height="315" src="{$THEME_IMG}/skeleton/skeleton-news.svg" alt="">
            </div>
            <div class="d-lg-block d-none">
                <img class="w-100" width="359" height="315" src="{$THEME_IMG}/skeleton/skeleton-news.svg" alt="">
            </div>
            <div class="d-lg-block d-none">
                <img class="w-100" width="359" height="315" src="{$THEME_IMG}/skeleton/skeleton-news.svg" alt="">
            </div>
        </div>
    {/capture}

    {include "%THEME%/helper/usertemplate/include/block_stub.tpl"
    name = "{t}Новости{/t}"
    skeleton = $skeleton_html
    do = [
        [
            'title' => "{t}Добавить категорию с новостями{/t}",
            'href' => "{adminUrl do=false mod_controller="article-ctrl"}"
        ],
        [
            'title' => "{t}Настроить блок{/t}",
            'href' => {$this_controller->getSettingUrl()},
            'class' => 'crud-add'
        ]
    ]}
{/if}
