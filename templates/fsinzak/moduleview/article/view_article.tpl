{* Просмотр одной новости *}
<main id="news">
    <section id="entry-content">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    {if $article.image}
                        <img class="lazy news-image inline-img" data-src="{$article.__image->getUrl(992, 559, 'xy')}" alt="{$article.title}">
                    {/if}
                    <h1>{$article.title}</h1>
                    {$article.content}
                </div>
            </div>
        </div>
    </section>
    <section id="relative-news" class="news-list">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h2>Другие новости</h2>
                </div>
            </div>
            <div class="row">
                {moduleinsert name="\Article\Controller\Block\LastNews" indexTemplate="%article%/blocks/lastnews/news_page.tpl" pageSize=3 category='1'}
            </div>
        </div>
    </section>
</main>
