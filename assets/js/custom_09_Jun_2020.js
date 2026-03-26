jQuery(document).ready(function() {
    jQuery('.home-banner').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 1
            }
        }
    });
    jQuery('#pro-gallery').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2,
                nav: false
            },
            1000: {
                items: 4
            }
        }
    });
    jQuery('#additional-info-tab').responsiveTabs({
        startCollapsed: 'accordion'
    });
    jQuery(".header-search, .mobile-search").click(function() {
        jQuery(".desktop-search-form").addClass("open");
    });
    jQuery(".icon-close").click(function() {
        jQuery(".desktop-search-form").removeClass("open");
    });
});

window.onscroll = function() { myFunction() };

var header = document.getElementById("menubar");
var sticky = header.offsetTop;

function myFunction() {
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}