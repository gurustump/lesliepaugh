<?php
/**
 * AutoFocus Tweaks 
 *
 * Filters and functions that alter the defualt WordPress functions 
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */


/**
 * Adds a 'singular' class to the array of body classes.
 */
function autofocus_body_classes( $classes ) {
	if ( is_singular() && ! is_home() && ! is_page_template( 'blog-page.php' ) )
		$classes[] = 'singular';
	if ( is_search() )
		$classes[] = 'archive';
	return $classes;
}
add_filter( 'body_class', 'autofocus_body_classes' );



/**
 * Adds the 'autofocus' class to the BODY for AF animation and displays
 * Uses these classes to display the Grid and Staggered layouts
 */
function autofocus_layout_class( $class = '' ) {
	global $posts, $shortname;
	$home_layout = of_get_option( $shortname . '_home_layout' );
	$archive_layout = of_get_option( $shortname . '_archive_layout' );

	/* Create classes array */
	$af_classes = array();
	
	/* Which layout is being used? */
	if ( $archive_layout == 'default' && ( is_archive() || is_search() ) ) {
		$af_classes[] = 'normal-layout';
	} else {
		$af_classes[] = 'af-layout';
	}
	
	if ( ( is_home() && $home_layout == 'default' ) )
		$af_classes[] = 'af-default';
	elseif ( ( is_home() && $home_layout == 'grid' ) ) 
		$af_classes[] = 'af-grid';

	if ( $home_layout == 'default' && $archive_layout == 'images' && ( is_archive() || is_search() ) ) 
		$af_classes[] = 'af-default';
	elseif ( $home_layout == 'grid' && $archive_layout == 'images' && ( is_archive() || is_search() ) )	
		$af_classes[] = 'af-grid';

	/* Output classes */
	$class_str = implode( ' ', $af_classes );
	echo $class_str;
}



/**
 *	Adds post count and sticky classes to post_class
 */
function autofocus_post_classes( $classes ) {
	global $post, $af_post_alt;

	if ( is_sticky( $post->ID ) && is_single( $post->ID ) )
		$classes[] = 'sticky';

	$af_post_alt++;

	/* Adds a post number (p1, p2, etc) to the .hentry DIVs */
	$classes[] = 'p' . $af_post_alt;
	return $classes;
}
add_filter( 'post_class', 'autofocus_post_classes' );

/* Define the num val for 'alt' classes (in post DIV and comment LI) */
$af_post_alt = 0;



/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 */
function autofocus_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'autofocus_page_menu_args' );



/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function autofocus_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'autofocus_excerpt_length' );



/**
 * Returns a "Continue Reading" link for excerpts
 */
function autofocus_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading', 'autofocus' ) . '<span class="meta-nav">&rarr;</span></a>';
}



/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and autofocus_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function autofocus_auto_excerpt_more( $more ) {
	return ' &hellip;' . autofocus_continue_reading_link();
}
add_filter( 'excerpt_more', 'autofocus_auto_excerpt_more' );



/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function autofocus_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= autofocus_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'autofocus_custom_excerpt_more' );



/**
 * Remove inline styles printed when the gallery shortcode is used.
 * Galleries are styled by the theme in AutoFocus’s style.css.
 */
function autofocus_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'autofocus_remove_gallery_css' );



/**
 * Filter the default gallery display to include rel=fancybox-ID
 * Source: http://wordpress.org/support/topic/add-relxyz-to-gallery-link
 */
function autoFocus_add_fancy_box_rel( $content ) {
	global $post, $shortname;

	if ( is_single() && ( of_get_option( $shortname . '_fancybox' ) == TRUE ) ) {
		$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
		$replacement = '<a$1href=$2$3.$4$5 rel="fancybox-' . $post->ID . '"$6>$7</a>';
		$content = preg_replace( $pattern, $replacement, $content );
	}

	return $content;
}
add_filter( 'the_content', 'autoFocus_add_fancy_box_rel', 12 );
add_filter( 'get_comment_text', 'autoFocus_add_fancy_box_rel' );



/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 */
function autofocus_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'autofocus_remove_recent_comments_style' );



/**
 * Add Custom Image sizes to insert and cropping options 
 * - Thanks to: http://kucrut.org/insert-image-with-custom-size-into-post/
 */
function autofocus_insert_custom_image_sizes( $sizes ) {
  global $_wp_additional_image_sizes;
  if ( empty( $_wp_additional_image_sizes ) )
    return $sizes;

  foreach ( $_wp_additional_image_sizes as $id => $data ) {
    if ( !isset( $sizes[$id] ) )
      $sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
  }

  return $sizes;
}
add_filter( 'image_size_names_choose', 'autofocus_insert_custom_image_sizes' );



/**
 * Add Images/Video/Embeds to feeds
 * - Based on the Custom Fields for Feeds Plugin by Justin Tadlock: 
 * - http://justintadlock.com/archives/2008/01/27/custom-fields-for-feeds-wordpress-plugin
 */
function autofocus_feed_content( $content ) {
	global $post, $id;
	
	$blog_key = substr( md5( home_url() ), 0, 16 );
	
	if ( !is_feed() ) return $content;
 
	/* Is there a Video attached? */
	if ( get_post_meta( $post->ID, 'autofocus_videoembed_value', true ) ) {
		$af_video_url = get_post_meta( $post->ID, 'autofocus_videoembed_value', true );
		$mediafeed = '[embed width="600" height="400"]' . $af_video_url . '[/embed]';
	}

	/* If thereís no video is there an image thumbnail? */
	if ( has_post_thumbnail() ) {
		$mediafeed = the_post_thumbnail( 'medium' );
	}

	/* If there's a video or an image, display the media with the content */
	if ( $mediafeed !== '' ) {
		$content = '<p>' . $mediafeed . '</p><br />' . $content;
		return $content;
 
	/* If there's no media, just display the content */
	} else { 
		$content = $content;
		return $content;
	}
}
add_filter( 'the_content', 'autofocus_feed_content' );