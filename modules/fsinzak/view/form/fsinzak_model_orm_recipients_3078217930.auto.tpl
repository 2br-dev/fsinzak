<div class="formbox" >
                        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="crud-form">
            <input type="submit" value="" style="display:none">
            <div class="notabs">
                                                                                                            
                                                                                            
                                                                                            
                                                    
                                    <table class="otable">
                                                                                                                    
                                <tr>
                                    <td class="otitle">{$elem.__name->getTitle()}&nbsp;&nbsp;{if $elem.__name->getHint() != ''}<a class="help-icon" title="{$elem.__name->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__name->getRenderTemplate() field=$elem.__name}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__surname->getTitle()}&nbsp;&nbsp;{if $elem.__surname->getHint() != ''}<a class="help-icon" title="{$elem.__surname->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__surname->getRenderTemplate() field=$elem.__surname}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__midname->getTitle()}&nbsp;&nbsp;{if $elem.__midname->getHint() != ''}<a class="help-icon" title="{$elem.__midname->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__midname->getRenderTemplate() field=$elem.__midname}</td>
                                </tr>
                                                                                                        </table>
                            </div>
        </form>
    </div>