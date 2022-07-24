<div class="formbox" >
    {if $elem._before_form_template}{include file=$elem._before_form_template}{/if}

                <div class="rs-tabs" role="tabpanel">
        <ul class="tab-nav" role="tablist">
                            <li class=" active"><a data-target="#shop-config-file-tab0" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(0)}</a></li>
                            <li class=""><a data-target="#shop-config-file-tab1" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(1)}</a></li>
                            <li class=""><a data-target="#shop-config-file-tab2" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(2)}</a></li>
                            <li class=""><a data-target="#shop-config-file-tab3" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(3)}</a></li>
                            <li class=""><a data-target="#shop-config-file-tab4" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(4)}</a></li>
                            <li class=""><a data-target="#shop-config-file-tab5" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(5)}</a></li>
                            <li class=""><a data-target="#shop-config-file-tab6" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(6)}</a></li>
                            <li class=""><a data-target="#shop-config-file-tab7" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(7)}</a></li>
                            <li class=""><a data-target="#shop-config-file-tab8" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(8)}</a></li>
                            <li class=""><a data-target="#shop-config-file-tab9" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(9)}</a></li>
                            <li class=""><a data-target="#shop-config-file-tab10" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(10)}</a></li>
                    </ul>
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="tab-content crud-form">
            <input type="submit" value="" style="display:none">
                            <div class="tab-pane active" id="shop-config-file-tab0" role="tabpanel">
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
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__basketminlimit->getTitle()}&nbsp;&nbsp;{if $elem.__basketminlimit->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__basketminlimit->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__basketminlimit->getRenderTemplate() field=$elem.__basketminlimit}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__basketminweightlimit->getTitle()}&nbsp;&nbsp;{if $elem.__basketminweightlimit->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__basketminweightlimit->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__basketminweightlimit->getRenderTemplate() field=$elem.__basketminweightlimit}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__check_quantity->getTitle()}&nbsp;&nbsp;{if $elem.__check_quantity->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__check_quantity->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__check_quantity->getRenderTemplate() field=$elem.__check_quantity}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__allow_buy_num_less_min_order->getTitle()}&nbsp;&nbsp;{if $elem.__allow_buy_num_less_min_order->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__allow_buy_num_less_min_order->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__allow_buy_num_less_min_order->getRenderTemplate() field=$elem.__allow_buy_num_less_min_order}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__allow_buy_all_stock_ignoring_amount_step->getTitle()}&nbsp;&nbsp;{if $elem.__allow_buy_all_stock_ignoring_amount_step->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__allow_buy_all_stock_ignoring_amount_step->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__allow_buy_all_stock_ignoring_amount_step->getRenderTemplate() field=$elem.__allow_buy_all_stock_ignoring_amount_step}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__check_cost_for_zero->getTitle()}&nbsp;&nbsp;{if $elem.__check_cost_for_zero->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__check_cost_for_zero->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__check_cost_for_zero->getRenderTemplate() field=$elem.__check_cost_for_zero}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__first_order_status->getTitle()}&nbsp;&nbsp;{if $elem.__first_order_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__first_order_status->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__first_order_status->getRenderTemplate() field=$elem.__first_order_status}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__user_orders_page_size->getTitle()}&nbsp;&nbsp;{if $elem.__user_orders_page_size->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__user_orders_page_size->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__user_orders_page_size->getRenderTemplate() field=$elem.__user_orders_page_size}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__reservation->getTitle()}&nbsp;&nbsp;{if $elem.__reservation->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__reservation->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__reservation->getRenderTemplate() field=$elem.__reservation}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__reservation_required_fields->getTitle()}&nbsp;&nbsp;{if $elem.__reservation_required_fields->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__reservation_required_fields->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__reservation_required_fields->getRenderTemplate() field=$elem.__reservation_required_fields}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__allow_concomitant_count_edit->getTitle()}&nbsp;&nbsp;{if $elem.__allow_concomitant_count_edit->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__allow_concomitant_count_edit->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__allow_concomitant_count_edit->getRenderTemplate() field=$elem.__allow_concomitant_count_edit}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__source_cost->getTitle()}&nbsp;&nbsp;{if $elem.__source_cost->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__source_cost->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__source_cost->getRenderTemplate() field=$elem.__source_cost}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__auto_change_status->getTitle()}&nbsp;&nbsp;{if $elem.__auto_change_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__auto_change_status->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__auto_change_status->getRenderTemplate() field=$elem.__auto_change_status}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__auto_send_supply_notice->getTitle()}&nbsp;&nbsp;{if $elem.__auto_send_supply_notice->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__auto_send_supply_notice->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__auto_send_supply_notice->getRenderTemplate() field=$elem.__auto_send_supply_notice}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__courier_user_group->getTitle()}&nbsp;&nbsp;{if $elem.__courier_user_group->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__courier_user_group->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__courier_user_group->getRenderTemplate() field=$elem.__courier_user_group}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__ban_courier_del->getTitle()}&nbsp;&nbsp;{if $elem.__ban_courier_del->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__ban_courier_del->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__ban_courier_del->getRenderTemplate() field=$elem.__ban_courier_del}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__remove_nopublic_from_cart->getTitle()}&nbsp;&nbsp;{if $elem.__remove_nopublic_from_cart->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__remove_nopublic_from_cart->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__remove_nopublic_from_cart->getRenderTemplate() field=$elem.__remove_nopublic_from_cart}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__show_number_of_lines_in_cart->getTitle()}&nbsp;&nbsp;{if $elem.__show_number_of_lines_in_cart->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__show_number_of_lines_in_cart->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__show_number_of_lines_in_cart->getRenderTemplate() field=$elem.__show_number_of_lines_in_cart}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__cart_life_time->getTitle()}&nbsp;&nbsp;{if $elem.__cart_life_time->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__cart_life_time->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__cart_life_time->getRenderTemplate() field=$elem.__cart_life_time}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="shop-config-file-tab1" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                        <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__default_region_id->getTitle()}&nbsp;&nbsp;{if $elem.__default_region_id->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__default_region_id->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__default_region_id->getRenderTemplate() field=$elem.__default_region_id}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__use_geolocation_address->getTitle()}&nbsp;&nbsp;{if $elem.__use_geolocation_address->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__use_geolocation_address->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__use_geolocation_address->getRenderTemplate() field=$elem.__use_geolocation_address}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__use_selected_address_in_checkout->getTitle()}&nbsp;&nbsp;{if $elem.__use_selected_address_in_checkout->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__use_selected_address_in_checkout->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__use_selected_address_in_checkout->getRenderTemplate() field=$elem.__use_selected_address_in_checkout}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__regions_marked_when_change_selected_address->getTitle()}&nbsp;&nbsp;{if $elem.__regions_marked_when_change_selected_address->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__regions_marked_when_change_selected_address->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__regions_marked_when_change_selected_address->getRenderTemplate() field=$elem.__regions_marked_when_change_selected_address}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="shop-config-file-tab2" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                        <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__use_personal_account->getTitle()}&nbsp;&nbsp;{if $elem.__use_personal_account->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__use_personal_account->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__use_personal_account->getRenderTemplate() field=$elem.__use_personal_account}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__nds_personal_account->getTitle()}&nbsp;&nbsp;{if $elem.__nds_personal_account->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__nds_personal_account->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__nds_personal_account->getRenderTemplate() field=$elem.__nds_personal_account}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__personal_account_payment_method->getTitle()}&nbsp;&nbsp;{if $elem.__personal_account_payment_method->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__personal_account_payment_method->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__personal_account_payment_method->getRenderTemplate() field=$elem.__personal_account_payment_method}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__personal_account_payment_subject->getTitle()}&nbsp;&nbsp;{if $elem.__personal_account_payment_subject->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__personal_account_payment_subject->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__personal_account_payment_subject->getRenderTemplate() field=$elem.__personal_account_payment_subject}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="shop-config-file-tab3" role="tabpanel">
                                                                                                                            {include file=$elem.____userfields__->getRenderTemplate() field=$elem.____userfields__}
                                                                                                                                                </div>
                            <div class="tab-pane" id="shop-config-file-tab4" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__checkout_type->getTitle()}&nbsp;&nbsp;{if $elem.__checkout_type->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__checkout_type->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__checkout_type->getRenderTemplate() field=$elem.__checkout_type}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__checkout_register_option->getTitle()}&nbsp;&nbsp;{if $elem.__checkout_register_option->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__checkout_register_option->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__checkout_register_option->getRenderTemplate() field=$elem.__checkout_register_option}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__require_choose_address->getTitle()}&nbsp;&nbsp;{if $elem.__require_choose_address->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__require_choose_address->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__require_choose_address->getRenderTemplate() field=$elem.__require_choose_address}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__register_user_default_checked->getTitle()}&nbsp;&nbsp;{if $elem.__register_user_default_checked->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__register_user_default_checked->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__register_user_default_checked->getRenderTemplate() field=$elem.__register_user_default_checked}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__default_checkout_tab->getTitle()}&nbsp;&nbsp;{if $elem.__default_checkout_tab->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__default_checkout_tab->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__default_checkout_tab->getRenderTemplate() field=$elem.__default_checkout_tab}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__default_zipcode->getTitle()}&nbsp;&nbsp;{if $elem.__default_zipcode->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__default_zipcode->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__default_zipcode->getRenderTemplate() field=$elem.__default_zipcode}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__require_country->getTitle()}&nbsp;&nbsp;{if $elem.__require_country->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__require_country->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__require_country->getRenderTemplate() field=$elem.__require_country}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__require_region->getTitle()}&nbsp;&nbsp;{if $elem.__require_region->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__require_region->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__require_region->getRenderTemplate() field=$elem.__require_region}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__require_city->getTitle()}&nbsp;&nbsp;{if $elem.__require_city->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__require_city->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__require_city->getRenderTemplate() field=$elem.__require_city}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__require_zipcode->getTitle()}&nbsp;&nbsp;{if $elem.__require_zipcode->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__require_zipcode->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__require_zipcode->getRenderTemplate() field=$elem.__require_zipcode}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__require_address->getTitle()}&nbsp;&nbsp;{if $elem.__require_address->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__require_address->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__require_address->getRenderTemplate() field=$elem.__require_address}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__check_captcha->getTitle()}&nbsp;&nbsp;{if $elem.__check_captcha->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__check_captcha->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__check_captcha->getRenderTemplate() field=$elem.__check_captcha}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__show_contact_person->getTitle()}&nbsp;&nbsp;{if $elem.__show_contact_person->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__show_contact_person->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__show_contact_person->getRenderTemplate() field=$elem.__show_contact_person}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__require_email_in_noregister->getTitle()}&nbsp;&nbsp;{if $elem.__require_email_in_noregister->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__require_email_in_noregister->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__require_email_in_noregister->getRenderTemplate() field=$elem.__require_email_in_noregister}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__require_phone_in_noregister->getTitle()}&nbsp;&nbsp;{if $elem.__require_phone_in_noregister->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__require_phone_in_noregister->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__require_phone_in_noregister->getRenderTemplate() field=$elem.__require_phone_in_noregister}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__myself_delivery_is_default->getTitle()}&nbsp;&nbsp;{if $elem.__myself_delivery_is_default->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__myself_delivery_is_default->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__myself_delivery_is_default->getRenderTemplate() field=$elem.__myself_delivery_is_default}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__require_license_agree->getTitle()}&nbsp;&nbsp;{if $elem.__require_license_agree->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__require_license_agree->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__require_license_agree->getRenderTemplate() field=$elem.__require_license_agree}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__license_agreement->getTitle()}&nbsp;&nbsp;{if $elem.__license_agreement->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__license_agreement->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__license_agreement->getRenderTemplate() field=$elem.__license_agreement}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__use_generated_order_num->getTitle()}&nbsp;&nbsp;{if $elem.__use_generated_order_num->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__use_generated_order_num->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__use_generated_order_num->getRenderTemplate() field=$elem.__use_generated_order_num}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__generated_ordernum_mask->getTitle()}&nbsp;&nbsp;{if $elem.__generated_ordernum_mask->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__generated_ordernum_mask->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__generated_ordernum_mask->getRenderTemplate() field=$elem.__generated_ordernum_mask}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__generated_ordernum_numbers->getTitle()}&nbsp;&nbsp;{if $elem.__generated_ordernum_numbers->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__generated_ordernum_numbers->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__generated_ordernum_numbers->getRenderTemplate() field=$elem.__generated_ordernum_numbers}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__hide_delivery->getTitle()}&nbsp;&nbsp;{if $elem.__hide_delivery->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__hide_delivery->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__hide_delivery->getRenderTemplate() field=$elem.__hide_delivery}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__hide_payment->getTitle()}&nbsp;&nbsp;{if $elem.__hide_payment->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__hide_payment->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__hide_payment->getRenderTemplate() field=$elem.__hide_payment}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__manager_group->getTitle()}&nbsp;&nbsp;{if $elem.__manager_group->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__manager_group->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__manager_group->getRenderTemplate() field=$elem.__manager_group}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__set_random_manager->getTitle()}&nbsp;&nbsp;{if $elem.__set_random_manager->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__set_random_manager->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__set_random_manager->getRenderTemplate() field=$elem.__set_random_manager}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__cashregister_class->getTitle()}&nbsp;&nbsp;{if $elem.__cashregister_class->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__cashregister_class->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__cashregister_class->getRenderTemplate() field=$elem.__cashregister_class}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__cashregister_enable_auto_check->getTitle()}&nbsp;&nbsp;{if $elem.__cashregister_enable_auto_check->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__cashregister_enable_auto_check->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__cashregister_enable_auto_check->getRenderTemplate() field=$elem.__cashregister_enable_auto_check}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__ofd->getTitle()}&nbsp;&nbsp;{if $elem.__ofd->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__ofd->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__ofd->getRenderTemplate() field=$elem.__ofd}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__sell_payment_object->getTitle()}&nbsp;&nbsp;{if $elem.__sell_payment_object->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__sell_payment_object->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__sell_payment_object->getRenderTemplate() field=$elem.__sell_payment_object}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__payment_method->getTitle()}&nbsp;&nbsp;{if $elem.__payment_method->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__payment_method->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__payment_method->getRenderTemplate() field=$elem.__payment_method}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="shop-config-file-tab5" role="tabpanel">
                                                                                                                                                                                                                                                                                    <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__return_enable->getTitle()}&nbsp;&nbsp;{if $elem.__return_enable->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__return_enable->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__return_enable->getRenderTemplate() field=$elem.__return_enable}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__return_rules->getTitle()}&nbsp;&nbsp;{if $elem.__return_rules->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__return_rules->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__return_rules->getRenderTemplate() field=$elem.__return_rules}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__return_print_form_tpl->getTitle()}&nbsp;&nbsp;{if $elem.__return_print_form_tpl->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__return_print_form_tpl->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__return_print_form_tpl->getRenderTemplate() field=$elem.__return_print_form_tpl}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="shop-config-file-tab6" role="tabpanel">
                                                                                                                                                                                                                                <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__discount_code_len->getTitle()}&nbsp;&nbsp;{if $elem.__discount_code_len->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__discount_code_len->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__discount_code_len->getRenderTemplate() field=$elem.__discount_code_len}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__fixed_discount_max_order_percent->getTitle()}&nbsp;&nbsp;{if $elem.__fixed_discount_max_order_percent->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__fixed_discount_max_order_percent->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__fixed_discount_max_order_percent->getRenderTemplate() field=$elem.__fixed_discount_max_order_percent}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="shop-config-file-tab7" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                        <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__discount_combination->getTitle()}&nbsp;&nbsp;{if $elem.__discount_combination->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__discount_combination->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__discount_combination->getRenderTemplate() field=$elem.__discount_combination}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__old_cost_delta_as_discount->getTitle()}&nbsp;&nbsp;{if $elem.__old_cost_delta_as_discount->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__old_cost_delta_as_discount->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__old_cost_delta_as_discount->getRenderTemplate() field=$elem.__old_cost_delta_as_discount}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__cart_item_max_discount->getTitle()}&nbsp;&nbsp;{if $elem.__cart_item_max_discount->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__cart_item_max_discount->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__cart_item_max_discount->getRenderTemplate() field=$elem.__cart_item_max_discount}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__discount_amount_correct_round->getTitle()}&nbsp;&nbsp;{if $elem.__discount_amount_correct_round->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__discount_amount_correct_round->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__discount_amount_correct_round->getRenderTemplate() field=$elem.__discount_amount_correct_round}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="shop-config-file-tab8" role="tabpanel">
                                                                                                                                                                                                                                <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__check_conformity_uit_to_barcode->getTitle()}&nbsp;&nbsp;{if $elem.__check_conformity_uit_to_barcode->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__check_conformity_uit_to_barcode->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__check_conformity_uit_to_barcode->getRenderTemplate() field=$elem.__check_conformity_uit_to_barcode}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__create_receipt_upon_shipment->getTitle()}&nbsp;&nbsp;{if $elem.__create_receipt_upon_shipment->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__create_receipt_upon_shipment->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__create_receipt_upon_shipment->getRenderTemplate() field=$elem.__create_receipt_upon_shipment}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="shop-config-file-tab9" role="tabpanel">
                                                                                                                                                                            <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__recurring_show_methods_menu->getTitle()}&nbsp;&nbsp;{if $elem.__recurring_show_methods_menu->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__recurring_show_methods_menu->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__recurring_show_methods_menu->getRenderTemplate() field=$elem.__recurring_show_methods_menu}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="shop-config-file-tab10" role="tabpanel">
                                                                                                                                                                                                                                <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__cdek_default_delivery->getTitle()}&nbsp;&nbsp;{if $elem.__cdek_default_delivery->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__cdek_default_delivery->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__cdek_default_delivery->getRenderTemplate() field=$elem.__cdek_default_delivery}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__cdek_webhook_uuid->getTitle()}&nbsp;&nbsp;{if $elem.__cdek_webhook_uuid->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__cdek_webhook_uuid->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__cdek_webhook_uuid->getRenderTemplate() field=$elem.__cdek_webhook_uuid}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                    </form>
    </div>
    </div>