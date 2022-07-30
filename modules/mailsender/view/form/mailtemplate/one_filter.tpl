<div class="mailsend-filter">
    <a class="mailsend-filter-close" title="{t}удалить фильтр{/t}">&times;</a>
    <table class="otable">
        <tbody class="mailsend-filter-type">
            <tr>
                <td class="otitle">{t}Фильтр{/t}</td>
                <td>
                    <select name="filters[{$key}][class]" data-filter-id="{$key}">
                        {html_options options=$all_filters selected=$self_class}
                    </select>
                </td>
            </tr>
        </tbody>
        <tbody class="mailsend-filter-settings">
            {$filter_settings_html}        
        </tbody>
    </table>
</div>   