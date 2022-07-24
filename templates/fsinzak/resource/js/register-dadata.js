$(() => {
    $('body').on('click', '.initDadata', initDaData);
    $('#region').focusout(function(){
        $('#region').attr('autocomplete', 'fdfsa');
        console.log('focusRegion');
    });
    // $('body').on('click', '#city', initDaData);
    // initDaData();
});

function initDaData()
{
    $('#region').attr('autocomplete', 'fdfsa');
    $('#city').attr('autocomplete', 'fdfsa');
    $('#address').attr('autocomplete', 'ddfsd');
    // setTimeout(function(){
    //
    // }, 100);
    let token = "f2d783727229a2287d898e59eae85eaffdba716a";
    let $country = $('#country');
    let $region = $('#region');
    let $city = $('#city');
    let $address = $('#address');
    let type  = "ADDRESS";
    $region.suggestions({
        token: token,
        type: type,
        bounds: "region",
        onSelectNothing: function(query) {
            // console.log(query);
            $region.val('');
            $('.dadata-error').removeClass('hidden');
            $('#region').attr('autocomplete', 'fdfsa');
        }
    });
    $city.suggestions({
        token: token,
        type: type,
        hint: false,
        bounds: "city-settlement",
        constraints: $region
    });
    $address.suggestions({
        token: token,
        type: type,
        hint: false,
        bounds: "street-flat",
        constraints: $city
    });
}



// function initDaData() {
//     setTimeout(function(){
//         $('#address').attr('autocomplete', 'fdfsa');
//     }, 100);
//     var token = "f2d783727229a2287d898e59eae85eaffdba716a";
//     var $address = $('#address');
//     $address.suggestions({
//         token: token,
//         type: "ADDRESS",
//         bounds: "street",
//         constraints: {
//             // ограничиваем поиск Краснодаром
//             locations: {
//                 region: "Краснодарский",
//                 city: $('#new-address').data('city')
//             },
//         },
//         restrict_value: true,
//         triggerSelectOnBlur: true,
//         triggerSelectOnEnter: true,
//         triggerSelectOnSpace: true,
//         /* Вызывается, когда пользователь выбирает одну из подсказок */
//         onSelect: function(suggestion) {
//             $('.dadata-error').addClass('hidden');
//             getSuggestionPart(suggestion);
//         },
//         onSelectNothing: function(query) {
//             // console.log(query);
//             $address.val('');
//             $('.dadata-error').removeClass('hidden');
//             $('#address').attr('autocomplete', 'fdfsa');
//         }
//     });
// }
