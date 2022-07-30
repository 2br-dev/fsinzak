<tr>
    <td></td>
    <td> 
    {if $change_type} 
        {$app->autoloadScripsAjaxBefore()} 
    {/if}
    {$type_object->getDescription()}</td>
</tr>
{$type_object->getFormHtml()}
<tr> 
<td></td>
<td>
    {if $change_type} 
        {$app->autoloadScripsAjaxAfter()} 
        {foreach from=$app->getCss('header')+$app->getCss('footer') item=css}
            {$css.params.before}<link {if $css.params.type !== false}type="{$css.params.type|default:"text/css"}"{/if} href="{$css.file}" {if $css.params.media!==false}media="{$css.params.media|default:"all"}"{/if} rel="{$css.params.rel|default:"stylesheet"}">{$css.params.after}
        {/foreach}
    {/if}
</td>
</tr>