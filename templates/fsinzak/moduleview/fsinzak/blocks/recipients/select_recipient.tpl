{if $is_auth}
    <ul class="nav-br dropdown-list">
        <li>
            Получатель:
            {if count($recipients)}
                {if !$current_recipient}
                    <a class="selected-recipient">Выбрать</a>
                {else}
                    <a class="selected-recipient">{$current_recipient->getFio(false)}</a>
                {/if}
                <ul>
                    {foreach $recipients as $recipient}
                        <li>
                            {if !$cart_empty}
                                <a
                                        data-href="{$router->getUrl('fsinzak-front-recipient',['Act' => 'change', 'referer' => $referer, 'id' => $recipient['id']])}"
                                        class="rs-in-dialog"
                                        data-id="{$recipient['id']}"
                                        data-referer="{$referer}"
                                >
                                    <span>{$recipient->getFio(false)}</span>
                                </a>
                            {else}
                                <a
                                        data-url="{$router->getUrl('fsinzak-front-recipient',['Act' => 'setRecipient'])}"
                                        class="recipient-item"
                                        data-id="{$recipient['id']}"
                                        data-referer="{$referer}"
                                >
                                    <span>{$recipient->getFio(false)}</span>
                                </a>
                            {/if}
                            {*                        <i class="mdi mdi-information explanation-tooltip-wrapper">*}
                            {*                            <div class="explanation-tooltip">*}
                            {*                                Ограничение:*}
                            {*                                <ul class="browser-default">*}
                            {*                                    <li>Не более 1 уп. на руки</li>*}
                            {*                                    <li>от 18 лет</li>*}
                            {*                                    <li>Не чаще 1р./неделю</li>*}
                            {*                                </ul>*}
                            {*                            </div>*}
                            {*                        </i>*}
                        </li>
                    {/foreach}
                    <li><a class="btn rs-in-dialog" href="{$router->getUrl('fsinzak-front-myrecipients', ['Act' => 'create', 'setCurrent' => true])}">Добавить</a></li>
                </ul>
            {else}
                <a href="{$router->getUrl('fsinzak-front-myrecipients', ['Act' => 'create', 'setCurrent' => true])}" class="rs-in-dialog">Добавить</a>
            {/if}
        </li>
    </ul>
{else}
    <ul class="nav-br dropdown-list">
        <li>Получатель: <a class="btn btn-flat rs-in-dialog" href="{$router->getUrl('fsinzak-front-recipient')}">Выбрать</a></li>
    </ul>
{/if}
