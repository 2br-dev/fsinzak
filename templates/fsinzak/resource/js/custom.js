new class Anton extends RsJsCore.classes.component
{
    initDatepicker(event)
    {
        let context = event.target; //Тут будет элемент, внутри которого появился новый контент

        //Тут ты можешь инициализировать все, что угодно, например:

        $('.datepicker', context).datepicker({
            container: document.body,
            maxDate: new Date(),
            onSelect: function(data){
                fillDateStamp(data, $(this.el));
            },
            defaultDate: fillDefaultDate(context),
            setDefaultDate: true,
            autoClose: true,
            format: 'dd.mm.yyyy',
            yearRange: [new Date().getFullYear() - 80, new Date().getFullYear()],
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

    /**
     * Выполняется, когда на странице пояился новый контент
     *
     * @param event
     */
    onContentReady(event) {
        this.initDatepicker(event);
    }
};
