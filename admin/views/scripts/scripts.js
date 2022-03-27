$(function(){

$('.bx-messenger-content-item-menu').click(function () {
    $(this).closest('.bx-messenger-content-item').data('messageid')
})

$('.popup-window-button.popup-window-button-accept .popup-window-button-text').click(function () {
    $(this).closest('.bx-messenger-content-item').data('messageid')
})


    $('textarea.editor').ckeditor();

    $('.catalog').dcAccordion();
    $('.cross-times').on('click', function(){
        $('#mes-edit').hide();
        $('#mes-edit .responce').empty();
    });

    $('.edit').each(function(){
        $(this).change(function(){
            var val = $(this).val();
            var title = $(this).attr('name');
            var url = $(this).parents('.zebra').data('table');

            updateField(val, title, url);
        });
    });

    $('.edit-price').change(function () {
        var val = $(this).val(),
            id = $(this).data('id'),
            url = $(this).parents('.zebra').data('table');
        updateField(val, id, url);
    })
    $('.del').click(function () {
        var id = $(this).data('id'),
            parent = $(this).closest('tr'),
            url = $(this).parents('.zebra').data('table');
        deleteRow(id, parent, url);
    })

    function deleteRow(id, parent, url) {
        var res = confirm('Подтвердите удаление');
        if (!res) return false;
        $.ajax({
            url: path + url,
            type: 'GET',
            data: {id: id},
            success: function(res){
                var answer;
                console.log(res)
                if (res == 'OK'){
                    answer = "Удалено";
                }else{
                    answer = "Ошибка удаления";
                }

                $('#mes-edit .responce').text(answer);
                $('#mes-edit').delay(500).fadeIn(1000, function(){
                    if(res == 'OK') parent.hide();
                });
                //$(parent).remove()
            },
            error: function(){
                alert('Ошибка!');
            },
            complete: function(){
                $('#loader').delay(500).fadeOut();
            }
        });
    }
    function updateField(val, title, url){
        if( !url ) url = '';
        $.ajax({
            url: path + url,
            type: 'GET',
            data: {val: val, title: title},
            beforeSend : function(){
                $('#loader').fadeIn();
            },
            success: function(res){
                $('#mes-edit .responce').text(res);
                $('#mes-edit').delay(500).fadeIn(1000);
            },
            error: function(){
                alert('Ошибка!');
            },
            complete: function(){
                $('#loader').delay(500).fadeOut();
            }
        });
    }

    var myDropzone = new Dropzone('div#upload', {
        paramName: "file",
        url: path + "upload",
        maxFiles: 1,
        // acceptedFiles: '.jpg, .gif',
        success: function (file, responce) {
            /*console.log(file);
            console.log(responce);*/
            var url = file.dataURL,
                res = JSON.parse(responce);
            if(res.answer == 'error') {
                //this.defaultOptions.error(file, res.error);
                this.removeFile(file);
                alert(res.error);
            }else{
                this.defaultOptions.success(file);
                //this.removeFile(file);
                //$('.preview').append('<img src="' + url + '" width="120">');
            }
        },
        init: function(){
            $(this.element).html(this.options.dictDefaultMessage);
        },
        processing: function()
        {
            $('.dz-message').remove();
        },
        dictDefaultMessage: '<div class="dz-message">Нажмите здесь или перетащите сюда файлы для загрузки</div>',
        dictMaxFilesExceeded: 'Достигнут лимит загрузки файлов - разрешено {{maxFiles}}'
    })
});