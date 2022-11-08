{$current_recipient = \Fsinzak\Model\RecipientsApi::getRecipientFromCookie('fsinzak-selected-recipient')}
{$fsinzak_config = \RS\Config\Loader::ByModule('fsinzak')}
{if $current_recipient}
    {$age = $current_recipient->getAge()}
    {$count_order = $current_recipient->getRecipientCountOrderForPeriod()}
    {$can_order_do = $fsinzak_config->canOrderDo()}
{/if}
<header>
    <div class="container">
        <div class="nav-top">
            <div class="nav-left">
                <a href="#mobile" class="sidenav-trigger hide-l-up burger">
                    <i class="mdi mdi-menu"></i>
                </a>
                <a href="/" class="logo"></a>
                <div class="nav-wrapper hide-l-down">
                    <a class="super-btn">
                        <i class="mdi mdi-menu"></i>
                        <span>Каталог</span>
                    </a>
                    <nav>
                        {moduleinsert name="\Catalog\Controller\Block\Category" indexTemplate="%catalog%/blocks/category/category.tpl"}
                    </nav>
                </div>
                <div class="hide-l-down">
                    {moduleinsert name="\Catalog\Controller\Block\Searchline" indexTemplate="%catalog%/blocks/searchline/searchform.tpl"}
                </div>
                <div class="hide-l-down">
                    {moduleinsert name="\Affiliate\Controller\Block\Selectaffiliate"}
                </div>
            </div>
            <div class="nav-right">
                <a href="tel://+78003334485" class="phone"><i class="mdi mdi-phone"></i><span>8 (800) 333-4485</span></a>
                {moduleinsert name="\Catalog\Controller\Block\Favorite"}
                {moduleinsert name="\Shop\Controller\Block\Cart"}
                <div class="icon-wrapper">
                    {moduleinsert name="\Users\Controller\Block\AuthBlock"}
                </div>
{*                <div class="icon-wrapper"><i class="mdi mdi-heart"></i><span class="label">Избранное</span><span class="indicator">9+</span></div>*}
{*                <div class="icon-wrapper"><i class="mdi mdi-cart"></i><span class="label">Корзина</span><span class="indicator">9+</span></div>*}
{*                <div class="icon-wrapper"><i class="mdi mdi-account"></i><span class="label">Профиль</span><span class="indicator">9+</span></div>*}
            </div>
        </div>
        <div class="nav-bottom hide-l-down">
            <ul class="nav-bl">
                <li><a href="/pravila/">Правила</a></li>
                <li><a href="/dostavka-i-oplata/">Доставка и оплата</a></li>
                <li><a href="/text-news/">Новости</a></li>
                <li><a href="/about/">О нас</a></li>
                <li><a href="/reviews/">Отзывы</a></li>
                <li><a href="/contacts/">Контакты</a></li>
            </ul>
            {moduleinsert name="\Fsinzak\Controller\Block\Selectrecipient"}
        </div>
    </div>
    <div class="hide-l-up top-toolbar">
        <div class="left name-selector-wrapper">
            {moduleinsert name="\Fsinzak\Controller\Block\Selectrecipient" indexTemplate="%fsinzak%/blocks/recipients/select_recipient_mobile.tpl"}
        </div>
        <div class="separator"></div>
        <div class="right">
            {moduleinsert name="\Affiliate\Controller\Block\SelectAffiliate" indexTemplate="%affiliate%/blocks/selectaffiliate/select_affiliate_bottom_toolbar.tpl"}
        </div>
    </div>
</header>
<ul class="sidenav" id="mobile">
    <li class="sidebar-header">
        <span class="logo"></span>
        <span class="region">
            {moduleinsert name="\Affiliate\Controller\Block\SelectAffiliate" indexTemplate="%affiliate%/blocks/selectaffiliate/select_affiliate_sidenav.tpl"}
		</span>
        <span class="sidebar-close">
			<i class="mdi mdi-close"></i>
		</span>
    </li>
    <li class="mobile-sticky">
        {moduleinsert name="\Catalog\Controller\Block\Searchline" indexTemplate="%catalog%/blocks/searchline/searchform_sidenav.tpl"}
    </li>
    <li><a href="/">Главная</a></li>
    <li><a href="/pravila/">Правила</a></li>
    <li>
        <ul class="collapsible" id="catalog">
            <li>
                <div class="collapsible-header">
                    <a href="#catalog"><strong>Каталог</strong></a>
                </div>
                <div class="collapsible-body">
                    {moduleinsert name="\Catalog\Controller\Block\Category" indexTemplate="%catalog%/blocks/category/category_mobile.tpl"}
                </div>
            </li>
        </ul>
    </li>
    <li><a href="/dostavka-i-oplata/">Доставка и оплата</a></li>
    <li><a href="/text-news/">Новости</a></li>
    <li><a href="/about/">О Нас</a></li>
    <li><a href="/reviews/">Отзывы</a></li>
    <li><a href="/contacts/">Контакты</a></li>
</ul>
{*{if $current_recipient && !$can_order_do}*}
{*    <p>Для выбранного получателя превышен лимит заказов за период</p>*}
{*{/if}*}
{block name="content"}
    {$app->blocks->getMainContent()}
{/block}

<footer>
    {moduleinsert name="\Fsinzak\Controller\Block\FooterBlock"}
</footer>

{*<div class="hide-l-up bottom-toolbar">*}
{*    <div class="left name-selector-wrapper">*}
{*        {moduleinsert name="\Fsinzak\Controller\Block\Selectrecipient" indexTemplate="%fsinzak%/blocks/recipients/select_recipient_mobile.tpl"}*}
{*    </div>*}
{*    <div class="separator"></div>*}
{*    <div class="right">*}
{*        {moduleinsert name="\Affiliate\Controller\Block\SelectAffiliate" indexTemplate="%affiliate%/blocks/selectaffiliate/select_affiliate_bottom_toolbar.tpl"}*}
{*    </div>*}
{*</div>*}


<ul class="bottom-toolbar hide-l-up">
    <li><a class="active" href="/"><i class="icon" id="home"></i><span class="title">Главная</span></a></li>
    <li><a class="active sidenav-trigger" href="#mobile"><i class="icon" id="catalog"></i><span class="title">Каталог</span></a></li>
    <li>{moduleinsert name="\Shop\Controller\Block\Cart" indexTemplate="%shop%/blocks/cart/cart_bottomtoolbar.tpl"}</li>
    <li>{moduleinsert name="\Catalog\Controller\Block\Favorite" indexTemplate="%catalog%/blocks/favorite/favorite_bottomtoolbar.tpl"}</li>
    <li id="profile-menu">
        <div class="icon-wrapper">
            {moduleinsert name="\Users\Controller\Block\AuthBlock" indexTemplate="%users%/blocks/authblock/authblock_bottomtoolbar.tpl"}
        </div>
    </li>
</ul>
<div class="datepicker-wrapper"></div>
