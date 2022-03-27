$(function () {
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
})