/*----------------------------------------------------------*/
/*                   TABLE OF CONTENT                        */
/*----------------------------------------------------------*/
/*
1 - CLIENTS IMG HOVER EFFECT
2 - SHOP JQUERY UI SLIDER
3 - REVOLUTION SLIDER
4 - TEAM MEMBER CHART JQUERY
5 - NOTIFICATIONS BLOCK JQUERY
6 - STICKY NAVIGATION
7 - TWITTER PLUGIN JQUERY
8 - PORTFOLIO ISOTOPE JQUERY
9 - RESPONSIVE NAVIGATION
10 - MAIN NAVIGATION JS
11 - LAYERSLIDER JS
12 - FLICKR PHOTOS
13 - INSTAGRAM PHOTOS
14 - SKILLS BAR ANIMATION
15 - FLEX SLIDERS 
16 - PRETTYPHOTO
17 - GOOGLE MAPS
18 - JQUERY ACCORDION
19 - JQUERY TABS
20 - JQUERY CAROUSEL
21 - CONTACT FORM VALIDATION
*/
jQuery.noConflict()(function ($) {
$(document).ready(function ($) {
 /*----------------------------------------------------------*/
 /*              1 - CLIENTS IMAGE HOVER EFFECT                */
 /*----------------------------------------------------------*/
     $('ul.client-block li a img').hover(function () {
            $(this).transition({
                scale: 1.12
            });
        }, function () {
            $(this).transition({
                scale: 1
            });
        });
 /*----------------------------------------------------------*/
 /*               2 - SHOP JQUERY UI SLIDER                  */
 /*----------------------------------------------------------*/
        if ($('#slider-range').length && jQuery()) {
            $(function () {
                var options = {
                    range: true,
                    min: 1,
                    max: 1500,
                    values: [50, 1000],
                    slide: function (event, ui) {
                        $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);  
                    }
                };
                $("#slider-range").slider(
                    options
                );
                $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
               
            });
        }
/*----------------------------------------------------------*/
/*              3 - REVOLUTION SLIDER                       */
/*----------------------------------------------------------*/
        if ($('.fullwidthbanner').length && jQuery()) {
            api = jQuery('.fullwidthbanner').revolution({
                delay: 9000,
                startheight: 450,
                startwidth: 940,
                hideThumbs: 300,
                thumbWidth: 100, // Thumb With and Height and Amount (only if navigation Tyope set to thumb !)
                thumbHeight: 50,
                thumbAmount: 5,
                navigationType: "both", //bullet, thumb, none, both     (No Thumbs In FullWidth Version !)
                navigationArrows: "verticalcentered", //nexttobullets, verticalcentered, none
                navigationStyle: "square", //round,square,navbar
                touchenabled: "on", // Enable Swipe Function : on/off
                onHoverStop: "on", // Stop Banner Timet at Hover on Slide on/off
                navOffsetHorizontal: 0,
                navOffsetVertical: 20,
                stopAtSlide: -1,
                stopAfterLoops: -1,
                shadow: 2, //0 = no Shadow, 1,2,3 = 3 Different Art of Shadows  (No Shadow in Fullwidth Version !)
                fullWidth: "off" // Turns On or Off the Fullwidth Image Centering in FullWidth Modus
            });
        }
/*----------------------------------------------------------*/
/*              4 - TEAM MEMBER CHART JQUERY                */
/*----------------------------------------------------------*/
        if ($('.chart').length && jQuery()) {
            //create instance
            $('.percentage-1,.percentage-2,.percentage-3,.percentage-4').easyPieChart({
                animate: 2000,
                barColor: '#169fe6',
                trackColor: '#e6e9ee',
                lineCap: 'round',
                size: 155,
                lineWidth: 10
            });
        }
/*----------------------------------------------------------*/
/*              5 - NOTIFICATIONS BLOCK JQUER                */
/*----------------------------------------------------------*/
    $('.notification span.close-notification').click(function () {
            $(this).parent().fadeOut(1000);
        });
        $(".tooltip").tipTip({
            defaultPosition: "bottom"
        });
         $(".tooltip.right").tipTip({
            defaultPosition: "right"
        });
           $(".tooltip.left").tipTip({
            defaultPosition: "left"
        });
/*----------------------------------------------------------*/
/*              6 - STICKY NAVIGATION                       */
/*----------------------------------------------------------*/
        var aboveHeight = $('#copyrights').outerHeight();
        $(window).scroll(function () {
            if ($(window).scrollTop() > aboveHeight && $(window).width() > 959) {
                $('#main-navigation.fixed').addClass('sticky');
                $('body').addClass('empty');
            } else {
                $('#main-navigation.fixed').removeClass('sticky');
                $('body').removeClass('empty');
            }
        });
/*----------------------------------------------------------*/
/*              7 - TWITTER PLUGIN JQUERY                 */
/*----------------------------------------------------------*/

/*----------------------------------------------------------*/
/*              8 - PORTFOLIO ISOTOPE JQUERY                */
/*----------------------------------------------------------*/
        if ($('#portfolio-container').length && jQuery()) {
            (function () {
                var $container = $('#portfolio-container');
                if ($container.length) {
                    var $itemsFilter = $('#filterable');
                    $('.isotope-item', $container).each(function (i) {
                        var $this = $(this);
                        $this.addClass($this.attr('data-categories'));
                    });
                    $(window).on('load', function () {
                        $container.isotope({
                            itemSelector: '.isotope-item',
                            layoutMode: 'fitRows'
                        });
                    });
                    $itemsFilter.on('click', 'a', function (e) {
                        var $this = $(this),
                         currentOption = $this.attr('data-categories');
                        $itemsFilter.find('a').removeClass('active');
                        $this.addClass('active');
                        if (currentOption) {
                            if (currentOption !== '*') currentOption = currentOption.replace(currentOption, '.' + currentOption)
                            $container.isotope({
                                filter: currentOption,
                                 
                            });
                        }
                        e.preventDefault();
                    } );
                    $itemsFilter.find('a').first().addClass('active');
                }
            })();
        }
/*----------------------------------------------------------*/
/*              9 - RESPONSIVE NAVIGATION                   */
/*----------------------------------------------------------*/
        var $menu_select = $("<select />");
        $("<option />", {
            "selected": "selected",
            "value": "",
            "text": "Main Navigation"
        }).appendTo($menu_select);
        $menu_select.appendTo("#main-navigation");
        $("#main-navigation ul li a").each(function () {
            var menu_url = $(this).attr("href");
            var menu_text = $(this).text();
            if ($(this).parents("li").length == 2) {
                menu_text = '- ' + menu_text;
            }
            if ($(this).parents("li").length == 3) {
                menu_text = "-- " + menu_text;
            }
            if ($(this).parents("li").length > 3) {
                menu_text = "--- " + menu_text;
            }
            $("<option />", {
                "value": menu_url,
                "text": menu_text
            }).appendTo($menu_select)
        })
        field_id = "#main-navigation select";
        $(field_id).change(function () {
            value = $(this).attr('value');
            window.location = value;
        });
/*----------------------------------------------------------*/
/*              10 - MAIN NAVIGATION JS                     */
/*----------------------------------------------------------*/
        $('ul.main-menu').superfish({
            delay: 100, // one second delay on mouseout 
            animation: {
                opacity: 'show',
                height: 'show'
            }, // fade-in and slide-down animation 
            speed: '1000', // faster animation speed 
            autoArrows: false // disable generation of arrow mark-up 
        });
/*----------------------------------------------------------*/
/*              11 - LAYER SLIDER JS                         */
/*----------------------------------------------------------*/
    if ($('#layerslider').length && jQuery()) {
        $('#layerslider').layerSlider({
            width: '100%',
            height: '450px',
            responsive: true,
            responsiveUnder: 940,
            sublayerContainer: 940,
            autoStart: true,
            pauseOnHover: true,
            firstLayer: 1,
            animateFirstLayer: true,
            randomSlideshow: false,
            twoWaySlideshow: true,
            loops: 0,
            forceLoopNum: true,
            autoPlayVideos: false,
            autoPauseSlideshow: 'auto',
            keybNav: true,
            touchNav: true,
            navButtons: true,
            navStartStop: false,
            skin: 'fullwidth',
            skinsPath: homepath+'images/layer-slider/skins/',
        });
    }
/*----------------------------------------------------------*/
/*              12 - FLICKR PHOTOS                           */
/*----------------------------------------------------------*/

/*----------------------------------------------------------*/
/*              13 - INSTAGRAM PHOTOS                        */
/*----------------------------------------------------------*/

/*----------------------------------------------------------*/
/*              14 - SKILLS BAR ANIMATION                   */
/*----------------------------------------------------------*/
        if ($('.bar_graph').length && jQuery()) {
            function animateBar() {
                $('.bar_graph li').each(function (i) {
                    var percent = $(this).find('span').attr('data-width');
                    $(this).find('span').animate({
                        'width': percent + '%'
                    }, 1700, 'easeOutCirc');
                });
            }
            if ($('.bar_graph').length > 0) {
                animateBar();
                $(window).scroll(animateBar);
            }
        }
/*----------------------------------------------------------*/
/*              15 - FLEX SLIDERS                           */
/*----------------------------------------------------------*/
        if ($('.flexslider.team-member-slider').length && jQuery()) {
            var target_flexslider = $('.flexslider.team-member-slider');
            target_flexslider.flexslider({
                animation: "slide",
                controlNav: false,
                animationSpeed: 1500,
                pauseOnHover: true,
                slideshow: false,
                smoothHeight: false,
                pauseOnAction: true
            });
            $(".flexslider.team-member-slider").hover(function () {
                    $('.flexslider.team-member-slider .flex-direction-nav').fadeIn(200);
                },
                function () {
                    $('.flexslider.team-member-slider .flex-direction-nav').fadeOut(200);
             });
        }

        if ($('.flexslider.clients-slider').length && jQuery()) {
            var target_flexslider = $('.flexslider.clients-slider');
            target_flexslider.flexslider({
                animation: "slide",
                controlNav: false,
                animationSpeed: 1500,
                pauseOnHover: true,
                slideshow: false,
                smoothHeight: false,
                pauseOnAction: true
            });
            $(".flexslider.clients-slider").hover(function () {
                    $('.flexslider.clients-slider .flex-direction-nav').fadeIn(200);
                },
                function () {
                    $('.flexslider.clients-slider .flex-direction-nav').fadeOut(200);
            });
        }

        if ($('.flexslider.single-portfolio-item-slider').length && jQuery()) {
            var target_flexslider = $('.flexslider.single-portfolio-item-slider');
            target_flexslider.flexslider({
                animation: "fade",
                controlNav: false
            });
            $(".flexslider.single-portfolio-item-slider").hover(function () {
                    $('.flexslider.single-portfolio-item-slider .flex-direction-nav').fadeIn(200);
                },
                function () {
                    $('.flexslider.single-portfolio-item-slider .flex-direction-nav').fadeOut(200);
             });
        }

        if ($('.flexslider.portfolio-items-slider.fade').length && jQuery()) {
            var target_flexslider = $('.flexslider.portfolio-items-slider.fade');
            target_flexslider.flexslider({
                animation: "fade",
                controlNav: false,
                smoothHeight: false,
                pauseOnHover: true,
                pauseOnAction: true,
                slideshow: false
            });
            $(".flexslider.portfolio-items-slider.fade").hover(function () {
                    $('.flexslider.portfolio-items-slider.fade .flex-direction-nav').fadeIn(200);
                },
                function () {
                    $('.flexslider.portfolio-items-slider.fade .flex-direction-nav').fadeOut(200);
            });    
        }

        if ($('.flexslider.portfolio-items-slider.slide').length && jQuery()) {
            var target_flexslider = $('.flexslider.portfolio-items-slider.slide');
            target_flexslider.flexslider({
                animation: "slide",
                slideshow: false,
                controlNav: true,
                smoothHeight: false,
                pauseOnHover: true,
                
            });
            $(".flexslider.portfolio-items-slider.slide").hover(function () {
                    $('.flexslider.portfolio-items-slider.slide .flex-direction-nav').fadeIn(200);
                },
                function () {
                    $('.flexslider.portfolio-items-slider.slide .flex-direction-nav').fadeOut(200);
            });  
        }

/*----------------------------------------------------------*/
/*              16 - PRETTYPHOTO                             */
/*----------------------------------------------------------*/
        $("a[data-rel^='prettyPhoto']").prettyPhoto({
            overlay_gallery: false
        });
/*----------------------------------------------------------*/
/*              17 - GOOGLE MAPS                             */
/*----------------------------------------------------------*/

/*----------------------------------------------------------*/
/*              18 - JQUERY TABS                            */
/*----------------------------------------------------------*/
        (function () {
            var $tabsNav = $('.tabs-nav'),
                $tabsNavLis = $tabsNav.children('li'),
                $tabContent = $('.tab-content');
            $tabContent.hide();
            $tabsNavLis.first().addClass('active').show();
            $tabContent.first().show();
            $tabsNavLis.on('click', function (e) {
                var $this = $(this);
                $tabsNavLis.removeClass('active');
                $this.addClass('active');
                $tabContent.hide();
                $($this.find('a').attr('href')).fadeIn(700);
                e.preventDefault();
            });
        })();
/*----------------------------------------------------------*/
/*              19 - JQUERY ACCORDION                      */
/*----------------------------------------------------------*/
      if ($('.accordion').length && jQuery()) {
        initAccordion();
        function initAccordion() {
            jQuery('.accordion-item').each(function (i) {
                var item = jQuery(this);
                item.find('.accordion-content').slideUp(0);
                item.find('.accordion-switch').click(function () {
                    var displ = item.find('.accordion-content').css('display');
                    item.closest('ul').find('.accordion-switch').each(function () {
                        var li = jQuery(this).closest('li');
                        li.find('.accordion-content').slideUp(300);
                        jQuery(this).parent().removeClass("selected");
                    });
                    if (displ == "block") {
                        item.find('.accordion-content').slideUp(300)
                        item.removeClass("selected");
                    } else {
                        item.find('.accordion-content').slideDown(300)
                        item.addClass("selected");
                    }
                });
            });
        }
        }
/*----------------------------------------------------------*/
/*              20 - JQUERY CAROUSEL                         */
/*----------------------------------------------------------*/
    if ($('.slidewrap').length && jQuery()) {
        $('.slidewrap').carousel({
                slider: '.slider',
                slide: '.slide',
                slideHed: '.slidehed',
                nextSlide : '.next',
                prevSlide : '.prev',
                addPagination: false,
                addNav : false
            });
    }
/*----------------------------------------------------------*/
/*              21 - CONTACT FORM VALIDATION                */
/*----------------------------------------------------------*/
        if ($('form#contact-form').length && jQuery()) {
            $('form#contact-form').submit(function () {
                function resetForm($form) {
                    $form.find('input:text, input:password, input:file, select, textarea').val('');
                    $form.find('input:radio, input:checkbox')
                        .removeAttr('checked').removeAttr('selected');
                }
                $('form#contact-form .error').remove();
                var hasError = false;
                $('.requiredField').each(function () {
                    if (jQuery.trim($(this).val()) == '') {
                        var formInput = $(this).attr("title");
                        $("#error-field").append('<div class="notification error"><p><i class="icon-warning-sign"></i>Please Enter ' +
                            formInput + '</p></div> ');
                        $(this).addClass('inputError');
                        hasError = true;
                    } else if ($(this).hasClass('email')) {
                        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                        if (!emailReg.test(jQuery.trim($(this).val()))) {
                            var formInput = $(this).attr("title");
                            $("#error-field").append(
                                '<div class="notification error"><p><i class="icon-warning-sign"></i>You entered an invalid Value - ' +
                                formInput + '</p></div>');
                            $(this).addClass('inputError');
                            hasError = true;
                        }
                    }
                });
                if (!hasError) {
                    $('form#contact-form input.submit').fadeOut('normal', function () {});
                    var formInput = $(this).serialize();
                    $.post($(this).attr('action'), formInput, function (data) {
                        $('#contact-form').prepend(
                            '<div class="notification success"><p> <i class="icon-check-sign"></i>Your email was successfully sent. We will contact you as soon as possible.</p></div>'
                        );
                        resetForm($('#contact-form'));
                    });
                }
                return false;
            });
        }
    });
});

jQuery(document).ready(function() {
    jQuery('a.color-box').each(function (i) {
        var a = jQuery(this);
        a.css({
            backgroundColor: '#' + a.attr('data-rel')
        })
    })
    var switcher_skins = jQuery('a.color-box');
    var switcher_link = jQuery('#style-color');
    switcher_skins.each(function(i) {
        var color = jQuery(this).attr('data-rel');


    });

    /*STYLESHEETS LOAD STARTS*/

    switcher_skins.click(function(e) {
        var color = jQuery(this).attr('data-rel');
        var skins;




        if (color == "169fe6") {
            switcher_link.attr('href',homepath+"css/colors/blue-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }



        if (color == "ed5564") {
            switcher_link.attr('href',homepath+"css/colors/soft-red-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }


        if (color == "fb6e52") {
            switcher_link.attr('href',homepath+"css/colors/soft-orange-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if (color == "ffce55") {
            switcher_link.attr('href',homepath+"css/colors/light-yellow-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if (color == "a0d468") {
            switcher_link.attr('href',homepath+"css/colors/light-green-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if (color == "48cfae") {
            switcher_link.attr('href',homepath+"css/colors/light-cyan-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if (color == "50c1e9") {
            switcher_link.attr('href',homepath+"css/colors/light-blue-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }



        if (color == "5d9cec") {
            switcher_link.attr('href',homepath+"css/colors/soft-blue-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }


        if (color == "ac92ed") {
            switcher_link.attr('href',homepath+"css/colors/soft-violet-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if (color == "ec87c1") {
            switcher_link.attr('href',homepath+"css/colors/soft-pink-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }
        if(color=="ff7534"){
            switcher_link.attr('href',homepath+"css/colors/light-orange-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="656d78"){
            switcher_link.attr('href',homepath+"css/colors/dark-grey-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }


        if(color=="363a88"){
            switcher_link.attr('href',homepath+"css/colors/dark-purple-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="00ba84"){
            switcher_link.attr('href',homepath+"css/colors/strong-cyan-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="e33000"){
            switcher_link.attr('href',homepath+"css/colors/strong-orange-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="bf0101"){
            switcher_link.attr('href',homepath+"css/colors/strong-red-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }


        if(color=="c69c6d"){
            switcher_link.attr('href',homepath+"css/colors/light-brown-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }
        if(color=="0054a6"){
            switcher_link.attr('href',homepath+"css/colors/dark-blue-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }


        if(color=="fcaf17"){
            switcher_link.attr('href',homepath+"css/colors/strong-yellow-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }


        if(color=="be3b19"){
            switcher_link.attr('href',homepath+"css/colors/strong-brown-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="7ecdf1"){
            switcher_link.attr('href',homepath+"css/colors/soft-blue-color-2.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="92c924"){
            switcher_link.attr('href',homepath+"css/colors/strong-green-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="fe5b42"){
            switcher_link.attr('href',homepath+"css/colors/bright-red-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }



        if(color=="f20505"){
            switcher_link.attr('href',homepath+"css/colors/vivid-red-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }


        if(color=="ef013f"){
            switcher_link.attr('href',homepath+"css/colors/vivid-pink-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="1bddf2"){
            switcher_link.attr('href',homepath+"css/colors/vivid-cyan-color.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }
        if(color=="c7d93d"){
            switcher_link.attr('href',homepath+"css/colors/bright-green.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }
        if(color=="fe6b34"){
            switcher_link.attr('href',homepath+"css/colors/bright-orange.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="9adada"){
            switcher_link.attr('href',homepath+"css/colors/soft-cyan.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="21262a"){
            switcher_link.attr('href',homepath+"css/colors/very-dark-blue.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="555e7b"){
            switcher_link.attr('href',homepath+"css/colors/desaturated-fark-blue.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="e25527"){
            switcher_link.attr('href',homepath+"css/colors/bright-brown.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="fa381c"){
            switcher_link.attr('href',homepath+"css/colors/vivid-orange.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }


        if(color=="72ac34"){
            switcher_link.attr('href',homepath+"css/colors/moderate-green.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }


        if(color=="ff7c8e"){
            switcher_link.attr('href',homepath+"css/colors/bright-pink.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }


        if(color=="1c7b7f"){
            switcher_link.attr('href',homepath+"css/colors/dark-cyan.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="ac50cc"){
            switcher_link.attr('href',homepath+"css/colors/moderate-violet.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="00ced6"){
            switcher_link.attr('href',homepath+"css/colors/strong-cyan.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="f28b66"){
            switcher_link.attr('href',homepath+"css/colors/pale-orange.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        if(color=="fd665c"){
            switcher_link.attr('href',homepath+"css/colors/pale-red.css");
            var atrrHref = switcher_link.attr('href');
            jQuery('body').css({
                backgroundColor: '#' + color,

            });
        }

        /*STYLESHEETS LOAD ENDS*/

        jQuery.cookie("portable_cookie_color", color);
        jQuery.cookie("portable_cookie_skins", atrrHref);
        return false;

    });

    var color = jQuery.cookie("portable_cookie_color");
    var portable_skins = jQuery.cookie("portable_cookie_skins");

    if (portable_skins) {
        jQuery("#style-color").attr("href", portable_skins);
        jQuery('body').css({
            backgroundColor: '#' + color,

        });
    }


   // var defaultPattern = jQuery.cookie("portable_cookie_defaultBg");
    var color = jQuery.cookie("portable_cookie_color");
    if (color) {
        jQuery('body').css({
            backgroundColor: '#' + color,
        });
    }

    jQuery('#dr_more_select').mouseover(function(){
        jQuery('#dr_more_color').css('display','block');
    }).mouseout(function(){
        jQuery('#dr_more_color').css('display','none');
    });

});