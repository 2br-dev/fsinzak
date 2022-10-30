{* Диалог выбора города *}
{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}

{block "class"}modal-lg{/block}
{block "title"}
{*    {if $current_affiliate.id}{t affiliate=$current_affiliate.title}%affiliate. Выбрать другой город.{/t}{else}{t}Выбрать город{/t}{/if}*}
    Выбор учреждения
{/block}
{block "body"}
    {$parent_affiliate = $current_affiliate->getParentAffiliate()}
    {$institutions = $parent_affiliate->getAffiliatesByParentId()}
    {$limits = $current_affiliate->getAffiliateLimits()}
    {$delivery = $current_affiliate->getAffiliateDeliveryInfo()}
    <div class="row">
        <div class="col l6 m12">
            <div class="list-field">
                <input type="hidden" name="city" value="{$parent_affiliate.title}"><label for="">{$parent_affiliate.title}</label>
                <ul>
                    {foreach $affiliates as $item}
                        <li>
                            <a
                                class="region-select"
                                data-id="{$item.fields.id}"
                                data-url="{$router->getUrl('fsinzak-front-location', ['Act' => 'getInstitutionsList'])}"
                                data-referer="{$referer}"
                            >
                                {$item.fields.title}
                            </a>
                        </li>
                    {/foreach}
                </ul>
            </div>
            <div class="list-field">
                <input type="hidden" name="organization"><label id="institution-label" for="">{$current_affiliate.title}</label>
                <ul id="institutions-list">
                    {foreach $institutions as $institution}
                        <li>
                            <a
                                class="institution-select"
                                data-id="{$institution['id']}"
                                data-url="{$router->getUrl('fsinzak-front-location', ['Act' => 'getInstitutionData'])}"
                                data-referer="{$referer}"
                            >
                                {$institution['title']}
                            </a>
                        </li>
                    {/foreach}
                </ul>
            </div>
        </div>
        <div class="col l6 m12">
            <div class="info style-warning">
                <div class="info-block-header">Действующие ограничения:</div>
                <ul class="browser-default" id="limits">
                    {if !empty($limits)}
                        {foreach $limits as $limit}
                            {if $limit['type'] == 'limit_sum'}
                                <li id="limit-sum">Сумма заказа не более <span id="limit-sum-value">{$limit['value']}</span>₽</li>
                            {/if}
                            {if $limit['type'] == 'limit_weight'}
                                <li id="limit-weight">Общий вес заказа не более <span id="limit-weight-value">{$limit['value']}</span>г</li>
                            {/if}
                            {if $limit['type'] == 'periodicity'}
                                <li id="limit-periodicity">не более <span id="limit-weight-value">{$limit['value']}</span> заказов в {$limit['value_month']} мес.</li>
                            {/if}
                        {/foreach}
                    {else}
                        <li>Ограничения отсутствуют</li>
                    {/if}
                </ul>
            </div>
        </div>
    </div>
    <div class="row {if $delivery == ''}hidden{/if}" id="delivery-block">
        <div class="col s12">
            <div class="info style-info">
                <div class="info-block-header">Условия доставки</div>
                <div id="delivery-text">{$delivery}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 right-align">
            <i class="mdi mdi-information warning"></i>
            <span class="small-text">Обращаем Ваше внимание, что в случае смены учреждения корзина будет сброшена</span>
        </div>
    </div>
{*    <div class="modal overflow">*}
{*        <div class="row row-cols-lg-3 row-cols-2 g-3 fs-5">*}
{*            {foreach $affiliates as $item}*}
{*                {if $item.fields.clickable}*}
{*                    <div><a class="{if $item.fields.is_highlight}fw-bold{/if}"*}
{*                            data-is-default="{$item.fields.is_default}"*}
{*                            data-redirect="{$item.fields->getChangeAffiliateUrl($referer)}">{$item.fields.title}</a></div>*}
{*                {else}*}
{*                    <div class="{if $item.fields.is_highlight}fw-bold{/if}">{$item.fields.title}</div>*}
{*                {/if}*}

{*                {if $item.child}*}
{*                    {foreach $item.child as $subitem}*}
{*                        {if $subitem.fields.clickable}*}
{*                            <div class="affiliate-sublevel">… <a class="{if $subitem.fields.is_highlight}fw-bold{/if}"*}
{*                               data-is-default="{$subitem.fields.is_default}"*}
{*                               data-redirect="{$subitem.fields->getChangeAffiliateUrl($referer)}">{$subitem.fields.title}</a></div>*}
{*                        {else}*}
{*                            <div class="affiliate-sublevel">… <span class="{if $subitem.fields.is_highlight}fw-bold{/if}">{$subitem.fields.title}</span></div>*}
{*                        {/if}*}
{*                    {/foreach}*}
{*                {/if}*}
{*            {/foreach}*}
{*        </div>*}
{*    </div>*}
{/block}
{block "footer"}
    <div class="modal-footer">
        <a data-redirect="{$current_affiliate->getChangeAffiliateUrl($referer)}" class="btn" id="place-accept">Выбрать</a>
    </div>
{/block}
