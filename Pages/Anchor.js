/* function offsetAnchor() {
    if(location.hash.length !== 0) {
        window.scrollTo(window.scrollX, window.scrollY - 100);
    }
}

// This will capture hash changes while on the page
$(window).on("hashchange", function () {
    offsetAnchor();
});

// This is here so that when you enter the page with a hash,
// it can provide the offset in that case too. Having a timeout
// seems necessary to allow the browser to jump to the anchor first.
window.setTimeout(function() {
    offsetAnchor();
}, 1) */

$(document).ready(function(){
    $('.link').on('click',function (e) {
        $('html, body').stop().animate({
            'scrollTop': $($(this).attr('rel')).offset().top - 100
        }, 'slow', 'swing', function () {});
    });
})
