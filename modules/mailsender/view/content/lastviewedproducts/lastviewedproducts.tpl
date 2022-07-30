<style type="text/css">
.products-table {
    width:100%;
}
.products-table td {
    padding:4px;
}
</style>
<table class="products-table">
    {foreach $products as $product}
        <tr>
            <td>
                <a href="{$product->getUrl(true)}"><img src="{$product->getMainImage(60, 60, 'axy')}"></a>
            </td>
            <td>
                {$product.title}
            </td>
            <td style="white-space:nowrap">
                {$product->getCost()} {$product->getCurrency()}
            </td>
            <td>
                <a href="{$product->getUrl(true)}">{t}купить{/t}</a>
            </td>
        </tr>
    {/foreach}
</table>