<div class="formbox" >
                        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="crud-form">
            <input type="submit" value="" style="display:none">
            <div class="notabs">
                                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                    
                                    <table class="otable">
                                                                                                                    
                                <tr>
                                    <td class="otitle">{$elem.__title->getTitle()}&nbsp;&nbsp;{if $elem.__title->getHint() != ''}<a class="help-icon" title="{$elem.__title->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__title->getRenderTemplate() field=$elem.__title}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__parent_id->getTitle()}&nbsp;&nbsp;{if $elem.__parent_id->getHint() != ''}<a class="help-icon" title="{$elem.__parent_id->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__parent_id->getRenderTemplate() field=$elem.__parent_id}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__bgcolor->getTitle()}&nbsp;&nbsp;{if $elem.__bgcolor->getHint() != ''}<a class="help-icon" title="{$elem.__bgcolor->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__bgcolor->getRenderTemplate() field=$elem.__bgcolor}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__type->getTitle()}&nbsp;&nbsp;{if $elem.__type->getHint() != ''}<a class="help-icon" title="{$elem.__type->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__type->getRenderTemplate() field=$elem.__type}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__copy_type->getTitle()}&nbsp;&nbsp;{if $elem.__copy_type->getHint() != ''}<a class="help-icon" title="{$elem.__copy_type->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__copy_type->getRenderTemplate() field=$elem.__copy_type}</td>
                                </tr>
                                                                                                        </table>
                            </div>
        </form>
    </div>