{if $smarty.cookies.confirm_affiliate == 1}
    <button
        type="button" class="btn btn-primary primary-svg rs-to-cart rs-no-modal-cart"
        data-href="{$router->getUrl('fsinzak-front-cartpage', ["add" => $product.id, 'amount' => 1])}"
    >
        <i class="mdi mdi-cart-arrow-down"></i>
        <span class="ms-2">{t}В корзину{/t}</span>
    </button>
{else}
    <button
        type="button" class="btn btn-primary primary-svg rs-in-dialog"
        data-href="{$router->getUrl('fsinzak-front-firstproductincart', ["add" => $product.id, "referer" => $smarty.server.REQUEST_URI])}">
        <i class="mdi mdi-cart-arrow-down"></i>
        <span class="ms-2">{t}В корзину{/t}</span>
    </button>
{/if}
