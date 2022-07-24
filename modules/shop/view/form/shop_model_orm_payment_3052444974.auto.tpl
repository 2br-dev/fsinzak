<div class="formbox" >
                <div class="rs-tabs" role="tabpanel">
        <ul class="tab-nav" role="tablist">
                    <li class=" active"><a data-target="#shop-payment-tab0" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(0)}</a></li>
                    <li class=""><a data-target="#shop-payment-tab1" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(1)}</a></li>
                    <li class=""><a data-target="#shop-payment-tab2" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(2)}</a></li>
                    <li class=""><a data-target="#shop-payment-tab3" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(3)}</a></li>
                </ul>
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="tab-content crud-form">
            <input type="submit" value="" style="display:none"/>
                        <div class="tab-pane active" id="shop-payment-tab0" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__title->getTitle()}&nbsp;&nbsp;{if $elem.__title->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__title->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__title->getRenderTemplate() field=$elem.__title}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__admin_suffix->getTitle()}&nbsp;&nbsp;{if $elem.__admin_suffix->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__admin_suffix->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__admin_suffix->getRenderTemplate() field=$elem.__admin_suffix}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__description->getTitle()}&nbsp;&nbsp;{if $elem.__description->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__description->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__description->getRenderTemplate() field=$elem.__description}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__picture->getTitle()}&nbsp;&nbsp;{if $elem.__picture->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__picture->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__picture->getRenderTemplate() field=$elem.__picture}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__first_status->getTitle()}&nbsp;&nbsp;{if $elem.__first_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__first_status->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__first_status->getRenderTemplate() field=$elem.__first_status}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__user_type->getTitle()}&nbsp;&nbsp;{if $elem.__user_type->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__user_type->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__user_type->getRenderTemplate() field=$elem.__user_type}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__target->getTitle()}&nbsp;&nbsp;{if $elem.__target->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__target->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__target->getRenderTemplate() field=$elem.__target}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__delivery->getTitle()}&nbsp;&nbsp;{if $elem.__delivery->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__delivery->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__delivery->getRenderTemplate() field=$elem.__delivery}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__public->getTitle()}&nbsp;&nbsp;{if $elem.__public->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__public->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__public->getRenderTemplate() field=$elem.__public}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__default_payment->getTitle()}&nbsp;&nbsp;{if $elem.__default_payment->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__default_payment->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__default_payment->getRenderTemplate() field=$elem.__default_payment}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__commission->getTitle()}&nbsp;&nbsp;{if $elem.__commission->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__commission->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__commission->getRenderTemplate() field=$elem.__commission}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__commission_include_delivery->getTitle()}&nbsp;&nbsp;{if $elem.__commission_include_delivery->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__commission_include_delivery->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__commission_include_delivery->getRenderTemplate() field=$elem.__commission_include_delivery}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__commission_as_product_discount->getTitle()}&nbsp;&nbsp;{if $elem.__commission_as_product_discount->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__commission_as_product_discount->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__commission_as_product_discount->getRenderTemplate() field=$elem.__commission_as_product_discount}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__class->getTitle()}&nbsp;&nbsp;{if $elem.__class->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__class->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__class->getRenderTemplate() field=$elem.__class}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="shop-payment-tab1" role="tabpanel">
                                                                                                                                                                                                                                                                                                                <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__min_price->getTitle()}&nbsp;&nbsp;{if $elem.__min_price->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__min_price->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__min_price->getRenderTemplate() field=$elem.__min_price}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__max_price->getTitle()}&nbsp;&nbsp;{if $elem.__max_price->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__max_price->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__max_price->getRenderTemplate() field=$elem.__max_price}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__show_on_partners->getTitle()}&nbsp;&nbsp;{if $elem.__show_on_partners->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__show_on_partners->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__show_on_partners->getRenderTemplate() field=$elem.__show_on_partners}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="shop-payment-tab2" role="tabpanel">
                                                                                                                                                                                                                                                                                                                <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__success_status->getTitle()}&nbsp;&nbsp;{if $elem.__success_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__success_status->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__success_status->getRenderTemplate() field=$elem.__success_status}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__holding_status->getTitle()}&nbsp;&nbsp;{if $elem.__holding_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__holding_status->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__holding_status->getRenderTemplate() field=$elem.__holding_status}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__holding_cancel_status->getTitle()}&nbsp;&nbsp;{if $elem.__holding_cancel_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__holding_cancel_status->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__holding_cancel_status->getRenderTemplate() field=$elem.__holding_cancel_status}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                        <div class="tab-pane" id="shop-payment-tab3" role="tabpanel">
                                                                                                                                                                                                                                                                                                                <table class="otable">
                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__create_cash_receipt->getTitle()}&nbsp;&nbsp;{if $elem.__create_cash_receipt->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__create_cash_receipt->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__create_cash_receipt->getRenderTemplate() field=$elem.__create_cash_receipt}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__payment_method->getTitle()}&nbsp;&nbsp;{if $elem.__payment_method->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__payment_method->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__payment_method->getRenderTemplate() field=$elem.__payment_method}</td>
                                </tr>
                                
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__create_order_transaction->getTitle()}&nbsp;&nbsp;{if $elem.__create_order_transaction->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__create_order_transaction->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__create_order_transaction->getRenderTemplate() field=$elem.__create_order_transaction}</td>
                                </tr>
                                
                                                                                    </table>
                                                </div>
                    </form>
    </div>
    </div>