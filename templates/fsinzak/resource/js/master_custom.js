$(document).ready(function(){
    $('body').on('click', '#add-recipient', addRecipient);
    $('body').on('click', '.recipient-item', setRecipient);
    $('body').on('click', '.recipient-edit', editRecipient);
    $('body').on('click', '.recipient-create', createRecipient);
    $('body').on('focus', '.datepicker', callDatepicker);
    // $('body').on('click', '.datepicker', initDatepicker);

    $('body').on('click', '.tel', phoneMask);
    $('body').on('input', '.tel', phoneMask);
    $('body').on('focus', '.tel', phoneMask);
    $('body').on('blur', '.tel', phoneMask);
    $('body').on('keydown', '.tel', phoneMask);

    $('body').on('change', 'select[name="data[citizen]"]', changeCitizen);

    $('.mask-phone').mask('+7 (999) 999-99-99');
    $('body').on('click', '.mask-pasport-number', function (){
        console.log('click');
        $(this).mask('9999 999999')
    });
    if($('.register-phone-block').length > 0){
        if($('.register-phone-block').hasClass('no-rf')){
            $('input[name="phone"]').removeAttr('readonly');
            $('.initDadata').removeClass('initDadata');
        }
    }
});

function callDatepicker() {
    var instance = M.Datepicker.getInstance($(this));
    instance.open();
    console.log($(this).datepicker);
}

function initDatepicker() {
    console.log('initDatepicker');
    $(this).datepicker({
        container: document.body,
        onSelect: function(data){
            fillDateStamp(data, $(this.el));
        },
        i18n: {
            cancel: "Отмена",
            clear: "Очистить",
            done: "OK",
            months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
            monthsShort: ["Янв", "Фев", "Мрт", "Апр", "Май", "Июн", "Июл", "Авг", "Снб", "Окт", "Ноя", "Дек"],
            weekdays: ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'],
            weekdaysShort: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
            weekdaysAbbrev: ['пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'вс']
        }
    });
}

function editRecipient(e)
{
    if(e !== 'undefined'){
        e.preventDefault();
    }
    let form = $('#recipient-edit-form');
    $.ajax({
        url: $(this).data('url'),
        type: 'POST',
        data: form.serialize(),
        dataType: 'JSON',
        success: function (res) {
            if(!res.success){
                if(res.error === 'surname'){
                    M.toast({html: '<p>Не заполенено поле Фамилия</p>', classes: 'toast-error'});
                }
                if(res.error === 'name'){
                    M.toast({html: '<p>Не заполенено поле Имя</p>', classes: 'toast-error'});
                }
                if(res.error === 'midname'){
                    M.toast({html: '<p>Не заполенено поле Отчество</p>', classes: 'toast-error'});
                }
                if(res.error === 'birthday'){
                    M.toast({html: '<p>Не заполенено поле Дата рождения</p>', classes: 'toast-error'});
                }
            }else {
                window.location.href = res.referer;
            }
        },
        error: function (err) {
            console.error(err);
        }
    });
}

function createRecipient(e)
{
    if(e !== 'undefined'){
        e.preventDefault();
    }
    let form = $('#recipient-create-form');
    let referer = $(this).data('referer');
    $.ajax({
        url: $(this).data('url'),
        type: 'POST',
        data: form.serialize(),
        dataType: 'JSON',
        success: function (res) {
            if(!res.success){
                if(res.error === 'surname'){
                    M.toast({html: '<p>Не заполенено поле Фамилия</p>', classes: 'toast-error'});
                }
                if(res.error === 'name'){
                    M.toast({html: '<p>Не заполенено поле Имя</p>', classes: 'toast-error'});
                }
                if(res.error === 'midname'){
                    M.toast({html: '<p>Не заполенено поле Отчество</p>', classes: 'toast-error'});
                }
                if(res.error === 'birthday'){
                    M.toast({html: '<p>Не заполенено поле Дата рождения</p>', classes: 'toast-error'});
                }
                if(res.error === 'same'){
                    M.toast({html: '<p>Получатель с такими данным уже создан</p>', classes: 'toast-error'});
                }
            }else {
                // console.log(referer);
                window.location.href = referer;
            }
        },
        error: function (err) {
            console.error(err);
        }
    });
}

function changeCitizen() {
    let select_val = $(this).val();
    if(select_val !== 'Гражданин РФ'){
        $('.register-phone-block').addClass('no-rf');
        $('input[name="data[country]"]').val('');
        $('input[name="data[country]"]').removeAttr('readonly');
        $('.initDadata').removeClass('initDadata');
        $('input[name="phone"]').removeAttr('readonly');
        $('.tel').val('').removeClass('tel');
        $('.mask-pasport-number').removeClass('mask-pasport-number');
    }else {
        $('.register-phone-block').removeClass('no-rf');
        $('input[name="data[country]"]').val('Россия');
        $('input[name="data[country]"]').attr('readonly', 'readonly');
        $('#region').addClass('.initDadata');
        $('#city').addClass('.initDadata');
        $('#address').addClass('.initDadata');
        $('input[name="phone"]').removeAttr('readonly');
        let oldPhone = $('.register-phone-block').data('old');
        $('input[name="phone"]').val(oldPhone);
        $('input[name="phone"]').addClass('tel');
    }
}

function phoneMask(event){
    var keyCode;
    event.keyCode && (keyCode = event.keyCode);
    var pos = this.selectionStart;
    if (pos < 3) event.preventDefault();
    var matrix = "+7 (___) ___ ____",
        i = 0,
        def = matrix.replace(/\D/g, ""),
        val = this.value.replace(/\D/g, ""),
        new_value = matrix.replace(/[_\d]/g, function(a) {
            return i < val.length ? val.charAt(i++) || def.charAt(i) : a
        });
    i = new_value.indexOf("_");
    if (i != -1) {
        i < 5 && (i = 3);
        new_value = new_value.slice(0, i)
    }
    var reg = matrix.substr(0, this.value.length).replace(/_+/g,
        function(a) {
            return "\\d{1," + a.length + "}"
        }).replace(/[+()]/g, "\\$&");
    reg = new RegExp("^" + reg + "$");
    if (!reg.test(this.value) || this.value.length < 5 || keyCode > 47 && keyCode < 58) this.value = new_value;
    if (event.type == "blur" && this.value.length < 5)  this.value = ""
}

function setRecipient(e) {
    console.log('recipient-item');
    if(e !== 'undefined'){
        e.preventDefault();
    }
    $.ajax({
        url: $(this).data('url'),
        data: {id: $(this).data('id'), referer: $(this).data('referer')},
        dataType: 'JSON',
        success: function (res) {
            if (res.reloadPage) {
                location.replace(window.location.href);
            }
        },
        error: function (err) {
            console.error(err);
        }
    });
}

/**
 * Добавление нового получателя
 * @param e
 */
function addRecipient(e) {
    let form = $('#recipient-add-form');
    let fd = new FormData(form[0]);

    if(e !== 'undefined')
    {
        e.preventDefault();
    }
    $.ajax({
        url: $(this).data('url'),
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function (res) {
            console.log(res);
            if (res.reloadPage) {
                location.replace(window.location.href);
            }
        },
        error: function(err){
            console.error(err);
        }
    });
}

/**
 * Заполняет timestamp выбранной даты из datepicker
 * @param date
 * @param el
 */
function fillDateStamp(date, el) {
    let hiddenInput = el.parents('.input-field').next();
    hiddenInput.val(date.getTime()/1000);
}

function fillDefaultDate(context){
    let hiddenInput = context.querySelector('.defaultDatePicker');
    let defaultDate = 0;
    if(hiddenInput){
        defaultDate = new Date(hiddenInput.value*1000);
    }
    return defaultDate;
}
