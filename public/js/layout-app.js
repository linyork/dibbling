function  getCookie(name) {
    var cookieName=encodeURIComponent(name)+'=';
    var cookieStart = document.cookie.indexOf(cookieName);

    if (cookieStart>-1) {
        var cookieEnd=document.cookie.indexOf(';',cookieStart);
        if(cookieEnd==-1){
            cookieEnd=documet.cookie.length;
        }
        cookieValue=decodeURIComponent(document.cookie.substring(cookieStart+cookieName.length,cookieEnd));
        return   cookieValue;
    }
}

function __(string) {
    return eval(string);
}


$(function(){
    $(".go-to-top").on('click', function(){
        $("html, body").animate({
            scrollTop: 0
        }, 500)
    })
    $(window).on('scroll', function() {
        if ( $(this).scrollTop() > 300){
            $('.go-to-top').fadeIn()
        } else {
            $('.go-to-top').fadeOut()
        }
    })
})