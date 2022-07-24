{if $category && $news}
    {foreach $news as $item}
        {include file="%fsinzak%/news-card.tpl" item=$item}
    {/foreach}
{/if}
