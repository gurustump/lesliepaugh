<?php
/** 
 * Include & setup custom metabox and fields
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */
 
$prefix = 'autofocus_'; // start with an underscore to hide fields from custom fields list
add_filter( 'cmb_meta_boxes', 'autofocus_metaboxes' );
function autofocus_metaboxes( $meta_boxes ) { 
	global $prefix;
	$meta_boxes[] = array(
		'id' => 'autofocus_metaboxes',
		'title' => 'AutoFocus Post Settings',
		'pages' => array( 'post', 'page' ), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __( 'Embed URL', 'autofocus' ),
				'desc' => __( 'Paste your oEmbed URL here. (Examples: http://vimeo.com/7757262 or http://www.youtube.com/watch?v=xwnJ5Bl4kLI)', 'autofocus' ),
				'id' => $prefix . 'videoembed_value',
				'type' => 'text'
			),
			array(
				'name' => __( 'Photo Credit', 'autofocus' ),
				'desc' => __( 'Text entered here will replace the default Photo credit. (Example: &copy; 2011 Photographer Name. All rights reserved.)', 'autofocus' ),
				'id' => $prefix . 'copyright_value',
				'type' => 'text'
			),
			array(
				'name' => __( 'Show Sliding Image Gallery?', 'autofocus' ),
				'desc' => __( 'Show a sliding Gallery of attached images above the post title? (Limited to 10 images. IMPORTANT: All images must be at least 800px wide or 600px tall.)', 'autofocus' ),
				'id' => $prefix . 'show_gallery',
				'std' => '',
				'type' => 'checkbox'
			),
			array(
				'name' => __( 'Slider Image Count', 'autofocus' ),
				'desc' => __( 'This determines how many images are displayed in the image slider. (Recommended Maximum: <strong>20</strong>)', 'autofocus' ),
				'id' => $prefix . 'slider_count_value',
				'std' => '10',
				'type' => 'text_small'
			),
		)
	);
	return $meta_boxes;
}


/*
// Initialize the metabox class
add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );
function be_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'init.php' );
	}
}
*/