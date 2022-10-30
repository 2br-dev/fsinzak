{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}
{$offers_data = $product->getOffersJson(['noVirtual' => true], true)}
{$has_any_offers = ($offers_data.offers && count($offers_data.offers) > 1) || ($offers_data.levels && !$offers_data.virtual)}
{block "class"}modal-lg{/block}
{block "title"}
    {t}Уточнение данных для заказа{/t}
{/block}
{block "body"}
    <div class="confirm-text-block">
        <p class="confirm-text">Для избежания ошибок, проверьте, пожалуйста, правильность выбранного учреждения и получателя</p>
        <div class="check-data-item">
            <p><strong>Учреждение:</strong> {$affiliate->getParentAffiliate()->title}, {$affiliate['title']}</p>
            <a href="{$router->getUrl('affiliate-front-affiliates', ['referer' => $referer])}" class="rs-in-dialog">изменить</a>
        </div>
        <div class="check-data-item">
            <p><strong>Получатель:</strong> {$recipient->getFio(false)}</p>
            <a
                data-href="{$router->getUrl('fsinzak-front-recipient', ['Act' => 'getListRecipientsModal', 'referer' => $referer])}"
                class="rs-in-dialog"
            >изменить</a>
        </div>
    </div>
{/block}
{block "footer"}
    <div class="modal-footer rs-product-item" data-id="{$product.id}">
        <span class="all-right">Все верно.</span>
        {if $has_any_offers || !$THEME_SETTINGS.button_as_amount}
            <button type="button" class="btn btn-primary primary-svg rs-buy rs-to-cart rs-no-modal-cart confirm-affiliate" data-add-text=""
                    data-href="{$router->getUrl('fsinzak-front-cartpage', ["add" => $product.id, 'amount' => 1])}"
{*                    {if !$disable_multioffer_dialog && $has_any_offers}data-select-multioffer-href="{$router->getUrl('shop-front-multioffers', ["product_id" => $product.id])}"{/if}>*}
                <span class="ms-2">{t}В корзину{/t}</span>
            </button>
            <input type="hidden" name="offer" value="{$offer_id}">
        {else}
            <button
                type="button" class="btn btn-primary primary-svg rs-to-cart rs-no-modal-cart confirm-affiliate"
                data-href="{$router->getUrl('fsinzak-front-cartpage', ["add" => $product['id'], 'amount' => 1])}"
            >
                <span class="ms-2">{t}В корзину{/t}</span>
            </button>
        {/if}
    </div>
{/block}
