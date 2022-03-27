$(document).ready(function (){
    $('.element-title').click(function(){
        if($(this).find('.arrow_img').hasClass("arrow")){
            $(this).find('img').attr('src', '/local/templates/itc2019/images/arrow_up.svg');
            $(this).parent().toggleClass('grey_background');

        }else{
            $(this).find('img').attr('src', '/local/templates/itc2019/images/arrow_down.svg');

            $(this).parent().toggleClass('grey_background');
        }
        $(this).find('.arrow_img').toggleClass("arrow")
        $(this).closest('.product-description__version_wrap').find('.element-body').toggleClass("hidden")
    })

    $('#cupon_input').change(function() {
        console.log(1234567)
        var cookie_date = new Date();
        cookie_date.setYear(cookie_date.getFullYear() + 1);
        document.cookie = "COUPON=" + $(this).val() + ";expires=" + cookie_date.toUTCString();
    });


})


$(document).ready(function (){

    BX24.callMethod(
        "crm.lead.update",
        {
            id: 148103,
            fields:
                {
                    "PRICE": 450,
                    "OPPORTUNITY": 15500,
                },
            params: { "REGISTER_SONET_EVENT": "N" }
        },
        function(result)
        {
            if(result.error())
                console.error(result.error());
            else
            {
                console.info(result.data());
            }
        }
    );


})



