<input type="checkbox" id="send-later" {if $elem.dateofsend !== null}checked{/if}>
<span id="send-later-container">
    {include file=$elem.__dateofsend->getOriginalTemplate() field=$elem.__dateofsend}
</span>
<script>
    $(function() {
        $('#send-later').change(function() {
            if (!$(this).is(':checked')) {
                $('[name="dateofsend"]').val('');
            }
            $('#send-later-container').toggle($(this).is(':checked'));        
        }).change();
    });
</script>