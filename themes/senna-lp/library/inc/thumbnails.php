<?php

/*
 * Custom Thumbnails
 */

function pxg_senna_custom_thumbnails (){
    // Add theme support for Featured Images
    add_theme_support( 'post-thumbnails' );
    add_image_size('blog-big', 800, 320, true);

	//for the portfolio grid
	add_image_size('big', 700, 540, true);
	add_image_size('long', 700, 270, true);
	add_image_size('small', 350, 270, true);
	add_image_size('tall', 350, 540, true);

	//for the single portfolio
	add_image_size('project-big', 1000);
	add_image_size('project-small', 500);
	add_image_size('project-half', 700);
}

add_action( 'after_setup_theme', 'pxg_senna_custom_thumbnails');

//function pxg_senna_filter_image_sizes( $sizes ) {
//    unset( $sizes['thumbnail']);
//    unset( $sizes['medium']);
//    unset( $sizes['large']);
//
//    return $sizes;
//}
//add_filter('intermediate_image_sizes_advanced', 'pxg_senna_filter_image_sizes');

/*
 * Get thumbnails
 * @param string $size Optional, default is 'full'.
 * @param string $class Class to put on img. Default is none.
 * @param bool $use_as_background Optional, default is false. Whether use the image as background on a div.
 * @return bool $force Force the function to return an image from theme options or from theme.
 */

function wpgrade_get_thumbnail( $size = 'full', $class = '', $use_as_background = false, $force = false ){

    global $wpGrade_Options;
    global $post;
    $post_id = $post->ID;

    $default_img = $wpGrade_Options->get("default_thumbnail_".$size);
    $src = '';
    if ( has_post_thumbnail($post_id )) { // take only the featured image src

        $thumbnail_id = get_post_thumbnail_id($post_id);
        $src = wp_get_attachment_image_src($thumbnail_id, $size);
        $src= $src[0];

    } elseif( !empty($default_img) && $force == true ) { // take the default image setted in theme options

        $src = $default_img;

    } elseif ($force == true) { // get the default thumbnail

        $src = get_template_directory_uri() .'/library/images/default_thumbnail_'.$size.'.png';

    }
    if ( !empty($src) ) {

        if ( $use_as_background ) {

            $output = '<div class="'.$class.'"  style="background-image: url(\''.$src.'\');" ></div>';

        } else {

            $output = '<img class="'.$class.'" src="'.$src.'" />';
        }

        echo $output;
    } else {
        return '';
    }

}
?>