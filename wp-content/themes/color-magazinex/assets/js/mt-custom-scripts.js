jQuery(document).ready(function($) {

    "use strict";

    /**
     * Color Magazine Preloader
     */
    if($('#preloader-background').length > 0) {
        setTimeout(function(){$('#preloader-background').hide();}, 1000);
    }

    var mtRTL = false
    var mtDirection = "left"
    if ($('body').hasClass("rtl")) {
        mtRTL = true;
        mtDirection = "right";
    };

    var grid = document.querySelector(
            '.mt-archive--masonry-style .mt-archive-article-wrapper,.mt-frontpage--masonry-style .mt-archive-article-wrapper'
        ),
        masonry;

    if (
        grid &&
        typeof Masonry !== undefined &&
        typeof imagesLoaded !== undefined
    ) {
        imagesLoaded( grid, function( instance ) {
            masonry = new Masonry( grid, {
                itemSelector: '.hentry'
            } );
        } );
    }

    /**
     * Header Search script
     */
    $('.mt-menu-search .mt-search-icon').click(function() {
        $('.mt-form-wrap').toggleClass('search-activate');
        var element = document.querySelector( '.mt-form-wrap.search-activate' );
        if( element ) {
            $(document).on('keydown', function(e) {
                var focusable = element.querySelectorAll( 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                var firstFocusable = focusable[0];
                var lastFocusable = focusable[focusable.length - 1];
                color_magazinex_focus_trap( firstFocusable, lastFocusable, e );
            })
        }
    });

    /**
     * Focus trap in popup.
     */
    var KEYCODE_TAB = 9;
    function color_magazinex_focus_trap( firstFocusable, lastFocusable, e ) {
        if (e.key === 'Tab' || e.keyCode === KEYCODE_TAB) {
            if ( e.shiftKey ) /* shift + tab */ {
                if (document.activeElement === firstFocusable) {
                    lastFocusable.focus();
                    e.preventDefault();
                }
            } else /* tab */ {
                if ( document.activeElement === lastFocusable ) {
                    firstFocusable.focus();
                    e.preventDefault();
                }
            }
        }
    }

    $('.mt-form-wrap .mt-form-close').click(function() {
        $('.mt-form-wrap').toggleClass('search-activate');
        var focusElement = $( this ).data( 'focus' );
        $( focusElement ).focus();
    });

    /**
     * Close popups on escape key.
     */
    $( document ).on( 'keydown', function( event ) {
        if ( event.keyCode === 27 ) {
            event.preventDefault();
            $( '.mt-menu-search .mt-form-wrap' ).removeClass( 'search-activate' );
        }
    });

    /**
     * Settings about sticky menu
     */
    var stickyOption = color_magazineObject.menu_sticky;
    if( stickyOption === 'on' ) {
        var windowWidth = $( window ).width();
        if( windowWidth < 500 ) {
            var wpAdminBar = 0;
        } else {
            var wpAdminBar = $('#wpadminbar');
        }
        if ( wpAdminBar.length ) {
            $(".mt-menu-wrapper").sticky({topSpacing:wpAdminBar.height()});
        } else {
            $(".mt-menu-wrapper").sticky({topSpacing:0});
        }
    }
    
    /**
     * Scroll To Top
     */
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1000) {
            $('#mt-scrollup').fadeIn('slow');
        } else {
            $('#mt-scrollup').fadeOut('slow');
        }
    });
    $('#mt-scrollup').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
    
    /**
     * Slider scripts
     */
    $('.front-slider').lightSlider({
        pager: false,
        auto: false,
        loop: true,
        item: 1,
        controls: true,
        slideMargin:0,
        rtl:true,
        nextHtml: '<span class="icon-next"><i class="bx bx-chevron-left"></i></span>',
        prevHtml: '<span class="icon-prev"><i class="bx bx-chevron-right"></i></span>',

        onSliderLoad: function() {
            $('.front-slider').removeClass('cS-hidden');
        }
        
    });

    /**
     * Slider scripts
     */
    $('.mt-gallery-slider').lightSlider({
        pager: false,
        auto: false,
        loop: true,
        item: 1,
        controls: true,
    });

    //responsive menu toggle
    $('.mt-main-menu-wrapper .menu-toggle').click(function(event) {
        $('.mt-main-menu-wrapper #site-navigation').toggleClass( 'isActive' ).slideToggle('slow');
        var element = document.querySelector( '.mt-main-menu-wrapper' );
        if( element ) {
            $(document).on('keydown', function(e) {
                if( element.querySelectorAll( '.mt-main-menu-wrapper #site-navigation.isActive' ).length === 1 ) {
                    var focusable = element.querySelectorAll( 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                    var firstFocusable = focusable[0];
                    var lastFocusable = focusable[focusable.length - 1];
                    color_magazinex_focus_trap( firstFocusable, lastFocusable, e );
                }
            })
        }
    });

    /**
     * responsive sub menu toggle
     */
    $('<a href="javascript:void(0);" class="sub-toggle"><i class="bx bx-chevron-right"></i></a>').insertAfter('#site-navigation .menu-item-has-children>a, #site-navigation .page_item_has_children>a');

    $('#site-navigation .sub-toggle').click(function() {
        $(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
        jQuery(this).parent('.page_item_has_children').children('ul.children').first().slideToggle('1000');
        $(this).children('.bx-chevron-right').first().toggleClass('bx-chevron-down');
    });

    // check for dark mode drafts
    if( localStorage.getItem( "siteMode" ) && localStorage.getItem( "siteMode" ) == "dark" ) {
        $( ".mt-site-mode-wrap input" ).attr( "checked", true );
        if( ! $( "body" ).hasClass( "mt-site-dark-mode" ) ) {
            $( "body" ).addClass( "mt-site-dark-mode" );
            $( "body" ).removeClass( "mt-main-body" );
        }
    }
    // toggle theme mode
    $( ".mt-site-mode-wrap" ).on( "click", function() {
        var _this = $(this)
        $( "body" ).toggleClass( "mt-site-dark-mode" )
        if( _this.find( "input:checked" ).length > 0 && $( "body" ).hasClass( "mt-site-dark-mode" ) ) {
            localStorage.setItem("siteMode", "dark");
            $("body").removeClass("mt-main-body");
        } else {
            localStorage.setItem( "siteMode", "light" );
            $("body").addClass("mt-main-body");
        }
    });

    /**
     * Ticker Posts slide handle
     */
    $('.ticker-posts-wrap').marquee({
        delayBeforeStart:2000,
        duration : 50000,
        direction: mtDirection,
        pauseOnHover : true,
        startVisible: true,
        duplicated: true,
    });

    /**
     * Focus trap in popup.
     */
    var KEYCODE_TAB = 9;
    function color_magazinex_focus_trap( firstFocusable, lastFocusable, e ) {
        if (e.key === 'Tab' || e.keyCode === KEYCODE_TAB) {
            if ( e.shiftKey ) /* shift + tab */ {
                if (document.activeElement === firstFocusable) {
                    lastFocusable.focus();
                    e.preventDefault();
                }
            } else /* tab */ {
                if ( document.activeElement === lastFocusable ) {
                    firstFocusable.focus();
                    e.preventDefault();
                }
            }
        }
    }

});