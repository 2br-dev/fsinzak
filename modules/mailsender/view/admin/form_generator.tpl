{* Шаблон, для генерации полей ORM объекта в виде tr полей *}
{assign var=groups value=$prop->getGroups(false, $switch)}
<table class="otable">
{foreach from=$groups key=i item=data}
    {foreach from=$data.items key=name item=item}
        {if !$item->isHidden()}
        {literal}
        <tr>
            <td class="otitle">{$elem.__{/literal}{$name}{literal}->getTitle()}&nbsp;&nbsp;{if $elem.__{/literal}{$name}{literal}->getHint() != ''}<a class="help-icon" title="{$elem.__{/literal}{$name}{literal}->getHint()|escape}">?</a>{/if}
            </td>
            <td>{include file=$elem.__{/literal}{$name}{literal}->getRenderTemplate() field=$elem.__{/literal}{$name}{literal}}</td>
        </tr>{/literal}
        {/if}
    {/foreach}
{/foreach}
</table>