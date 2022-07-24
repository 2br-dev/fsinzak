{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}

{block "class"}modal-lg{/block}
{block "title"}
    {t}Смена Получателя{/t}
{/block}
{block "body"}
    <div class="">
        При смене получателя корзина будет сброшена
    </div>
{/block}
{block "footer"}
    <div class="modal-footer">
        <a data-id="{$id}"
           data-referer="{$referer}"
           data-url="{$router->getUrl('fsinzak-front-recipient',['Act' => 'setRecipient'])}"
           class="btn recipient-item"
        >Принять</a>
    </div>
{/block}
