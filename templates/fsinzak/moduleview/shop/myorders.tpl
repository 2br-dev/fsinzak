{* Личный кабинет - список моих заказов *}
{*{extends file="%THEME%/helper/wrapper/my-cabinet.tpl"}*}
{block name="content"}
    {$paginator = $paginator_with_archive}
    <main id="orders" class="profile">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        {moduleinsert name="\Main\Controller\Block\Breadcrumbs" indexTemplate="%main%/blocks/breadcrumbs/breadcrumbs-catalog.tpl"}
                    </div>
                    <div class="col s12">
                        <h1>Личный кабинет</h1>
                    </div>
                    <div class="col l2 m12">
                        {include file="%fsinzak%/profile-menu.tpl"}
                    </div>
                    <div class="col l10 m12">
                        <h2>
                            Мои заказы
                        </h2>
                        <p class="info">
                            Здесь вы можете просмотреть данные по оформленным Вами заказам.
                        </p>
                        {if count($order_list_with_archive)}
                            <table class="orders">
                                <thead>
                                <tr class="main-row-header">
                                    <th>&nbsp;</th>
                                    <th>№</th>
                                    <th>Дата</th>
                                    <th>Получатель</th>
                                    <th>Колония</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                {foreach $order_list_with_archive as $order}
                                    {if !($order instanceof Shop\Model\Orm\ArchiveOrder)}
                                        {$cart = $order->getCart()}
                                        {$products = $cart->getProductItems()}
                                        {$order_data = $cart->getOrderData()}
                                    {/if}
                                    <tr class="main-row">
                                        <td class="expander"><i class="hide-m-down mdi mdi-plus"></i><span class="hide-m-up">Детали ▼</span></td>
                                        <td data-before="№">{$order['order_num']}</td>
                                        <td data-before="Дата">{$order.dateof|dateformat:"@date"}</td>
                                        <td data-before="Получатель">{$order->getRecipient()->getFio(false)}</td>
                                        <td data-before="Колония">{$order->getColonyTitle()}</td>
                                        <td data-before="Статус">
                                            {$status = $order->getStatus()}
                                            {$status['title']}
                                        </td>
                                        <td data-before="Сумма">
                                            {if $order instanceof Shop\Model\Orm\ArchiveOrder}
                                                {$order.totalcost|format_price} {$order.currency_stitle}
                                            {else}
                                                {$order_data.total_cost}
                                            {/if}
                                        </td>
                                        <td>
                                            <div class="order-actions">
                                                <i class="mdi mdi-dots-vertical"></i>
                                                <ul>
                                                    <li>
                                                        <a href="{$router->getUrl('shop-front-cartpage', ['Act'=>'repeatOrder', 'order_num' => $order.order_num])}" rel="nofollow">
                                                            {t}Повторить заказ{/t}
                                                        </a>
                                                    </li>
                                                    {if $order->canOnlinePay()}
                                                        <li>
                                                            <a href="{$order->getOnlinePayUrl()}" class="btn btn-primary col-12 col-sm-auto">
                                                                {if $status.type == 'payment_method_selected' || $status.copy_type == 'payment_method_selected'}
                                                                    {t}выбрать другую карту{/t}
                                                                {else}
                                                                    {t}оплатить{/t}
                                                                {/if}
                                                            </a>
                                                        </li>
                                                    {/if}
                                                    {if !($order instanceof Shop\Model\Orm\ArchiveOrder)}
                                                        {if $order->getPayment()->hasDocs()}
                                                            {$type_object = $order->getPayment()->getTypeObject()}
                                                            <li><div class="divider"></div></li>
                                                            {foreach $type_object->getDocsName() as $key=>$doc}
                                                                <div class="order-md-first">
                                                                    <a href="{$type_object->getDocUrl($key)}" target="_blank">{$doc.title}</a>
                                                                </div>
                                                            {/foreach}
                                                        {/if}
                                                    {/if}
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="details-row">
                                        <td colspan="7">
                                            <div class="details-row-wrapper">
                                                <table class="order-details">
                                                    <thead>
                                                        <tr>
                                                            <th>Наименование</th>
                                                            <th>Количество</th>
                                                            <th>Стоимость</th>
                                                        </tr>
                                                    </thead>
                                                    {foreach $products as $product}
                                                        <tr class="details-row">
                                                            <td data-before="Название" class="name">{$product.cartitem.title}</td>
                                                            <td data-before="Количество" class="count">{$product.cartitem.amount}{$product.product->getUnit()->stitle}</td>
                                                            <td data-before="Цена" class="price">{$product.cartitem.price}</td>
                                                        </tr>
                                                    {/foreach}
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                {/foreach}
                            </table>
{*                            {include file="%THEME%/paginator.tpl"}*}
                        {else}
                            {include file="%THEME%/helper/usertemplate/include/empty_list.tpl" reason="{t}Еще не оформлено ни одного заказа{/t}"}
                        {/if}
                    </div>
                </div>
            </div>
        </section>
    </main>
{/block}
