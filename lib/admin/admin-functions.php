<?php

/**
 * Southbridge Admin Functions
 *
 * This file controls the various front general functions,
 * adds custom header functionality with a default header,
 * adds styles to Tiny MCE, filters favicon, adds a custom 
 * Avatar, ability to change Avatar size, removes version
 * generator (security).
 *
 * @package      Southbridge
 * @author       Travis Smith, for detail communications
 * @copyright    Copyright (c) 2012, Travis Smith
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0.0
 */

/** Table of Contents
 * Editor Style
 * Admin Favicon
 * Admin Footer
 * Genesis Theme Settings
 * Genesis Slider Defaults
 * Avatar
 */

/* Editor Style
------------------------------------------------------------ */

add_filter( 'mce_buttons_3', 'sbridge_mce_buttons_3' );
/**
 * Show the style dropdown on the THIRD row of the editor toolbar.
 *
 * This code also adds the font family and font size dropdowns too, along with a horizontal rule button, and backcolor.
 *
 * @link http://www.tinymce.com/wiki.php/Buttons/controls
 * @param array $buttons Exising buttons
 * @return array $buttons Amended buttons
 */
function sbridge_mce_buttons_3( array $buttons ) {

	$additional_buttons = array( 'styleselect', 'fontselect', 'fontsizeselect', 'hr', 'backcolor' );

	return array_unique( array_merge( $buttons, $additional_buttons ) );

}

add_filter( 'tiny_mce_before_init', 'sbridge_mce_before_init' );
/**
 * Add column entries to the style dropdown.
 *
 * @param array $settings Existing settings for all toolbar items
 * @return array $settings Amended settings
 */
function sbridge_mce_before_init( array $settings ) {

	$style_formats = array(
		array( 'title' => __( 'List Styles', 'sbridge' ), ),
		array(
			'title' => __( 'Space li', 'sbridge' ),
			'block' => 'li',
			'classes' => 'space',
		),
		array(
			'title' => __( 'Number li', 'sbridge' ),
			'block' => 'li',
			'classes' => 'number',
		),
		array(
			'title' => __( 'Alpha li', 'sbridge' ),
			'block' => 'li',
			'classes' => 'alpha',
		),
		array(
			'title' => __( 'Disc li', 'sbridge' ),
			'block' => 'li',
			'classes' => 'disc',
		),
		array(
			'title' => __( 'Circle li', 'sbridge' ),
			'block' => 'li',
			'classes' => 'circle',
		),
		array(
			'title' => __( 'Square li', 'sbridge' ),
			'block' => 'li',
			'classes' => 'square',
		),
		array( 'title' => __( 'Columns', 'sbridge' ), ),
		array(
			'title' => __( 'First Half', 'sbridge' ),
			'block' => 'div',
			'classes' => 'one-half first',
		),
		array(
			'title' => __( 'Half', 'sbridge' ),
			'block' => 'div',
			'classes' => 'one-half',
		),
		array(
			'title' => __( 'First Third', 'sbridge' ),
			'block' => 'div',
			'classes' => 'one-third first',
		),
		array(
			'title' => __( 'Third', 'sbridge' ),
			'block' => 'div',
			'classes' => 'one-third',
		),
		array(
			'title' => __( 'First Quarter', 'sbridge' ),
			'block' => 'div',
			'classes' => 'one-fourth first',
		),
		array(
			'title' => __( 'Quarter', 'sbridge' ),
			'block' => 'div',
			'classes' => 'one-fourth',
		),
		array(
			'title' => __( 'First Fifth', 'sbridge' ),
			'block' => 'div',
			'classes' => 'one-fifth first',
		),
		array(
			'title' => __( 'Fifth', 'sbridge' ),
			'block' => 'div',
			'classes' => 'one-fifth',
		),
		array(
			'title' => __( 'First Sixth', 'sbridge' ),
			'block' => 'div',
			'classes' => 'one-sixth first',
		),
		array(
			'title' => __( 'Sixth', 'sbridge' ),
			'block' => 'div',
			'classes' => 'one-sixth',
		),
	);

	// Check if there are some styles already
	if ( isset( $settings['style_formats'] ) ) {
		// Decode any existing style formats
		$existing_style_formats = json_decode( $settings['style_formats'] );

		// Merge our new formats with any existing formats and re-encode
		$settings['style_formats'] = json_encode( array_merge( (array) $existing_style_formats, $style_formats ) );
	} else {
		$settings['style_formats'] = json_encode( $style_formats );
	}

	return $settings;

}

//add_action( 'admin_head', 'sbridge_admin_favicon' );
/**
 * Adds Admin Favicon
 *
 */
function sbridge_admin_favicon() {
	echo '<link rel="shortcut icon" type="image/x-icon" href="' . SBRIDGE_IMAGES . '/admin-favicon.png" />';
}

add_filter( 'admin_footer_text', 'sbridge_admin_footer' );
/**
 * Modify Admin Footer Text and Logo
 *
 */
function sbridge_admin_footer() {
	echo '<span id="footer-thankyou">Thank you for creating with <a href="http://wordpress.org/">WordPress</a> &amp; <a href="' . CHILD_THEME_URL . '">' . CHILD_THEME_NAME . '</a> designed by <a href="' . CHILD_THEME_URL . '">' . CHILD_DEVELOPER . '</a></span>';
} 

//add_filter( 'genesis_theme_settings_defaults', 'sbridge_genesis_setting_defaults' );
/**
 * Set Primary Navigation default to OFF
 *
 * @param array $defaults Genesis Theme Settings
 * @return array $defaults Modified Genesis Theme Settings
 */
function sbridge_genesis_setting_defaults( $defaults ) {
	$defaults['nav'] = 0;
    return $defaults;
}

//add_filter( 'avatar_defaults', 'sbridge_new_avatar' );
/**
 * Add Custom Avatar (Discussion Settings)
 *
 * @param array $avatar_defaults WordPress default avatars
 * @return array $avatar_defaults Amended defaults
 */
function sbridge_new_avatar( $avatar_defaults ){
	$avatar_defaults[SBRIDGE_IMAGES . '/new_avatar.png'] = __( 'New Avatar Name', 'sbridge' );
	
	return $avatar_defaults;
}

//add_action( 'admin_init', 'sbridge_avatar_default' );
/**
 * Set new avatar to be default. This also assumes that
 * user will never want mystery man to be the default.
 *
 */
function sbridge_avatar_default() {
	$default = get_option( 'avatar_default' );
	if ( ( empty( $default ) ) || ( 'mystery' == $default ) )
		$default = SBRIDGE_IMAGES . '/new_avatar.png';
	update_option( 'avatar_default', $default );
}