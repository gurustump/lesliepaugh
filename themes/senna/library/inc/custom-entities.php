<?php

/*
 * Register custom post types
 */

function pxg_senna_register_post_types() {
    global $wpGrade_Options;
    $psg_label = $wpGrade_Options->get('portfolio_single_label');
    if ( $psg_label == '' ) { define('psg_label', 'Project'); } else { define('psg_label', $psg_label); }
    $ppl_label = $wpGrade_Options->get('portfolio_plural_label');
    if ( $ppl_label == '' ) { define('ppl_label', 'Projects'); } else { define('ppl_label', $ppl_label); }
    /*
     * Portfolio
     */

    $pargs = array(
        'labels' => array(
            'name'              => _x( psg_label, 'Post Type General Name', wpGrade_txtd ),
            'singular_name'     => _x( psg_label, 'Post Type General Name', wpGrade_txtd ),
            'add_new'           => __( 'Add New', wpGrade_txtd ),
            'add_new_item'      => __( 'Add New '.psg_label, wpGrade_txtd ),
            'edit_item'         => __( 'Edit '.psg_label, wpGrade_txtd ),
            'new_item'          => __( 'New '.psg_label, wpGrade_txtd ),
            'all_items'         => __( 'All '.ppl_label, wpGrade_txtd ),
            'view_item'         => __( 'View '.psg_label, wpGrade_txtd ),
            'search_items'      => __( 'Search '.ppl_label, wpGrade_txtd ),
            'not_found'         => __( 'No '.psg_label.' found', wpGrade_txtd ),
            'not_found_in_trash'=> __( 'No '.psg_label.' found in Trash', wpGrade_txtd ),
            'parent_item_colon' => '',
            'menu_name'         => __( ppl_label, wpGrade_txtd ),
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'portfolio-project' ),
        'capability_type' => 'post',
        'has_archive' => 'portfolio-archive',
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'tags', 'post-formats')
    );

    if ( $wpGrade_Options->get('portfolio_rewrite_slug') && $wpGrade_Options->get('portfolio_rewrite_slug') ) {
        $pargs['rewrite']['slug'] = $wpGrade_Options->get('portfolio_slug');
    }

    if ( $wpGrade_Options->get('portfolio_rewrite_archive_slug') && $wpGrade_Options->get('portfolio_rewrite_archive_slug') ) {
        $pargs['has_archive'] = $wpGrade_Options->get('portfolio_archive_slug');
    }

    register_post_type( 'portfolio', $pargs );
	
	add_post_type_support( 'portfolio', 'post-formats', array('video') );

    // assign categories
//    if ( $wpGrade_Options->get('portfolio_use_categories' ) ) {
//        register_taxonomy_for_object_type( "category", 'portfolio' );
//    }

    // assign tags
    if ( $wpGrade_Options->get('portfolio_use_tags' ) ) {
        register_taxonomy_for_object_type( "post_tag", 'portfolio' );
    }

    // assign taxonomies to this post type
    register_taxonomy_for_object_type( 'portfolio_categories', 'portfolio' );

    /*
     * Homepage Slider
     */

    $hps_args = array(
        'labels' => array(
            'name'              => __( "Home Slides", wpGrade_txtd ),
            'singular_name'     => __( 'Slide', wpGrade_txtd ),
            'add_new'           => __( 'Add New', wpGrade_txtd ),
            'add_new_item'      => __( 'Add New Slide', wpGrade_txtd ),
            'edit_item'         => __( 'Edit Slide', wpGrade_txtd ),
            'new_item'          => __( 'New Slide', wpGrade_txtd ),
            'all_items'         => __( 'All Slides', wpGrade_txtd ),
            'view_item'         => __( 'View Slide', wpGrade_txtd ),
            'search_items'      => __( 'Search Slides', wpGrade_txtd ),
            'not_found'         => __( 'No slides found', wpGrade_txtd ),
            'not_found_in_trash'=> __( 'No slides found in trash', wpGrade_txtd ),
            'parent_item_colon' => '',
            'menu_name'         => __( 'Home Slider', wpGrade_txtd ),
        ),
        'publicly_queryable'    => true,
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_nav_menus'     => false,
        'show_in_admin_bar'     => false,
        'show_in_menu'          => true,
        'query_var'             => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'capability_type'       => 'page',
        'menu_position'         => null,
        'supports'              => array('title', 'page-attributes', /*'editor', 'thumbnail' */)
    );
    register_post_type( 'homepage_slide', $hps_args );
//    add_post_type_support( 'homepage_slide', 'post-formats', array('image', 'video') );
}

add_action( 'init', 'pxg_senna_register_post_types',11 );



function pxg_senna_register_taxonomies () {

        $labels = array(
            'name'                => _x( 'Portfolio Categories', 'taxonomy general name', wpGrade_txtd ),
            'singular_name'       => _x( 'Portfolio Category', 'taxonomy singular name', wpGrade_txtd ),
            'search_items'        => __( 'Search Portfolio Category', wpGrade_txtd ),
            'all_items'           => __( 'All Portfolio Categories', wpGrade_txtd ),
            'parent_item'         => __( 'Parent Portfolio Category' , wpGrade_txtd),
            'parent_item_colon'   => __( 'Parent Portfolio Category: ', wpGrade_txtd ),
            'edit_item'           => __( 'Edit Portfolio Category' , wpGrade_txtd),
            'update_item'         => __( 'Update Portfolio Category' , wpGrade_txtd),
            'add_new_item'        => __( 'Add New Portfolio Category' , wpGrade_txtd),
            'new_item_name'       => __( 'New Portfolio Category Name' , wpGrade_txtd),
            'menu_name'           => __( 'Portfolio Categories' , wpGrade_txtd)
        );

        $args = array(
            'hierarchical'        => true,
            'labels'              => $labels,
            'show_ui'             => true,
            'show_admin_column'   => true,
            'query_var'           => true,
            'rewrite'             => array('slug' => 'portfolio_categories')
        );

        register_taxonomy( 'portfolio_cat', 'portfolio', $args );

}
add_action( 'init', 'pxg_senna_register_taxonomies', 2); ?>