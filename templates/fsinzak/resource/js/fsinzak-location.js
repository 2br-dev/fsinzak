$(document).ready(function() {
    $('body').on('click', '.region-select', getInstitutionsList);
    $('body').on('click', '.institution-select', getInstitutionData);
});

function getInstitutionsList(e)
{
    if(e !== 'undefined'){
        e.preventDefault();
    }
    $.ajax({
        url: $(this).data('url'),
        type: 'POST',
        dataType: 'JSON',
        data: {id: $(this).data('id'), referer: $(this).data('referer')},
        success: function(res) {
            console.log(res);
            $('#institutions-list').empty();
            for(let i=0; i < res.institutions.length;i++){
                if(i === 0){
                    $('#institution-label').text(res.institutions[i].title);
                    $('#limits').empty();
                    if(res.institutions[i].limits.length){
                        for(let j=0; j < res.institutions[i].limits.length; j++){
                            if( res.institutions[i].limits[j].type === 'limit_sum'){
                                $('#limits').append('<li id="limit-sum">Сумма заказа не более <span id="limit-sum-value">'+res.institutions[i].limits[j].value+'</span>₽</li>');
                            }
                            if( res.institutions[i].limits[j].type === 'limit_weight'){
                                $('#limits').append('<li id="limit-sum">Общий вес заказа не более <span id="limit-sum-value">'+res.institutions[i].limits[j].value+'</span>г</li>');
                            }
                            if( res.institutions[i].limits[j].type === 'perodicity'){
                                $('#limits').append('<li id="limit-periodicity">не чаще <span id="limit-weight-value">'+res.institutions[i].limits[j].value+'</span> раза в месяц</li>');
                            }
                        }
                    }else{
                        $('#limits').append('<li>Ограничения отсутствуют</li>');
                    }
                    if(res.institutions[i].delivery !== ''){
                        $('#delivery-text').empty();
                        $('#delivery-text').html(res.institutions[i].delivery);
                        $('#delivery-block').removeClass('hidden');
                    }else {
                        $('#delivery-block').addClass('hidden');
                    }
                    $('#place-accept').attr('data-redirect', res.institutions[i].redirect);
                }
                $('#institutions-list').append('<li><a class="institution-select" data-url="'+res.institutions[i].url+'" data-id="'+res.institutions[i].id+'" data-referer="'+res.referer+'">'+res.institutions[i].title+'</a></li>')
            }
        },
        error: function(err) {
            console.error(err);
        }
    });
}

function getInstitutionData(e)
{
    if(e !== 'undefined'){
        e.preventDefault();
    }
    $.ajax({
        url: $(this).data('url'),
        type: 'POST',
        dataType: 'JSON',
        data: {id: $(this).data('id'), referer: $(this).data('referer')},
        success: function(res) {
            $('#institution-label').text(res.institution.title);
            $('#limits').empty();
            if(res.limits.length){
                for(let j=0; j < res.limits.length; j++){
                    if( res.limits[j].type === 'limit_sum'){
                        $('#limits').append('<li id="limit-sum">Сумма заказа не более <span id="limit-sum-value">'+res.limits[j].value+'</span>₽</li>');
                    }
                    if( res.limits[j].type === 'limit_weight'){
                        $('#limits').append('<li id="limit-sum">Общий вес заказа не более <span id="limit-sum-value">'+res.limits[j].value+'</span>г</li>');
                    }
                    if( res.limits[j].type === 'perodicity'){
                        $('#limits').append('<li id="limit-periodicity">не чаще <span id="limit-weight-value">'+res.limits[j].value+'</span> раза в месяц</li>');
                    }
                }
            }else{
                $('#limits').append('<li>Ограничения отсутствуют</li>');
            }
            if(res.delivery !== ''){
                $('#delivery-text').empty();
                $('#delivery-text').html(res.delivery);
                $('#delivery-block').removeClass('hidden');
            }else {
                $('#delivery-block').addClass('hidden');
            }

            $('#place-accept').attr('data-redirect', res.redirect);
        },
        error: function (err) {
            console.error(err);
        }
    });
}
