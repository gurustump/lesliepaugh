<?php
/** 
 * These are functions specific to these options settings and this theme 
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */




/** 
 * Theme Header Output - wp_head() 
 * - This sets up the layouts and styles selected from the options panel
 */
if (!function_exists('optionsframework_wp_head')) {
	function optionsframework_wp_head() { 

		// This prints out the custom css and specific styling options
		of_options_output_css();
	}
}
add_action('wp_head', 'optionsframework_wp_head');




/**
 * Theme Footer Output - wp_footer() 
 */

/* This sets up the JS options selected from the options panel */
if (!function_exists('optionsframework_wp_footer')) {
	function optionsframework_wp_footer() { 

		// This prints out the custom JS settings and options
		of_options_output_js();
	}
}
add_action('wp_footer', 'optionsframework_wp_footer');




/** 
 * Output CSS from standarized options 
 */
function of_options_output_css() { 
	global $post, $shortname; 

	$output = '';

	$text_color = of_get_option( $shortname . '_text_color' );
	$link_color = of_get_option( $shortname . '_link_color' );
	$bg_color = of_get_option( $shortname . '_bg_color' );
	$photo_color = of_get_option( $shortname . '_photo_color' );
	$custom_css = of_get_option( $shortname . '_custom_css' );
	$title_date = of_get_option( $shortname . '_title_date' );
	$sliding_sticky_area = of_get_option( $shortname . '_sliding_sticky_area' );
	$single_image_display = of_get_option( $shortname . '_image_display' );
	$fancybox = of_get_option( $shortname . '_fancybox' );
	$slider_nav = of_get_option( $shortname . '_slider_nav' );
	$home_layout = of_get_option( $shortname . '_home_layout' );
	$archive_layout = of_get_option( $shortname . '_archive_layout' );
	$title_pos = of_get_option( $shortname . '_title_position' );
	$nav_arrows = of_get_option( $shortname . '_hide_nav_arrows' );
	$blogcat_slug = get_cat_name( of_get_option( $shortname . '_blog_cat' ) );

	if ($custom_css <> '') {
		$output .= $custom_css . "\n";
	}
	
	// Output styles
	if ($output <> '') {
		$output = "/* Custom Styling */\n\t" . $output;
	}
	
	?>
<style type="text/css">
/* <![CDATA[ */
<?php /* Pull Styles from Dynamic StylesSheet (Look in /css/ ) */
	$af_css_options_output = get_template_directory() . '/css/style.options.php'; 
	if ( is_file( $af_css_options_output ) ) 
		require $af_css_options_output;
	
	// Echo Optional Styles
	echo $output;
?>
/* ]]> */
</style>
<?php }




/* 
 * Output JS from options 
 */
function of_options_output_js() {
	global $post, $shortname; 

	$output = '';

	$text_color = of_get_option( $shortname . '_text_color' );
	$link_color = of_get_option( $shortname . '_link_color' );
	$bg_color = of_get_option( $shortname . '_bg_color' );
	$photo_color = of_get_option( $shortname . '_photo_color' );
	$custom_css = of_get_option( $shortname . '_custom_css' );
	$title_date = of_get_option( $shortname . '_title_date' );
	$sliding_sticky_area = of_get_option( $shortname . '_sliding_sticky_area' );
	$single_image_display = of_get_option( $shortname . '_image_display' );
	$fancybox = of_get_option( $shortname . '_fancybox' );
	$slider_nav = of_get_option( $shortname . '_slider_nav' );
	$home_layout = of_get_option( $shortname . '_home_layout' );
	$archive_layout = of_get_option( $shortname . '_archive_layout' );
	$title_pos = of_get_option( $shortname . '_title_position' );
	$nav_arrows = of_get_option( $shortname . '_hide_nav_arrows' );

?>
<script type="text/javascript">
/* <![CDATA[ */
<?php 
$af_js_options_output = get_template_directory() . '/js/js.options.php'; 
if( is_file( $af_js_options_output ) ) 
	require $af_js_options_output; 
?>
/* ]]> */
</script>
<?php }





/** 
 * Add Favicon
 */
function autofocus_favicon() {
	global $shortname;
	if ( of_get_option( $shortname . '_custom_favicon') != '' ) {
        echo '<link rel="shortcut icon" href="' . of_get_option( $shortname . '_custom_favicon' )  . '"/>'."\n";
    }
	else { ?>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/images/favicon.ico" />
<?php }
}
add_action( 'wp_head', 'autofocus_favicon' );





/** 
 * Add a Custom Logo
 */
function autofocus_branding() {
	global $shortname;
	$the_logo = of_get_option( $shortname . '_logo');
    $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';?>

    <<?php echo $heading_tag; ?> id="site-title">
    
    <?php if ( of_get_option( $shortname . '_logo') != '' ) : ?>
    
		<a href="<?php echo home_url(); ?>" title="<?php bloginfo('description'); ?>">
    		<img src="<?php echo $the_logo; ?>" alt="<?php bloginfo('name'); ?>"/>
		</a>
	    </<?php echo $heading_tag; ?>>
    
	<?php else : ?>

		<span>
			<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</span>
	    </<?php echo $heading_tag; ?>>
		<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>

	<?php endif;

}




/** 
 * Footer text 
 */
function autofocus_display_footer_text() {
	global $shortname;
	$text = of_get_option($shortname . '_footer_text');
	$showtext = stripslashes($text);
	echo $showtext;
}




/** 
 * Flickr functions
 */
function flickrUsername() {
	global $shortname;
	return of_get_option( $shortname . '_flickr_username' );
}
function flickrUserId() {
	global $shortname, $af_flickr;
	$flickr_user = $af_flickr->urls_lookupUser( 'http://flickr.com/photos/'. of_get_option( $shortname . '_flickr_username' ) );
	return $flickr_user['id'];
}
function flickrApiKey() {
	global $shortname;
	return of_get_option( $shortname . '_flickr_api_key' );
}
function flickrApiSecret() {
	global $shortname;
	return of_get_option( $shortname . '_flickr_api_secret' );
}

?>