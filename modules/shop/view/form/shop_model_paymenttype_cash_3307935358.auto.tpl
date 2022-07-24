                                            
    
                                    
            <tr>
                <td class="otitle">{$elem.__is_cash->getTitle()}&nbsp;&nbsp;{if $elem.__is_cash->getHint() != ''}<a class="help-icon" title="{$elem.__is_cash->getHint()|escape}">?</a>{/if}
                </td>
                <td>{include file=$elem.__is_cash->getRenderTemplate() field=$elem.__is_cash}</td>
            </tr>
                        