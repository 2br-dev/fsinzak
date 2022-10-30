{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}
{block "class"}modal-lg{/block}
{block "title"}
    {t}Получатели{/t}
{/block}
{block "body"}
    <div class="list-recipients">
        <ul>
            {foreach $recipients as $recipient}
                <li>
                    <a
                            data-url="{$router->getUrl('fsinzak-front-recipient',['Act' => 'setRecipient'])}"
                            class="recipient-item"
                            data-id="{$recipient['id']}"
                            data-referer="{$referer}"
                    >
                        <span>{$recipient->getFio(false)}</span>
                    </a>
                </li>
            {/foreach}
            <li><a class="btn rs-in-dialog" href="{$router->getUrl('fsinzak-front-myrecipients', ['Act' => 'create', 'setCurrent' => true])}">Добавить</a></li>
        </ul>
    </div>
{/block}
{block "footer"}
    При смене Получателя корзина будет сброшена
{/block}
