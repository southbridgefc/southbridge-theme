<?php

/**
 * Get latest tweet.
 *
 * @param  string $userid Defaults to southbridgefc.
 * @return StdClass Obj 
 * stdClass Object
(
    [id] => 375946119
    [id_str] => 375946119
    [name] => Southbridge
    [screen_name] => southbridgefc
    [location] => Brier Creek in Raleigh, NC
    [url] => http://www.southbridgefellowship.com
    [description] => Connecting people to Jesus for life change
    [protected] => 
    [followers_count] => 70
    [friends_count] => 66
    [listed_count] => 0
    [created_at] => Mon Sep 19 01:15:44 +0000 2011
    [favourites_count] => 0
    [utc_offset] => -18000
    [time_zone] => Quito
    [geo_enabled] => 1
    [verified] => 
    [statuses_count] => 138
    [lang] => en
    [status] => stdClass Object
        (
            [created_at] => Wed Oct 17 15:30:34 +0000 2012
            [id] => 258590835929645057
            [id_str] => 258590835929645057
            [text] => You're invited to a dessert event with Pastor Scott! http://t.co/wzYM905V
            [source] => <a href="http://www.icontact.com" rel="nofollow">iContact's Social Tools</a>
            [truncated] => 
            [in_reply_to_status_id] => 
            [in_reply_to_status_id_str] => 
            [in_reply_to_user_id] => 
            [in_reply_to_user_id_str] => 
            [in_reply_to_screen_name] => 
            [geo] => 
            [coordinates] => 
            [place] => 
            [contributors] => 
            [retweet_count] => 0
            [favorited] => 
            [retweeted] => 
            [possibly_sensitive] => 
        )

    [contributors_enabled] => 
    [is_translator] => 
    [profile_background_color] => 1A1B1F
    [profile_background_image_url] => http://a0.twimg.com/profile_background_images/552805722/background-beige.jpg
    [profile_background_image_url_https] => https://si0.twimg.com/profile_background_images/552805722/background-beige.jpg
    [profile_background_tile] => 1
    [profile_image_url] => http://a0.twimg.com/profile_images/2221329419/brown_banner_normal.jpg
    [profile_image_url_https] => https://si0.twimg.com/profile_images/2221329419/brown_banner_normal.jpg
    [profile_banner_url] => https://si0.twimg.com/profile_banners/375946119/1349812869
    [profile_link_color] => 2FC2EF
    [profile_sidebar_border_color] => 181A1E
    [profile_sidebar_fill_color] => 252429
    [profile_text_color] => 666666
    [profile_use_background_image] => 1
    [default_profile] => 
    [default_profile_image] => 
    [following] => 
    [follow_request_sent] => 
    [notifications] => 
)
 */
function sbridge_get_tweet( $userid = 'southbridgefc' ) {
	$key = 'sbridge_latest_tweet';
	delete_transient( $key );
	$status = get_transient( $key );
	$status = false;
	if ( $status !== false ) {
		return $status;
	}
	else {
		// If there's no cached version we ask Twitter
		$response = wp_remote_get( "http://api.twitter.com/1/users/show.json?screen_name={$userid}" );
		$json = json_decode( wp_remote_retrieve_body( $response ) );
		
		// In case Twitter is down we return the last successful count
		if ( is_wp_error( $response ) || isset( $json->error ) ) {
			return get_option( $key );
		}
		else {
			// If everything's okay, parse the body and json_decode it
			// Store the result in a transient, expires after 1 day
			// Also store it as the last successful using update_option
			set_transient( $key, $json, 60 * 60 * 24 );
			update_option( $key, $json);
			return $json;
		}
	}
}

function sbridge_how_long_ago( $twitter_timestamp ){
	
	$datetime = strtotime( $twitter_timestamp );
	
	$difference = current_time( 'timestamp' ) - $datetime;

	if ( $difference >= 60 * 60 * 24 * 365 ) {          // if more than a year ago
		$int = intval( $difference / ( 60 * 60 * 24 * 365 ) );
		$s   = ( $int > 1 ) ? 's' : '';
		$r   = $int . ' year' . $s . ' ago';
	} elseif ( $difference >= 60 * 60 * 24 * 7 * 5 ) {  // if more than five weeks ago
		$int = intval( $difference / ( 60 * 60 * 24 *30 ) );
		$s   = ( $int > 1 ) ? 's' : '';
		$r   = $int . ' month' . $s . ' ago';
	} elseif ( $difference >= 60 * 60 * 24 * 7 ) {      // if more than a week ago
		$int = intval( $difference / ( 60 * 60 * 24 * 7 ) );
		$s   = ( $int > 1) ? 's' : '';
		$r   = $int . ' week' . $s . ' ago';
	} elseif ( $difference >= 60 * 60 * 24 ) {          // if more than a day ago
		$int = intval( $difference / ( 60 * 60 * 24 ) );
		$s   = ( $int > 1 ) ? 's' : '';
		$r   = $int . ' day' . $s . ' ago';
	} elseif ( $difference >= 60*60 ) {                 // if more than an hour ago
		$int = intval($difference / ( 60 * 60 ) );
		$s   = ( $int > 1 ) ? 's' : '';
		$r   = $int . ' hour' . $s . ' ago';
	} elseif ( $difference >= 60 ) {                    // if more than a minute ago
		$int = intval( $difference / ( 60 ) );
		$s   = ( $int > 1) ? 's' : '';
		$r   = $int . ' minute' . $s . ' ago';
	} else {                                            // if less than a minute ago
		$r = 'moments ago';
	}

	return $r;
}
