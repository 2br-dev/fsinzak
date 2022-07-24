{* Шаблон, отвечающий за генерацию динамических форм, создаваемых в административной панели для
некоторых объектов (регистрация пользователя, оформление заказа, покупка в 1 клик) *}
{if $fld.type == 'string'}
    <input
        type="text"
        name="{$fld.fieldname}"
        value="{$values[$fld.alias]}"
        {if $fld.maxlength>0}maxlength="{$fld.maxlength}"{/if}
        class="form-control{if $has_error} is-invalid{/if}{if $fld.alias == 'pasport'} mask-pasport-number{/if}{if $fld.alias == 'region' || $fld.alias == 'city' || $fld.alias == 'address'} initDadata{/if}"
        placeholder="{$fld.title}"
        {if $fld.alias == 'region'}
            id="region"
        {/if}
        {if $fld.alias == 'city'}
            id="city"
        {/if}
        {if $fld.alias == 'address'}
            id="address"
        {/if}
    >

{elseif $fld.type == 'text'}
    <textarea cols="50" rows="10" name="{$fld.fieldname}" {if $fld.maxlength>0}maxlength="{$fld.maxlength}"{/if} class="form-control{if $has_error} is-invalid{/if}" placeholder="{$fld.title}">{$values[$fld.alias]}</textarea>

{elseif $fld.type == 'list'}
    <select name="{$fld.fieldname}" class="styled{if $has_error} is-invalid{/if}">
{*        {if $fld.necessary}*}
{*            <option value="">{t}Не выбрано{/t}</option>*}
{*        {/if}*}
        {foreach $options as $option}
            <option{if $option==$values[$fld.alias]} selected{/if}>{$option}</option>
        {/foreach}
    </select>

{elseif $fld.type == 'bool'}
    <div>
        <input type="hidden" name="{$fld.fieldname}" value="0" {if $values[$fld.alias]}checked{/if}>
        <input type="checkbox" name="{$fld.fieldname}" value="1" class="{if $has_error} is-invalid{/if}" {if $values[$fld.alias]}checked{/if}>
    </div>
{/if}
