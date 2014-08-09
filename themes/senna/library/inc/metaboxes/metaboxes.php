<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category Senna
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_senna_';

	$meta_boxes[] = array(
		'id'         => 'homepage_slide_content',
		'title'      => 'Home Slider Content',
		'pages'      => array( 'homepage_slide', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
            array(
                'name' => 'Image',
                'desc' => __('Upload an image or enter an URL.', wpGrade_txtd),
                'id'   => $prefix . 'homepage_slide_image',
                'type' => 'file',
            ),
            array(
                'name'    => 'Caption',
                'desc'    => __('The caption of the slider', wpGrade_txtd),
                'id'      => $prefix . 'homepage_slide_caption',
                'type'    => 'wysiwyg',
                'options' => array(	'textarea_rows' => 5, ),
            ),
            array(
                'name' => 'Button Label',
                'id'   => $prefix . 'homepage_slide_label',
                'type' => 'text_medium',
            ),
            array(
                'name' => 'Link',
                'id'   => $prefix . 'homepage_slide_link',
                'type' => 'text',
            ),
		),
	);


    /*
     * The Video Post Format
     */
    $meta_boxes[] = array(
        'id' => 'video_settings_for_homepage_slider',
        'title' => __('Video Settings', wpGrade_txtd),
        'pages'      => array( 'homepage_slide'), // Post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => __('Youtube Link', wpGrade_txtd),
                'desc' => __('Enter here an Youtube video link. Anything bellow will be overridden.', wpGrade_txtd),
                'id' => $prefix . 'youtube_id',
                'type' => 'text',
                'std' => '',
            ),
            array(
                'name' => __('Vimeo Link', wpGrade_txtd),
                'desc' => __('Enter here a Vimeo video link. Anything bellow will be overridden.', wpGrade_txtd),
                'id' => $prefix . 'vimeo_link',
                'type' => 'text',
                'std' => '',
            ),
            array(
                'name' => __('MP4 File URL', wpGrade_txtd),
                'desc' => __('Please enter in the URL to your .m4v video file (h.264 codec). This format is need to provide support for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7', wpGrade_txtd),
                'id' => $prefix . 'video_m4v',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('WebM/VP8 File URL', wpGrade_txtd),
                'desc' => __('Please enter in the URL to your .webm video file. This format is need to provide support for Firefox4, Opera, and Chrome', wpGrade_txtd),
                'id' => $prefix . 'video_webm',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('Ogg/Vorbis File URL', wpGrade_txtd),
                'desc' => __('Please enter in the URL to your .ogv video file. This format is need to provide support for older Firefox and Opera versions', wpGrade_txtd),
                'id' => $prefix . 'video_ogv',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('Preview Image', wpGrade_txtd),
                'desc' => __('This will be the image displayed when the video has not been played yet. The image should be at least 640px wide. Click the "Upload" button to open the Media Manager, and click "Use as Preview Image" once you have uploaded or chosen an image from the media library.', wpGrade_txtd),
                'id' => $prefix . 'video_poster',
                'type' => 'file',
                'std' => ''
            ),
        )
    );

    $meta_boxes[] = array(
        'id'         => 'page_details_metabox',
        'title'      => 'Header Settings',
        'pages'      => array( 'page', ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
//        'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
        'fields' => array(
            array(
                'name' => 'Hide Title',
                'desc' => __('Hide the page title?', wpGrade_txtd),
                'id'   => $prefix . 'page_display_title',
                'type' => 'checkbox',
            ),
            array(
                'name' => 'HTML Title',
                'desc' => __('Create your own title and header content', wpGrade_txtd),
                'id'   => $prefix . 'page_html_title',
                'type' => 'wysiwyg',
				'options' => array (
					'textarea_rows' => 10,
					),
            ),
        )
    );
    $meta_boxes[] = array(
        'id'         => 'portfolio_features',
        'title'      => __('Project Settings', wpGrade_txtd),
        'pages'      => array( 'portfolio' ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => 'Featured Project',
                'desc' => __('Items checked as featured will be displayed first in the homepage portfolio section (ordered by date descending)', wpGrade_txtd),
                'id'   => $prefix . 'portfolio_featured',
                'type' => 'checkbox',
            )
        )
    );
	$meta_boxes[] = array(
        'id'         => 'post_details_metabox',
        'title'      => 'Header Settings',
        'pages'      => array( 'post', ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
//        'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
        'fields' => array(
            array(
                'name' => 'HTML Title',
                'desc' => __('Create your own title and header content', wpGrade_txtd),
                'id'   => $prefix . 'post_html_title',
                'type' => 'wysiwyg',
				'options' => array (
					'textarea_rows' => 10,
					),
            ),
        )
    );
	
	/*
	 * The Quote Post Format
	 */
    $meta_boxes[] = array(
		'id' => 'post_format_metabox_quote',
		'title' =>  __('Quote Settings', wpGrade_txtd),
		'pages'      => array( 'post', ), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
					'name' =>  __('Quote Content', wpGrade_txtd),
					'desc' => __('Please type the text of your quote here.', wpGrade_txtd),
					'id' => $prefix . 'quote',
					'type' => 'wysiwyg',
                    'std' => '',
					'options' => array (
						'textarea_rows' => 10,
						),
				)
		)
	);
	
	/*
	 * The Video Post Format
	 */
    $meta_boxes[] = array(
		'id' => 'post_format_metabox_video',
		'title' => __('Video Settings', wpGrade_txtd),
		'pages'      => array( 'post', 'portfolio'), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
					'name' => __('Embed Code', wpGrade_txtd),
					'desc' => __('Enter here a Youtube, Vimeo (or other online video services) embed code here. The width should be a minimum of 640px. We will use this if filled, not the selfhosted options bellow!', wpGrade_txtd),
					'id' => $prefix . 'video_embed',
					'type' => 'textarea_small',
					'std' => '',
				),
			array( 
					'name' => __('MP4 File URL', wpGrade_txtd),
					'desc' => __('Please enter in the URL to your .m4v video file (h.264 codec). This format is need to provide support for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7', wpGrade_txtd),
					'id' => $prefix . 'video_m4v',
					'type' => 'file',
					'std' => ''
				),
			array( 
					'name' => __('WebM/VP8 File URL', wpGrade_txtd),
					'desc' => __('Please enter in the URL to your .webm video file. This format is need to provide support for Firefox4, Opera, and Chrome', wpGrade_txtd),
					'id' => $prefix . 'video_webm',
					'type' => 'file',
					'std' => ''
				),
			array( 
					'name' => __('Ogg/Vorbis File URL', wpGrade_txtd),
					'desc' => __('Please enter in the URL to your .ogv video file. This format is need to provide support for older Firefox and Opera versions', wpGrade_txtd),
					'id' => $prefix . 'video_ogv',
					'type' => 'file',
					'std' => ''
				),
			array( 
					'name' => __('Preview Image', wpGrade_txtd),
					'desc' => __('This will be the image displayed when the video has not been played yet. The image should be at least 640px wide. Click the "Upload" button to open the Media Manager, and click "Use as Preview Image" once you have uploaded or chosen an image from the media library.', wpGrade_txtd),
					'id' => $prefix . 'video_poster',
					'type' => 'file',
					'std' => ''
				),
		)
	);
	
	/*
	 * The Audio Post Format
	 */
	$meta_boxes[] = array(
		'id' => 'post_format_metabox_audio',
		'title' =>  __('Audio Settings', wpGrade_txtd),
		'pages'      => array( 'post', 'portfolio'), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array( 
					'name' => __('MP3 File URL', wpGrade_txtd),
					'desc' => __('Please enter in the URL to the .mp3 file', wpGrade_txtd),
					'id' => $prefix . 'audio_mp3',
					'type' => 'file',
					'std' => ''
				),
			array( 
					'name' => __('M4A File URL', wpGrade_txtd),
					'desc' => __('Please enter in the URL to the .m4a file', wpGrade_txtd),
					'id' => $prefix . 'audio_m4a',
					'type' => 'file',
					'std' => ''
				),
			array( 
					'name' => __('OGA File URL', wpGrade_txtd),
					'desc' => __('Please enter in the URL to the .ogg or .oga file', wpGrade_txtd),
					'id' => $prefix . 'audio_ogg',
					'type' => 'file',
					'std' => ''
				),
			array( 
					'name' => __('Poster Image', wpGrade_txtd),
					'desc' => __('This will be the image displayed above the audio controls. The image should be at least 640px wide. Click the "Upload" button to open the Media Manager, and click "Use as Poster Image" once you have uploaded or chosen an image from the media library.', wpGrade_txtd),
					'id' => $prefix . 'audio_poster',
					'type' => 'file',
					'std' => ''
				),
		)
	);
	
	/*
	 * The Link Post Format
	 */ 
//	$meta_boxes[] = array(
//		'id' => 'post_format_metabox_link',
//		'title' =>  __('Link Settings', wpGrade_txtd),
//		'pages'      => array( 'post', ), // Post type
//		'context' => 'normal',
//		'priority' => 'high',
//		'show_names' => true, // Show field names on the left
//		'fields' => array(
//			array(
//					'name' =>  __('Link URL', wpGrade_txtd),
//					'desc' => __('Please input the URL of your link(i.e. http://www.pixelgrade.com)', wpGrade_txtd),
//					'id' => $prefix .'link',
//					'type' => 'text',
//					'std' => ''
//				)
//		)
//	);

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}