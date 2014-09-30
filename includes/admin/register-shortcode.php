<?php
if ( ! function_exists( 'get_the_content_with_formatting' ) ) {
	function get_the_content_with_formatting ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
		$content = get_the_content($more_link_text, $stripteaser, $more_file);
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		return $content;
	}
}

				function getCurrentUrl() {
			        $url  = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http';
			        $url .= '://' . $_SERVER['SERVER_NAME'];
			        $url .= in_array( $_SERVER['SERVER_PORT'], array('80', '443') ) ? '' : ':' . $_SERVER['SERVER_PORT'];
			        $url .= $_SERVER['REQUEST_URI'];
			        return $url;
			    }

// Check if the function is already called
if ( ! function_exists( 'ebss_buttons_shortcode' ) ) {

// Add Shortcode
	function ebss_buttons_shortcode( $atts ) {
		ob_start();
		$ebss_prefix = '_ebss_';
		$shortout = "";
		// Attributes
		extract( shortcode_atts(
			array(
				'type' => 'eros-buttons',
				'order' => 'ASC',
				'orderby' => $ebss_prefix . 'test_datetime_timestamp',
				'buttons_type' => '',
				'post_limit' => '-1',
			), $atts, 'ebss-buttons' )
		);

		// WP_Query arguments
		$ebss_args = array (
			'post_type'              => $type,
			'meta_key'				 => $ebss_prefix . 'test_datetime_timestamp',
			'order'                  => $order,
			'orderby'                => $orderby,
			'meta_query'             => array(
			 	array(
					'key' => $ebss_prefix . 'test_datetime_timestamp',
					'value' => time(),
					'compare' => '>'
				)
			 ),
			'eros-buttons-type' 	 => $buttons_type,
			'posts_per_page'         => $post_limit,
			'cache_results'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => true,
			'no_found_rows' 		 => true,
			'pagination'             => true,
	        // 'nopaging' => true, // This causes posts_per_page not to work as expected.
		);

		// The Query
		$ebss_query = new WP_Query( $ebss_args );

		// The Loop
		if ( $ebss_query->have_posts() ) {

			global $post;

			// Prefix for metaboxes
			$shortout .= "<div class=\"buttons-listing\">";

			while ( $ebss_query->have_posts() ) {
				$ebss_query->the_post(); 
				//Declare Variables to Use (for metaboxes)
				
				// $tzTime = current_time('F d, Y h:i a');
				if ( get_post_meta( $post->ID, $ebss_prefix . '_buttons_timezone', true ) ) {
        			$time_zone = get_post_meta( $post->ID, $ebss_prefix . '_buttons_timezone', true );
				}

				if ( get_post_meta( $post->ID, $ebss_prefix . 'test_datetime_timestamp', true ) ) {
					$just_datetime = get_post_meta( $post->ID, $ebss_prefix . 'test_datetime_timestamp', true );
    				$the_selected_datetime = date('F d, Y h:i a', $just_datetime);
    			}

    			if ( get_post_meta( $post->ID, $ebss_prefix . 'url', true ) ) { 
    				$registration_url = get_post_meta( $post->ID, $ebss_prefix . 'url', true );
    			}

    			$tzTime = $the_selected_datetime;

			if (strpos($time_zone,'UTC') === 0) { //check if UTC time
	
				$utc_offset = substr($time_zone, 3); //get utc offset; 
	
				$utc_offset = preg_replace('/[^0-9]/', '', $utc_offset) * 3600; //convert hours to seconds
	
				$time_zone = timezone_name_from_abbr(null, $utc_offset, true); //get timezone from utc offset
	 
			} 

				$sourceTimeZone = new DateTimeZone($time_zone);
				$tzDate = DateTime::createFromFormat('F d, Y h:i a', $tzTime, $sourceTimeZone);
				$the_current_time = current_time('F d, Y h:i a');

				$current_uri = getCurrentUrl();
				$buttons_link = $current_uri . '#buttons-' . $post->ID;
				$title_length = strlen(get_the_title($post->ID));
				$desired_title_length = 90;
				$tweet_title = get_the_title($post->ID);
				$tweent_via = "SageAlchemex";
				$tweet_related = "SageAlchemex, SageNAmerica";

				if ($title_length > $desired_title_length) {
					$tweet_title = preg_replace('/\s+?(\S+)?$/', '...', substr(get_the_title($post->ID), 0, ($desired_title_length - 3)));
				}


					$shortout .= "<div id='buttons-" . $post->ID . "' class='" . implode(' ', get_post_class('single-buttons')) ."' >";
					$shortout .= the_title('<h3 class="buttons-title">', '<a id="ebss-anchor" href="#buttons-' . $post->ID . '" ></a><a class="buttons-twitter" rel="nofollow" href="https://twitter.com/intent/tweet?url=' . urlencode($buttons_link) . '&text=' . urlencode($tweet_title) . '&via=' . urlencode($tweent_via) . '&related='. urlencode($tweet_related)  . '" title="Share on Twitter" target="_blank"></a><a class="buttons-facebook" rel="nofollow" href="http://www.facebook.com/sharer.php?u=' . urlencode($buttons_link) . '&amp;p[summary]=' . urlencode($tweet_title) . '" title="Share this post on Facebook" target="_blank"></a></h3>', false);


	    			
	    			if ( get_post_meta( $post->ID, $ebss_prefix . 'timezonetype_checkbox', true ) ) {
	    				$chosen_timezone = get_post_meta( get_the_ID(), $ebss_prefix . 'timezone_repeat_group', true );
	    				
	    				$shortout .= "<div class=\"buttons-timezones\">";

							$shortout .= '<a class="wcbtn wcbtn-block wcbtn-darkgrey" href="'.$registration_url.'"><span class="buttons-register"></span> Register Now</a><br />';
							/*
$shortout .= '<p class="buttons-humantime">This buttons is in <strong>' . human_time_diff( current_time('timestamp') , get_post_meta( $post->ID, $ebss_prefix . 'test_datetime_timestamp', true ) ) . '</strong></p>' ;
							$shortout .= '<hr />';
*/
							$shortout .= "<ul class=\"wc-tz-list\">";
							

		    				foreach ( (array) $chosen_timezone as $key => $entry ) {

							    $the_tz = '';

							    if ( isset( $entry[$ebss_prefix . 'choose_buttons_timezone'] ) ) {
							        $the_tz = $entry[$ebss_prefix . 'choose_buttons_timezone'];
							    

							    // Do something with the data


							if (strpos($the_tz,'UTC') === 0) { //check if UTC time
	
								$utc_offset = substr($time_zone, 3); //get utc offset; 
	
								$utc_offset = preg_replace('/[^0-9]/', '', $utc_offset) * 3600; //convert hours to seconds
	
								$uct_tz = timezone_name_from_abbr(null, $utc_offset, true); //get timezone from utc offset
								
								$destinationTimeZone = new DateTimeZone($uct_tz);
								
								$read_city = $the_tz;

	 
							} else {

							        $destinationTimeZone = new DateTimeZone($the_tz);
							

								$tzDate->setTimezone($destinationTimeZone);
								list($country, $city) = explode("/", $the_tz, 2);
								$read_city = str_replace("_", " ", str_replace("/", ", ", $city));
							}
					
								$tz_timezone_date = $tzDate->format('M d');
								$tz_timezone_time = $tzDate->format('H:i');

								$shortout .= "<li>";
								$shortout .= "<span class=\"buttons-tzname\">" . $read_city . ": </span>";
								$shortout .= "<span class=\"webast-date\">" . $tz_timezone_date . "</span> ";
								$shortout .= "<span class=\"webast-time\">" . $tz_timezone_time . "</span> ";
								$shortout .= "</li>";

								} else {
									echo "No Time Zones Chosen!";
								}

							}

							$shortout .= "</ul>";
							$shortout .= "</div>";
						
	    			}
	    			
					else {
						    $myTimeZones = array(
							    'Los Angeles' 	=> 'America/Los_Angeles',
							    'Denver'		=> 'America/Denver',
								'Chicago' 		=> 'America/Chicago',
								'New York' 		=> 'America/New_York',
								'Johannesburg'	=> 'Africa/Johannesburg',
								'Singapore'		=> 'Asia/Singapore',
								'Sydney' 		=> 'Australia/Sydney',
							);

						    $shortout .= "<div class=\"buttons-timezones\">";

							$shortout .= '<a class="wcbtn wcbtn-block wcbtn-blue" href="'.$registration_url.'"><span class="buttons-register"></span> Register Now</a>';
							/* $shortout .= '<p class="buttons-humantime">This buttons is in <strong>' . human_time_diff( current_time('timestamp') , get_post_meta( $post->ID, $ebss_prefix . 'test_datetime_timestamp', true ) ) . '</strong></p>' ; */
							$shortout .= '';
							    
									$shortout .= "<ul class=\"wc-tz-list\">";

									foreach($myTimeZones as $myTZname=>$myTZ) {
										$destinationTimeZone = new DateTimeZone($myTZ);
										$tzDate->setTimezone($destinationTimeZone);
										$tz_timezone_date = $tzDate->format('M d');
										$tz_timezone_time = $tzDate->format('H:i');
										
										//Display The Timezones
										$shortout .= "<li>";
										$shortout .= "<span class=\"buttons-tzname\">" . $myTZname . ": </span>";
										$shortout .= "<span class=\"webast-date\">" . $tz_timezone_date . "</span> ";
										$shortout .= "<span class=\"webast-time\">" . $tz_timezone_time . "</span> ";
										$shortout .= "</li>";
									}
									// $current_uri = home_url( add_query_arg( NULL, NULL ) );
									// $current_uri = home_url( add_query_arg( array(), $wp->request ) );
									
									$shortout .= "</ul>";

									// $shortout .= "</div>";
							$shortout .= "</div>";
							

					}

					// do something

					$shortout .= get_the_content_with_formatting();
					//$shortout .= "<hr />";
					unset($myTimeZones);

					// $shortout .= $title_length . "<br />";
					// $shortout .= $s . "<br />";
					// $shortout .= $current_uri . "<br />";
					

					// echo $shortout;
					$shortout .= "</div>"; // end of post-id and post-class div
					$shortout .= "<hr />";


				//} // if statement for future posts only
			}

		} else {
			// no posts found
			$shortout .= '<div>There are no live buttonss coming up this week, please visit again soon or watch a recorded buttons that covers the same topic or a related one.';

		}

		$shortout .= "</div>";

		// Restore original Post Data
		wp_reset_postdata();

		// End of WP Query

		// Code
		echo $shortout;
		$shortout = ob_get_clean();
        return $shortout;
	}
add_shortcode( 'ebss-buttons', 'ebss_buttons_shortcode' );
}