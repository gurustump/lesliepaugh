<?php
/**
 * AutoFocus Shortcodes
 *
 * Adds custom Shortcodes for displaying dynamic content within the post area.
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */



/**	
 *	Pull Quote Shortcode
 */
function pull_quote_sc( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'author' => __('Author&#8217;s Name (Default)', 'autofocus'),
		), $atts ) );
	return '<blockquote class="pull-quote"><p>' . $content . '</p><cite class="author"> &mdash; ' . esc_attr($author) . '</cite></blockquote>';
}
add_shortcode( 'pullquote', 'pull_quote_sc' );



/**	
 *	Flickr Gallery Shortcode
 */
function flickr_gallery_sc($atts, $content = null) {
	global $af_flickr;

	extract( shortcode_atts( array(
		'setid' => '',
		'limit' => '10',
		), $atts ) );

	/* Create varibles from shortcode attributes */
	$sc_setid = esc_attr($setid);
	$sc_limit = esc_attr($limit);

	/* Flickr loop variables */
	$images = $af_flickr->photosets_getPhotos($sc_setid, NULL, NULL, $sc_limit);

	if ( $images != null ) { 
		$return = '<div id="gallery-flickrset" class="gallery"><div class="gallery-row clear">';
		$count = 0;
	
		/* Start Flickr loop */
		foreach ( $images['photoset']['photo'] as $image ) { 
			$count++;
			if ( ( $count % 5 ) == 0 && ( $count ) != ( $sc_limit ) ) {
				$return .= '<dl class="gallery-item col-5"><dt class="gallery-icon"><a href="' . $af_flickr->buildPhotoURL($image, 'large') . '" title="' . $image['title'] . '"><img style="max-width:88px;max-height:88px;" src="' . $af_flickr->buildPhotoURL( $image, "square" ) . '" alt="' . $image['title'] . '" /></a></dt></dl></div><div class="gallery-row clear">';
			} else {
				$return .= '<dl class="gallery-item col-5"><dt class="gallery-icon"><a href="' . $af_flickr->buildPhotoURL($image, 'large') . '" title="' . $image['title'] . '"><img style="max-width:88px;max-height:88px;" src="' . $af_flickr->buildPhotoURL( $image, "square" ) . '" alt="' . $image['title'] . '" /></a></dt></dl>';
			}
		}
		return $return .= '</div></div>';
	}
}
add_shortcode( 'flickrgallery', 'flickr_gallery_sc' );



/**	
 *	Large Post Image Shortcode
 */
function large_image_sc( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'description' => '',
		), $atts ) );
	if ( ! $description == '' ) {
		return '<figure class="large-image">' . $content . '<figcaption class="image-description ie6">' . esc_attr( $description ) . '</figcaption></figure>';
	} elseif ( $description == '' ) {
		return '<figure class="large-image">' . $content . '</figure>';
	}
}
add_shortcode( 'largeimage', 'large_image_sc' );



/**	
 *	Narrow Columns Shortcode
 */
function narrow_column_sc( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'side' => 'left',
		), $atts ) );
	return '<div class="narrow-column ' . esc_attr($side) . '"><p>' . $content . '</p></div>';
}
add_shortcode( 'narrowcolumn', 'narrow_column_sc' );





/**
 * Filter to replace the [caption] shortcode text with HTML5 compliant code
 *
 * @return text HTML content describing embedded figure
 **/
function autofocus_img_caption_shortcode_filter($val, $attr, $content = null)
{
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> '',
		'width'	=> '',
		'caption' => ''
	), $attr));
	
	if ( 1 > (int) $width || empty($caption) )
		return $val;

	$capid = '';
	if ( $id ) {
		$id = esc_attr($id);
		$capid = 'id="figcaption_'. $id . '" ';
		$id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
	}

	return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: '
	. ( (int) $width ) . 'px">' . do_shortcode( $content ) . '<figcaption ' . $capid 
	. 'class="wp-caption-text">' . $caption . '</figcaption></figure>';
}
add_filter( 'img_caption_shortcode', 'autofocus_img_caption_shortcode_filter', 10, 3 );



