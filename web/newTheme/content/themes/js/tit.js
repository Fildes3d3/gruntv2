jQuery(document).ready(function($) {

    "use strict";

    // SlickNav
    $("#top-nav .menu").slicknav({
        label: '',
        prependTo: '#top-nav',
        duration: 200,
        allowParentLinks: true,
    });

    // Search
    $(".search-icon").click(function(){
        $("#top-search .search-input").slideToggle(200)
    });

    // BxSlider
    $(".post-img .bxslider").bxSlider({
        mode: 'fade',
        captions: true,
        adaptiveHeight: true,
        pager: false,
        onSliderLoad: function(){
            $(".post-slider").css("visibility", "visible");
        }
    });

    // Fitvids
    $(".container").fitVids();

    // Back To Top
    $(".footer-text-back-to-top").click(function(){
        $("html, body").animate({scrollTop : 0},800);
        return false;
    });

});
