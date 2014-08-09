<?php

/*
 *
 * Set the text domain for the theme or plugin.
 *
 */
define('wpGrade_txtd', 'senna_txtd');

/*
 * Declare some global data that will be used everywhere
 */

$wpGrade_data=new stdClass();

/*
 * Define constants regarding theme info
 */

//main theme info constants
define("WPGRADE_THEMENAME", 'Senna');
define("WPGRADE_SHORTNAME", 'senna');

$theme_data = wp_get_theme();
define("WPGRADE_VERSION", $theme_data->Version);

//library main paths and urls
define("WPGRADE_LIB_PATH", get_template_directory() . '/library/');
define("WPGRADE_LIB_URL", get_template_directory_uri().'/library/');
define("WPGRADE_CSS_URL", WPGRADE_LIB_URL.'css/');
define("WPGRADE_SCRIPT_URL", WPGRADE_LIB_URL.'js/');

/*
 * Require the theme backend.
 */
require_once('admin-panel/options.php');

if(is_admin() && basename($_SERVER["PHP_SELF"]) != 'update-core.php'){
	require_once('inc/upgrade-notifier.php');
}

/*
 * Here we define our custom post types and taxonomies.
 * Remove this line if you find this boring.
 */
require_once('inc/custom-entities.php');

/*
 * Require the needed plugins & custom theme suports
 */
require_once('inc/required-plugins/required-plugins.php');
require_once('inc/widgets.php');
require_once('inc/custom-admin-login.php');
require_once('inc/menus.php');
require_once('inc/media.php');
require_once('inc/thumbnails.php');
require_once('inc/portfolio-gallery.php');
require_once('inc/template-tags.php');
require_once('inc/theme-defaults.php');
include_once 'inc/metaboxes/metaboxes.php';
include_once 'inc/social.php';

//theme activation hooks
add_action( 'after_switch_theme', 'wpgrade_gets_active' );
function wpgrade_gets_active() {
    // Flush permalinks rules on theme activation
    flush_rewrite_rules();
}

// initial thingys
add_action('after_setup_theme','wp_grade_start', 16);
function wp_grade_start() {
	//load the translations
	load_theme_textdomain( wpGrade_txtd, get_template_directory() .'/library/languages' );
    // clean the head
    add_action('init', 'wpgrade_head_cleanup');
    // no Wordpress version in the RSS feed
    add_filter('the_generator', 'wpgrade_rss_version');
    // remove inline css for the recent comments widget
    add_filter( 'wp_head', 'wpgrade_remove_recent_comments_widget_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'wpgrade_remove_recent_comments_style', 1);
    // clean up gallery output - remove the inline css
    add_filter('gallery_style', 'wpgrade_gallery_style');
    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'wpgrade_scripts_and_styles', 1);
    // custom javascript
    add_action('wp_head', 'wpgrade_load_custom_js');
	// Register theme Features
	add_action( 'after_setup_theme', 'custom_theme_features' );
    // cleaning up <p>s around images
    add_filter('the_content', 'wpgrade_filter_ptags_on_images');
    // cleaning up excerpt - replace [..] with a Read more link
    add_filter('excerpt_more', 'wpgrade_excerpt_more');
	// Add theme support for Post Formats
	$formats = array( 'quote', 'video', 'audio', );
	add_theme_support( 'post-formats', $formats );	
}

/*
 * Load theme scripts and styles
 */
function wpgrade_scripts_and_styles () {
	wp_register_script('ampersand', get_stylesheet_directory_uri() . '/library/js/plugins/jquery.best-ampersand.min.js');
	wp_register_script('modernizr', get_stylesheet_directory_uri() . '/library/js/plugins/modernizr.js');
	wp_register_script('off-canvas-menu', get_stylesheet_directory_uri() . '/library/js/plugins/off-canvas-menu.js', array('modernizr'), "", true);
	wp_register_script('isotope', get_stylesheet_directory_uri() . '/library/js/plugins/jquery.isotope.min.js', array(), "", true);
	wp_register_script('infinite-scroll', get_stylesheet_directory_uri() . '/library/js/plugins/jquery.infinitescroll.min.js', array(), "", true);
	wp_register_script('fancy-input', get_stylesheet_directory_uri() . '/library/js/plugins/fancyInput.js', array(), "", true);
	wp_register_script('magnific-popup', get_stylesheet_directory_uri() . '/library/js/plugins/jquery.magnific-popup.min.js', array(), "", true);
	wp_register_script('fake-element', get_stylesheet_directory_uri() . '/library/js/plugins/fake-element.js', array(), "", true);
	wp_register_script('nice-scroll', get_stylesheet_directory_uri() . '/library/js/plugins/jquery.nicescroll.min.js', array(), "", true);
	$cacheBusterJS = date("YmdHi", filemtime( get_stylesheet_directory() . '/library/js/plugins/flexslider.js'));
	wp_register_script('flexslider', get_stylesheet_directory_uri() . '/library/js/plugins/flexslider.js', array(), $cacheBusterJS, true);
    wp_register_script('froogaloop', get_stylesheet_directory_uri() . '/library/js/plugins/froogaloop.min.js', array(), "", true);
    wp_register_script('youtube-api', '//www.youtube.com/iframe_api', array(), "", false);
    wp_register_script('fitvids', get_stylesheet_directory_uri() . '/library/js/plugins/jquery.fitvids.js', array(), "", false);

	//Circle Shortcode
	wp_register_script('knob', get_stylesheet_directory_uri() . '/library/js/plugins/jquery.knob.js', array(), "", true);
	wp_register_script('autoresize', get_stylesheet_directory_uri() . '/library/js/plugins/jquery.autoresize.min.js', array(), "", true);

	//Google Map for Contact Page
	wp_register_script('gmap-api', get_stylesheet_directory_uri() . '/library/js/plugins/gmap/gmap-api-v3.js', array(), "", true);
	wp_register_script('gmap-infobox', get_stylesheet_directory_uri() . '/library/js/plugins/gmap/infobox.js', array(), "", true);

	wp_register_script('mediaelement', get_stylesheet_directory_uri() . '/library/js/plugins/mediaelement-and-player.min.js', array('jquery'), "", true);
	$cacheBusterJS = date("YmdHi", filemtime( get_stylesheet_directory() . '/library/js/main.js'));
	wp_register_script('main-scripts', get_stylesheet_directory_uri() . '/library/js/main.js', array('jquery', 'youtube-api', 'modernizr', 'ampersand', 'off-canvas-menu', 'flexslider', 'fancy-input', 'nice-scroll', 'magnific-popup', 'autoresize', 'knob', 'mediaelement', 'froogaloop', 'fitvids'), $cacheBusterJS, true);
	wp_register_script('portfolio-grid', get_stylesheet_directory_uri() . '/library/js/portfolio-grid.js', array('jquery', 'isotope','infinite-scroll', 'fake-element'), "", true);
	wp_register_script('contact-scripts', get_stylesheet_directory_uri() . '/library/js/contact.js', array('jquery', 'gmap-api','gmap-infobox'), "", true);

	wp_enqueue_script('main-scripts');
	wp_enqueue_script('portfolio-grid');
	if(is_page_template('template-contact.php')) {
		wp_enqueue_script('contact-scripts');
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	$cacheBusterCSS = date("YmdHi", filemtime( get_stylesheet_directory() . '/library/css/style.css'));
	wp_enqueue_style('main-style', get_stylesheet_directory_uri() . '/library/css/style.css', array(),$cacheBusterCSS);
	wp_enqueue_style('font-oswald:200', 'http://fonts.googleapis.com/css?family=Open+Sans|Oswald|Lato:300');
	
    global $wpGrade_Options;

    $style_query_string = '?';
    if ( $wpGrade_Options->get('main_color') ) {
        $main_color = $wpGrade_Options->get('main_color');
        $main_color = str_replace('#', '', $main_color);
        $style_query_string .= 'color='.$main_color;
    }

    if ( $wpGrade_Options->get('use_google_fonts') ) {
        add_action('wp_head', 'wpgrade_load_google_fonts');
        $fonts_array = array('google_main_font', 'google_second_font', 'google_menu_font', 'google_body_font');

        foreach ( $fonts_array as $font) {
            $this_font = get_clean_google_font( $font );
            if (!empty($this_font)) {
                $key = str_replace('google_', '', $font);
                if ( $style_query_string != '?' ) {
                    $style_query_string .= '&'. $key .'='.$this_font;
                } else {
                    $style_query_string .= $key .'='.$this_font;
                }
            }
        }
    }
	if ( $wpGrade_Options->get('portfolio_text_color') ) {
        $port_color = $wpGrade_Options->get('portfolio_text_color');
        $port_color = str_replace('#', '', $port_color);
		if ( $style_query_string != '?' ) {
			$style_query_string .= '&port_color='.$port_color;
		} else {
            $style_query_string .= 'port_color='.$port_color;
        }
    }

    $custom_css = $wpGrade_Options->get('custom_css');
    if ( $custom_css ) {
        if ( $style_query_string != '?' ) {
            $style_query_string .= '&custom_css='.urlencode( $custom_css );
        } else {
            $style_query_string .= 'custom_css='.urlencode( $custom_css );
        }
    }

    wp_register_style('php-style', get_stylesheet_directory_uri() . '/library/custom.css.php'.$style_query_string );
    wp_enqueue_style('php-style');
}

// return the css value for the font
function get_clean_google_font($font){
    global $wpGrade_Options;
    $this_font = $wpGrade_Options->get($font);
    $this_font = str_replace("+", " ", $this_font);
    $this_font = explode(":", $this_font);
    return $this_font[0];
}

/*
 * Load style options
 */
function wpgrade_load_google_fonts(){
    global $wpGrade_Options;

    // fonts
    if ( $wpGrade_Options->get('use_google_fonts') ) {

        $fonts_array = array('google_main_font', 'google_second_font', 'google_menu_font', 'google_body_font');
        $families = array();
        foreach ( $fonts_array as $key => $font) {

            $this_font = get_clean_google_font( $font );
            if (!empty($this_font)) {
                $families[] = $this_font;
            }
        }
        if ( !empty($families)) {
            ?>
            <script type="text/javascript">
                WebFontConfig = {
                    google: { families: <?php echo json_encode($families); ?> }
                };
                (function() {
                    var wf = document.createElement('script');
                    wf.src = (document.location.protocol == 'https:' ? 'https' : 'http') +
                        '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                    wf.type = 'text/javascript';
                    wf.async = 'true';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(wf, s);
                })();
            </script>
            <?php
        }
    }
}
/*
 * Load custom js set in theme options
 */
function wpgrade_load_custom_js(){
    global $wpGrade_Options;

    $custom_js = $wpGrade_Options->get('custom_js');
    if ( !empty( $custom_js ) ) {  ?>
        <script type="text/javascript">
            <?php echo  $custom_js; ?>
        </script>
    <?php
    }
}

/*
 * COMMENT LAYOUT
 */
function wpgrade_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php
			/*
				this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
				echo get_avatar($comment,$size='32',$default='<path_to_url>' );
			*/
				?>
				<!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', wpGrade_txtd), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('c'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('j M Y', wpGrade_txtd)); ?> </a></time>
				<?php edit_comment_link(__('Edit', wpGrade_txtd),'  ','') ?>
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
			<div class="alert info">
				<p><?php _e('Your comment is awaiting moderation.', wpGrade_txtd) ?></p>
			</div>
		<?php endif; ?>
		<section class="comment_content clearfix">
			<?php comment_text() ?>
		</section>
	</article>
	<!-- </li> is added by WordPress automatically -->
	<?php
} // don't remove this bracket!

/*
 *  Set content width value based on the theme's design
 */
if ( ! isset( $content_width ) )
	$content_width = 960;

// Register Theme Features
function custom_theme_features() {
	add_theme_support( 'automatic-feed-links' );
	add_editor_style( get_stylesheet_directory_uri() . '/library/css/style.css');
}

function wp_grade_pagination($custom_query = false){
	if ( !$custom_query ) {
        global $wp_query;
        $custom_query = $wp_query;
    }

	$big = 999999999; ///sneed an unlikely integer
	echo '<div class="wpgrade_pagination">';

	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $custom_query->max_num_pages,
		'prev_text'    => __('&larr; Newer posts', wpGrade_txtd ),
		'next_text'    => __('Older posts &rarr;', wpGrade_txtd ),
		) );
	echo '</div>';

}

function get_wpg_excerpt($str, $startPos=0, $maxLength=100) {
	if(strlen($str) > $maxLength) {
		$excerpt   = substr($str, $startPos, $maxLength-3);
		$lastSpace = strrpos($excerpt, ' ');
		$excerpt   = substr($excerpt, 0, $lastSpace);
		$excerpt  .= '...';
	} else {
		$excerpt = $str;
	}
	
	return $excerpt;
}

//function wpgrade_excerpt_length($length) {
//	global $wpGrade_Options;
//	
//	if ($wpGrade_Options->get('blog_excerpt_length'))
//	{
//		return absint($wpGrade_Options->get('blog_excerpt_length'));
//	}
//	return $length;
//}

function wpgrade_better_excerpt($text) {
	global $wpGrade_Options;
	
    $raw_excerpt = $text;
   
	$text = strip_shortcodes( $text );
	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);

	// Removes any JavaScript in posts (between <script> and </script> tags)
	$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);

	// Enable formatting in excerpts - Add HTML tags that you want to be parsed in excerpts
	$allowed_tags = '<p><a><em><strong><i><br><h1><h2><h3><h4><h5><h6>';
	$text = strip_tags($text, $allowed_tags);

	// Set custom excerpt length - number of words to be shown in excerpts
	if ($wpGrade_Options->get('blog_excerpt_length'))
	{
		$excerpt_length = absint($wpGrade_Options->get('blog_excerpt_length'));
	}
	else 
	{
		$excerpt_length = 55;
	}
	
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	if ( count($words) > $excerpt_length ) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $excerpt_more;
	} else {
		$text = implode(' ', $words);
	}

	// IMPORTANT! Prevents tags cutoff by excerpt (i.e. unclosed tags) from breaking formatting
	$text = force_balance_tags( $text );
	
    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}

// remove shity CSS from galleries
function wpgrade_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

// remove inline CSS for the recent comments widget
function wpgrade_remove_recent_comments_widget_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove inline CSS from the recent comments widget
function wpgrade_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

//=====================================
//Head thingys - cleanup
//=====================================

function wpgrade_head_cleanup() {
	// Remove WP version
	remove_action( 'wp_head', 'wp_generator' );
	
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	
	// remove WP version from css - those parameters can prevent caching
	//add_filter( 'style_loader_src', 'wpgrade_noversion_css_js', 9999 );
	// remove WP version from scripts - those parameters can prevent caching
	//add_filter( 'script_loader_src', 'wpgrade_noversion_css_js', 9999 );

}

// remove WP version from RSS
function wpgrade_rss_version() { return ''; }

// remove WP version from scripts
function wpgrade_noversion_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
// end head cleanup
//=====================================

// remove the <p>s around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function wpgrade_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// change the […] to a Read More link
function wpgrade_excerpt_more($more) {
	global $post;
	return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read more about', wpGrade_txtd) .' '. get_the_title($post->ID).'">'. __('Read more &raquo;', wpGrade_txtd) .'</a>';
}
