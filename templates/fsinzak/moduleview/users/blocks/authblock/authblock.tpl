{if $is_auth}
    {modulegetvars name="\Support\Controller\Block\NewMessages" var="data"}
    <ul class="dropdown-list block-user {if $data.new_count}active{/if}" id="logged">
        <li>
            <span>
                <i class="mdi mdi-account"></i>
                <span class="label">Профиль</span>
                <span class="indicator profile-message-count">{$data.new_count}</span>
            </span>
            <ul>
                <li><a href="{$router->getUrl('users-front-profile')}">Профиль</a></li>
                <li><a href="{$router->getUrl('shop-front-myorders')}">Заказы</a></li>
                {if $return_enable}
                    <li><a href="{$router->getUrl('shop-front-myproductsreturn')}">Возвраты</a></li>
                {/if}
                <li><a href="/my/recipients/">Получатели</a></li>
                <li class="nav-link-support">
                    <a href="{$router->getUrl('support-front-support')}" class="aside-menu__link">
                        {t}Поддержка{/t}
                    </a>
                    <span class="indicator">{$data.new_count}</span>
                </li>
                <li><a href="{$router->getUrl('users-front-auth', ['Act' => 'logout'])}">Выход</a></li>
            </ul>
        </li>
    </ul>
{else}
    {$referer = urlencode($url->server('REQUEST_URI'))}
    <ul class="dropdown-list" id="guest">
        <li>
            <a data-bs-reference="parent"><i class="mdi mdi-login"></i><span class="label">Вход</span></a>
            <ul>
{*                <li><a class="rs-in-dialog" href="{$authorization_url}">Авторизация</a></li>*}
                <li><a class="rs-in-dialog" href="{$router->getUrl('users-front-auth', ['referer' => $referer])}">Авторизация</a></li>
                <li><a class="rs-in-dialog" href="{$router->getUrl('users-front-register', ['referer' => $referer])}">Регистрация</a></li>
            </ul>
        </li>
    </ul>
{/if}
