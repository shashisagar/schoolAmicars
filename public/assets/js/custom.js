$(document).ready(function () {

    // Write your custom Javascript codes here...

//Full screen
//ADDED BY: DINANATH THAKUR
//DATE: 09-02-2016
// document.addEventListener("keydown", function(e) {
//        if (e.keyCode == 70) {
//            toggleFullScreen();
//        }
//    }, false);
//
//function toggleFullScreen() {
//    if (!document.fullscreenElement &&    // alternative standard method
//            !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
//        if (document.documentElement.requestFullscreen) {
//            document.documentElement.requestFullscreen();
//        } else if (document.documentElement.msRequestFullscreen) {
//            document.documentElement.msRequestFullscreen();
//        } else if (document.documentElement.mozRequestFullScreen) {
//            document.documentElement.mozRequestFullScreen();
//        } else if (document.documentElement.webkitRequestFullscreen) {
//            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
//        }
//    } else {
//        if (document.exitFullscreen) {
//            document.exitFullscreen();
//        } else if (document.msExitFullscreen) {
//            document.msExitFullscreen();
//        } else if (document.mozCancelFullScreen) {
//            document.mozCancelFullScreen();
//        } else if (document.webkitExitFullscreen) {
//            document.webkitExitFullscreen();
//        }
//    }
//}

//End-Full screen

});


//ADDED BY: DINANATH THAKUR
//DATE: 09-02-2016
$(document.body).on('keydown', '.float-type', function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || /*Allow: Ctrl+A*/(e.keyCode == 65 && e.ctrlKey === true) || /*Allow: Ctrl+C*/(e.keyCode == 67 && e.ctrlKey === true) || /*Allow: Ctrl+X*/(e.keyCode == 88 && e.ctrlKey === true) || /*Allow: home, end, left, right*/(e.keyCode >= 35 && e.keyCode <= 39)) {
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
$(document.body).on('keydown', '.integer-type', function (e) {
    // Allow: backspace, delete, tab, escape and enter
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 || /*Allow: Ctrl+A*/(e.keyCode == 65 && e.ctrlKey === true) || /*Allow: Ctrl+C*/(e.keyCode == 67 && e.ctrlKey === true) || /*Allow: Ctrl+X*/(e.keyCode == 88 && e.ctrlKey === true) || /*Allow: home, end, left, right*/(e.keyCode >= 35 && e.keyCode <= 39)) {
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});

//Defer parsing of images
//ADDED BY: DINANATH THAKUR
//DATE: 09-02-2016
function initImgDefer() {
    var imgDefer = $('img');
    $.each(imgDefer, function (index, value) {
        if ($(this).attr('img-src')) {
            $(this).attr('src', $(this).attr('img-src'));
        }
    });
}
window.onload = initImgDefer;

function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}

