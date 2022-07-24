{$bc = $app->breadcrumbs->getBreadCrumbs()}
{if !empty($bc)}
    <ul class="breadcrumb__list breadcrumbs">
        {foreach from=$bc item=item name="path"}
            {if empty($item.href)}
                <li class="breadcrumb__item {if $smarty.foreach.path.last}last{/if}"><span>{$item.title}</span></li>
            {else}
                <li class="breadcrumb__item {if $smarty.foreach.path.last}last{/if}"><a href="{$item.href}" {if $smarty.foreach.path.first}class="first"{/if}>{$item.title}</a></li>
            {/if}
        {/foreach}
    </ul>
{/if}
