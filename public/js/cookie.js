window.onload = function() {
    let cookie_agree = getCookie("cookie_agree");
    if(cookie_agree != ""){
        document.getElementById("cookieNotice").style.display = "none";
    }else{
        document.getElementById("cookieNotice").style.display = "flex";
    }
};
// Create cookie
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

// Delete cookie
function deleteCookie(name) {
    const d = new Date();
    d.setTime(d.getTime() + (24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = name + "=;" + expires + ";path=/";
}

// Read cookie
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

// Set cookie
function acceptCookie(){
    deleteCookie('cookie_agree');
    setCookie('cookie_agree', 1, 30);
    document.getElementById("cookieNotice").style.display = "none";
}
