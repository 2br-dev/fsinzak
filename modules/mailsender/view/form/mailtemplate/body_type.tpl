{addjs file="%mailsender%/mailtemplate.js"}
{addcss file="%mailsender%/mailtemplate.css"}
<a class="mailsender-select-sample" data-url="{adminUrl do="ajaxSelectSample"}">{t}Выбрать оформление{/t}</a>
{include file=$elem.__body_type->getOriginalTemplate() field=$elem.__body_type}
<script>
$(function() {
    $('.formbox [name="body_type"]').change(function() {
        var is_editor = $('[name="body_type"]:checked').val() == 'editor';
        
        $('.formbox [name="body"]').closest('tr').toggle(is_editor);
        $('.formbox [name="body_template"]').closest('tr').toggle(!is_editor);
        $('.formbox .mailsender-select-sample').toggle(is_editor);
        
        if (is_editor) {
            $('.tinymce[name="body"]').trigger('became-visible');
        }
    }).first().change();
});
</script>