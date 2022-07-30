{addjs file="%mailsender%/mailtemplate.js"}

<div id="mailsend-filters">
    <a data-href="{adminUrl do="ajaxGetFilter"}" class="mailsend-add-filter"><u>{t}Добавить фильтр{/t}</u></a>
    <div id="mailsend-filters-container">
        {foreach $elem->getFilters() as $key => $filter}
            {$filter->getView($key)}
        {/foreach}
    </div>
</div>