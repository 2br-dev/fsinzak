<div id="mailsend-contents">
    {foreach $elem.__contents->getList() as $key => $value}
        {$content=$elem->getContentById($key)}
        <div class="mailsend-content">
            <label><input type="checkbox" name="contents[{$key}][class]" value="{$key}" data-n="{$value@iteration}" class="mailsend-content-cb" {if $elem.contents && in_array($key, array_keys($elem.contents))}checked{/if}> {$value}</label>
            <a class="help-icon" title="{$content->getDescription()}">?</a>
            &nbsp;<a class="mailsend-content-edit" title="{t}Настройки{/t}"></a>            
            <div class="mailsend-content-settings">
                {$content->getSettingsHtml()}
            </div>
        </div>
    {/foreach}
</div>
</td>
</tr>
<tr>
<td></td>
<td>
<div class="mailsender-content-wrapper">
    {$elem->getReplaceVarsHtml()}
</div>