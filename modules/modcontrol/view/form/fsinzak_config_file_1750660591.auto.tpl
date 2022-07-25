<div class="formbox" >
    {if $elem._before_form_template}{include file=$elem._before_form_template}{/if}

                <div class="rs-tabs" role="tabpanel">
        <ul class="tab-nav" role="tablist">
                            <li class=" active"><a data-target="#fsinzak-config-file-tab0" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(0)}</a></li>
                            <li class=""><a data-target="#fsinzak-config-file-tab1" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(1)}</a></li>
                            <li class=""><a data-target="#fsinzak-config-file-tab2" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(2)}</a></li>
                            <li class=""><a data-target="#fsinzak-config-file-tab3" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(3)}</a></li>
                            <li class=""><a data-target="#fsinzak-config-file-tab4" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(4)}</a></li>
                    </ul>
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="tab-content crud-form">
            <input type="submit" value="" style="display:none">
                            <div class="tab-pane active" id="fsinzak-config-file-tab0" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__name->getTitle()}&nbsp;&nbsp;{if $elem.__name->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__name->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__name->getRenderTemplate() field=$elem.__name}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__description->getTitle()}&nbsp;&nbsp;{if $elem.__description->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__description->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__description->getRenderTemplate() field=$elem.__description}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__version->getTitle()}&nbsp;&nbsp;{if $elem.__version->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__version->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__version->getRenderTemplate() field=$elem.__version}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__core_version->getTitle()}&nbsp;&nbsp;{if $elem.__core_version->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__core_version->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__core_version->getRenderTemplate() field=$elem.__core_version}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__author->getTitle()}&nbsp;&nbsp;{if $elem.__author->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__author->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__author->getRenderTemplate() field=$elem.__author}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__enabled->getTitle()}&nbsp;&nbsp;{if $elem.__enabled->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__enabled->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__enabled->getRenderTemplate() field=$elem.__enabled}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="fsinzak-config-file-tab1" role="tabpanel">
                                                                                                                                                                                                                                <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__wait_pay_status->getTitle()}&nbsp;&nbsp;{if $elem.__wait_pay_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__wait_pay_status->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__wait_pay_status->getRenderTemplate() field=$elem.__wait_pay_status}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__not_payed_status->getTitle()}&nbsp;&nbsp;{if $elem.__not_payed_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__not_payed_status->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__not_payed_status->getRenderTemplate() field=$elem.__not_payed_status}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="fsinzak-config-file-tab2" role="tabpanel">
                                                                                                                                                                                                                                <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__in_institution_status->getTitle()}&nbsp;&nbsp;{if $elem.__in_institution_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__in_institution_status->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__in_institution_status->getRenderTemplate() field=$elem.__in_institution_status}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__end_status->getTitle()}&nbsp;&nbsp;{if $elem.__end_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__end_status->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__end_status->getRenderTemplate() field=$elem.__end_status}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="fsinzak-config-file-tab3" role="tabpanel">
                                                                                                                                                                                                                                <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__product_commission->getTitle()}&nbsp;&nbsp;{if $elem.__product_commission->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__product_commission->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__product_commission->getRenderTemplate() field=$elem.__product_commission}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__status_to_send_pdf->getTitle()}&nbsp;&nbsp;{if $elem.__status_to_send_pdf->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__status_to_send_pdf->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__status_to_send_pdf->getRenderTemplate() field=$elem.__status_to_send_pdf}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="fsinzak-config-file-tab4" role="tabpanel">
                                                                                                                                                                            <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__dirs_to_main_page->getTitle()}&nbsp;&nbsp;{if $elem.__dirs_to_main_page->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dirs_to_main_page->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__dirs_to_main_page->getRenderTemplate() field=$elem.__dirs_to_main_page}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                    </form>
    </div>
    </div>