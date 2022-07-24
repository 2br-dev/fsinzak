<div class="formbox" >
                <div class="rs-tabs" role="tabpanel">
        <ul class="tab-nav" role="tablist">
                    <li class=" active"><a data-target="#catalog-currency-tab0" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(0)}</a></li>
                    <li class=""><a data-target="#catalog-currency-tab1" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(1)}</a></li>
                </ul>
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="tab-content crud-form">
            <input type="submit" value="" style="display:none"/>
                        <div class="tab-pane active" id="catalog-currency-tab0" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__title->getTitle()}&nbsp;&nbsp;{if $elem.__title->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__title->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__title->getRenderTemplate() field=$elem.__title}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__stitle->getTitle()}&nbsp;&nbsp;{if $elem.__stitle->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__stitle->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__stitle->getRenderTemplate() field=$elem.__stitle}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__is_base->getTitle()}&nbsp;&nbsp;{if $elem.__is_base->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__is_base->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__is_base->getRenderTemplate() field=$elem.__is_base}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__ratio->getTitle()}&nbsp;&nbsp;{if $elem.__ratio->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__ratio->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__ratio->getRenderTemplate() field=$elem.__ratio}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__public->getTitle()}&nbsp;&nbsp;{if $elem.__public->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__public->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__public->getRenderTemplate() field=$elem.__public}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__default->getTitle()}&nbsp;&nbsp;{if $elem.__default->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__default->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__default->getRenderTemplate() field=$elem.__default}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__reconvert->getTitle()}&nbsp;&nbsp;{if $elem.__reconvert->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__reconvert->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__reconvert->getRenderTemplate() field=$elem.__reconvert}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="catalog-currency-tab1" role="tabpanel">
                                                                                                                                                                        <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__percent->getTitle()}&nbsp;&nbsp;{if $elem.__percent->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__percent->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__percent->getRenderTemplate() field=$elem.__percent}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                    </form>
    </div>
    </div>