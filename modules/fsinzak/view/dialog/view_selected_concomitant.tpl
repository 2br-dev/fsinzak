{addcss file="%catalog%/selectproduct.css" basepath="root"}
{addcss file="%fsinzak%/selectproduct.css" basepath="root"}
{addjs file="%catalog%/selectproduct.js" basepath="root"}

<div class="concomitant-product-group-container{if $hide_group_checkbox} hide-group-cb{/if}{if $hide_product_checkbox} hide-product-cb{/if}" data-urls='{ "getChild": "{adminUrl mod_controller="catalog-dialog" do="getChildCategory"}", "getProducts": "{adminUrl mod_controller="catalog-dialog" do="getProducts"}", "getDialog": "{adminUrl mod_controller="catalog-dialog" do=false}" }'>
    <a class="btn btn-success select-button"><i class="zmdi zmdi-plus"></i> <span>{t}Выбрать товары{/t}</span></a><br>
        <div class="selected-container">
            <ul class="group-block">
                {foreach from=$productArr.group item=item}
                    <li class="group" val="{$item}"><a class="remove" title="{t}удалить из списка{/t}">&#215;</a><span class="group_icon" title="{t}категория товаров{/t}"></span>
                        {$extdata.group.$item.obj.name}
                    </li>
                {/foreach}
            </ul>
            <ul class="product-block">
                {foreach from=$productArr.product item=item}
                    <li class="product" val="{$item}">
                        <a class="remove" title="{t}удалить из списка{/t}">&#215;</a>
                        <span class="product_image cell-image" data-preview-url="{$extdata.product.$item.obj->getMainImage()->getUrl(200, 200)}">
                            <img src="{$extdata.product.$item.obj->getMainImage()->getUrl(30, 30)}" alt=""/>
                        </span>
                        <span class="value">{$extdata.product.$item.obj.title}</span>
                        <span class="decorate-x">
                            Х
                        </span>
                        <span>
                            <input type="number" name="{$fieldName}[limit_amount][{$item}]" value="{$productArr.limit_amount.$item}">
                        </span>
                    </li>
                {/foreach}
            </ul>
        </div>

        <div class="input-container" data-field-name="{$fieldName}">
            <div class="products">
                {foreach from=$productArr.product item=item}
                    <input type="hidden" data-catids="{$extdata.product.$item.dirs}" value="{$item}" name="{$fieldName}[product][]">
                {/foreach}
            </div>
        </div>
</div>        

<script>
    $.allReady(function() {
        $('.concomitant-product-group-container').selectProduct({
            dialog: 'concomitantDialog',
            itemHtml: function(){
                return $('<li class="product">'+
                        '<a class="remove">&#215</a>'+
                        '<span class="product_image cell-image" data-preview-url=""><img src="" alt=""/></span>'+
                        '<span class="value"></span>'+
                        '<span class="decorate-x"> X </span>'+
                        '<span>\n' +
                    '                            <input type="number" name="{$fieldName}[limit_amount][{$item}]" value="">\n' +
                    '                        </span>' +
                    '</li>');
            }
        });
    });
</script>
