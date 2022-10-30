{$shop_config=ConfigLoader::byModule('shop')}
<ul class="profile-sections hide-s-down">
    <li><a href="/my/">Личные данные</a></li>
    <li><a href="/my/orders/">Мои заказы</a></li>
    {if $shop_config.return_enable}
        <li><a href="/my/productsreturn/">Возвраты</a></li>
    {/if}
    <li><a href="/my/recipients/">Получатели</a></li>
    <li><a href="/my/support/">Поддержка</a></li>
</ul>
<div class="col s12 hide-s-up center-align">
    <a href="#profile-menu-mobile" class="sidenav-trigger btn outlined profile-menu-button">Меню</a>
</div>
<ul class="sidenav" id="profile-menu-mobile">
    <li><a href="/my/">Личные данные</a></li>
    <li><a href="/my/orders/">Мои заказы</a></li>
    {if $shop_config.return_enable}
        <li><a href="/my/productsreturn/">Возвраты</a></li>
    {/if}
    <li><a class="active" href="/my/recipients/">Получатели</a></li>
    <li><a href="/my/support/">Поддержка</a></li>
</ul>
