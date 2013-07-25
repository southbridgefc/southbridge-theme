<?php
/**
 * Custom Home Page.
 *
 * @package    Southbridge
 * @author     Travis Smith, for detail communications
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wpsmith.net/
 * @since      1.0.0
 */
 
/** Remove the Genesis Post Meta */
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );

/** Remove the Share Link */
remove_action( 'genesis_after_loop', 'sbridge_social_link' );
		
add_action( 'genesis_meta', 'sbridge_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 * Force full-width on the home page
 */
function sbridge_home_genesis_meta() {

	if ( is_active_sidebar( 'home-slider' ) || is_active_sidebar( 'home-carousel' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_before_loop', 'sbridge_home', 15 );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

	}
}

/**
 * Custom Home Widgeted HTML Markup
 *
 * @uses genesis_widget_area() Generate Genesis widgetized area.
 */
function sbridge_home() {

	echo '<div id="home-featured" class="clearfix"><div class="wrap">';

		genesis_widget_area( 'home-slider', array(
			'before' => '<div id="home-slider" class="home-widget widget-area">',
		) );

		genesis_widget_area( 'home-carousel', array(
			'before' => '<div id="home-carousel" class="home-widget widget-area">',
		) );

	echo '</div><!-- end .wrap --></div><!-- end #home-featured -->';

}

/** Remove the Default Loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );

genesis();