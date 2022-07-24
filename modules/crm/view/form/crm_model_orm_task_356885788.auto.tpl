<div class="formbox" >
                <div class="rs-tabs" role="tabpanel">
        <ul class="tab-nav" role="tablist">
                    <li class=" active"><a data-target="#crm-task-tab0" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(0)}</a></li>
                    <li class=""><a data-target="#crm-task-tab2" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(2)}</a></li>
                </ul>
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="tab-content crud-form">
            <input type="submit" value="" style="display:none"/>
                        <div class="tab-pane active" id="crm-task-tab0" role="tabpanel">
                                                                                                                                    {include file=$elem.__id->getRenderTemplate() field=$elem.__id}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <table class="otable">
                                                                                                                                                        
                                <tr>
                                    <td class="otitle">{$elem.__task_num->getTitle()}&nbsp;&nbsp;{if $elem.__task_num->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__task_num->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__task_num->getRenderTemplate() field=$elem.__task_num}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__links->getTitle()}&nbsp;&nbsp;{if $elem.__links->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__links->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__links->getRenderTemplate() field=$elem.__links}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__title->getTitle()}&nbsp;&nbsp;{if $elem.__title->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__title->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__title->getRenderTemplate() field=$elem.__title}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__status_id->getTitle()}&nbsp;&nbsp;{if $elem.__status_id->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__status_id->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__status_id->getRenderTemplate() field=$elem.__status_id}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__description->getTitle()}&nbsp;&nbsp;{if $elem.__description->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__description->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__description->getRenderTemplate() field=$elem.__description}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__date_of_create->getTitle()}&nbsp;&nbsp;{if $elem.__date_of_create->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__date_of_create->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__date_of_create->getRenderTemplate() field=$elem.__date_of_create}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__date_of_planned_end->getTitle()}&nbsp;&nbsp;{if $elem.__date_of_planned_end->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__date_of_planned_end->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__date_of_planned_end->getRenderTemplate() field=$elem.__date_of_planned_end}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__date_of_end->getTitle()}&nbsp;&nbsp;{if $elem.__date_of_end->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__date_of_end->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__date_of_end->getRenderTemplate() field=$elem.__date_of_end}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__expiration_notice_time->getTitle()}&nbsp;&nbsp;{if $elem.__expiration_notice_time->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__expiration_notice_time->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__expiration_notice_time->getRenderTemplate() field=$elem.__expiration_notice_time}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__expiration_notice_is_send->getTitle()}&nbsp;&nbsp;{if $elem.__expiration_notice_is_send->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__expiration_notice_is_send->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__expiration_notice_is_send->getRenderTemplate() field=$elem.__expiration_notice_is_send}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__creator_user_id->getTitle()}&nbsp;&nbsp;{if $elem.__creator_user_id->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__creator_user_id->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__creator_user_id->getRenderTemplate() field=$elem.__creator_user_id}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__implementer_user_id->getTitle()}&nbsp;&nbsp;{if $elem.__implementer_user_id->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__implementer_user_id->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__implementer_user_id->getRenderTemplate() field=$elem.__implementer_user_id}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__is_archived->getTitle()}&nbsp;&nbsp;{if $elem.__is_archived->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__is_archived->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__is_archived->getRenderTemplate() field=$elem.__is_archived}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="crm-task-tab2" role="tabpanel">
                                                                                                            {include file=$elem.____files__->getRenderTemplate() field=$elem.____files__}
                                                                                                                                                </div>
                    </form>
    </div>
    </div>