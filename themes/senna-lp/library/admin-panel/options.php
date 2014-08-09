<?php

/*
 *
 * Require the framework class before doing anything else, so we can use the defined URLs and directories.
 * If you are running on Windows you may have URL problems which can be fixed by defining the framework url first.
 *
 */
//define('Redux_OPTIONS_URL', site_url('path the options folder'));
if(!class_exists('Redux_Options')) {
    require_once(dirname(__FILE__) . '/options/defaults.php');
}

/*
 *
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for URLs, and directories will NOT be available at this point in a child theme,
 * so you must use get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections) {
    //$sections = array();
    $sections[] = array(
        'title' => __('A Section added by hook', wpGrade_txtd),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', wpGrade_txtd),
		'icon' => 'paper-clip',
		'icon_class' => '',
        // Leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}
//add_filter('redux-opts-sections-twenty_eleven', 'add_another_section');

/*
 * 
 * Custom function for filtering the args array given by a theme, good for child themes to override or add to the args array.
 *
 */
//function change_framework_args($args) {
//    $args['dev_mode'] = false;
//
//    return $args;
//}
//add_filter('redux-opts-args-twenty_eleven', 'change_framework_args');


/*
 *
 * Most of your editing will be done in this section.
 *
 * Here you can override default values, uncomment args and change their values.
 * No $args are required, but they can be over ridden if needed.
 *
 */
function setup_framework_options() {
    $args = array();

    // Setting dev mode to true allows you to view the class settings/info in the panel.
    // Default: true
    $args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['dev_mode_icon_class'] = '';

    // If you want to use Google Webfonts, you MUST define the api key.
    $args['google_api_key'] = 'AIzaSyB7Yj842mK5ogSiDa3eRrZUIPTzgiGopls';

    // Define the starting tab for the option panel.
    // Default: '0';
    //$args['last_tab'] = '0';

    // Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
    // If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
    // If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
    // Default: 'standard'
    $args['admin_stylesheet'] = 'custom';

    // Add HTML before the form.
    //$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', wpGrade_txtd);

    // Add content after the form.
    //$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', wpGrade_txtd);

    // Set footer/credit line.
    //$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', wpGrade_txtd);

    // Setup custom links in the footer for share icons
    $args['share_icons']['twitter'] = array(
        'link' => 'http://twitter.com/pixelgrade',
        'title' => __('Follow me on Twitter', wpGrade_txtd),
        'img' => Redux_OPTIONS_URL . 'img/social/Twitter.png'
    );
    $args['share_icons']['linked_in'] = array(
        'link' => 'http://www.linkedin.com/company/pixelgrade-media',
        'title' => __('Find me on LinkedIn', wpGrade_txtd),
        'img' => Redux_OPTIONS_URL . 'img/social/LinkedIn.png'
    );
    $args['share_icons']['facebook'] = array(
        'link' => 'http://www.facebook.com/PixelGradeMedia',
        'title' => __('Find me on LinkedIn', wpGrade_txtd),
        'img' => Redux_OPTIONS_URL . 'img/social/Facebook.png'
    );

    // Enable the import/export feature.
    // Default: true
    //$args['show_import_export'] = false;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['import_icon_class'] = '';

    // Set a custom option name. Don't forget to replace spaces with underscores!
    $args['opt_name'] = 'senna_options';

    // Set a custom menu icon.
    $args['menu_icon'] = get_template_directory_uri() . '/library/admin-panel/options/img/theme_options.png';

    // Set a custom title for the options page.
    // Default: Options
    $args['menu_title'] = __('Theme Options', wpGrade_txtd);

    // Set a custom page title for the options page.
    // Default: Options
    $args['page_title'] = __('Options', wpGrade_txtd);

    // Set a custom page slug for options page (wp-admin/themes.php?page=***).
    // Default: redux_options
    $args['page_slug'] = 'senna_options';

    // Set a custom page capability.
    // Default: manage_options
    //$args['page_cap'] = 'manage_options';

    // Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
    // Default: menu
    //$args['page_type'] = 'submenu';

    // Set the parent menu.
    // Default: themes.php
    // A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    //$args['page_parent'] = 'options-general.php';

    // Set a custom page location. This allows you to place your menu where you want in the menu order.
    // Must be unique or it will override other items!
    // Default: null
    $args['page_position'] = '60.66';

    // Set a custom page icon class (used to override the page icon next to heading)
    //$args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Font Awesome, or "image" for traditional.
	// Redux no longer ships with standard icons!
	// Default: iconfont
	//$args['icon_type'] = 'image';
	//$args['dev_mode_icon_type'] = 'image';
	//$args['import_icon_type'] == 'image';

    // Disable the panel sections showing as submenu items.
    // Default: true
    //$args['allow_sub_menu'] = false;
        
    // Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
//    $args['help_tabs'][] = array(
//        'id' => 'redux-opts-1',
//        'title' => __('Theme Information 1', wpGrade_txtd),
//        'content' => __('<p>This is the tab content, HTML is allowed.</p>', wpGrade_txtd)
//    );
//    $args['help_tabs'][] = array(
//        'id' => 'redux-opts-2',
//        'title' => __('Theme Information 2', wpGrade_txtd),
//        'content' => __('<p>This is the tab content, HTML is allowed.</p>', wpGrade_txtd)
//    );

    // Set the help sidebar for the options page.                                        
    //$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', wpGrade_txtd);

    /*
     * Create a taxonomy list
     */

    $sections = array();

    $sections[] = array(
        'icon' => 'cogs',
        'icon_class' => '',
        'title' => __('General Options', wpGrade_txtd),
        'desc' => __('<p class="description">Welcome to the options panel! You can switch between option groups by using the left-hand tabs.</p>', wpGrade_txtd),
        'fields' => array(
            array(
                'id' => 'use_smooth_scrool',
                'type' => 'checkbox',
                'title' => __('Smooth Scrolling', wpGrade_txtd),
                'sub_desc' => __('Enable/ Disable smooth scrolling option', wpGrade_txtd),
                'std' => '1',
                'switch' => true
            ),
            array(
                'id' => 'portfolio_use_taxonomies_info_alert',
                'type' => 'info',
                'desc' => __('<h2>Branding Options</h2>', wpGrade_txtd)
            ),
            array(
                'id' => 'main_logo',
                'type' => 'upload',
                'title' => __('Main Logo', wpGrade_txtd),
                'sub_desc' => __('Upload here your logo image (we recommend a height of 80-100px).If there is no image uploaded, plain text will be used instead (generated from the site\'s name).
     ', wpGrade_txtd),       ),
            array(
                'id' => 'use_retina_logo',
                'type' => 'checkbox_hide_below',
                'title' => __('Retina 2x Logo', wpGrade_txtd),
                'sub_desc' => __('To be Retina-ready you need to add a 2x logo image (double the dimensions of the 1x logo above).', wpGrade_txtd),
                'switch' => true
            ),
            array(
                'id' => 'retina_main_logo',
                'type' => 'upload',
                'title' => __('Retina 2x Logo Image', wpGrade_txtd),
            ),
            array(
                'id' => 'favicon',
                'type' => 'upload',
                'title' => __('Favicon', wpGrade_txtd),
                'sub_desc' => __('Upload a 16px x 16px image that will be used as a favicon.', wpGrade_txtd),
            ),
            array(
                'id' => 'apple_touch_icon',
                'type' => 'upload',
                'title' => __('Apple Touch Icon', wpGrade_txtd),
                'sub_desc' => __('You can customize the icon for the Apple touch shortcut to your website. The size of this icon must be 77x77px.', wpGrade_txtd)
            ),
            array(
                'id' => 'metro_icon',
                'type' => 'upload',
                'title' => __('Metro Icon', wpGrade_txtd),
                'sub_desc' => __('You can customize the icon for the shortcuts of your website in the Metro interface. The size of this icon must be 144x144px.', wpGrade_txtd)
            ),
			array(
                'id' => 'google_analytics',
                'type' => 'textarea',
                'title' => __('Google Analytics', wpGrade_txtd),
                'sub_desc' => __('Paste here your Google Analytics tracking code (or for what matters any tracking code) and we will put it on every page.', wpGrade_txtd),
                'desc' => __('', wpGrade_txtd)
            ),
        )
    );
    // Style Options
    $sections[] = array(
        'icon' => "quote-right",
        'icon_class' => '',
        'title' => __('Style Options', wpGrade_txtd),
        'desc' => __('<p class="description">Give some style to your website!</p>', wpGrade_txtd),
        'fields' => array(
            array(
                'id' => 'main_color',
                'type' => 'color',
                'title' => __('Main Color', wpGrade_txtd),
                'sub_desc' => __('Use the color picker to change the main color of the site to match your brand color.', wpGrade_txtd),
            ),
            array(
                'id' => 'use_google_fonts',
                'type' => 'checkbox_hide_below',
                'title' => __('Do you need custom web fonts?', wpGrade_txtd),
                'sub_desc' => __('Tap into the massive <a href="http://www.google.com/fonts/">Google Fonts</a> collection (with Live preview).', wpGrade_txtd),
                'std' => '0',
                'switch' => true,
                'next_to_hide' => 4
            ),
            array(
                'id' => 'google_main_font',
                'type' => 'google_webfonts',
                'title' => __('Main Font', wpGrade_txtd),
                'sub_desc' => 'Select a font for the main titles'
            ),
            array(
                'id' => 'google_body_font',
                'type' => 'google_webfonts',
                'title' => __('Body Font', wpGrade_txtd),
                'sub_desc' => 'Select a font for content and other general areas'
            ),
            array(
                'id' => 'google_menu_font',
                'type' => 'google_webfonts',
                'title' => __('Menu Font', wpGrade_txtd),
                'sub_desc' => 'Select a font for menu'
            ),
			array(
                'id' => 'bw_portfolio_filter',
                'type' => 'checkbox',
                'title' => __('Portfolio B&W Images Filter', wpGrade_txtd),
                'sub_desc' => __('Do you want that nice black&white filter on the portfolio images?', wpGrade_txtd),
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'portfolio_text_color',
                'type' => 'color',
                'title' => __('Portfolio Hover Text Color', wpGrade_txtd),
                'sub_desc' => __('Use the color picker to change the color of text and graphics that appear on hover over the portfolio items.', wpGrade_txtd),
				'std' => '#ffffff',
            ),
            array(
                'id' => 'custom_css',
                'type' => 'textarea',
                'title' => __('Custom CSS Style', wpGrade_txtd),
                'sub_desc' => __('Use this area to make slight css changes. It will be included in the head section of the page.', wpGrade_txtd),
                'desc' => __('', wpGrade_txtd),
                'validate' => 'html'
            ),
            array(
                'id' => 'custom_js',
                'type' => 'textarea',
                'title' => __('Custom Javascript', wpGrade_txtd),
                'sub_desc' => __('Use this area to make custom javascript calls.This code will be loaded in head section', wpGrade_txtd),
                'desc' => __('jQuery is available here.', wpGrade_txtd),
                'validate' => 'html'
            ),
        )
    );
    $sections[] = array ('divider' => true,'title' => '' );
    // Header Options
    $sections[] = array(
        'icon' => 'bookmark',
        'icon_class' => '',
        'title' => __('Header Options', wpGrade_txtd),
        'desc' => __('<p class="description">Change header related options from here.</p>', wpGrade_txtd),
        'fields' => array(
             array(
                'id' => 'header_fixed',
                'type' => 'checkbox_hide_below',
                'title' => __('Fixed Header Position', wpGrade_txtd),
                'sub_desc' => __('Do you want the header to stay fixed on top when you scroll?', wpGrade_txtd),
				'std' => '1',
                'switch' => true
            ),
        )
    );
    // Footer Options
    $sections[] = array(
        'icon' => 'bookmark-empty',
        'icon_class' => '',
        'title' => __('Footer Options', wpGrade_txtd),
        'desc' => __('<p class="description">Change footer related options from here.</p>', wpGrade_txtd),
        'fields' => array(
            array(
                'id' => 'use_site_wide_box',
                'type' => 'checkbox_hide_below',
                'title' => __('Site-Wide Call-to-Action', wpGrade_txtd),
                'sub_desc' => __('Use a site-wide block section as a call to action area.', wpGrade_txtd),
                'std' => '1',
                'switch' => true,
                'next_to_hide' => 3,
            ),
            array(
                'id' => 'site_wide_section',
                'type' => 'editor',
                'title' => __('Site-Wide Call-to-Action Content', wpGrade_txtd),
                'sub_desc' => __('The content that you would like to appear in the site-wide block section (html supported).', wpGrade_txtd)
            ),
            array(
                'id' => 'site_wide_button_label',
                'type' => 'text',
                'title' => __('Button Text', wpGrade_txtd),
                'sub_desc' => __('The label text of the call to action button.', wpGrade_txtd),
            ),
            array(
                'id' => 'site_wide_button_link',
                'type' => 'text',
                'title' => __('Button Link', wpGrade_txtd),
                'sub_desc' => __('The URL of the call to action button.', wpGrade_txtd),
            ),
            array(
                'id' => 'copyright_text',
                'type' => 'editor',
                'title' => __('Copyright Text', wpGrade_txtd),
                'sub_desc' => __('Text that will appear in footer left area (eg. Copyright 2013 Senna All Rights Reserved).', wpGrade_txtd),
                'std' => 'Copyright 2013 Senna All Rights Reserved.'
            ),
        )
    );
    $sections[] = array ('divider' => true,'title' => '' );

    $sections[] = array(
        'icon' => "home",
        'icon_class' => '',
        'title' => __('Home Page', wpGrade_txtd),
        'desc' => __('<p class="description">General settings for the home page layout.</p>', wpGrade_txtd),
        'fields' => array(
            array(
                'id' => 'homepage_use_slider',
                'type' => 'checkbox',
                'title' => __('Display Slider', wpGrade_txtd),
                'sub_desc' => __('Do you want to use the homepage parallax slider ?', wpGrade_txtd),
                'std' => '1',
                'switch' => true
            ),
            array(
                'id' => 'homepage_content1',
                'type' => 'editor',
                'title' => __('First Content Area', wpGrade_txtd),
                'sub_desc' => __('This content will be displayed after the slider', wpGrade_txtd),
//                'row' => '2'
            ),
            array(
                'id' => 'homepage_use_portfolio',
                'type' => 'checkbox_hide_below',
                'title' => __('Portfolio - Latest Items', wpGrade_txtd),
                'sub_desc' => __('Display the latest three portfolio items in a full-width, grid based gallery.', wpGrade_txtd),
                'std' => '1',
                'switch' => true,
				'next_to_hide' => 2,
            ),
			array(
                'id' => 'homepage_portfolio_title',
                'type' => 'text',
                'title' => __('Latest Items Title', wpGrade_txtd),
                'sub_desc' => __('Change here the title of the latest items section on the homepage.', wpGrade_txtd),
                'std' => 'Portfolio'
            ),
			array(
                'id' => 'homepage_portfolio_more',
                'type' => 'text',
                'title' => __('Latest Items More', wpGrade_txtd),
                'sub_desc' => __('Change here the text of the more button for the latest items section on the homepage.', wpGrade_txtd),
                'std' => 'More'
            ),
//			array(
//                'id' => 'homepage_portfolio_limit',
//                'type' => 'text',
//                'title' => __('How many projects?', wpGrade_txtd),
//                'sub_desc' => __('Set the number of projects you want displayed on the homepage.', wpGrade_txtd),
//				'std' => '3',
//            ),
            array(
                'id' => 'homepage_content2',
                'type' => 'editor',
                'title' => __('Secondary Content Area', wpGrade_txtd),
                'sub_desc' => __('This content will be displayed after the portfolio latest items gallery.', wpGrade_txtd),
            ),
        )
    );
// prepare the contact forms  list
    $contact_forms = array();
    $contact_form_field = array();
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
    if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
        global $wpdb;
        $cf7 = $wpdb->get_results("SELECT ID, post_title
            FROM $wpdb->posts
            WHERE post_type = 'wpcf7_contact_form'
            ");
        $contact_forms = array();
        if ($cf7) {
            foreach ( $cf7 as $cform ) {
                $contact_forms[$cform->ID] = $cform->post_title;
            }
        }

        $contact_form_field = array(
            'id' => 'contact_form_7',
            'type' => 'select', // create a new type with font preview
            'title' => __('Select Form', wpGrade_txtd),
            'sub_desc' => 'Select a contact form previously created with the Contact Form 7 plugin. You can create one <a href="'.admin_url( 'admin.php?page=wpcf7' ).'" title="Contact Form 7">here</a>',
            'options' => $contact_forms
        );

    } else {
        $contact_form_field = array(
            'id' => 'contact_form_7_inactive',
            'type' => 'info', // create a new type with font preview
            'title' => __('Notice', wpGrade_txtd),
            'desc' => '<p class="description">Contact form 7 is not active. You can install/activate it from <a href="'.admin_url( 'themes.php?page=install-required-plugins' ).'" title="Contact Form 7">here</a></p>',
        );
    }

    //Contact Page
    $sections[] = array(
        'icon' => "envelope",
        'icon_class' => '',
        'title' => __('Contact Page', wpGrade_txtd),
        'desc' => __('<p class="description">General settings for the contact page template!</p>', wpGrade_txtd),
        'fields' => array(
            array(
                'id' => 'contact_use_gmap',
                'type' => 'checkbox_hide_below',
                'title' => __('Use Google Maps?', wpGrade_txtd),
                'sub_desc' => __('Do you want to use the a Google map or keep using the featured image on top?', wpGrade_txtd),
                'std' => '0',
                'switch' => true
            ),
            array(
                'id' => 'contact_gmap_link',
                'type' => 'text',
                'title' => __('Google Maps Link', wpGrade_txtd),
				'sub_desc' => __('Paste here the the URL that you\'ve got from Google Maps, after navigating to your location.<br />Here it is <a href="http://screenr.com/MjV7" target="_blank">a short movie</a> showing you how to get the URL', wpGrade_txtd),
            ),
            array(
                'id' => 'contact_phone',
                'type' => 'text',
                'title' => __('Phone Number', wpGrade_txtd),
            ),
            array(
                'id' => 'contact_email',
                'type' => 'text',
                'title' => __('Email Address', wpGrade_txtd),
            ),
            array(
                'id' => 'contact_address',
                'type' => 'text',
                'title' => __('Address', wpGrade_txtd),
            ),
            array(
                'id' => 'contact_content_left',
                'type' => 'editor',
                'title' => __('Left Content', wpGrade_txtd),
                'sub_desc' => __('This content will be displayed on the left side of the contact page.', wpGrade_txtd),
            ),
            array(
                'id' => 'contact_form_title',
                'type' => 'text',
                'title' => __('Contact Form Title', wpGrade_txtd),
                'std' => "Send Us A Message",
            ),
            $contact_form_field
        )
    );
    $sections[] = array ('divider' => true,'title' => '' );

    $sections[] = array(
        'icon' => 'camera',
        'icon_class' => '',
        'title' => __('Portfolio Options', wpGrade_txtd),
        'desc' => __('<p class="description">General settings for portfolio items.</p>', wpGrade_txtd),
        'fields' => array(
			array(
                'id' => 'portfolio_title',
                'type' => 'text',
                'title' => __('Portfolio Title', wpGrade_txtd),
                'sub_desc' => __('This is the title of the portfolio page (it will appear over the header image bellow).', wpGrade_txtd),
				'std' => __('Our Projects.', wpGrade_txtd),
            ),
            array(
                'id' => 'portfolio_header_image',
                'type' => 'upload',
                'title' => __('Portfolio Header Image', wpGrade_txtd),
                'sub_desc' => __('Image that will be used on top of the portfolio archive page.', wpGrade_txtd),
            ),
			array(
                'id' => 'portfolio_archive_limit',
                'type' => 'text',
                'title' => __('How many projects?', wpGrade_txtd),
                'sub_desc' => __('Set the number of projects you want to be loaded at once.', wpGrade_txtd),
				'std' => '6',
            ),
            array(
                'id' => 'portfolio_technical_stuff_info_alert',
                'type' => 'info',
                'desc' => __('<h2>Technical Stuff</h2>', wpGrade_txtd)
            ),
            array(
                'id' => 'portfolio_single_label',
                'type' => 'text',
                'title' => __('Single Item Label', wpGrade_txtd),
                'sub_desc' => __('Here you can change the singular label.The default is "Project"', wpGrade_txtd),
                'std' => __('Portfolio', wpGrade_txtd),
            ),
            array(
                'id' => 'portfolio_plural_label',
                'type' => 'text',
                'title' => __('Multiple Items Label (plural)', wpGrade_txtd),
                'sub_desc' => __('Here you can change the plural label.The default is "Projects"', wpGrade_txtd),
                'std' => __('Projects', wpGrade_txtd),
            ),
            array(
                'id' => 'portfolio_rewrite_slug',
                'type' => 'checkbox_hide_below',
                'title' => __('Change Single Item Slug', wpGrade_txtd),
                'sub_desc' => __('Do you want to rewrite the single portfolio item slug ?', wpGrade_txtd),
				'std' => '1',
                'switch' => true,
            ),
            array(
                'id' => 'portfolio_slug',
                'type' => 'text',
                'title' => __('New Single Item Slug', wpGrade_txtd),
                'sub_desc' => __('Change the single portfolio item slug as you need it.<br /> Exemple from www.your-domain.com/<b>portfolio</b>/item1 in www.your-domain.com/<b>new-slug</b>/item1', wpGrade_txtd),
                'desc' => __('After you change this you need to go and save the permalinks to flush the rewrite rules.', wpGrade_txtd),
				'std' => __('portfolio', wpGrade_txtd),
            ),
            array(
                'id' => 'portfolio_rewrite_archive_slug',
                'type' => 'checkbox_hide_below',
                'title' => __('Change Archive Slug', wpGrade_txtd),
                'sub_desc' => __('Do you want to rewrite the portfolio archive slug? This will only be used if you don\'t have a page with the Portfolio template!', wpGrade_txtd),
				'std' => '0',
                'switch' => true,
            ),
            array(
                'id' => 'portfolio_archive_slug',
                'type' => 'text',
                'title' => __('New Archive Slug', wpGrade_txtd),
                'sub_desc' => __('Exemple from www.your-domain.com/<b>portfolio</b> in www.your-domain.com/<b>new-slug</b>', wpGrade_txtd),
                'desc' => __('After you change this you need to go and save the permalinks to flush the rewrite rules', wpGrade_txtd),
            ),
//            array(
//                'id' => 'portfolio_use_categories',
//                'type' => 'checkbox',
//                'title' => __('Use Categories', wpGrade_txtd),
//                'sub_desc' => __('Do you want to assign categories to portfolio items ?', wpGrade_txtd),
//                'switch' => true
//            ),
            array(
                'id' => 'portfolio_use_tags',
                'type' => 'checkbox',
                'title' => __('Use Tags', wpGrade_txtd),
                'sub_desc' => __('Do you want to assign tags to portfolio items ?', wpGrade_txtd),
                'switch' => true
            ),
        )
    );

    $sections[] = array(
        'icon' => 'file-alt',
        'icon_class' => '',
        'title' => __('Blog Options', wpGrade_txtd),
        'desc' => __('<p class="description">Change blog archive and single post related options here.</p>', wpGrade_txtd),
        'fields' => array(
			array(
                'id' => 'blog_archive_title',
                'type' => 'text',
                'title' => __('Archive Title', wpGrade_txtd),
                'sub_desc' => __('This is the title of the blog archive page (it will appear over the header image bellow).', wpGrade_txtd),
				'std' => __('Blog & News.', wpGrade_txtd),
            ),
            array(
                'id' => 'blog_header_image',
                'type' => 'upload',
                'title' => __('Archive Header Image', wpGrade_txtd),
                'sub_desc' => __('The image that will be used on top of the blog archive page, behind the title and the categories button.', wpGrade_txtd),
               
            ),
			array(
                'id' => 'blog_display_dropdown',
                'type' => 'checkbox',
                'title' => __('Display Header Dropdown?', wpGrade_txtd),
                'sub_desc' => __('Do you want to show the categories and tags dropdown in your blog archive pages?', wpGrade_txtd),
				'std' => '1',
                'switch' => true
            ),
            array(
                'id' => 'blog_archive_template',
                'type' => 'radio_img',
                'title' => __('Archive Layout', wpGrade_txtd),
                'sub_desc' => __('Choose the layout for the blog\'s archive.', wpGrade_txtd),
//                'desc' => __('This uses some of the built in images, you can use them for layout options.', wpGrade_txtd),
                'options' => array(
                    'full' => array('title' => 'Full Width', 'img' => Redux_OPTIONS_URL . 'img/1col.png'),
                    'sidebar-left' => array('title' => 'Sidebar Left', 'img' => Redux_OPTIONS_URL . 'img/2cl.png'),
                    'sidebar-right' => array('title' => 'Sidebar Right', 'img' => Redux_OPTIONS_URL . 'img/2cr.png')
                ), // Must provide key => value(array:title|img) pairs for radio options
                'std' => 'full'
            ),
			array(
                'id' => 'blog_show_featured_image',
                'type' => 'checkbox',
                'title' => __('Show Featured Images in Archive', wpGrade_txtd),
                'sub_desc' => __('Do you want to show the featured images of posts in the archive pages?', wpGrade_txtd),
				'std' => '0',
                'switch' => true,
            ),
			array(
                'id' => 'blog_excerpt_length',
                'type' => 'text',
                'title' => __('Excerpt Length', wpGrade_txtd),
                'sub_desc' => __('Set here the excerpt length for the blog archive (number of words).', wpGrade_txtd),
				'std' => '100',
            ),
            array(
                'id' => 'blog_single_template',
                'type' => 'radio_img',
                'title' => __('Single Post Layout', wpGrade_txtd),
                'sub_desc' => __('Choose the layout for the blog\'s single post pages.', wpGrade_txtd),
                'options' => array(
                    'full' => array('title' => 'Full Width', 'img' => Redux_OPTIONS_URL . 'img/1col.png'),
                    'sidebar-left' => array('title' => 'Sidebar Left', 'img' => Redux_OPTIONS_URL . 'img/2cl.png'),
                    'sidebar-right' => array('title' => 'Sidebar Right', 'img' => Redux_OPTIONS_URL . 'img/2cr.png')
                ), // Must provide key => value(array:title|img) pairs for radio options
                'std' => 'full'
            ),
			array(
                'id' => 'blog_single_show_share_links',
                'type' => 'checkbox_hide_below',
                'title' => __('Show Share Links', wpGrade_txtd),
                'sub_desc' => __('Do you want to show the share links bellow the article?', wpGrade_txtd),
				'std' => '1',
                'switch' => true,
				"next_to_hide" => 3,
            ),
			array(
                'id' => 'blog_single_share_links_twitter',
                'type' => 'checkbox',
                'title' => __('Twitter Share Link', wpGrade_txtd),
                'sub_desc' => '',
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'blog_single_share_links_facebook',
                'type' => 'checkbox',
                'title' => __('Facebook Share Link', wpGrade_txtd),
                'sub_desc' => '',
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'blog_single_share_links_googleplus',
                'type' => 'checkbox',
                'title' => __('Google+ Share Link', wpGrade_txtd),
                'sub_desc' => '',
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'blog_single_show_author',
                'type' => 'checkbox',
                'title' => __('Show Author Box', wpGrade_txtd),
                'sub_desc' => __('Do you want to show the author info box bellow the article?', wpGrade_txtd),
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'blog_single_show_comments_title',
                'type' => 'checkbox',
                'title' => __('Show Comments Title', wpGrade_txtd),
                'sub_desc' => __('Do you want to show the number of comments above the comments?', wpGrade_txtd),
				'std' => '0',
                'switch' => true,
            ),
        )
    );

    $sections[] = array(
        'icon' => "facebook-sign",
        'icon_class' => '',
        'title' => __('Social and SEO Options', wpGrade_txtd),

        'desc' => __('<p class="description">Social sharing stuff.</p>', wpGrade_txtd),
        'fields' => array(
            array(
                'id' => 'prepare_for_social_share',
                'type' => 'checkbox_hide_below',
                'title' => __('Add Social Meta Tags', wpGrade_txtd),
                'sub_desc' => __('Let us properly prepare your theme for the social sharing and discovery by adding the needed metatags in the <head> section.', wpGrade_txtd),
                'std' => '1',
                'switch' => true,
                "next_to_hide" => 4,
            ),
            array(
                'id' => 'facebook_id_app',
                'type' => 'text',
                'title' => __('Facebook Application ID', wpGrade_txtd),
                'sub_desc' => __('Enter the Facebook Application ID of the Fan Page which is associated with this website. You can create one <a href="https://developers.facebook.com/apps">here</a>.', wpGrade_txtd),
            ),
            array(
                'id' => 'facebook_admin_id',
                'type' => 'text',
                'title' => __('Facebook Admin ID', wpGrade_txtd),
                'sub_desc' => __('The id of the user that has administrative privileges to your Facebook App so you can access the <a href="https://www.facebook.com/insights/">Facebook Insights</a>.', wpGrade_txtd),
            ),
            array(
                'id' => 'google_page_url',
                'type' => 'text',
                'title' => __('Google+ Publisher', wpGrade_txtd),
                'sub_desc' => __('Enter your Google Plus page URL (example: https://plus.google.com/105345678532237339285) here if you have set up a "Google+ Page".', wpGrade_txtd),
            ),
			array(
                'id' => 'twitter_card_site',
                'type' => 'text',
                'title' => __('Twitter Site Username', wpGrade_txtd),
                'sub_desc' => __('The Twitter username of the entire site. The username for the author will be taken from the author\'s profile (skip the @)', wpGrade_txtd),
            ),
			array(
                'id' => 'social_share_default_image',
                'type' => 'upload',
                'title' => __('Default Image', wpGrade_txtd),
                'sub_desc' => __('If an image is uploaded, this will be used for content sharing if you don\'t upload a custom image with your content (at least 200px wide recommended).', wpGrade_txtd),
            ),
			array(
                'id' => 'social_seo_social_widget_title',
                'type' => 'info',
                'desc' => __('<h2>Social Icons Widget Settings</h2>', wpGrade_txtd)
            ),
            array(
                'id' => 'social_icons',
                'type' => 'text_sortable',
                'title' => __('Social Icons', wpGrade_txtd),
                'sub_desc' => __('Define and reorder your social links.<br /><b>Note: </b>These will be displayed in the "Senna Social Links" widget so you can put them anywhere on your site. Only those filled will appear.', wpGrade_txtd),
                'desc' => __('Icons provided by <b>Senna</b>.', wpGrade_txtd),
                'options' => array(
                    'twitter' => __('Twitter', wpGrade_txtd),
                    'facebook' => __('Facebook', wpGrade_txtd),
                    'gplus' => __('Google+', wpGrade_txtd),
                    'skype' => __('Skype', wpGrade_txtd),
                    'linkedin' => __('LinkedIn', wpGrade_txtd),
                    'youtube' => __('Youtube', wpGrade_txtd),
                    'vimeo' => __('Vimeo', wpGrade_txtd),
                    'instagram' => __('Instagram', wpGrade_txtd),
                    'flickr' => __('Flickr', wpGrade_txtd),
                    'pinterest' => __('Pinterest', wpGrade_txtd),
                    'tumblr' => __('Tumblr', wpGrade_txtd)
                )
            ),
            array(
                'id' => 'social_icons_target_blank',
                'type' => 'checkbox',
                'title' => __('Open social icons links in new a window?', wpGrade_txtd),
                'sub_desc' => __('Do you want to open social links in a new window ?', wpGrade_txtd),
                'std' => '1',
                'switch' => true
            ),
        )
    );
	
	 $sections[] = array(
        'icon' => "cloud-download",
        'icon_class' => '',
        'title' => __('Theme Auto Update', wpGrade_txtd),

        'desc' => __('<p class="description">Let us notify you when new versions of this theme are live on ThemeForest! Update with just one button click. Forget about manual updates!</p>', wpGrade_txtd),
        'fields' => array(
            array(
                'id' => 'themeforest_upgrade',
                'type' => 'checkbox_hide_below',
                'title' => __('Use Auto Update', wpGrade_txtd),
                'sub_desc' => __('Activate this to enter the info needed for the theme auto update to work.', wpGrade_txtd),
                'std' => '1',
                'switch' => true,
                "next_to_hide" => 2,
            ),
            array(
                'id' => 'marketplace_username',
                'type' => 'text',
                'title' => __('ThemeForest Username', wpGrade_txtd),
                'sub_desc' => __('Enter here your ThemeForest (or Envato) username account (i.e. pixelgrade).', wpGrade_txtd),
            ),
            array(
                'id' => 'marketplace_api_key',
                'type' => 'text',
                'title' => __('ThemeForest Secret API Key', wpGrade_txtd),
                'sub_desc' => __('Enter here the secret api key you\'ve created on ThemeForest. You can create a new one in the Settings > API Keys section of your profile.', wpGrade_txtd),
            ),
        )
    );

    $tabs = array();

    if (function_exists('wp_get_theme')){
        $theme_data = wp_get_theme();
        $item_uri = $theme_data->get('ThemeURI');
        $description = $theme_data->get('Description');
        $author = $theme_data->get('Author');
        $author_uri = $theme_data->get('AuthorURI');
        $version = $theme_data->get('Version');
        $tags = $theme_data->get('Tags');
    }
    
    $item_info = '<div class="redux-opts-section-desc">';
    $item_info .= '<p class="redux-opts-item-data description item-uri">' . __('<strong>Theme URL:</strong> ', wpGrade_txtd) . '<a href="' . $item_uri . '" target="_blank">' . $item_uri . '</a></p>';
    $item_info .= '<p class="redux-opts-item-data description item-author">' . __('<strong>Author:</strong> ', wpGrade_txtd) . ($author_uri ? '<a href="' . $author_uri . '" target="_blank">' . $author . '</a>' : $author) . '</p>';
    $item_info .= '<p class="redux-opts-item-data description item-version">' . __('<strong>Version:</strong> ', wpGrade_txtd) . $version . '</p>';
    $item_info .= '<p class="redux-opts-item-data description item-description">' . $description . '</p>';
    $item_info .= '<p class="redux-opts-item-data description item-tags">' . __('<strong>Tags:</strong> ', wpGrade_txtd) . implode(', ', $tags) . '</p>';
    $item_info .= '</div>';

    $tabs['item_info'] = array(
		'icon' => 'info-sign',
		'icon_class' => '',
        'title' => __('Theme Information', wpGrade_txtd),
        'content' => $item_info
    );

    global $wpGrade_Options;
    $wpGrade_Options = new Redux_Options($sections, $args, $tabs);

}
add_action('init', 'setup_framework_options',0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value =  'just testing';
    /*
    do your validation
    
    if(something) {
        $value = $value;
    } elseif(somthing else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
    }
    */
    
    $return['value'] = $value;
    if($error == true) {
        $return['error'] = $field;
    }
    return $return;
}
