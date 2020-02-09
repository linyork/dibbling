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
