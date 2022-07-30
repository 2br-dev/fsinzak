{include file=$elem.__type_class->getOriginalTemplate() field=$elem.__type_class}
<script>
    $(function() { 
        var updateTypeForm = function() {
            var type = $('select[name="type_class"]').val();
            $.ajaxQuery({
                url: '{$router->getAdminUrl("AjaxGetTriggerTypeForm")}',
                data: { type: type },
                success: function(response) {
                    $('#type-form').html(response.html).trigger('new-content');
                }
            })
        }
        $('select[name="type_class"]').change(function() {
            updateTypeForm();
        });
    });
</script>
</td></tr>
<tbody id="type-form">
    {if $type_object = $elem->getTypeObject()}
        {include file="%mailsender%/form/trigger/type_form.tpl"}
    {/if}
</tbody>
<tr><td>