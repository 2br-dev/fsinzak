<div class="formbox" >
                <div class="rs-tabs" role="tabpanel">
        <ul class="tab-nav" role="tablist">
                    <li class=" active"><a data-target="#fsinzak-footer-tab1" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(1)}</a></li>
                    <li class=""><a data-target="#fsinzak-footer-tab2" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(2)}</a></li>
                </ul>
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="tab-content crud-form">
            <input type="submit" value="" style="display:none"/>
                        <div class="tab-pane active" id="fsinzak-footer-tab1" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__important_information->getTitle()}&nbsp;&nbsp;{if $elem.__important_information->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__important_information->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__important_information->getRenderTemplate() field=$elem.__important_information}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__help_to_order->getTitle()}&nbsp;&nbsp;{if $elem.__help_to_order->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__help_to_order->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__help_to_order->getRenderTemplate() field=$elem.__help_to_order}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__main_phone->getTitle()}&nbsp;&nbsp;{if $elem.__main_phone->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__main_phone->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__main_phone->getRenderTemplate() field=$elem.__main_phone}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__e_mail->getTitle()}&nbsp;&nbsp;{if $elem.__e_mail->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__e_mail->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__e_mail->getRenderTemplate() field=$elem.__e_mail}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__regim->getTitle()}&nbsp;&nbsp;{if $elem.__regim->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__regim->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__regim->getRenderTemplate() field=$elem.__regim}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="fsinzak-footer-tab2" role="tabpanel">
                                                                                                                                                                        <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__dop_contacts->getTitle()}&nbsp;&nbsp;{if $elem.__dop_contacts->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dop_contacts->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__dop_contacts->getRenderTemplate() field=$elem.__dop_contacts}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                    </form>
    </div>
    </div>