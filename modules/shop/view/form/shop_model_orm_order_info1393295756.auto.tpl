{* Файл генерируется автоматически исходя из полей объекта Order *}

            
            <tr>
            <td class="otitle">{$elem.__source_id->getTitle()}&nbsp;&nbsp;{if $elem.__source_id->getHint() != ''}<a class="help-icon" title="{$elem.__source_id->getHint()|escape}">?</a>{/if}
            </td>
            <td>{include file=$elem.__source_id->getRenderTemplate() field=$elem.__source_id}</td>
            </tr>
    