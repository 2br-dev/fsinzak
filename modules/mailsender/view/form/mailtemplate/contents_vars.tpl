<div class="mailsend-vars" data-update-url="{adminUrl do="ajaxGetReplaceVars"}" id="mailsend-replace-vars">
    <p><strong>{t}Переменные, которые можно использовать в письме{/t}</strong></p>
    {foreach $elem->getReplaceVarsTitle() as $data}
    {$data.group}:
    <ul>
        {foreach $data.vars as $var => $description}
        <li>{ldelim}${$var}{rdelim} - {$description}</li>
        {/foreach}
    </ul>
    {/foreach}
</div>