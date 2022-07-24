$(document).ready(function() {
    $('body').on('click', '#sent-pdf', sentOrderPdf);
});

function sentOrderPdf(e) {
    if(e !== 'undefined'){
        e.preventDefault();
    }
    $.ajax({
        url: $(this).data('url'),
        type: 'POST',
        data: {order_id: $(this).data('order')},
        success: function(res) {
            console.log(res);
        },
        error: function(err){
            console.error(err);
        }
    });
}
