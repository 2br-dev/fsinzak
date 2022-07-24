                                            
                                            
                                            
                                            
                                            
                                            
                                            
    
                                    
            <tr>
                <td class="otitle">{$elem.____help__->getTitle()}&nbsp;&nbsp;{if $elem.____help__->getHint() != ''}<a class="help-icon" title="{$elem.____help__->getHint()|escape}">?</a>{/if}
                </td>
                <td>{include file=$elem.____help__->getRenderTemplate() field=$elem.____help__}</td>
            </tr>
                                            
            <tr>
                <td class="otitle">{$elem.__shop_id->getTitle()}&nbsp;&nbsp;{if $elem.__shop_id->getHint() != ''}<a class="help-icon" title="{$elem.__shop_id->getHint()|escape}">?</a>{/if}
                </td>
                <td>{include file=$elem.__shop_id->getRenderTemplate() field=$elem.__shop_id}</td>
            </tr>
                                            
            <tr>
                <td class="otitle">{$elem.__key_secret->getTitle()}&nbsp;&nbsp;{if $elem.__key_secret->getHint() != ''}<a class="help-icon" title="{$elem.__key_secret->getHint()|escape}">?</a>{/if}
                </td>
                <td>{include file=$elem.__key_secret->getRenderTemplate() field=$elem.__key_secret}</td>
            </tr>
                                            
            <tr>
                <td class="otitle">{$elem.__is_holding->getTitle()}&nbsp;&nbsp;{if $elem.__is_holding->getHint() != ''}<a class="help-icon" title="{$elem.__is_holding->getHint()|escape}">?</a>{/if}
                </td>
                <td>{include file=$elem.__is_holding->getRenderTemplate() field=$elem.__is_holding}</td>
            </tr>
                                            
            <tr>
                <td class="otitle">{$elem.__enable_log->getTitle()}&nbsp;&nbsp;{if $elem.__enable_log->getHint() != ''}<a class="help-icon" title="{$elem.__enable_log->getHint()|escape}">?</a>{/if}
                </td>
                <td>{include file=$elem.__enable_log->getRenderTemplate() field=$elem.__enable_log}</td>
            </tr>
                                            
            <tr>
                <td class="otitle">{$elem.__recurring_type->getTitle()}&nbsp;&nbsp;{if $elem.__recurring_type->getHint() != ''}<a class="help-icon" title="{$elem.__recurring_type->getHint()|escape}">?</a>{/if}
                </td>
                <td>{include file=$elem.__recurring_type->getRenderTemplate() field=$elem.__recurring_type}</td>
            </tr>
                                            
            <tr>
                <td class="otitle">{$elem.__forbid_receipt_on_bind_method->getTitle()}&nbsp;&nbsp;{if $elem.__forbid_receipt_on_bind_method->getHint() != ''}<a class="help-icon" title="{$elem.__forbid_receipt_on_bind_method->getHint()|escape}">?</a>{/if}
                </td>
                <td>{include file=$elem.__forbid_receipt_on_bind_method->getRenderTemplate() field=$elem.__forbid_receipt_on_bind_method}</td>
            </tr>
                        