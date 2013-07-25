<?php
/**
 * Visiting.
 *
 * @package    Southbridge
 * @author     Travis Smith, for detail communications
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wpsmith.net/
 * @since      1.0.0
 */
 
add_action( 'genesis_before', 'sbridge_visiting_before' );
/**
 * Registers All Scripts to use when needed based on Debugging.
 */
function sbridge_visiting_before() { ?>

	<div id="visiting">
		<div class="info">
			<?php
			$page = get_page_by_title( 'Visiting' );
 
			if ( $page ) {
				$classes = get_post_class( '', $page->ID );
				$classes = implode( ' ', $classes );
				$html = '<div class="selected-post ' . $classes . '" id="' . $page->ID . '">';
				$html .= apply_filters( 'the_content', $page->post_content );
				$html .= '<div class="clear"></div>';
				$html .= '</div>';
				
			}
			echo $html;
			?>
		</div>
		<div id="visiting-close">
			<div class="wrap">
			<a class="close" href="#" onclick="return false;">
				<span class="close-text">close</span>
				<span class="close-icon"></span>
			</a>
			</div>
		</div>
	</div>
<?php	
}

add_action( 'wp_print_styles', 'sbridge_wp_ui_scripts', 999 );
function sbridge_wp_ui_scripts() {
	wp_dequeue_script( 'wpui-light-css' );
}
	
//add_action( 'wp_ajax_get_visiting', 'sbridge_get_visiting' );
//add_action( 'wp_ajax_nopriv_get_visiting', 'sbridge_get_visiting' );

function sbridge_get_visiting() {
	/** Do a security check first */
	check_ajax_referer( 'sbridge-nonce', 'nonce' );
	
	//$post_id = #;
	//$page    = get_post( $post_id );
	$page = get_page_by_title( 'Visiting' );
 
	if ( $page ) {
		$response = $page;
		$classes = get_post_class( '', $page->ID );
		$classes = implode( ' ', $classes );
		$response = '<div class="selected-post ' . $classes . '" id="' . $page->ID . '">';
		$response .= apply_filters( 'the_content', $page->post_content );
		$response .= '<div class="clear"></div>';
		$response .= '</div>';
		
	}
	
	/** Send the response back to our script and die */
	echo json_encode( $response );
	die;
}