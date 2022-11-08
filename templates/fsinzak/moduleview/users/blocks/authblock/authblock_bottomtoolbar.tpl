{if $is_auth}
    {modulegetvars name="\Support\Controller\Block\NewMessages" var="data"}
{*    <ul class="dropdown-list block-user {if $data.new_count}active{/if}" id="logged">*}
        <a class="active" href="javascript:void(0);">
            <span>
                <i class="icon" id="profile">
                   {if $data['new_count'] != 0}
                       <span class="indicator profile-message-count">{$data.new_count}</span>
                   {/if}
                </i>
                <span class="label">Профиль</span>
            </span>
        </a>
        <ul class="z-depth-1 active">
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
{*                {if $data['new_count'] != 0}*}
                    <span class="indicator indicator-ul-bottomtoolbar">{$data.new_count}</span>
{*                {/if}*}
            </li>
            <li><div class="divider"></div></li>
            <li><a href="{$router->getUrl('users-front-auth', ['Act' => 'logout'])}">Выход</a></li>
        </ul>
{*        </a>*}
{*    </ul>*}
{else}
    {$referer = urlencode($url->server('REQUEST_URI'))}
{*    <ul class="dropdown-list" id="guest">*}
        <a class="active" data-bs-reference="parent">
            <span>
                <i class="icon" id="profile">
                </i>
                <span class="label">Вход</span>
            </span>
        </a>
{*            <a data-bs-reference="parent"><i class="mdi mdi-login"></i><span class="label">Вход</span></a>*}
        <ul>
{*            <li><a class="rs-in-dialog" href="{$authorization_url}">Авторизация</a></li>*}
            <li><a class="rs-in-dialog" href="{$router->getUrl('users-front-auth', ['referer' => $referer])}">Авторизация</a></li>
            <li><a class="rs-in-dialog" href="{$router->getUrl('users-front-register', ['referer' => $referer])}">Регистрация</a></li>
        </ul>
{*        </a>*}
{*    </ul>*}
{/if}
