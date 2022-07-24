{$app->autoloadScripsAjaxBefore()}
<div class="virtual-form" data-has-validation="true" data-action="/admin/catalog-block-propertyvaluesblock/?ido=addSomeValues">
    <div class="crud-form-error"></div>
    <input type="hidden" name="value_id" value="{$elem.id}">
    <input type="hidden" name="prop_id" value="{$elem.prop_id}">
    <input type="hidden" name="prop_type" value="{$elem.prop_type}">
    <table class="table-inline-edit">
                                                    
                <tr>
                    <td class="key">{$elem.__values->getTitle()}&nbsp;&nbsp;{if $elem.__values->getHint() != ''}<a class="help-icon" title="{$elem.__values->getHint()|escape}">?</a>{/if} </td>
                    <td>{include file=$elem.__values->getRenderTemplate() field=$elem.__values}</td>
                </tr>
                                                <tr>
                <td class="key"></td>
                <td><a class="btn btn-success virtual-submit">Сохранить</a>
                <a class="btn btn-default cancel">Отмена</a>
                </td>
            </tr>
    </table>
</div>
{$app->autoloadScripsAjaxAfter()}