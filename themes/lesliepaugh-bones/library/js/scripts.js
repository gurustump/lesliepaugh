/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/


/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y }
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;


/*
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/

/*
 * We're going to swap out the gravatars.
 * In the functions.php file, you can see we're not loading the gravatar
 * images on mobile to save bandwidth. Once we hit an acceptable viewport
 * then we can swap out those images since they are located in a data attribute.
*/
function loadGravatars($) {
  // set the viewport using the function above
  viewport = updateViewportDimensions();
  // if the viewport is tablet or larger, we load in the gravatars
  if (viewport.width >= 768) {
  $('.comment img[data-gravatar]').each(function(){
    $(this).attr('src',$(this).attr('data-gravatar'));
  });
	}
} // end function
function adjustSliderSize(slider,$) {
	var sliderPanel = slider.find('.SLIDER_PANEL');
	sliderPanel.add('.SLIDER_CONTAINER').height(sliderPanel.width() * 2 / 3);
	slider.animate({'opacity':1},500);
}
function changeSlide(slider,direction,$) {
	var thisSlide = slider.find('.SLIDER_PANEL > li.active');
	var prevSlide = thisSlide.prev().length > 0 ? thisSlide.prev() : slider.find('.SLIDER_PANEL > li:last-child');
	var nextSlide = thisSlide.next().length > 0 ? thisSlide.next() : slider.find('.SLIDER_PANEL > li:first-child');
	thisSlide.removeClass('active');
	if (direction =="next") {
		nextSlide.addClass('active');
	} else {
		prevSlide.addClass('active');
	}
}
var autoslide;
function slider(slider,$) {
	$('body').data('activeSlider',slider);
	adjustSliderSize(slider,$);
	autoSlide = setInterval(function() {
		changeSlide(slider,'next',$);
	}, 7000);
	slider.find('.PREV,.NEXT').click(function(e) {
		e.preventDefault();
		clearInterval(autoSlide);
		var direction = $(this).hasClass('NEXT') ? 'next' : 'prev';
		changeSlide(slider,direction,$);
	});
	$(window).resize(function () {
		waitForFinalEvent( function() {
			adjustSliderSize($('body').data('activeSlider'));
		}, timeToWaitForLast, "slider-panel-resize");
	});
}

function projectMenu($) {
	$('.PROJECTS > a').click(function(e) {
		e.preventDefault();
		var projectsList = $('.PROJECTS_LIST');
		projectsList.toggleClass('active');
		if ($(window).height() < projectsList.offset().top + projectsList.outerHeight()) {
			$('body,html').animate({scrollTop:projectsList.offset().top + projectsList.outerHeight() - $(window).height()},300)
		}
	});
}

function resizeContactForm($) {
	$('.contact-container').height($(window).height() - ($('.header').outerHeight() * 2) -50)
}


/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {

	/*
	* Let's fire off the gravatar function
	* You can remove this if you don't need it
	*/
	loadGravatars($);
	
	$('.NAV_SHOW').click(function(e) {
		e.preventDefault();
		$('#main_nav').toggleClass('active').removeClass('trans-complete');
		$('#container').toggleClass('nav-active');
		setTimeout(function() {
			$('#main_nav').toggleClass('trans-complete');
		}, 500);
	});
	$('.TOP_NAV a').click(function() {
		$('#main_nav').removeClass('active trans-complete');
		$('#container').removeClass('nav-active');
		setTimeout(function() {
			$('#main_nav').toggleClass('trans-complete');
		}, 500);
	});
	
	if ( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
	if ( typeof is_project === "undefined" ) var is_project = $('body').hasClass('single-project');
	if ( typeof is_contact === "undefined" ) var is_contact = $('body').hasClass('page-contact');
	
	if ( is_home ) {
		slider($('.HOME_SLIDER'),$);
		projectMenu($);
		/*$('.PROJECTS_LIST a').click(function(e) {
			e.preventDefault();
			$('body').data('activeSlider').animate({'opacity':0},500);
			clearInterval(autoSlide)
			slider($('.'+$(this).attr('id').replace('subnav_','PROJECT_SLIDER_')),$);
		});*/
	}
	
	if (is_project) {
		slider($('.PROJECT_SLIDER'),$);
	}
	
	if (is_contact) {
		resizeContactForm($);
		$(window).resize(function () {
			waitForFinalEvent( function() {
				resizeContactForm($);
			}, timeToWaitForLast, "contact-page-resize");
		});
		$('.EMAIL_FORM').click(function(e) {
			e.preventDefault();
			$('.wpcf7').toggleClass('active');
			$('.contact-links').toggleClass('inactive');
		})
	}
	
	$('.VID_OV').dialog({
		autoOpen:false,
		dialogClass:'vid-ov-wrap',
		modal:true,
		hide:130,
		show:250,
		open: function(e,ui) {
			thisDialog = $(this);
			thisDialog.addClass('OPEN');
			console.log(thisDialog.find('input.VIDSRC').val());
			if (thisDialog.find('input.VIDSRC').val() != '') {
				thisDialog.find('.VID_CONTAINER').html(thisDialog.find('input.VIDSRC').val());
			}
			$('.ui-widget-overlay').click(function() {
				thisDialog.dialog('close');
			});
		},
		close: function(e,ui) {
			$(this).removeClass('OPEN').find('.VID_CONTAINER').empty();
		},
		width:'auto'
	});
	
	$('.TRIGGER_VID_OV').click(function(e) {
		e.preventDefault();
		$($(this).attr('href')).dialog('open');
	});

}); /* end of as page load scripts */

