<?php
/**
 * Scripts.
 *
 * @package    Southbridge
 * @author     Travis Smith, for detail communications
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wpsmith.net/
 * @since      1.0.0
 */
 
add_action( 'init', 'sbridge_register_scripts', 9999 );
/**
 * Registers All Scripts to use when needed based on Debugging.
 * Assumes that the normal *.js is the minified version & *-dev.js is beautified version.
 * Includes example for localizing PHP values into JavaScript.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_register_script
 * @uses wp_register_script() Registers javascripts for use with wp_enqueue_script() later.
 * @uses wp_register_style()  Registers styles for use with wp_enqueue_script() later.
 * @uses wp_get_theme()       Gets theme data.
 * @uses WP_DEBUG             Constant: Triggers "debug" mode throughout WordPress
 * @uses WP_SCRIPT_DEBUG      Constant: Forces WordPress to use the "dev" versions of core CSS and Javascript files
 * @uses CHILD_JS           Constant: Southbridge Javascript URL base
 * @uses CHILD_CSS          Constant: Southbridge CSS URL base
 * @since 1.0.0
 */
function sbridge_register_scripts() {
	$suffix = ( WP_DEBUG || WP_SCRIPT_DEBUG ) ? '.js' : '.min.js';
	
	// Frontend Scripts
	//wp_register_script( 'sbridge-font-script', 'http://fast.fonts.com/jsapi/6c3cc8ca-47a5-45c3-b514-e25481917b16.js', '', CHILD_THEME_VERSION, true );
	//wp_register_script( 'sbridge-script', CHILD_JS . '/southbridge' . $suffix, array( 'jquery-ui', ), CHILD_THEME_VERSION, false );
	
	// Frontend Styles
	//wp_register_style( 'sbridge-font-style', 'http://fast.fonts.com/cssapi/6c3cc8ca-47a5-45c3-b514-e25481917b16.css', array(), $theme->version );
	wp_register_style( 'wpui-sbridge', CHILD_CSS . '/wpui-sbridge.css', array(), CHILD_THEME_VERSION );
	
}

add_action( 'wp_print_styles', 'sbridge_print_styles', 9999 );
/**
 * While this is not the recommended approach to enqueuing styles, since wp-ui plugin
 * enqueues their styles at wp_print_styles, we will add our own after to over-write.
 *
 * @since 1.0.0
 */
function sbridge_print_styles() {
	// Did not remove the default style in case user wants to use that style in the future.
	//wp_dequeue_style( 'wpui-light' );
	wp_enqueue_style( 'wpui-sbridge' );
}

add_action( 'wp_enqueue_scripts', 'sbridge_enqueue_scripts', 20 );
/**
 * Enqueue theme scripts.
 *
 * Includes example for localizing PHP values into JavaScript.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @since 1.0.0
 */
function sbridge_enqueue_scripts() {
	$suffix = ( WP_DEBUG || WP_SCRIPT_DEBUG ) ? '.js' : '.min.js';
	
	//wp_enqueue_script( 'sbridge-font-script' );	
	wp_enqueue_script( 'sbridge-script', CHILD_JS . '/southbridge' . $suffix, array( 'jquery' ), CHILD_THEME_VERSION, false);

	wp_dequeue_script( 'superfish-args' );
	wp_enqueue_script( 'sbridge-superfish-args', CHILD_JS . '/superfish.args' . $suffix, array( 'superfish' ), CHILD_THEME_VERSION, true );
}

/**
 * Outputs HTML markup from ShareThis option.
 *
 * @since 1.0.0
 */
function sbridge_social_script() { 
	echo get_option( 'st_widget' );
}

add_action( 'wp_head', 'sbridge_typekit' );
/**
 * Outputs Typekit Script.
 *
 * @since 1.0.0
 */
function sbridge_typekit() { ?>
<script type="text/javascript">
  (function() {
    var config = {
      kitId: 'ymh8bhj',
      scriptTimeout: 3000
    };
    var h=document.getElementsByTagName("html")[0];h.className+=" wf-loading";var t=setTimeout(function(){h.className=h.className.replace(/(\s|^)wf-loading(\s|$)/g," ");h.className+=" wf-inactive"},config.scriptTimeout);var tk=document.createElement("script"),d=false;tk.src='//use.typekit.net/'+config.kitId+'.js';tk.type="text/javascript";tk.async="true";tk.onload=tk.onreadystatechange=function(){var a=this.readyState;if(d||a&&a!="complete"&&a!="loaded")return;d=true;clearTimeout(t);try{Typekit.load(config)}catch(b){}};var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(tk,s)
  })();
</script>
<?php
}