<?php

add_action( 'genesis_before_footer', 'sbridge_clear', 1 );
/** 
 * Clear
 */
function sbridge_clear() {
	echo '<div class="clear"></div>';
}

add_action( 'genesis_before_content_sidebar_wrap', 'sbridge_single_featured_image' );
/** 
 * Add featured image to single post pages.
 */
function sbridge_single_featured_image() {
	
	if ( ! has_post_thumbnail() || is_home() || is_front_page() ) return;
	
	the_post_thumbnail( 'sbridge-single-feature', array( 'class' => 'single-feature aligncenter' ) );
}

add_action( 'genesis_before', 'sbridge_before' );
/** 
 * Move Title
 */
function sbridge_before() {
	if ( is_home() || is_front_page() ) return;
	//if ( has_post_thumbnail() )
		//add_action( 'genesis_before_content_sidebar_wrap', 'sbridge_do_post_title' );
	
	if ( is_page( 'blog' ) || is_page_template( 'page_blog.php' ) )
		add_action( 'genesis_before_content_sidebar_wrap', 'sbridge_do_mini_menu' );
}

/** 
 * Get Parent Title
 */
function sbridge_do_post_title() {
	echo '<div class="title-wrap">';
	genesis_do_post_title();
	echo '</div>';
}

add_filter( 'genesis_post_info', 'sbridge_post_info' );
/**
 * Customize the post info function
 */
function sbridge_post_info($post_info) {
	if ( ! is_page() ) {
		$post_info = '[post_author_posts_link before="By "] [post_date format="F j"] [post_categories before=""]';
		return $post_info;
	}
}

add_action( 'genesis_after_loop', 'sbridge_social_link' );
function sbridge_social_link() {
	
	echo 
	'<p class="st">
		<span class="st_sharethis_custom">
			<span class="plus">&#43;</span>
		</span>
		<span class="st_sharethis_custom text">
			share
		</span>
	</p>';
}

add_filter( 'tgmsp_caption_output', 'sbridge_caption_output', 10, 3 );
function sbridge_caption_output( $output, $id, $image ) {
	if ( 7 != $id ) return;
	return '<div class="soliloquy-caption"><div class="soliloquy-caption-inside">' . $image['caption'] . '<br /><span class="plus-box"></span></div></div>';
}

add_action( 'genesis_after_header', 'sbridge_change_sidebar' );
/**
 * Swap Primary and Blog Sidebars
 *
 */
function sbridge_change_sidebar() {
	global $post;
	if ( is_page( 'blog' ) || is_page_template( 'page_blog.php' ) || ( is_single() && 'post' == $post->post_type ) ) {
		// Remove the Primary Sidebar from the Primary Sidebar area.
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

		// Remove the Secondary Sidebar from the Secondary Sidebar area.
		remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );

		// Place the Secondary Sidebar into the Primary Sidebar area.
		add_action( 'genesis_sidebar', 'genesis_do_sidebar_alt' );

		// Place the Primary Sidebar into the Secondary Sidebar area.
		add_action( 'genesis_sidebar_alt', 'genesis_do_sidebar' );
	}
}