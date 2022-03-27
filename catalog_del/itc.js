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
})