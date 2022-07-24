<div class="formbox" >
                <div class="rs-tabs" role="tabpanel">
        <ul class="tab-nav" role="tablist">
                    <li class=" active"><a data-target="#affiliate-affiliate-tab0" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(0)}</a></li>
                    <li class=""><a data-target="#affiliate-affiliate-tab1" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(1)}</a></li>
                    <li class=""><a data-target="#affiliate-affiliate-tab2" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(2)}</a></li>
                    <li class=""><a data-target="#affiliate-affiliate-tab3" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(3)}</a></li>
                    <li class=""><a data-target="#affiliate-affiliate-tab4" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(4)}</a></li>
                    <li class=""><a data-target="#affiliate-affiliate-tab5" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(5)}</a></li>
                </ul>
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="tab-content crud-form">
            <input type="submit" value="" style="display:none"/>
                        <div class="tab-pane active" id="affiliate-affiliate-tab0" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__title->getTitle()}&nbsp;&nbsp;{if $elem.__title->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__title->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__title->getRenderTemplate() field=$elem.__title}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__alias->getTitle()}&nbsp;&nbsp;{if $elem.__alias->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__alias->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__alias->getRenderTemplate() field=$elem.__alias}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__parent_id->getTitle()}&nbsp;&nbsp;{if $elem.__parent_id->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__parent_id->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__parent_id->getRenderTemplate() field=$elem.__parent_id}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__clickable->getTitle()}&nbsp;&nbsp;{if $elem.__clickable->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__clickable->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__clickable->getRenderTemplate() field=$elem.__clickable}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__cost_id->getTitle()}&nbsp;&nbsp;{if $elem.__cost_id->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__cost_id->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__cost_id->getRenderTemplate() field=$elem.__cost_id}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__short_contacts->getTitle()}&nbsp;&nbsp;{if $elem.__short_contacts->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__short_contacts->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__short_contacts->getRenderTemplate() field=$elem.__short_contacts}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__contacts->getTitle()}&nbsp;&nbsp;{if $elem.__contacts->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__contacts->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__contacts->getRenderTemplate() field=$elem.__contacts}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.___geo->getTitle()}&nbsp;&nbsp;{if $elem.___geo->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.___geo->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.___geo->getRenderTemplate() field=$elem.___geo}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__skip_geolocation->getTitle()}&nbsp;&nbsp;{if $elem.__skip_geolocation->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__skip_geolocation->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__skip_geolocation->getRenderTemplate() field=$elem.__skip_geolocation}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__is_default->getTitle()}&nbsp;&nbsp;{if $elem.__is_default->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__is_default->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__is_default->getRenderTemplate() field=$elem.__is_default}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__is_highlight->getTitle()}&nbsp;&nbsp;{if $elem.__is_highlight->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__is_highlight->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__is_highlight->getRenderTemplate() field=$elem.__is_highlight}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__public->getTitle()}&nbsp;&nbsp;{if $elem.__public->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__public->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__public->getRenderTemplate() field=$elem.__public}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__linked_region_id->getTitle()}&nbsp;&nbsp;{if $elem.__linked_region_id->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__linked_region_id->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__linked_region_id->getRenderTemplate() field=$elem.__linked_region_id}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="affiliate-affiliate-tab1" role="tabpanel">
                                                                                                                                                                                                                                                                                                                <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__meta_title->getTitle()}&nbsp;&nbsp;{if $elem.__meta_title->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__meta_title->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__meta_title->getRenderTemplate() field=$elem.__meta_title}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__meta_keywords->getTitle()}&nbsp;&nbsp;{if $elem.__meta_keywords->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__meta_keywords->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__meta_keywords->getRenderTemplate() field=$elem.__meta_keywords}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__meta_description->getTitle()}&nbsp;&nbsp;{if $elem.__meta_description->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__meta_description->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__meta_description->getRenderTemplate() field=$elem.__meta_description}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="affiliate-affiliate-tab2" role="tabpanel">
                                                                                                                                                                        <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__delivery_info->getTitle()}&nbsp;&nbsp;{if $elem.__delivery_info->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__delivery_info->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__delivery_info->getRenderTemplate() field=$elem.__delivery_info}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="affiliate-affiliate-tab3" role="tabpanel">
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
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="affiliate-affiliate-tab4" role="tabpanel">
                                                                                                                                                                        <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__email_for_pdf->getTitle()}&nbsp;&nbsp;{if $elem.__email_for_pdf->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__email_for_pdf->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__email_for_pdf->getRenderTemplate() field=$elem.__email_for_pdf}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="affiliate-affiliate-tab5" role="tabpanel">
                                                                                                                                                                                                                                                                                                                <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__auto_change_status->getTitle()}&nbsp;&nbsp;{if $elem.__auto_change_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__auto_change_status->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__auto_change_status->getRenderTemplate() field=$elem.__auto_change_status}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.___auto_change_from_status->getTitle()}&nbsp;&nbsp;{if $elem.___auto_change_from_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.___auto_change_from_status->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.___auto_change_from_status->getRenderTemplate() field=$elem.___auto_change_from_status}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__change_timout_hours_for_not_paid->getTitle()}&nbsp;&nbsp;{if $elem.__change_timout_hours_for_not_paid->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__change_timout_hours_for_not_paid->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__change_timout_hours_for_not_paid->getRenderTemplate() field=$elem.__change_timout_hours_for_not_paid}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                    </form>
    </div>
    </div>