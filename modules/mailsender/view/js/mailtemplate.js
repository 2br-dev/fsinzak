$(function() {
    //Подключаем фильтры
    $('body')
        .on('change', '#mailsend-filters select[name$="[class]"]', function() {
            var settingsBody = $(this).closest('table').find('.mailsend-filter-settings');
            
            $.ajaxQuery({
                url: $('.mailsend-add-filter').data('href'),
                data: {
                    filter_class: $(this).val(),
                    filter_key:$(this).data('filterId')
                },
                success: function(response) {
                    settingsBody.html(response.html).trigger('new-content');
                }
            });
        })
        .on('click', '#mailsend-filters .mailsend-filter-close', function() {
            $(this).closest('.mailsend-filter').remove();
        })
        .on('click', '#mailsend-filters .mailsend-add-filter', function() {
            var filtersContainer = $('#mailsend-filters-container');
            
            $.ajaxQuery({
                url: $(this).data('href'),
                success: function(response) {
                    filtersContainer.append(response.html).trigger('new-content');
                }
            });
        });
    
    //Подключаем генераторы контента
    $('body').on('change', '.mailsend-content-cb', function() {
        var form = $(this).closest('.crud-form');
        var url = $('#mailsend-replace-vars').data('updateUrl');
        
        $.ajaxQuery({
            url: url,
            method: 'POST',
            data: form.serializeArray(),
            success: function(response) {
                $('#mailsend-replace-vars').replaceWith(response.html).trigger('new-content');
            }
        });
    });
    
    //Подключаем настройки генератора контента
    $('body').on('click', '.mailsend-content-edit', function() {
        $(this).closest('.mailsend-content').toggleClass('open');        
    });
    
    //Подключаем кнопку добавить файл
    $('body')
        .on('click', '.mailsend-file-attach', function() {
            $('.mailsend-files-container').append('<li><input type="file" name="uploadfiles[]"> <a class="mailsend-uploadfile-remove" title="'+lang.t('удалить')+'">&times;</a></li>');
            return false;
        })
        .on('click', '.mailsend-uploadfile-remove', function() {
            $(this).closest('li').remove();
        })
        .on('click', '.mailsend-attached-remove', function() {
            var li = $(this).closest('li');
            $(this).closest('.crud-form').append('<input type="hidden" name="deletefiles[]" value="'+li.data('id')+'">');
            li.remove();
        });
    
    //Подключаем выбор шаблона
    $('body')
        .on('click', '.mailsender-select-sample', function() {
            $.rs.openDialog({
                url: $(this).data('url'),
                dialogOptions: {
                    dialogClass: 'selectSampleDialog'
                },
                afterOpen: function(dialog) {
                    dialog.trigger('disableBottomToolbar', 'select-sample');
                    $('.mailsender-samples li').click(function() {
                        var sampleId = $(this).data('sampleId');
                        var url = $(this).closest('[data-get-sample-url]').data('getSampleUrl');
                        
                        $.ajaxQuery({
                            url: url,
                            type: 'post',
                            data: {id: $(this).data('sampleId')},
                            success: function(response) {
                                
                                $('textarea[name="body"]').val(response.html);
                                
                                dialog.dialog('close');
                            }
                        });
                    });
                },
                close: function(dialog) {
                    dialog.trigger('enableBottomToolbar', 'select-sample');
                }
            });
        });
        
    $('body').on('change', '.mailsend-source-input', function() {
        $('.mailsend-source-settings[data-link-source="'+$(this).val()+'"]').toggle( $(this).is(':checked') );
    });
    
    $('body').on('change', '.mailsend-content-cb', function() {
        if ($(this).is(':checked')) {
            $(this).closest('.mailsend-content').addClass('open');
        }
    });
    
});