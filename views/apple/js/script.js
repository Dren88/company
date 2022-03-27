$(function () {

    $.widget( "custom.catcomplete", $.ui.autocomplete, {
        _create: function() {
            this._super();
            this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
        },
        _renderMenu: function( ul, items ) {
            var that = this,
                currentCategory = "";
            $.each( items, function( index, item ) {
                var li;
                if ( item.category != currentCategory ) {
                    ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                    currentCategory = item.category;
                }
                li = that._renderItemData( ul, item );
                if ( item.category ) {
                    li.attr( "aria-label", item.category + " : " + item.label );
                }
            });
        }
    });

    $('#autocomplete').catcomplete({
        source: path + 'search/',
        minLength: 1,
        select: function( event, ui ){
            window.location = path + 'search/?search=' + encodeURIComponent(ui.item.value);
        }
    });

    $('.catalog').dcAccordion({
        eventType: 'hover',
        disableLink: false,
        hoverDelay   : 100,
    });

    if (search != ''){
        $('.product h1').highlight(search);
    }


    $('#forgot-link').click(function (e) {
        e.preventDefault()
        $('#auth').fadeOut(300, function () {
            $('#forgot').fadeIn()
        })
    })
    $('#auth-link').click(function (e) {
        e.preventDefault()
        $('#forgot').fadeOut(300, function () {
            $('#auth').fadeIn()
        })
    })

    $('.access').change(function () {
        var $this = $(this),
            val = $.trim($this.val()),
            dataField = $this.attr('data-field'),
            span = $this.next();
        span.removeClass();
        if (val == '') {
            span.addClass('reg-cross')
            span.next().text('Заполните поле');
        } else {
            span.addClass('reg-loader')
            $.ajax({
                url: path + 'registration',
                type: 'POST',
                data: {val: val, dataField: dataField},
                success: function (res) {
                    var result = JSON.parse(res);
                    span.next().text('');
                    if (result.answer == 'no'){
                        span.addClass('reg-cross')
                        span.next().text(result.info);
                    }else{
                        span.addClass('reg-check')
                    }
                }
            })
        }
    })
})