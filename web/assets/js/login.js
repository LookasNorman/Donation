$(function () {
    $('#google-signin img').hover(function (e) {
        $(this).attr('src','assets/icon/btn_google_signin_dark_focus_web.png');
    },function(){
        $(this).attr('src','assets/icon/btn_google_signin_dark_normal_web.png');
    })

    $('#google-signin').on('mousedown', function (e) {
        $(this).children().attr('src','assets/icon/btn_google_signin_dark_pressed_web.png');
    })

})