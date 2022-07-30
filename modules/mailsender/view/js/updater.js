/**
* Активирует обновление счетчиков и статусов рассылок в списке рассылок
*/
$(function() {
    //defaults
    var options = {
        refreshUrl: $('.rs-table[data-refresh-url]').data('refreshUrl'),
        delay: 5000
    };
    
    var timer;
    
    $.contentReady(function() {
        clearInterval(timer);
        var ids = [];
        $('.crud-list-form .crud-edit[data-id]').each(function() {
            ids.push($(this).data('id'));
        });
        if (ids.length) {
            timer = setInterval(function() {
                $.ajax({
                    url: options.refreshUrl,
                    type: 'post',
                    dataType: 'json',
                    data: {templates_id: ids},
                    success: function(response) {
                        if (response.success) {
                            $.each(response.info, function(key, val) {
                                $('.mailsend-cell-status-' + key).html(val.status);
                                $('.mailsend-cell-sended-' + key).html(val.sended);
                            });
                        }
                    }
                });
                
            }, options.delay);
        }
    });
});