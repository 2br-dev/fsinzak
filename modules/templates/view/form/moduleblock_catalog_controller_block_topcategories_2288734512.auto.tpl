<div class="formbox" >
                        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="crud-form">
            <input type="submit" value="" style="display:none">
            <div class="notabs">
                                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                    
                                    <table class="otable">
                                                                                                                    
                                <tr>
                                    <td class="otitle">{$elem.__indexTemplate->getTitle()}&nbsp;&nbsp;{if $elem.__indexTemplate->getHint() != ''}<a class="help-icon" title="{$elem.__indexTemplate->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__indexTemplate->getRenderTemplate() field=$elem.__indexTemplate}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__category_ids->getTitle()}&nbsp;&nbsp;{if $elem.__category_ids->getHint() != ''}<a class="help-icon" title="{$elem.__category_ids->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__category_ids->getRenderTemplate() field=$elem.__category_ids}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__sort->getTitle()}&nbsp;&nbsp;{if $elem.__sort->getHint() != ''}<a class="help-icon" title="{$elem.__sort->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__sort->getRenderTemplate() field=$elem.__sort}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__cache_html_lifetime->getTitle()}&nbsp;&nbsp;{if $elem.__cache_html_lifetime->getHint() != ''}<a class="help-icon" title="{$elem.__cache_html_lifetime->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__cache_html_lifetime->getRenderTemplate() field=$elem.__cache_html_lifetime}</td>
                                </tr>
                                                                                                        </table>
                            </div>
        </form>
    </div>