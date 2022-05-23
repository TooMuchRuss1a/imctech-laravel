window.onscroll = function () {
    "use strict";
    if (document.body.scrollTop >= 0.92 * window.innerHeight && document.body.scrollTop < 1.78 * window.innerHeight >= window.innerHeight || document.documentElement.scrollTop >= 0.92 * window.innerHeight && document.documentElement.scrollTop < 1.78 * window.innerHeight) {
        myNav.classList.add("scroll");
        dd.classList.add("dropdown-content1-scr");
    } else {
        myNav.classList.remove("scroll");
        dd.classList.remove("dropdown-content1-scr");
    }
};