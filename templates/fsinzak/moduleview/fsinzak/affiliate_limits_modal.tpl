{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}

{block "class"}modal-lg{/block}
{block "title"}
    {t}Ограничения{/t}
{/block}
{block "body"}
    <div class="">
        <p>В <strong>{$current_affiliate['title']}({$parent_affiliate['title']})</strong> дествуют следующие ограничения:</p>
        <div class="info style-warning">
            <ul class="browser-default">
                {foreach $limits as $limit}
                    {if $limit['type'] == 'limit_sum'}
                        <li>По сумме заказа: не более {$limit['value']}₽</li>
                    {/if}
                    {if $limit['type'] == 'limit_weight'}
                        <li>По весу заказа: не более {$limit['value']}кг</li>
                    {/if}
                    {if $limit['type'] == 'periodicity'}
                        <li>Не более {$limit['value']} заказов в {$limit['value_month']} мес.</li>
                    {/if}
                {/foreach}
            </ul>
        </div>
    </div>
{/block}
{block "footer"}

{/block}
