<div class="virtual-form" data-has-validation="true" data-action="/admin/catalog-block-offerblock/?odo=offerEdit">
    <div class="crud-form-error"></div>
    <input type="hidden" name="offer_id" value="{$elem.id}">
    <input type="hidden" name="product_id" value="{$elem.product_id}">
    <table class="table-inline-edit">
                                                    
                <tr>
                    <td class="key">{$elem.__title->getTitle()}&nbsp;&nbsp;{if $elem.__title->getHint() != ''}<a class="help-icon" title="{$elem.__title->getHint()|escape}">?</a>{/if}</td>
                    <td>{include file=$elem.__title->getRenderTemplate() field=$elem.__title}</td>
                </tr>
                                                            
                <tr>
                    <td class="key">{$elem.__barcode->getTitle()}&nbsp;&nbsp;{if $elem.__barcode->getHint() != ''}<a class="help-icon" title="{$elem.__barcode->getHint()|escape}">?</a>{/if}</td>
                    <td>{include file=$elem.__barcode->getRenderTemplate() field=$elem.__barcode}</td>
                </tr>
                                                            
                <tr>
                    <td class="key">{$elem.__weight->getTitle()}&nbsp;&nbsp;{if $elem.__weight->getHint() != ''}<a class="help-icon" title="{$elem.__weight->getHint()|escape}">?</a>{/if}</td>
                    <td>{include file=$elem.__weight->getRenderTemplate() field=$elem.__weight}</td>
                </tr>
                                                            
                <tr>
                    <td class="key">{$elem.__pricedata_arr->getTitle()}&nbsp;&nbsp;{if $elem.__pricedata_arr->getHint() != ''}<a class="help-icon" title="{$elem.__pricedata_arr->getHint()|escape}">?</a>{/if}</td>
                    <td>{include file=$elem.__pricedata_arr->getRenderTemplate() field=$elem.__pricedata_arr}</td>
                </tr>
                                                            
                <tr>
                    <td class="key">{$elem.___propsdata->getTitle()}&nbsp;&nbsp;{if $elem.___propsdata->getHint() != ''}<a class="help-icon" title="{$elem.___propsdata->getHint()|escape}">?</a>{/if}</td>
                    <td>{include file=$elem.___propsdata->getRenderTemplate() field=$elem.___propsdata}</td>
                </tr>
                                                            
                <tr>
                    <td class="key">{$elem.__stock_num->getTitle()}&nbsp;&nbsp;{if $elem.__stock_num->getHint() != ''}<a class="help-icon" title="{$elem.__stock_num->getHint()|escape}">?</a>{/if}</td>
                    <td>{include file=$elem.__stock_num->getRenderTemplate() field=$elem.__stock_num}</td>
                </tr>
                                                            
                <tr>
                    <td class="key">{$elem.__photos_arr->getTitle()}&nbsp;&nbsp;{if $elem.__photos_arr->getHint() != ''}<a class="help-icon" title="{$elem.__photos_arr->getHint()|escape}">?</a>{/if}</td>
                    <td>{include file=$elem.__photos_arr->getRenderTemplate() field=$elem.__photos_arr}</td>
                </tr>
                                                            
                <tr>
                    <td class="key">{$elem.__sku->getTitle()}&nbsp;&nbsp;{if $elem.__sku->getHint() != ''}<a class="help-icon" title="{$elem.__sku->getHint()|escape}">?</a>{/if}</td>
                    <td>{include file=$elem.__sku->getRenderTemplate() field=$elem.__sku}</td>
                </tr>
                                                                                
                <tr>
                    <td class="key">{$elem.__market_sku->getTitle()}&nbsp;&nbsp;{if $elem.__market_sku->getHint() != ''}<a class="help-icon" title="{$elem.__market_sku->getHint()|escape}">?</a>{/if}</td>
                    <td>{include file=$elem.__market_sku->getRenderTemplate() field=$elem.__market_sku}</td>
                </tr>
                                                <tr>
                <td class="key"></td>
                <td><a class="btn btn-success virtual-submit">Сохранить</a>
                <a class="btn btn-default cancel">Отмена</a>
                </td>
            </tr>
    </table>
</div>