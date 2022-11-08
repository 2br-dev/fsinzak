<div class="col xl3 l4 m6 s12" {$item->getDebugAttributes()}>
    <div class="news-entry">
        <div class="news-entry-image">
            {if $item.image}
                <a class="lazy h hoverable" href="{$item->getUrl()}" data-src="{$item.__image->getUrl(1040, 620, 'xy')}"></a>
            {else}
                <a class="lazy h hoverable" href="{$item->getUrl()}" data-src="{$THEME_IMG}/news-entry.svg"></a>
            {/if}
        </div>
        <div class="news-entry-content">
            <div class="title">{$item.title}</div>
            <div class="intro">{$item->getPreview(200)}</div>
        </div>
        <div class="news-entry-footer">
            <a href="{$item->getUrl()}">Подробнее</a>
        </div>
    </div>
</div>
