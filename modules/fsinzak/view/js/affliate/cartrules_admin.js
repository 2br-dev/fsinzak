var cartRulesCurrentRow = 0;

class AffiliateCartRules{
    /**
     * Заменяет сортировку в полях name
     * @param $this - текущий элемент
     * @param m - номер строки
     */
    replaceCartRulesSortnName($this, m)
    {
        let name = $this.attr('name');
        const matches =  name.toString().match(/(cartrules_arr\[\d*\])/);
        const nameReplace = matches[1];
        name = name.replace(nameReplace, 'cartrules_arr[' + m + ']');
        $this.attr('name', name);
    }


    /**
     * Обновляет сортировные индексы в аттрибутах name
     */
    updateCartRulesSortn()
    {
        const rows = $("#cartrulesRows");
        let m = 0;
        $('tr', rows).each(function(){
            $(this).data('sortn', m);
            $(this).attr('data-sortn', m);
            $('select', $(this)).each(function() {
                affiliateCartRules.replaceCartRulesSortnName($(this), m);
            });
            $('input', $(this)).each(function() {
                affiliateCartRules.replaceCartRulesSortnName($(this), m);
            });
            m++;
        });
    }

    /**
     * Удаляет правило для корзины
     */
    removeCartRule()
    {
        const wrapper = $(this).closest('tr');
        wrapper.remove();
        this.updateCartRulesSortn();
    }

    /**
     * Инициализирует выбор товара
     */
    initSelectProduct()
    {
        const rows = $("#cartrulesRows");
        $('.cartrules-products-wrapper', rows).selectProduct({
            dialog: 'cartRulesDialog',
            startButton: '.cartrules-add-product',
            inputContainer: '.cartrules-result-products',
            selectedContainer: '.cartrules-result-products .product-block',
            onCheckProduct: function(val, li_product, dialog){
                li_product.find('.cartrule-amount')
                    .attr('title', lang.t('Количество для добавления'))
                    .attr('name', 'cartrules_arr[][product_amount]['+val+']');
            },
            onResult: function(){
                affiliateCartRules.updateCartRulesSortn();
            },
            itemHtml: function(){
                return $(`<li class="product">
                <a class="remove">&#215</a>
                <span class="product_icon"></span>
                <span class="product_image cell-image" data-preview-url=""><img src="" alt=""/></span>
                <span class="barcode"></span>
                <span class="value"></span>
                <input type="number" value="1" class="cartrule-amount" title="Количество для добавления" name="%field_name%[amount]">
            </li>`);
            }
        });
    }

    /**
     * Добавляет правило для корзины
     */
    addCartRule()
    {
        if ($("#cartrules-empty").length){
            $("#cartrules-empty").remove();
        }
        const cartrulesRowTemplateHtml = $("#cartrulesRowTemplate").html();
        $("#cartrulesRows").append(cartrulesRowTemplateHtml);
        this.initSelectProduct();
        this.updateCartRulesSortn();
    }

    /**
     * Удаляет условие правил для корзины
     */
    removeCartRuleCondition()
    {
        const wrapper = $(this).closest('.cartrules-condition');
        wrapper.remove();
    }

    /**
     * Добавляет условие для правил для корзины
     */
    addCartRuleCondition()
    {
        const cartrulesRuleTemplateHtml = $("#cartrulesRuleTemplate").html();
        const wrapperTr = $(this).closest('tr');
        const sortn = wrapperTr.data('sortn');
        const wrapper = $(this).closest('td');
        $(".cartrules-rights", wrapper).append(cartrulesRuleTemplateHtml);
        $('select', wrapper).each(function() {
            affiliateCartRules.replaceCartRulesSortnName($(this), sortn);
            $(this).prop('disabled', false);
        });
        $('input', wrapper).each(function() {
            affiliateCartRules.replaceCartRulesSortnName($(this), sortn);
            $(this).prop('disabled', false);
        });
    }


    /**
     * Добавляет товары
     */
    addCartRuleProducts()
    {
        const wrapper = $(this).closest('tr');
        cartRulesCurrentRow = wrapper.data('sortn');
    }
}

var affiliateCartRules = new AffiliateCartRules();

$.allReady(function(){
    $('body').on('click', '.cartrules-add', function(){
        affiliateCartRules.addCartRule();
    }).on('click', '.remove-cart-rule', affiliateCartRules.removeCartRule)
    .on('click', '.cartrules-add-rule', affiliateCartRules.addCartRuleCondition)
    .on('click', '.cartrules-remove-condition', affiliateCartRules.removeCartRuleCondition)
    .on('click', '.cartrules-add-product', affiliateCartRules.addCartRuleProducts);

    affiliateCartRules.initSelectProduct();
});