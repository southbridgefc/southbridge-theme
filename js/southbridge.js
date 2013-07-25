'use strict';

function callOut( action ) {
	
	if ( 'times' == action ) {
		jQuery('#blog-call-out .call-out-box').hide( 'fast' );
		jQuery('#twitter-call-out .call-out-box').hide( 'fast' );
		
		jQuery('#service-times-call-out .call-out-box').toggle( 'fast', function() {
			// Animation complete.
		});
	}
	
	if ( 'blog' == action ) {
		jQuery('#twitter-call-out .call-out-box').hide( 'fast' );
		jQuery('#service-times-call-out .call-out-box').hide( 'fast' );
		jQuery('#blog-call-out .call-out-box').toggle( 'fast', function() {
			// Animation complete.
		});
	}
	
	if ( 'twitter' == action ) {
		jQuery('#blog-call-out .call-out-box').hide( 'fast' );
		jQuery('#service-times-call-out .call-out-box').hide( 'fast' );
		jQuery('#twitter-call-out .call-out-box').toggle( 'fast', function() {
			// Animation complete.
		});
	}
	
}

// Responsive: Get Width
jQuery(window).resize(function() {

	// Set size of footer-widgets-*
	selectorSizing( jQuery(this).width() );
});

/*
 * Resizes the selector to the designated size
 *
 * @param int    size     Browser Size to do nothing
 * @param string selector Selector, defaults to '#footer-widgets .widget-area'
 */
function selectorSizing( size ) {
	'use strict'; 

	// size is required
	if ( !size)
		return false;

	// Responsive Code
	// Widgets move to 100% width if width of the browser window is < 960px
	// Done via @media only screen and (max-width: 960px) { } in style.css
	if( 960 < size ) {
		var contentH = jQuery('#content').height();
		var sidebarH = jQuery('#sidebar').height();
		if ( sidebarH > contentH ) {
			jQuery('#content').height(sidebarH);
		}
	}
	else {
		// Remove max height to the selectors
		jQuery('#content').height('auto');
	}
}

jQuery(window).ready(function($) {
	var visitingAreaOpen = false;
	
	// Get current browser width
	var browserWidth = jQuery(window).width();
	selectorSizing( browserWidth );
	
	/** Slider Control Nav */
	var selector = '#home-slider .soliloquy-container .flexslider .flex-control-nav';
	var sliderControlNavWidth = jQuery( selector ).width();
	var sliderControlNav = sliderControlNavWidth/2;
	sliderControlNavWidth++;
	$(selector).attr( 'style', 'width: '+sliderControlNavWidth+'px; display: block; margin-left: -'+sliderControlNav+'px;' );
	
	/** Center Title on Single Post/Page */
	//var selector = '.single .title-wrap,.page .title-wrap';
	//var titleW = $(selector).width();
	//var titleH = $(selector).height();
	//$('.title-wrap').attr( 'style', 'top:50%; left:50%; margin-left:-'+(titleW+200)/2+'px; margin-top:-'+(titleH+50)/2+'px' );
	
	/** For bottom hover carrot */
	$('.call-out-selector').hover(
		function () {
			$(this).addClass("hover");
		},
		function () {
			$(this).removeClass("hover");
		}
	);
	
	/** Search input */
	$('.menu .search a').click( function() {
		$('#header .s').toggle('slide', {direction: 'right'}, 500);
	});
	
	/** Carousel Caption */
	$('#home-carousel .soliloquy-item').hover( 
		function(){
			$('.soliloquy-caption',this).slideDown();
		},
		function(){
			$('.soliloquy-caption',this).slideUp();
	});
	/*
	$('.flexslider-item a').click( function() {
		$(this).parent().addClass("hover");
		$(this).next().slideDown();
		return false;
	});
	
	$('.flexslider-item.hover .soliloquy-caption').click( function() {
		alert('click');
		$(this).parent().removeClass("hover");
		$(this).slideToggle();
		return false;
	});
*/
	
	/** Visiting Bar */
	$('.menu .visiting a').click( function() {
		if (visitingAreaOpen) {
			closeVisitingArea();
		} else {
			openVisitingArea();
		}
		//$('#visiting').slideToggle();
	});
	
	$('#visiting .close').click( function() {
		closeVisitingArea();
		//$('#visiting').slideUp();
	});
	
	function openVisitingArea() {
		console.log('open');
		jQuery('#visiting').slideDown(1000, 'easeOutBounce');
		visitingAreaOpen = true;
	}

	function closeVisitingArea() {
		console.log('close');
		jQuery('#visiting').slideUp(1000, 'easeOutCirc');
		visitingAreaOpen = false;
	}	
});


