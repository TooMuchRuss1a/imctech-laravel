// loading
$(window).load(function () {
    $(".se-pre-con").fadeOut("slow");;
});

// scroll
window.onscroll = function () {
    "use strict";
    if (document.body.scrollTop >= 0.2 * window.innerHeight && document.body.scrollTop || document.documentElement.scrollTop >= 0.2 * window.innerHeight) {
        scrUp.classList.add("scrup");
    } else {
        scrUp.classList.remove("scrup");
    }
};

// dropdown
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown1").classList.toggle("show1");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn1')) {
        var dropdowns = document.getElementsByClassName("dropdown1-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show1')) {
                openDropdown.classList.remove('show1');
            }
        }
    }
}