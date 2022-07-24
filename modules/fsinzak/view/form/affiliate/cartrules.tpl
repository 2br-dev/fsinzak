{addjs file="%fsinzak%/affliate/cartrules_admin.js"}
{addjs file="%catalog%/selectproduct.js"}

{addcss file="%fsinzak%/affliate/cartrules_admin.css"}
{addcss file="%catalog%/selectproduct.css"}

<div class="cartrulesWrapper">
    <table id="cartrulesWrapper" class="otable">
        <thead>
            <tr>
                <th>
                    {t}Условия{/t}
                </th>
                <th>
                    {t}Товары{/t}
                </th>
                <th style="width: 16px">
                    #
                </th>
            </tr>
        </thead>
        <tbody id="cartrulesRows">
            {if empty($elem.cartrules_arr)}
                <tr id="cartrules-empty">
                    <td colspan="3" class="cartrules-empty">
                        Нет правил
                    </td>
                </tr>
            {else}
                {$m=0}
                {foreach $elem.cartrules_arr as $k=>$cartrule}
                    {$m++|devnull}
                    <tr class="{if ($m%2)==0}hr{/if}">
                        <td>
                            <div class="cartrules-rights">
                                {foreach $cartrule.condition as $j=>$condition}
                                    <div class="cartrules-condition">
                                        Если&nbsp;
                                        <select name="cartrules_arr[{$k}][condition][{$j}]">
                                            <option {if $condition=='weight'}selected{/if} value="weight">{t}Вес гр.{/t}</option>
                                            <option {if $condition=='total'}selected{/if} value="total">{t}Сумма{/t}</option>
                                        </select>
                                        <input type="number" name="cartrules_arr[{$k}][equal_from][{$j}]" min="0" value="{$cartrule.equal_from[$j]}" size="6" placeholder="от/больше"/>&nbsp;{t}и{/t}&nbsp;
                                        <input type="number" name="cartrules_arr[{$k}][equal_to][{$j}]" min="0" value="{$cartrule.equal_to[$j]}" size="6" placeholder="до"/>
                                        <a class="remove cartrules-remove-condition" title="{t}удалить из списка{/t}">&#215;</a>
                                    </div>
                                {/foreach}
                            </div>
                            <button type="button" class="btn btn-default cartrules-add-rule">{t}Добавить условие{/t}</button>
                        </td>
                        <td class="cartrules-products-wrapper"
                            data-urls='{ "getChild": "{adminUrl mod_controller="catalog-dialog" do="getChildCategory"}", "getProducts": "{adminUrl mod_controller="catalog-dialog" do="getProducts"}", "getDialog": "{adminUrl mod_controller="catalog-dialog" do=false}" }'>
                            <div class="cartrules-result-products" data-field-name="cartrules_arr[]">
                                <ol class="product-block">
                                    {if !empty($cartrule.product)}
                                        {foreach $cartrule.product as $val}
                                            {$product=\Catalog\Model\Orm\Product::loadByWhere([
                                                'id' => $val
                                            ])}
                                            <li class="product" val="{$val}">
                                                <a class="remove" title="" data-original-title="удалить из списка">×</a>
                                                <span class="product_icon" title="" data-original-title="товар"></span>
                                                <span class="product_image cell-image" data-preview-url="">
                                                    <img src="{$product->getMainImage()->getUrl(30, 30)}" alt=""/>
                                                </span>
                                                <span class="barcode">{$product.barcode}</span>
                                                <span class="value">{$product.title}</span>
                                                <input type="number" value="{$cartrule.product_amount[$val]}" class="cartrule-amount" title="" name="cartrules_arr[{$k}][product_amount][{$val}]" data-original-title="Количество для добавления">
                                            </li>
                                        {/foreach}
                                    {/if}
                                </ol>
                                <div class="products">
                                    {if !empty($cartrule.product)}
                                        {foreach $cartrule.product as $val}
                                            <input type="hidden" name="cartrules_arr[{$k}][product][]" data-weight="0" data-catids="undefined" value="{$val}">
                                        {/foreach}
                                    {/if}
                                </div>
                            </div>
                            <button type="button" class="btn btn-default cartrules-add-product">{t}Добавить товар{/t}</button>
                        </td>
                        <td>
                            <a class="remove remove-cart-rule" title="{t}удалить правило{/t}">&#215;</a>
                        </td>
                    </tr>
                {/foreach}
            {/if}
        </tbody>
    </table>
    <button type="button" class="btn btn-success cartrules-add">{t}Добавить правило{/t}</button>
</div>

<table style="display: none">
    <tbody id="cartrulesRowTemplate">
        <tr>
            <td>
                <div class="cartrules-rights">

                </div>
                <button type="button" class="btn btn-default cartrules-add-rule">{t}Добавить условие{/t}</button>
            </td>
            <td class="cartrules-products-wrapper"
                data-urls='{ "getChild": "{adminUrl mod_controller="catalog-dialog" do="getChildCategory"}", "getProducts": "{adminUrl mod_controller="catalog-dialog" do="getProducts"}", "getDialog": "{adminUrl mod_controller="catalog-dialog" do=false}" }'>
                <div class="cartrules-result-products" data-field-name="cartrules_arr[]">
                    <ol class="product-block"></ol>
                    <div class="products"></div>
                </div>
                <button type="button" class="btn btn-default cartrules-add-product">{t}Добавить товар{/t}</button>
            </td>
            <td>
                <a class="remove remove-cart-rule" title="{t}удалить правило{/t}">&#215;</a>
            </td>
        </tr>
    </tbody>
</table>

<div id="cartrulesRuleTemplate" style="display: none">
    <div class="cartrules-condition">
        Если&nbsp;
        <select class="cartrules-select-condition" name="cartrules_arr[][condition][]" disabled>
            <option value="weight">{t}Вес гр.{/t}</option>
            <option value="total">{t}Сумма{/t}</option>
        </select>
        <input type="number" class="cartrules-input-condition" name="cartrules_arr[][equal_from][]" min="0" value="" size="6" placeholder="от/больше" disabled/>&nbsp;{t}и{/t}&nbsp;
        <input type="number" class="cartrules-input-condition" name="cartrules_arr[][equal_to][]" min="0" value="" size="6" placeholder="до" disabled/>
        <a class="remove cartrules-remove-condition" title="{t}удалить из списка{/t}">&#215;</a>
    </div>
</div>