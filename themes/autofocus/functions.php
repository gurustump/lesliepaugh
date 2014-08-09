<?php /**
 * 
 * AutoFocus functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, autofocus_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */




/**
 * Define constants 
 */
define( 'STYLESHEET_DIR', get_stylesheet_directory_uri() );
define( 'TEMPLATE_DIR', get_template_directory_uri() );




/**
 * Set constants from parent and child theme data 
 * - Credits: Joern Kretzschmar & Thematic http://themeshaper.com/thematic 
 */

/* Parent Theme */
$themeData = wp_get_theme( get_template_directory() . '/style.css' );
$version = trim( $themeData->Version );
if ( ! $version )
    $version = "unknown";

/* Child Theme */
$childeThemeData = wp_get_theme( get_stylesheet_directory() . '/style.css' );
$templateversion = trim( $childeThemeData->Version );
if ( ! $templateversion )
    $templateversion = "unknown";

/* Set theme constants */
define( 'THEMENAME', $themeData->Title );
define( 'THEMEAUTHOR', $themeData->Author );
define( 'THEMEURI', $themeData->URI );
define( 'VERSION', $version );

/* Set child theme constants */
define( 'TEMPLATENAME', $childeThemeData->Title );
define( 'TEMPLATEAUTHOR', $childeThemeData->Author );
define( 'TEMPLATEURI', $childeThemeData->URI );
define( 'TEMPLATEVERSION', $templateversion );





/**
 * Include Options Framework: http://wptheming.com/2010/12/options-framework/
 */




/**
* Initialize Options Framework and Metabox Class
* see /inc/metabox/example-functions.php for more information
*
*/
if ( ! function_exists( 'optionsframework_init' ) ) {

	define( 'OPTIONS_FRAMEWORK_PATH', get_template_directory() . '/inc/options/' );
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/options/' );
	require_once( OPTIONS_FRAMEWORK_PATH . 'options-framework.php' );
	require_once( get_template_directory() . '/inc/autofocus-options-functions.php' );
}

if ( !class_exists( 'cmb_Meta_Box' ) ) {
	require_once( get_template_directory() . '/inc/autofocus-metaboxes.php' );
	require_once( get_template_directory() . '/inc/metabox/init.php' );
}




/**
 * AutoFocus Includes
 */

/* Include AutoFocus Image Functions */
require_once( get_template_directory() . '/inc/autofocus-images.php' );

/* Include AutoFocus Templat Tags */
require_once( get_template_directory() . '/inc/autofocus-template-tags.php' );

/* Include AutoFocus WP Tweaks & Filters */
require_once( get_template_directory() . '/inc/autofocus-tweaks.php' );

/* Include AutoFocus Settings */
require_once( get_template_directory() . '/inc/autofocus-shortcodes.php' );

/* Include AutoFocus Shortcode Instructions */
require_once( get_template_directory() . '/inc/autofocus-help.php' );

/* Include php Flickr and set up Flickr API variable: http://phpflickr.com/ */
require_once( get_template_directory() . '/inc/phpFlickr.php' );
require_once( get_template_directory() . '/inc/autofocus-metaboxes-flickr.php' );
$af_flickr = new phpFlickr( flickrApiKey() );

/* Include AF+ Flickr Functions */
require_once( get_template_directory() . '/inc/autofocus-flickr.php' );




/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 494;



/** 
 * Tell WordPress to run autofocus_setup() when the 'after_setup_theme' hook is run. 
 */
add_action( 'after_setup_theme', 'autofocus_setup' );

if ( ! function_exists( 'autofocus_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * To override autofocus_setup() in a child theme, add your own autofocus_setup to your child theme's
 * functions.php file.
 */
function autofocus_setup() {

	/* This theme styles the visual editor with editor-style.css to match the theme style. */
	add_editor_style();

	/* This theme uses post thumbnails */
	add_theme_support( 'post-thumbnails' );

	/* Add new Full Gallery & Archive Thumb image sizes for Front Page slider and Archives */
//	set_post_thumbnail_size( 188, 188, true ); // Default thumbnail size
//	add_image_size( 'archive-thumbnail', 188, 188, true ); // Archives thumbnail size
	add_image_size( 'front-page-thumbnail', 800, 300, true ); // Front Page thumbnail size
	add_image_size( 'fixed-post-thumbnail', 800, 600 ); // Fixed Single Posts thumbnail size
	add_image_size( 'full-post-thumbnail', 800, 9999 ); // Full Single Posts thumbnail size
	
	/* Make theme available for translation
	 * Translations can be found in the /languages/ directory */
	load_theme_textdomain( 'autofocus', get_template_directory() . '/languages' );

	/* Set Up localization */
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/* Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );

	/* This theme uses wp_nav_menu() in one location. */
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'autofocus' ),
	) );

}
endif;



/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override autofocus_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 */
function autofocus_widgets_init() {

	/* Area 1, located in the footer. Empty by default. */
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'autofocus' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	/* Area 2, located in the footer. Empty by default. */
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'autofocus' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	/* Area 3, located in the footer. Empty by default. */
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'autofocus' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	/* Area 4, located in the footer. Empty by default. */
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'autofocus' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	/* Area 5, located to the right of the content area. */
	register_sidebar( array(
		'name' => __( 'Singular Widget Area', 'autofocus' ),
		'id' => 'singular-widget-area',
		'description' => __( 'The singular post/page widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	/* Area 6, located above the header. */
	register_sidebar( array(
		'name' => __( 'Leaderboard Widget Area', 'autofocus' ),
		'id' => 'leaderboard-widget-area',
		'description' => __( 'Displays a widget area above the header to be used as ad space.', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	/* Area 7, located below the header. */
	register_sidebar( array(
		'name' => __( 'Intro Widget Area', 'autofocus' ),
		'id' => 'intro-widget-area',
		'description' => __( 'Displays a widget area below the header to be used as ad space.', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
/** Register sidebars by running autofocus_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'autofocus_widgets_init' );




/**
 * Custom settings initiated at activation.
 */
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	/* Thumbnail sizes */
	update_option( 'thumbnail_size_h', '188' );
	update_option( 'thumbnail_size_w', '188' );
	update_option( 'thumbnail_crop', '1' );

	/* Medium sizes */
	update_option( 'medium_size_h', '288' );
	update_option( 'medium_size_w', '288' );
	update_option( 'medium_crop', '0' );

	/* Large sizes */
	update_option( 'large_size_h', '494' );
	update_option( 'large_size_w', '494' );
	update_option( 'large_crop', '0' );

	/* Comment settings */
	update_option( 'thread_comments', '1' );
	update_option( 'thread_comments_depth', '2' );
	
	/* Embed sizes */
	update_option( 'embed_size_h', '200' );
	update_option( 'embed_size_w', '494' );

	/* Post settings */
	update_option( 'posts_per_page', '12' );

}




/**
 *	Add custom styles on NON-admin pages.
 */
function autofocus_enqueue_styles() {
	global $post, $shortname; 

	if ( !is_admin() ) { /* Is this necessary? */
	
		wp_enqueue_style( 'bm-theme', get_stylesheet_uri(), '', VERSION, 'all' );
		wp_enqueue_style( 'mobile', get_template_directory_uri() . '/css/style.mobile.css', '', VERSION, 'screen' );

		/* Add Fancybox script to single pages if the option is turned on */
		if ( is_single() && ( of_get_option( $shortname . '_fancybox' ) == TRUE ) )
			wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox-1.3.1.css', '', '1.3.1' );

	}
}
add_action( 'wp_print_styles', 'autofocus_enqueue_styles' );




/**
 *	Add custom JS & jQuery scripts on NON-admin pages.
 */
function autofocus_enqueue_scripts() {
	global $post, $shortname; 

	if ( ! is_admin() ) { /* Is this necessary? */
		wp_enqueue_script( 'modernizer', get_template_directory_uri() . '/js/modernizr-1.6.min.js', array( 'jquery' ), '1.6' );
		wp_enqueue_script( 'easing', get_template_directory_uri() . '/js/jquery.easing-1.3.pack.js', array( 'jquery' ), '1.3' );
		wp_enqueue_script( 'hoverintent', get_template_directory_uri() . '/js/hoverIntent.js', array( 'jquery' ) );
		wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery', 'easing' ) );
		wp_enqueue_script( 'supersubs', get_template_directory_uri() . '/js/supersubs.js', array( 'jquery' ) );

		/* Center images in the home page grid */
		if ( ( is_home() || is_front_page() ) || ( ( is_archive() || is_search() ) && of_get_option( $shortname . '_archive_layout' ) ) ) 
			wp_enqueue_script( 'imgcenter', get_template_directory_uri() . '/js/jquery.imgCenter.min.js', array( 'jquery' ), '1.0' );

		/* Add Hashgrid for logged in users only */
		if ( is_user_logged_in() )
			wp_enqueue_script( 'hashgrid', get_template_directory_uri() . '/js/hashgrid.js', array( 'jquery' ), '6.0' );

		/* Add Cycle Script */
		if ( of_get_option( $shortname . '_sliding_sticky_area' ) == TRUE || is_single() )
			wp_enqueue_script( 'cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array( 'jquery', 'easing' ), '1.2' );

		/* Add Fancybox script to single pages if the option is turned on */
		if ( is_single() && ( of_get_option( $shortname . '_fancybox' ) == TRUE ) ) {
			wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox-1.3.1.pack.js', array( 'jquery', 'easing' ), '1.3.1' );
		}
		
		/* Add some JavaScript to pages/posts with threaded comments */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		wp_enqueue_script( 'autofocusjs', get_template_directory_uri() . '/js/js.autofocus.js', array( 'jquery' ), VERSION );
	}
}
add_action( 'wp_print_scripts', 'autofocus_enqueue_scripts' );




/**
 *	Counts Database queries and speed
 */
function autofocus_query_count() { ?>
	<?php echo get_num_queries(); ?> queries.
	<?php timer_stop(1); ?> seconds.
<?php }
// add_action( 'wp_footer', 'autofocus_query_count' );




/**
 *	Adds Commented Credit
 */
function autofocus_author_credit() { ?>
<!-- This site uses the 'AutoFocus' theme for WordPress by THEME SUPPLY Co. http://themesupply.co/ -->
<?php }
add_action( 'wp_footer', 'autofocus_author_credit' );
