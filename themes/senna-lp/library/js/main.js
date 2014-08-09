;(function ($) {

	function is_touch_device() {
	  return !!('ontouchstart' in window) // works on most browsers 
	      || !!('onmsgesturechange' in window); // works on ie10
	};
	/*
	Include here scripts which depends on document elements.
	*/
	$(document).ready(function(){

		$('h1, h2, h3, h4, h5, h6').each(function(){
			if ( $(this).find( 'a[title]').length > 0 ) {
				$(this).find( 'a[title]').bestAmpersand();
			} else {
				$(this).bestAmpersand();
			}
		});

		$('.categories-dropdown-toggle').on('click', function(e) {
			$('.categories-dropdown').toggleClass('is-open');
			e.preventDefault();
			return false;
		});

		$('.search-toggle, .search-remove').on('click', function(e) {
			
			// $('.site-header-wrapper').find('.search-icon').toggleClass('icon-search');
			$('.search-form').toggleClass('is-visible');

			if (!$('.site-header-wrapper').hasClass('search-form-is-visible')) {
				$('.search-form input').trigger('focus');
			} else {
				$('.search-form input').trigger('blur');
			}
			$('.site-header-wrapper').toggleClass('search-form-is-visible');
		});

		//Contact page stuff
		$("textarea").autoresize();

		//Search form
		$('.search-toggle').appendTo('#menu-main-menu').wrap('<li>').css('float', 'left');

		document.onkeydown = function(e) {
			e = e || window.event;
			if (e.keyCode == 27) {
				if ($('.site-header-wrapper').hasClass('search-form-is-visible')) {
					// $('.site-header-wrapper').find('.search-icon').toggleClass('icon-search');
					$('.search-form').toggleClass('is-visible');
					$('.search-form input').trigger('blur');
					$('.site-header-wrapper').toggleClass('search-form-is-visible');
				}
			}
		};

		//Add active class to open sub-menus on responsive navigation
		$('#responsive li.menu-parent-item > a').on('click', function(e) {
			e.preventDefault();
			$('#responsive li.menu-parent-item:not(".active")').removeClass('active');
			$(this).parent().toggleClass('active');
		});

		//Add small class to menu when scroll down
		if (!is_touch_device()) { //Disable on touch devices
			$(window).scroll(function() {
				var scroll_position = $(document).scrollTop();
				if(scroll_position > 0) {
					$('html').addClass('l-header-small');
				} else {
					$('html').removeClass('l-header-small');
				}
			});
		}
		if(Modernizr.mq('screen and (max-width: 400px)')) {
			$('html').addClass('l-header-small');
		}
	});

	var retina = window.devicePixelRatio > 1 ? true : false;
	if (retina && $('.site-logo').data('retina_logo')) {
		$('.site-logo').attr('src', $('.site-logo').data('retina_logo'));
	}

	/*
	Include bellow independent scripts calls.
	*/

	$(document).ready(function(){

		//Parallax header image
		if (Modernizr.csstransitions && !is_touch_device()) {
			var top_header = $('.featured-image');
			$(window).scroll(function () {
			  var st = $(window).scrollTop();
			  top_header.css({
			  	'-webkit-transform': 'translateY(' +  -st / 3 + 'px)',
			  	'-ms-transform': 'translateY(' +  -st / 3 + 'px)',
			  	'transform': 'translateY(' +  -st / 3 + 'px)'
				});	
			});
		}

		//Search Fancy Input Animation (only on browsers that support CSS3 and not on mobile devices)
		if (!is_touch_device() && Modernizr.csstransitions) {
		    $('#header #searchform input.search-query').fancyInput();
		}

	    //Smooth Scroll
	    var $smooth_scroll = $('html').attr('data-smooth-scroll'); 
	    var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod|Macintosh)/g) ? true : false );
		if( $smooth_scroll == 'on' && $(window).width() > 680 && !is_touch_device() && !iOS){ 
			$("html").niceScroll({
		     	zindex: 9999,
		     	cursoropacitymin: 0.3,
		     	cursorwidth: 7,
		     	cursorborder: 0,
		     	mousescrollstep: 40,
		     	scrollspeed: 100
		    });
		}

		//Magnific Popup for Project Page
		$('.portfolio_single_gallery ul').magnificPopup({
		  	delegate: 'li a',
		  	type: 'image',
		  	image: {
		  		 titleSrc: ''
		  	},
		  	gallery: { 
		  		enabled:true
		  	},
			removalDelay: 300,
		  	mainClass: 'pxg-slide-bottom'
		});

		//Magnific Popup for any other <a> tag that link to an image
		$('.single-post a[href$=".jpg"], .single-post a[href$=".png"], .page a[href$=".jpg"], .page a[href$=".png"]').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			closeBtnInside: false,
			removalDelay: 300,
		  	mainClass: 'pxg-slide-zoom',
			image: {
				verticalFit: true
			},
			gallery: { 
		  		// enabled:true
		  	}
		});

		// Shortcodes
		// Circle
		 $(".dial").knob({
		 	readOnly: true,
		 	thickness: 0.10,
		 	bgColor: "#e8e8e8",
		 	skin: "tron",
		 	width: 240,
		 	height: 240, 
		 	cursor: false
		 });

		if (!iOS) {
			$('body').addClass('not-ios');
		}

		//MediaPlayerJS plugin for audio and video
		$('audio, video').mediaelementplayer({
			videoWidth: '100%',
			videoHeight: '100%',
			audioWidth: '100%',
			features: ['playpause','progress','tracks','volume','fullscreen'],
			videoVolume: 'horizontal',
			enableAutosize: true,
            success: function(mediaElement, domObject){

                var slider = $(domObject).parents('.flexslider');
                if ( slider.length > 0 ) {
                    $(mediaElement).on('playing' , function(){
                        slider.flexslider('pause');
                    });

                    $(mediaElement).on('pause' , function(){
                        slider.flexslider('play');
                    });
                }
            }
		});
	
		//One Slide Case
	    if(($('.flexslider .slides').children().length) == 1) {
	        $('.flexslider .slides .slide').addClass('flex-active-slide');
	    }

		//Call FlexSlider
		$('.flexslider').flexslider({
	        animation: "fadecss",
	        controlNav: false,
	        useCSS: false,
	        smoothHeight: false,  
	        animationSpeed: 1000,
	        video: true,
	        pauseOnHover: false,
	        slideshow: true,
	        before: function(slider){

	            // when we change a slide we need to stop the playing video
	            var vimeo_frame = slider.slides.eq(slider.currentSlide).find('iframe.vimeo_frame'),
	                youtube = slider.slides.eq(slider.currentSlide).find('.youtube_frame'),
	                mejs_container = slider.slides.eq(slider.currentSlide).find('.mejs-container');

	            if ( youtube.length !== 0)
	                youtube[0].contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');

	            if ( vimeo_frame.length !== 0)
	                $f(  vimeo_frame.attr('id') ).api('pause');


	            if ( mejs_container.length !== 0) {
	                $(mejs_container).find('video')[0].pause();
	            }
	             $(window).trigger('resize focus');
	             slider.slides.removeClass('s-hidden');   
	        },
	        after: function(slider) {
	        	slider.slides.not(':eq('+slider.currentSlide+')').addClass('s-hidden');
	        },
	        start: function(slider) {
	        	slider.slides.not(':eq('+slider.currentSlide+')').addClass('s-hidden');
	        }
	    });
	    //Responsive Videos
	   	$(".slide-video").fitVids();
   	});


})(jQuery);

jQuery(window).load(function() {

    var vimeoPlayers = jQuery('.flexslider').find('iframe.vimeo_frame'), player;
    for (var i = 0, length = vimeoPlayers.length; i < length; i++) {
        player = vimeoPlayers[i];
        $f(player).addEvent('ready', ready);
    }

    function addEvent(element, eventName, callback) {
        if (element.addEventListener) {
            element.addEventListener(eventName, callback, false)
        } else {
            element.attachEvent(eventName, callback, false);
        }
    }

    function ready(player_id) {

        var froogaloop = $f(player_id);
        froogaloop.addEvent('play', function(data) {
            jQuery('.flexslider').flexslider('pause');
        });
        froogaloop.addEvent('pause', function(data) {
            jQuery('.flexslider').flexslider('play');
        });
    }

    function create_youtube_player(self){
        var this_player = new YT.Player(jQuery(self).attr('id'), {
            videoId: jQuery(self).data('ytid'),
            playerVars: { 'controls': 1, 'modestbranding': 1, 'showinfo': 0 },
            events: {

                'onStateChange': function (event) {
                    if (event.data == YT.PlayerState.PLAYING ) {
                        // Pause Slider while Playing the Video
                        jQuery('.flexslider').flexslider("pause");
                    }
                    if (event.data == YT.PlayerState.PAUSED ) {
                        // Play Slider while Video is paused
                        jQuery('.flexslider').flexslider("play");
                    }
                }
            }
        });

    }


    jQuery('.youtube_frame').each(function(){
        self = this;
        create_youtube_player(self);
        jQuery(".slide-video").fitVids();
    });
});

function popitup(url, title) {
	var w = 550;
	var h = 400;
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	newwindow = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	if (window.focus) {newwindow.focus()}
	return false;
}