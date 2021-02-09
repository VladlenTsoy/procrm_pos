// ------------------------------------------------------- //
// print sale receipt
// ------------------------------------------------------ //

function PrintTicket() {
    $("#printSection").print();
}

// ------------------------------------------------------- //
// full screen button
// ------------------------------------------------------ //

function toggleFullscreen(elem) {
    elem = elem || document.documentElement;
    if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
        $('body').removeClass('show-sidebar');
        $('body').addClass('hide-sidebar');
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
        $('body').addClass('show-sidebar');
        $('body').removeClass('hide-sidebar');
    }
}
if($('#btnFullscreen').length > 0) {
    document.getElementById('btnFullscreen').addEventListener('click', function() {
        toggleFullscreen();
    });
}

// ------------------------------------------------------- //
// reload window after lead create
// ------------------------------------------------------ //

$(document).on('click', '#lead-modal .modal-header .close', function (){
    window.location.reload();
});
$(document).on('click', '#ticket .modal-header .close', function (){
    window.location.reload();
});
$(document).on('click', '#ticket .modal-close', function (){
    window.location.reload();
});
