<div class="formbox" >
                <div class="rs-tabs" role="tabpanel">
        <ul class="tab-nav" role="tablist">
                    <li class=" active"><a data-target="#fsinzak-recipients-tab0" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(0)}</a></li>
                    <li class=""><a data-target="#fsinzak-recipients-tab1" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(1)}</a></li>
                </ul>
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="tab-content crud-form">
            <input type="submit" value="" style="display:none"/>
                        <div class="tab-pane active" id="fsinzak-recipients-tab0" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__name->getTitle()}&nbsp;&nbsp;{if $elem.__name->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__name->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__name->getRenderTemplate() field=$elem.__name}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__surname->getTitle()}&nbsp;&nbsp;{if $elem.__surname->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__surname->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__surname->getRenderTemplate() field=$elem.__surname}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__midname->getTitle()}&nbsp;&nbsp;{if $elem.__midname->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__midname->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__midname->getRenderTemplate() field=$elem.__midname}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__birthday->getTitle()}&nbsp;&nbsp;{if $elem.__birthday->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__birthday->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__birthday->getRenderTemplate() field=$elem.__birthday}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__removed->getTitle()}&nbsp;&nbsp;{if $elem.__removed->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__removed->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__removed->getRenderTemplate() field=$elem.__removed}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="fsinzak-recipients-tab1" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                    <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__limit_sum->getTitle()}&nbsp;&nbsp;{if $elem.__limit_sum->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__limit_sum->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__limit_sum->getRenderTemplate() field=$elem.__limit_sum}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__limit_weight->getTitle()}&nbsp;&nbsp;{if $elem.__limit_weight->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__limit_weight->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__limit_weight->getRenderTemplate() field=$elem.__limit_weight}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__periodicity->getTitle()}&nbsp;&nbsp;{if $elem.__periodicity->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__periodicity->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__periodicity->getRenderTemplate() field=$elem.__periodicity}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__periodicity_month->getTitle()}&nbsp;&nbsp;{if $elem.__periodicity_month->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__periodicity_month->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__periodicity_month->getRenderTemplate() field=$elem.__periodicity_month}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                    </form>
    </div>
    </div>