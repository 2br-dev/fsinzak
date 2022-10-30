{* Шаблон реализует логику отображения кнопки в корзину для одного товара *}
{$current_recipient = \Fsinzak\Model\RecipientsApi::getRecipientFromCookie('fsinzak-selected-recipient')}
{$fsinzak_config = \RS\Config\Loader::ByModule('fsinzak')}
{if $current_recipient}
    {$age = $current_recipient->getAge()}
    {$count_order = $current_recipient->getRecipientCountOrderForPeriod()}
    {$can_order_do = $fsinzak_config->canOrderDo()}
{/if}


{$periodicity_limit = $fsinzak_config->getLimitByType('periodicity')}
<!-- Если превышени лимит для заказа то показываетм не активную кнопку-->
{if $current_recipient}
    {if !$can_order_do}
        <div class="pcf-left">
            <div class="item-product-cart-action__to-cart">
{*                <a class="btn disabled">Ограничение по количеству</a>*}
            </div>
        </div>
    {else}
        {if $age >= 18}
            {include file="%catalog%/add_to_cart_button.tpl"}
        {else}
            {if $product->getLimit18(false)}
                <div class="pcf-left">
                    <div class="item-product-cart-action__to-cart only18">
                        <i class="disable-icon age"></i>
    {*                    <img src="{$THEME_IMG}/18only.png" title="ограничени 18+" alt="ограничение 18+">*}
                    </div>
                </div>
            {else}
                {include file="%catalog%/add_to_cart_button.tpl"}
            {/if}
        {/if}
    {/if}
{else}
    <div class="pcf-left card-basket-wrapper">
        <a href="" class="btn disabled basket-add">
            Выбирите получателя
        </a>
    </div>
{/if}
