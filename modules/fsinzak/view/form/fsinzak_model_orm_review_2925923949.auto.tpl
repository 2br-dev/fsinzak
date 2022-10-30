<div class="formbox" >
                        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="crud-form">
            <input type="submit" value="" style="display:none">
            <div class="notabs">
                                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                    
                                    <table class="otable">
                                                                                                                    
                                <tr>
                                    <td class="otitle">{$elem.____url_user__->getTitle()}&nbsp;&nbsp;{if $elem.____url_user__->getHint() != ''}<a class="help-icon" title="{$elem.____url_user__->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.____url_user__->getRenderTemplate() field=$elem.____url_user__}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__text->getTitle()}&nbsp;&nbsp;{if $elem.__text->getHint() != ''}<a class="help-icon" title="{$elem.__text->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__text->getRenderTemplate() field=$elem.__text}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__public->getTitle()}&nbsp;&nbsp;{if $elem.__public->getHint() != ''}<a class="help-icon" title="{$elem.__public->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__public->getRenderTemplate() field=$elem.__public}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__answer->getTitle()}&nbsp;&nbsp;{if $elem.__answer->getHint() != ''}<a class="help-icon" title="{$elem.__answer->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__answer->getRenderTemplate() field=$elem.__answer}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__dateof->getTitle()}&nbsp;&nbsp;{if $elem.__dateof->getHint() != ''}<a class="help-icon" title="{$elem.__dateof->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__dateof->getRenderTemplate() field=$elem.__dateof}</td>
                                </tr>
                                                                                                        </table>
                            </div>
        </form>
    </div>