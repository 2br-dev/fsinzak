<span class="white-text">
    <span class="icon">
        <i class="mdi mdi-clipboard-account"></i>
    </span>
    <span class="text">
        <span class="name-top">
            <span class="last-name">Получатель: </span>
        </span>
        {if $is_auth}
            {if count($recipients)}
                {if !$current_recipient}
                    <span class="name-bottom explanation-tooltip-wrapper">
                        <span class="first-name">Выбрать</span>
                    </span>
                {else}
                    <span class="name-bottom explanation-tooltip-wrapper">
                        <span class="first-name"><strong>{$current_recipient->getFio(false)}</strong></span>
                    </span>
                {/if}
            {else}
                <span class="name-bottom explanation-tooltip-wrapper">
                    <a href="{$router->getUrl('fsinzak-front-myrecipients', ['Act' => 'create', 'setCurrent' => true])}" class="rs-in-dialog">
                        <span class="first-name">Добавить</span>
                    </a>
                </span>
            {/if}
        {else}
            <span class="name-bottom explanation-tooltip-wrapper">
                <a class="btn btn-flat rs-in-dialog" href="{$router->getUrl('fsinzak-front-recipient')}">
                    <span class="first-name">Выбрать</span>
                </a>
            </span>
        {/if}
    </span>
</span>
{if $is_auth}
    {if count($recipients)}
        <div class="name-selector">
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
                    </li>
                {/foreach}
                <li><a class="btn rs-in-dialog" href="{$router->getUrl('fsinzak-front-myrecipients', ['Act' => 'create'])}">Добавить</a></li>
            </ul>
        </div>
    {/if}
{/if}
