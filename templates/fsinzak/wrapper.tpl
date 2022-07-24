<header>
    <div class="container">
        <div class="nav-top">
            <div class="nav-left">
                <a href="#mobile" class="sidenav-trigger hide-l-up burger">
                    <i class="mdi mdi-menu"></i>
                </a>
                <a href="/" class="logo"></a>
                <div class="nav-wrapper hide-l-down">
                    <a href="" class="super-btn">
                        <i class="mdi mdi-menu"></i>
                        <span>Каталог</span>
                    </a>
                    <nav>
                        {moduleinsert name="\Catalog\Controller\Block\Category" indexTemplate="%catalog%/blocks/category/category.tpl"}
                    </nav>
                </div>
                <div class="hide-m-down">
                    {moduleinsert name="\Catalog\Controller\Block\Searchline" indexTemplate="%catalog%/blocks/searchline/searchform.tpl"}
                </div>
                <div class="hide-m-down">
                    {moduleinsert name="\Affiliate\Controller\Block\Selectaffiliate"}
                </div>
            </div>
            <div class="nav-right">
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
        <div class="hide-m-down">
            <div class="nav-bottom">
                <ul class="nav-bl">
                    <li><a href="">Правила</a></li>
                    <li><a href="">Доставка</a></li>
                    <li><a href="">Контакты</a></li>
                </ul>
                {moduleinsert name="\Fsinzak\Controller\Block\Selectrecipient"}
            </div>
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
    <li><a href="">Главная</a></li>
    <li>
        <ul class="collapsible" id="catalog">
            <li>
                <div class="collapsible-header">
                    <a href="#catalog"><strong>Каталог</strong></a>
                </div>
                <div class="collapsible-body">
                    {moduleinsert name="\Catalog\Controller\Block\Category" indexTemplate="%catalog%/blocks/category/category.tpl"}
                </div>
            </li>
        </ul>
    </li>
    <li><a href="">Правила</a></li>
    <li><a href="">Доставка</a></li>
    <li><a href="">Отзывы</a></li>
    <li><a href="">Контакты</a></li>
</ul>
<div class="hide-m-up bottom-toolbar">
    <div class="left name-selector-wrapper">
        {moduleinsert name="\Fsinzak\Controller\Block\Selectrecipient" indexTemplate="%fsinzak%/blocks/recipients/select_recipient_mobile.tpl"}
    </div>
    <div class="separator"></div>
    <div class="right">
        {moduleinsert name="\Affiliate\Controller\Block\SelectAffiliate" indexTemplate="%affiliate%/blocks/selectaffiliate/select_affiliate_bottom_toolbar.tpl"}
    </div>
</div>

{block name="content"}
    {$app->blocks->getMainContent()}
{/block}

<footer>
    <div class="pre-footer">
        <div class="container">
            <div class="row">
                <div class="col l5 m12 s12">
                    <div class="footer-header">Важная информация</div>
                    <ul class="browser-default">
                        <li>Прием заказов 24 часа в сутки</li>
                        <li>Возможность совершения покупок с помощью компьютера, планшета или смартфона с выходом в интернет</li>
                        <li>Большое разнообразие ассортимента товара</li>
                        <li>Только через онлайн-сервис - возможность приобретения Эксклюзивных товаров</li>
                        <li>Гарантированное получение заказа в течение 1-3 рабочих дней, со дня поступления заявки в Учреждение, согласно графика, и обязательным уведомлением покупателя</li>
                        <li>Вы покупаете сертификат, адресат получает сигареты, но в случае отказа имеет право обменять их на продукты питания на эквивалентную сумму</li>
                    </ul>
                </div>
                <div class="col l3 m6 s12">
                    <div class="footer-header">Способы оплаты</div>
                    <p>
                        Оплату товара можно осуществить практически всеми современными способами онлайн и оффлайн платежей.
                    </p>
                    <div class="lazy footer-payment" data-src="/img/footer-payment.svg"></div>
                </div>
                <div class="col l3 offset-l1 m6 s12">
                    <div class="footer-header">Уважаемые клиенты!</div>
                    <p>
                        По всем интересующим вопросам Вы можете обратиться по электронной почте: info@fsinzak.ru или позвонить:
                    </p>
                    <div class="kv-table">
                        <div class="kv-pair">
                            <div class="key">Хабаровск:</div>
                            <div class="value">8 (4212) 78-80-21</div>
                        </div>
                        <div class="kv-pair">
                            <div class="key">Новосибирск:</div>
                            <div class="value">8 (383) 383-25-10</div>
                        </div>
                        <div class="kv-pair hide-s-down">
                            <div class="key">&nbsp;</div>
                            <div class="value">&nbsp;</div>
                        </div>
                        <div class="kv-pair">
                            <div class="key">пн-пт: </div>
                            <div class="value">9:00 – 20:00</div>
                        </div>
                        <div class="kv-pair">
                            <div class="key">сб-вс:</div>
                            <div class="value">9:00 – 17:45</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col xl9 l8 m12 s12 offset-l2 align-center-l-down align-left-l-up footer-left">
                    <a href="" class="footer-logo"></a>
                    <ul>
                        <li><a href="">Главная</a></li>
                        <li><a href="">Правила</a></li>
                        <li><a href="">Доставка</a></li>
                        <li><a href="">Отзывы</a></li>
                        <li><a href="">Контакты</a></li>
                    </ul>
                </div>
                <div class="col xl3 l8 offset-l2 m10 offset-m1 s12 align-center-l-down align-right-l-up">
                    <form action="" id="contact-form">
                        <div class="input-field">
                            <input type="text" placeholder="Ваш e-mail">
                            <label for="">Ваш e-mail</label>
                        </div>
                        <a href="" class="btn">Отправить</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright center-align">© 2022</div>
</footer>
<div class="datepicker-wrapper"></div>
