<?php

/**
 * Init File
 *
 * This file defines the Child Theme's constants & tells WP not to update.
 *
 * @package      Southbridge
 * @author       Travis Smith, for detail communications
 * @copyright    Copyright (c) 2012, Travis Smith
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0.0
 */
 
add_action( 'genesis_init', 'sbridge_constants', 15 );
/**
 * This function defines the Genesis Child theme constants
 *
 * @since 1.0.0
 */
function sbridge_constants() {
	$theme = wp_get_theme();

	// Child theme (Change but do not remove)
		/** @type constant Child Theme Options/Settings. */
		define( 'CHILD_SETTINGS_FIELD', $theme->get('TextDomain') . '-settings' );
		
		/** @type constant Child Theme Version. */
		define( 'CHILD_THEME_VERSION', $theme->Version );
		
		/** @type constant Child Theme Name, used in footer. */
		define( 'CHILD_THEME_NAME', $theme->Name );
		
		/** @type constant Child Theme URL, used in footer. */
		define( 'CHILD_THEME_URL', $theme->get('ThemeURI') );
		
	// Developer Information, see lib/admin/admin-functions.php
		/** @type constant Child Theme Developer, used in footer. */
		define( 'CHILD_DEVELOPER', $theme->Author );
		
		/** @type constant Child Theme Developer URL, used in footer. */
		define( 'CHILD_DEVELOPER_URL', $theme->{'Author URI'}  );
		
	// Define Directory Location Constants
		/** @type constant Child Theme Library/Includes URL Location. */
		define( 'CHILD_LIB_DIR',    CHILD_DIR . '/lib' );
		
		/** @type constant Child Theme Images URL Location. */
		define( 'CHILD_IMAGES_DIR', CHILD_DIR . '/images' );
		
		/** @type constant Child Theme Admin URL Location. */
		define( 'CHILD_ADMIN_DIR',  CHILD_LIB_DIR . '/admin' );
		
		/** @type constant Child Theme JS URL Location. */
		define( 'CHILD_JS_DIR',     CHILD_DIR .'/js' );
		
		/** @type constant Child Theme JS URL Location. */
		define( 'CHILD_CSS_DIR',    CHILD_DIR .'/css' );
	
	// Define URL Location Constants
		/** @type constant Child Theme Library/Includes URL Location. */
		define( 'CHILD_LIB',    CHILD_URL . '/lib' );
		
		/** @type constant Child Theme Images URL Location. */
		define( 'CHILD_IMAGES', CHILD_URL . '/images' );
		
		/** @type constant Child Theme Admin URL Location. */
		define( 'CHILD_ADMIN',  CHILD_LIB . '/admin' );
		
		/** @type constant Child Theme JS URL Location. */
		define( 'CHILD_JS',     CHILD_URL .'/js' );
		
		/** @type constant Child Theme JS URL Location. */
		define( 'CHILD_CSS',    CHILD_URL .'/css' );
}

add_action( 'genesis_init', 'sbridge_init', 15 );
/**
 * This function calls necessary child theme files
 *
 * @since 1.0.0
 */
function sbridge_init() {

	/** Theme Specific Functions */
	//include_once( CHILD_DIR . '/lib/functions/CHILD-functions.php' );	
	
	include_once( CHILD_LIB_DIR . '/functions/scripts.php' );	
	include_once( CHILD_LIB_DIR . '/functions/functions.php' );	
	include_once( CHILD_LIB_DIR . '/functions/footer.php' );	
	include_once( CHILD_LIB_DIR . '/functions/twitter.php' );	
	include_once( CHILD_LIB_DIR . '/functions/menu.php' );	
	include_once( CHILD_LIB_DIR . '/functions/visiting.php' );	
	
	/** Remove Widgets */
	//include_once( CHILD_LIB_DIR . 	'/widgets/widgets.php' );
	
	// Load admin files when necessary
	if ( is_admin() ) {
		/** Require Plugins using TGMPA */
		include_once( CHILD_LIB_DIR . '/tgmpa/plugins.php' );
		
		/** Settings */
		include_once( CHILD_LIB_DIR . '/admin/admin-functions.php');
		
	}
	
}

add_filter( 'http_request_args', 'sbridge_prevent_theme_update', 5, 2 );
/**
 * Don't update theme from .org repo.
 *
 * If there is a theme in the repo with the same name,
 * this prevents WP from prompting an update.
 *
 * @since 1.0.0
 *
 * @author Mark Jaquith
 * @link   http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 */
function sbridge_prevent_theme_update( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}
