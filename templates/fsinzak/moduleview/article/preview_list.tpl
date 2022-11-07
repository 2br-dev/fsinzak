{* Список новостей *}
<main id="news">
    <section>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h1>{$dir.title}</h1>
                </div>
            </div>
        </div>
        {moduleinsert name="\Article\Controller\Block\LastNews" category='1' pageSize=3 indexTemplate="%article%/blocks/lastnews/preview_list.tpl"}
    </section>
    <section id="regular-news" class="news-list">
        <div class="container">
            <div class="row flex">
                <div class="col s12">
                    <div class="segmented-control">
                        <a href="/news.html" class="segment">Все<span class="hide-m-down"> новости</span></a>
                        <a href="/news.html" class="segment active"><span class="hide-m-down">Новости </span>ФСИН</a>
                        <a href="/news.html" class="segment"><span class="hide-m-down">Новости </span>сервис<span class="hide-m-down">а</span></a>
                    </div>
                </div>
            </div>
            <div class="row">
                {if $list}
                    {foreach $list as $item}
                        {include file="%fsinzak%/news-card.tpl" item=$item}
                    {/foreach}

                    {include file="%THEME%/paginator.tpl"}
                {else}
                    {include file="%THEME%/helper/usertemplate/include/empty_list.tpl" reason="{t}Не найдено ни одной статьи{/t}"}
                {/if}
            </div>
        </div>
    </section>
</main>


