<div class="formbox" >
    {if $elem._before_form_template}{include file=$elem._before_form_template}{/if}

                <div class="rs-tabs" role="tabpanel">
        <ul class="tab-nav" role="tablist">
                            <li class=" active"><a data-target="#exchange-config-file-tab0" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(0)}</a></li>
                            <li class=""><a data-target="#exchange-config-file-tab1" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(1)}</a></li>
                            <li class=""><a data-target="#exchange-config-file-tab2" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(2)}</a></li>
                            <li class=""><a data-target="#exchange-config-file-tab3" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(3)}</a></li>
                            <li class=""><a data-target="#exchange-config-file-tab4" data-toggle="tab" role="tab">{$elem->getPropertyIterator()->getGroupName(4)}</a></li>
                    </ul>
        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="tab-content crud-form">
            <input type="submit" value="" style="display:none">
                            <div class="tab-pane active" id="exchange-config-file-tab0" role="tabpanel">
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
                                        <td class="otitle">{$elem.__import_scheme->getTitle()}&nbsp;&nbsp;{if $elem.__import_scheme->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__import_scheme->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__import_scheme->getRenderTemplate() field=$elem.__import_scheme}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__import_offers_in_one_product->getTitle()}&nbsp;&nbsp;{if $elem.__import_offers_in_one_product->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__import_offers_in_one_product->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__import_offers_in_one_product->getRenderTemplate() field=$elem.__import_offers_in_one_product}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__file_limit->getTitle()}&nbsp;&nbsp;{if $elem.__file_limit->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__file_limit->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__file_limit->getRenderTemplate() field=$elem.__file_limit}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__use_zip->getTitle()}&nbsp;&nbsp;{if $elem.__use_zip->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__use_zip->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__use_zip->getRenderTemplate() field=$elem.__use_zip}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__history_depth->getTitle()}&nbsp;&nbsp;{if $elem.__history_depth->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__history_depth->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__history_depth->getRenderTemplate() field=$elem.__history_depth}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__dont_check_sale_init->getTitle()}&nbsp;&nbsp;{if $elem.__dont_check_sale_init->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dont_check_sale_init->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__dont_check_sale_init->getRenderTemplate() field=$elem.__dont_check_sale_init}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__lock_expire_interval->getTitle()}&nbsp;&nbsp;{if $elem.__lock_expire_interval->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__lock_expire_interval->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__lock_expire_interval->getRenderTemplate() field=$elem.__lock_expire_interval}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="exchange-config-file-tab1" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__cat_for_import->getTitle()}&nbsp;&nbsp;{if $elem.__cat_for_import->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__cat_for_import->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__cat_for_import->getRenderTemplate() field=$elem.__cat_for_import}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__cat_for_catless_porducts->getTitle()}&nbsp;&nbsp;{if $elem.__cat_for_catless_porducts->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__cat_for_catless_porducts->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__cat_for_catless_porducts->getRenderTemplate() field=$elem.__cat_for_catless_porducts}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__catalog_import_interval->getTitle()}&nbsp;&nbsp;{if $elem.__catalog_import_interval->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__catalog_import_interval->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__catalog_import_interval->getRenderTemplate() field=$elem.__catalog_import_interval}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__catalog_element_action->getTitle()}&nbsp;&nbsp;{if $elem.__catalog_element_action->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__catalog_element_action->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__catalog_element_action->getRenderTemplate() field=$elem.__catalog_element_action}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__catalog_offer_action->getTitle()}&nbsp;&nbsp;{if $elem.__catalog_offer_action->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__catalog_offer_action->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__catalog_offer_action->getRenderTemplate() field=$elem.__catalog_offer_action}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__catalog_section_action->getTitle()}&nbsp;&nbsp;{if $elem.__catalog_section_action->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__catalog_section_action->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__catalog_section_action->getRenderTemplate() field=$elem.__catalog_section_action}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__product_uniq_field->getTitle()}&nbsp;&nbsp;{if $elem.__product_uniq_field->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__product_uniq_field->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__product_uniq_field->getRenderTemplate() field=$elem.__product_uniq_field}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__is_unic_dirname->getTitle()}&nbsp;&nbsp;{if $elem.__is_unic_dirname->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__is_unic_dirname->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__is_unic_dirname->getRenderTemplate() field=$elem.__is_unic_dirname}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__hide_new_products->getTitle()}&nbsp;&nbsp;{if $elem.__hide_new_products->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__hide_new_products->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__hide_new_products->getRenderTemplate() field=$elem.__hide_new_products}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__hide_new_dirs->getTitle()}&nbsp;&nbsp;{if $elem.__hide_new_dirs->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__hide_new_dirs->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__hide_new_dirs->getRenderTemplate() field=$elem.__hide_new_dirs}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__full_name_to_description->getTitle()}&nbsp;&nbsp;{if $elem.__full_name_to_description->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__full_name_to_description->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__full_name_to_description->getRenderTemplate() field=$elem.__full_name_to_description}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__offer_name_from_props->getTitle()}&nbsp;&nbsp;{if $elem.__offer_name_from_props->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__offer_name_from_props->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__offer_name_from_props->getRenderTemplate() field=$elem.__offer_name_from_props}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__dimensions_unit->getTitle()}&nbsp;&nbsp;{if $elem.__dimensions_unit->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dimensions_unit->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__dimensions_unit->getRenderTemplate() field=$elem.__dimensions_unit}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="exchange-config-file-tab2" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__catalog_keep_spec_dirs->getTitle()}&nbsp;&nbsp;{if $elem.__catalog_keep_spec_dirs->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__catalog_keep_spec_dirs->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__catalog_keep_spec_dirs->getRenderTemplate() field=$elem.__catalog_keep_spec_dirs}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__catalog_update_parent->getTitle()}&nbsp;&nbsp;{if $elem.__catalog_update_parent->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__catalog_update_parent->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__catalog_update_parent->getRenderTemplate() field=$elem.__catalog_update_parent}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__product_update_dir->getTitle()}&nbsp;&nbsp;{if $elem.__product_update_dir->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__product_update_dir->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__product_update_dir->getRenderTemplate() field=$elem.__product_update_dir}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__dont_delete_prop->getTitle()}&nbsp;&nbsp;{if $elem.__dont_delete_prop->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dont_delete_prop->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__dont_delete_prop->getRenderTemplate() field=$elem.__dont_delete_prop}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__dont_delete_costs->getTitle()}&nbsp;&nbsp;{if $elem.__dont_delete_costs->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dont_delete_costs->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__dont_delete_costs->getRenderTemplate() field=$elem.__dont_delete_costs}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__dont_delete_stocks->getTitle()}&nbsp;&nbsp;{if $elem.__dont_delete_stocks->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dont_delete_stocks->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__dont_delete_stocks->getRenderTemplate() field=$elem.__dont_delete_stocks}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__dont_update_fields->getTitle()}&nbsp;&nbsp;{if $elem.__dont_update_fields->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dont_update_fields->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__dont_update_fields->getRenderTemplate() field=$elem.__dont_update_fields}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__dont_update_offer_fields->getTitle()}&nbsp;&nbsp;{if $elem.__dont_update_offer_fields->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dont_update_offer_fields->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__dont_update_offer_fields->getRenderTemplate() field=$elem.__dont_update_offer_fields}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__dont_update_group_fields->getTitle()}&nbsp;&nbsp;{if $elem.__dont_update_group_fields->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dont_update_group_fields->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__dont_update_group_fields->getRenderTemplate() field=$elem.__dont_update_group_fields}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__dont_update_prop_fields->getTitle()}&nbsp;&nbsp;{if $elem.__dont_update_prop_fields->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__dont_update_prop_fields->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__dont_update_prop_fields->getRenderTemplate() field=$elem.__dont_update_prop_fields}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="exchange-config-file-tab3" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__remove_offer_from_product_title->getTitle()}&nbsp;&nbsp;{if $elem.__remove_offer_from_product_title->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__remove_offer_from_product_title->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__remove_offer_from_product_title->getRenderTemplate() field=$elem.__remove_offer_from_product_title}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__catalog_translit_on_add->getTitle()}&nbsp;&nbsp;{if $elem.__catalog_translit_on_add->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__catalog_translit_on_add->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__catalog_translit_on_add->getRenderTemplate() field=$elem.__catalog_translit_on_add}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__catalog_translit_on_update->getTitle()}&nbsp;&nbsp;{if $elem.__catalog_translit_on_update->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__catalog_translit_on_update->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__catalog_translit_on_update->getRenderTemplate() field=$elem.__catalog_translit_on_update}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__brand_property->getTitle()}&nbsp;&nbsp;{if $elem.__brand_property->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__brand_property->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__brand_property->getRenderTemplate() field=$elem.__brand_property}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__import_brand->getTitle()}&nbsp;&nbsp;{if $elem.__import_brand->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__import_brand->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__import_brand->getRenderTemplate() field=$elem.__import_brand}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__weight_property->getTitle()}&nbsp;&nbsp;{if $elem.__weight_property->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__weight_property->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__weight_property->getRenderTemplate() field=$elem.__weight_property}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__multi_separator_fields->getTitle()}&nbsp;&nbsp;{if $elem.__multi_separator_fields->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__multi_separator_fields->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__multi_separator_fields->getRenderTemplate() field=$elem.__multi_separator_fields}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__allow_insert_multioffers->getTitle()}&nbsp;&nbsp;{if $elem.__allow_insert_multioffers->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__allow_insert_multioffers->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__allow_insert_multioffers->getRenderTemplate() field=$elem.__allow_insert_multioffers}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__unique_offer_barcode->getTitle()}&nbsp;&nbsp;{if $elem.__unique_offer_barcode->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__unique_offer_barcode->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__unique_offer_barcode->getRenderTemplate() field=$elem.__unique_offer_barcode}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__sort_offers_by_title->getTitle()}&nbsp;&nbsp;{if $elem.__sort_offers_by_title->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__sort_offers_by_title->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__sort_offers_by_title->getRenderTemplate() field=$elem.__sort_offers_by_title}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                            <div class="tab-pane" id="exchange-config-file-tab4" role="tabpanel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <table class="otable">
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__sale_export_only_payed->getTitle()}&nbsp;&nbsp;{if $elem.__sale_export_only_payed->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__sale_export_only_payed->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__sale_export_only_payed->getRenderTemplate() field=$elem.__sale_export_only_payed}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__sale_export_statuses->getTitle()}&nbsp;&nbsp;{if $elem.__sale_export_statuses->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__sale_export_statuses->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__sale_export_statuses->getRenderTemplate() field=$elem.__sale_export_statuses}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__sale_final_status_on_delivery->getTitle()}&nbsp;&nbsp;{if $elem.__sale_final_status_on_delivery->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__sale_final_status_on_delivery->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__sale_final_status_on_delivery->getRenderTemplate() field=$elem.__sale_final_status_on_delivery}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__sale_final_status_on_pay->getTitle()}&nbsp;&nbsp;{if $elem.__sale_final_status_on_pay->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__sale_final_status_on_pay->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__sale_final_status_on_pay->getRenderTemplate() field=$elem.__sale_final_status_on_pay}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__sale_final_status_on_shipment->getTitle()}&nbsp;&nbsp;{if $elem.__sale_final_status_on_shipment->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__sale_final_status_on_shipment->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__sale_final_status_on_shipment->getRenderTemplate() field=$elem.__sale_final_status_on_shipment}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__sale_final_status_on_success->getTitle()}&nbsp;&nbsp;{if $elem.__sale_final_status_on_success->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__sale_final_status_on_success->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__sale_final_status_on_success->getRenderTemplate() field=$elem.__sale_final_status_on_success}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__sale_final_status_on_cancel->getTitle()}&nbsp;&nbsp;{if $elem.__sale_final_status_on_cancel->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__sale_final_status_on_cancel->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__sale_final_status_on_cancel->getRenderTemplate() field=$elem.__sale_final_status_on_cancel}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__order_flag_cancel_requisite_name->getTitle()}&nbsp;&nbsp;{if $elem.__order_flag_cancel_requisite_name->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__order_flag_cancel_requisite_name->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__order_flag_cancel_requisite_name->getRenderTemplate() field=$elem.__order_flag_cancel_requisite_name}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__sale_replace_currency->getTitle()}&nbsp;&nbsp;{if $elem.__sale_replace_currency->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__sale_replace_currency->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__sale_replace_currency->getRenderTemplate() field=$elem.__sale_replace_currency}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__order_update_status->getTitle()}&nbsp;&nbsp;{if $elem.__order_update_status->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__order_update_status->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__order_update_status->getRenderTemplate() field=$elem.__order_update_status}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__export_timezone->getTitle()}&nbsp;&nbsp;{if $elem.__export_timezone->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__export_timezone->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__export_timezone->getRenderTemplate() field=$elem.__export_timezone}</td>
                                        </tr>
                                    
                                                                    
                                        <tr>
                                        <td class="otitle">{$elem.__uniq_delivery_id->getTitle()}&nbsp;&nbsp;{if $elem.__uniq_delivery_id->getHint() != ''}<a class="help-icon" data-placement="right" title="{$elem.__uniq_delivery_id->getHint()|escape}">?</a>{/if}
                                        </td>
                                        <td>{include file=$elem.__uniq_delivery_id->getRenderTemplate() field=$elem.__uniq_delivery_id}</td>
                                        </tr>
                                    
                                                            </table>
                                                            </div>
                    </form>
    </div>
    </div>