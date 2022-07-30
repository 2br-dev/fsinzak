{include file=$elem.__send_type->getOriginalTemplate() field=$elem.__send_type}
<script>
$(function() {
    $('.formbox [name="send_type"]').change(function() {
        var is_manual = $('[name="send_type"]:checked').val() == 'manual';
        
        $('.formbox [name^="sources["]').closest('tr').toggle(is_manual);
        $('.formbox [name="dateofsend"]').closest('tr').toggle(is_manual);
        $('.formbox [name="trigger_id"]').closest('tr').toggle(!is_manual);
        
    }).first().change();
});
</script>