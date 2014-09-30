<?php


// Check if the function is already called
if ( ! function_exists( 'ebss_buttons_shortcode' ) ) {


	// Add Shortcode
function sage_button_shortcode( $atts , $content = null ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'style' => 'default',
			'link' => '#',
			'size' => 'standard',
		), $atts )
	);
}
add_shortcode( 'sage-button', 'sage_button_shortcode' );

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
			$shortout .= "";

			while ( $ebss_query->have_posts() ) {
				$ebss_query->the_post();
				//Declare Variables to Use (for metaboxes)




					}



			} else {
			// no posts found
		}


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
