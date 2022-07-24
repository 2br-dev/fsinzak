<div class="formbox" >
                        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="crud-form">
            <input type="submit" value="" style="display:none">
            <div class="notabs">
                                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                    
                                    <table class="otable">
                                                                                                                    
                                <tr>
                                    <td class="otitle">{$elem.__applied->getTitle()}&nbsp;&nbsp;{if $elem.__applied->getHint() != ''}<a class="help-icon" title="{$elem.__applied->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__applied->getRenderTemplate() field=$elem.__applied}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__comment->getTitle()}&nbsp;&nbsp;{if $elem.__comment->getHint() != ''}<a class="help-icon" title="{$elem.__comment->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__comment->getRenderTemplate() field=$elem.__comment}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__warehouse->getTitle()}&nbsp;&nbsp;{if $elem.__warehouse->getHint() != ''}<a class="help-icon" title="{$elem.__warehouse->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__warehouse->getRenderTemplate() field=$elem.__warehouse}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__date->getTitle()}&nbsp;&nbsp;{if $elem.__date->getHint() != ''}<a class="help-icon" title="{$elem.__date->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__date->getRenderTemplate() field=$elem.__date}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__linked_documents->getTitle()}&nbsp;&nbsp;{if $elem.__linked_documents->getHint() != ''}<a class="help-icon" title="{$elem.__linked_documents->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__linked_documents->getRenderTemplate() field=$elem.__linked_documents}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__products->getTitle()}&nbsp;&nbsp;{if $elem.__products->getHint() != ''}<a class="help-icon" title="{$elem.__products->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__products->getRenderTemplate() field=$elem.__products}</td>
                                </tr>
                                                                                                        </table>
                            </div>
        </form>
    </div>