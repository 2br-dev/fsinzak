{*{extends file="%THEME%/helper/wrapper/my-cabinet.tpl"}*}
{block name="content"}

    <main id="returns" class="profile">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <h1>Управление аккаунтом</h1>
                    </div>
                    <div class="col l2 m12">
                        {include file="%fsinzak%/profile-menu.tpl"}
                    </div>
                    <div class="col l10 m12">
                        <div class="row">
                            <div class="col s12">
                                <h2>
                                    Возвраты
                                </h2>
                                <p class="info">
                                    С помощью данного раздела, вы сможете оформить заявку на возврат товара, а также распечатать бланк заявления на возврат товара.
                                    После оформления заявки с вами свяжется менеджер и расскажет о дальнейших действиях. Пожалуйста, ознакомьтесь
                                    с <a href="/rules.html">правилами возврата товаров</a> перед оформлением заявки.
                                </p>
                            </div>
                        </div>
                        {if $order_list}
                            <form action="{urlmake Act="add"}" method="GET" class="row">
{*                                            <div class="fs-5 mb-2">{t}Ваши заказы{/t}</div>*}
{*                                            <div class="row g-3">*}
                                    <div class="col l4">
                                        <div class="input-field">
                                            <select class="styled" name="order_id">
                                                {foreach $order_list as $order}
                                                    <option value="{$order.order_num}">{$order.order_num} от {$order.dateof|date_format:"d.m.Y"}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col l2">
                                        <button type="submit" class="btn btn-primary col-12 col-sm-auto">{t}Создать возврат{/t}</button>
                                    </div>
                            </form>
                        {else}
                            {include file="%THEME%/helper/usertemplate/include/empty_list.tpl" reason="{t}Нет заказов для создания новых возвратов{/t}"}
                        {/if}
                    </div>
                </div>
                {if $returns_list}
                    {/if}
{*                            <div class="col l2"><a href="/make-returns.html" class="btn">Создать возврат</a></div>*}
{*                        </div>*}
{*                        <div class="row flex requests-story">*}
{*                            <div class="col s12">*}
{*                                <h3>История заявок</h3>*}
{*                            </div>*}
{*                            @@loop('./parts/returns-entry.html', './data/requests.json')*}
{*                        </div>*}
{*                    </div>*}
{*                </div>*}
{*            </div>*}
        </section>
    </main>

{*<div class="col">*}
{*    <h1 class="mb-5">{t}Мои возвраты{/t}</h1>*}
{*    <div class="section pt-0">*}
{*        {if $order_list}*}
{*            <form action="{urlmake Act="add"}" method="GET">*}
{*                <div class="fs-5 mb-2">{t}Ваши заказы{/t}</div>*}
{*                <div class="row g-3">*}
{*                    <div class="col-xl-5 col-sm-7">*}
{*                        <select class="form-select" name="order_id">*}
{*                            {foreach $order_list as $order}*}
{*                                <option value="{$order.order_num}">{$order.order_num} от {$order.dateof|date_format:"d.m.Y"}</option>*}
{*                            {/foreach}*}
{*                        </select>*}
{*                    </div>*}
{*                    <div class="col">*}
{*                        <button type="submit" class="btn btn-primary col-12 col-sm-auto">{t}Создать возврат{/t}</button>*}
{*                    </div>*}
{*                </div>*}
{*            </form>*}
{*        {else}*}
{*            {include file="%THEME%/helper/usertemplate/include/empty_list.tpl" reason="{t}Нет заказов для создания новых возвратов{/t}"}*}
{*        {/if}*}
{*    </div>*}
{*    {if $returns_list}*}
{*        <div class="lk-returns">*}
{*            <div class="lk-returns__title">{t}История заявок{/t}</div>*}
{*            <div class="lk-returns__head">*}
{*                <div class="row row-cols-4 g-3">*}
{*                    <div>{t}Заявка{/t}</div>*}
{*                    <div>{t}Даты{/t}</div>*}
{*                    <div>{t}Сумма возврата{/t}</div>*}
{*                    <div>{t}Заявление{/t}</div>*}
{*                </div>*}
{*            </div>*}
{*            <div class="lk-returns__list-wrapper">*}
{*                <ul class="lk-returns__list fs-5">*}
{*                    {foreach $returns_list as $return}*}
{*                    {$order = $return->getOrder()}*}
{*                        <li>*}
{*                            <div class="row g-3 align-items-center align-items-sm-start">*}
{*                                <div class="col-sm-3 col-12">*}
{*                                    <div class="d-flex justify-content-between flex-sm-column">*}
{*                                        <div class="fw-bold">{if $return.status == 'new'}<a href="{urlmake Act="edit" return_id=$return.return_num}">№{$return.return_num}</a>*}
{*                                            {else}№{$return.return_num}{/if}*}
{*                                        </div>*}
{*                                        <div class="ms-2 ms-sm-0 mt-sm-1">Статус: {$return.__status->textView()}</div>*}
{*                                    </div>*}
{*                                    {if $order.order_num}*}
{*                                        <div class="mt-1">{t}Заказ №{/t}: {$order.order_num}</div>*}
{*                                    {/if}*}
{*                                </div>*}
{*                                <div class="col-sm-3 col-12 d-flex justify-content-between flex-sm-column">*}
{*                                    {if $return.date_exec}*}
{*                                        <div class="mt-3 mb-sm-2">{t}Исполнение заявки{/t}:</div>*}
{*                                        <div class="ms-2 ms-sm-0">{$return.date_exec|date_format:"d.m.Y"}</div>*}
{*                                    {else}*}
{*                                        <div class="mb-sm-2">Оформление заявки:</div>*}
{*                                        <div class="ms-2 ms-sm-0">{$return.dateof|date_format:"d.m.Y"}</div>*}
{*                                    {/if}*}
{*                                </div>*}
{*                                <div class="col col-sm-3">{$return.cost_total|format_price} {$return.currency_stitle}</div>*}
{*                                <div class="col-auto col-sm-3"><a class="fs-4" href="{urlmake Act="print" return_id=$return.return_num}" target="_blank">{t}Распечатать{/t}</a></div>*}
{*                            </div>*}
{*                        </li>*}
{*                    {/foreach}*}
{*                </ul>*}
{*            </div>*}
{*        </div>*}
{*    {/if}*}
{*</div>*}
{/block}
