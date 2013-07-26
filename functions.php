<?php
/**
 * Custom amendments for the theme.
 *
 * @package    Southbridge
 * @author     Travis Smith, for detail communications
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wpsmith.net/
 * @since      1.0.0
 */

/********************************************************************************/
//DO NOT EDIT! EDITING THIS SECTION CAN HAVE SERIOUS RAMIFICATIONS!.

/** 
 * Start the child engine 
 *
 * Init file contains:
 *  - the WP prevent update function
 *  - Declaration of constants or other files in sbridge_init()
 */
require_once( 'lib/init.php' );

add_action( 'genesis_setup', 'sbridge_setup' );
/**
 * Configure Southbridge, after Genesis has been set up.
 *
 * @since 1.0.0
 */
function sbridge_setup() {
  /** Localization Text Domain */
  load_child_theme_textdomain( 'sbridge', get_stylesheet_directory() . '/languages' );
  
  /** Load Theme Supports */
  add_theme_support( 'custom-background' );
  add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer', ) );
  
  /** Footer Widgets, change 3 to any number, be sure to include styles */
  //add_theme_support( 'genesis-footer-widgets', 3 );
  
  add_theme_support(
    'genesis-custom-header',
    array( // Default values
      'width'                 => 960,
      'height'                => 80,
      'textcolor'             => '333333',
      'no_header_text'        => false,
      'header_image'          => '%s/images/header.png',
      'header_callback'       => 'genesis_custom_header_style',
      'admin_header_callback' => 'genesis_custom_header_admin_style',
    )
  );
  
  /** Remove Genesis Readme */
  remove_theme_support( 'genesis-readme-menu' );
  
  /** Add Style to the editor */
  /** See also lib/admin/admin-functions.php */
  add_editor_style( 'editor-style.css' );
  
  /** Register Custom Sidebars */
  genesis_register_sidebar(
    array(
      'id'          => 'home-slider',
      'name'        => __( 'Home Slider', 'sbridge' ),
      'description' => __( 'Place chosen slider widget in this area.', 'sbridge' ),
    )
  );
  
  genesis_register_sidebar(
    array(
      'id'          => 'home-carousel',
      'name'        => __( 'Home Carousel', 'sbridge' ),
      'description' => __( 'Place chosen carousel widget in this area.', 'sbridge' ),
    )
  );
  
  genesis_register_sidebar(
    array(
      'id'          => 'service-times',
      'name'        => __( 'Service Times', 'sbridge' ),
      'description' => __( 'Place chosen widget in this area for service times.', 'sbridge' ),
    )
  );

  /* @jagcrete - add footer-contact-info widget */
  genesis_register_sidebar(
    array(
      'id'          => 'footer-contact-info',
      'name'        => __( 'Footer Contact Info', 'sbridge' ),
      'description' => __( 'Place chosen widget in this area for contact info to appear in the footer.', 'sbridge' ),     
    )
  );

  
  /** Adjust Genesis Menus */
  add_theme_support(
    'genesis-menus' , 
    array(
      'primary'   => __( 'Primary Navigation Menu', 'sbridge' ),
      'secondary' => __( 'Secondary Navigation Menu', 'sbridge' ),
      'mini'      => __( 'Mini Navigation Menu', 'sbridge' ),
      'footer'    => __( 'Footer Social Navigation Menu', 'sbridge' ), 
    )
  );

  /** Remove three-column layouts */ /* Other layouts: 'full-width-content', 'content-sidebar', 'sidebar-content', */
  foreach( array( 'content-sidebar-sidebar', 'sidebar-sidebar-content', 'sidebar-content-sidebar' ) as $layout )
    genesis_unregister_layout( $layout );
  
  /** Add Image Sizes */
  add_image_size( 'sbridge-slider', 990, 445, true );
  add_image_size( 'sbridge-carousel', 206, 166, true );
  add_image_size( 'sbridge-single-feature', 970, 235, true );
}

/** Load Genesis */
require_once( get_template_directory() . '/lib/init.php' );
/********************************************************************************/

/** Remove edit link on posts */
add_filter( 'genesis_edit_post_link', '__return_false' );

/** Remove Secondary Sidebar */
unregister_sidebar( 'sidebar-alt' );

/** Re-register Secondary Sidebar for Blog Page */
genesis_register_sidebar(
  array(
    'id'          => 'sidebar-alt',
    'name'        => __( 'Blog Sidebar', 'genesis' ),
    'description' => __( 'This is the blog sidebar for the blog page template.', 'genesis' ),
  )
);

/** Remove post meta */
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );

add_action( 'genesis_meta', 'sbridge_viewport_meta_tag' );
/**
 * Add viewport meta tag.
 *
 * @since 1.0.0
 */
function sbridge_viewport_meta_tag() {
  echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';
}

//add_filter( 'genesis_seo_title', 'sbridge_seo_title', 10, 3 );
/**
 * Change title for CSS styling.
 */
function sbridge_seo_title( $title, $inside, $wrap ) {
  /** Build the Title */
  $title = sprintf( '<%s id="title"><a class="logo" href="%s" title="%s"><span class="sb-blue">%s</span><span class="sb-gray">%s</span></a></%s>',
    $wrap,
    trailingslashit( home_url() ), 
    esc_attr( get_bloginfo( 'name' ) ), 
    'southbridge',
    'fellowship',
    $wrap
  );
  return $title;
}







