{foreach $elem.__sources->getList() as $key => $value}
    {$source=$elem->getSourceById($key)}
    {$checked=($elem.sources && in_array($key, array_keys($elem.sources)))}
    <label><input class="mailsend-source-input" type="checkbox" name="sources[{$key}][class]" value="{$key}" {if $checked}checked{/if}> {$value}</label>
    {if $description=$source->getDescription()}<a class="help-icon" title="{$description}">?</a>{/if}<br>

    {if $html=$source->getSettingsHtml($elem)}
        <div class="mailsend-source-settings" data-link-source="{$key}" {if $checked}style="display:block"{/if}>
            {$html}
        </div>
    {/if}
{/foreach}