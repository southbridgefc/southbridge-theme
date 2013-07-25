<?php

/** Move Footer */
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

add_action( 'wp_footer', 'sbridge_do_bottom' );
add_action( 'wp_footer', 'genesis_footer_widget_areas' );
add_action( 'wp_footer', 'genesis_footer_markup_open' );
add_action( 'wp_footer', 'genesis_do_footer' );
add_action( 'wp_footer', 'sbridge_do_footer_social' );
add_action( 'wp_footer', 'genesis_footer_markup_close' );

function sbridge_do_bottom() { ?>
	<div id="sbridge-bottom">
		<div class="wrap">
			<div class="call-outs">
				<div id="twitter-call-out">
					<div class="call-out-box" style="display:none;"> 
					<?php
						$status = sbridge_get_tweet();
						if ( is_object( $status ) && isset( $status->status->text ) ):
						?>
							<div class="tweet"><?php echo genesis_tweet_linkify( $status->status->text ); ?></div>
							<div class="tweet-date"><?php echo sbridge_how_long_ago( $status->status->created_at ); ?></div>
							<a class="tweet-more" href="http://twitter.com/southbridgefc/status/<?php echo $status->status->id_str; ?>">
								<span class="read-more"></span><span class="more-text">more</span>
							</a>
						<?php else: ?>
							<div class="tweet">Tweet! Tweet!</div>
							<div class="tweet-date">Twitter's broke!</div>
							<a class="tweet-more" href="http://twitter.com/southbridgefc/">
								<span class="read-more"></span><span class="more-text">more</span>
							</a>
						<?php endif; ?>
					</div>
					<a class="call-out-selector" href="#" onclick="callOut('twitter'); return false;">
						<div class="call-out twitter">
							<p class="pop-up">twitter</p>
						</div>
					</a>
				</div>
				<div id="blog-call-out">
					<div class="call-out-box" style="display: none;">
					<?php $post = get_posts( array( 'numberposts' => 1 ) ); ?>
						<div class="post-title">
						<?php //wps_printr( $post ); ?>
						<?php echo $post[0]->post_title; ?>
						</div>
						<div class="post-info">
						<?php 
						//$date   = $post[0]->post_modified ? $post[0]->post_modified : $post[0]->post_date; 
						$author = new WP_User( $post[0]->post_author );
						?>
						<span class="post-author">post by <?php echo strtolower( $author->data->display_name ); ?></span> <span class="post-date"><?php echo strtolower( get_the_time( 'F n', $post[0]->ID ) ); ?></span>
						</div>
						<a class="blog-more" href="<?php echo get_permalink( $post[0]->ID ); ?>">
							<span class="read-more"></span><span class="more-text">more</span>
						</a>
					</div>
					<a class="call-out-selector" href="#" onclick="callOut('blog'); return false;">
						<div class="call-out blog">
							<p class="pop-up">the blog</p>
						</div>
					</a>
				</div>
				<?php
				if ( is_active_sidebar( 'service-times' ) ) :
				?>
				<div id="service-times-call-out">
					<div class="call-out-box" style="display: none;">
						<?php genesis_widget_area(
							'service-times',
							array(
								'before' => '<div class="service-times widget-area">',
							)
						); ?>
					</div>
					<a class="call-out-selector" href="#" onclick="callOut('times'); return false;">
						<div class="call-out service-times">
							<p class="pop-up">service times</p>
						</div>
					</a>
				</div>
				<?php
				endif;
				?>
			</div>
		</div>
	</div>
<?php
}

add_filter( 'genesis_footer_output', 'child_footer_output', 10, 3 );
/** 
 * Customize the entire footer
 */
function child_footer_output( $output, $backtotop_text, $creds_text ) {
	genesis_widget_area(
		'footer-contact-info',
		array(
			'before' => '<div class="creds">'
		)
	);
	return '';
}