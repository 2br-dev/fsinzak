{* Список новостей *}
<main id="news">
    <section id="regular-news" class="news-list">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h1>{$dir.title}</h1>
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


