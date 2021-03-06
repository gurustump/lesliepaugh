<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

function project_post_type() { 
	$psg_label = 'Project';
	// creating (registering) the custom type 
	register_post_type( 'project', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( $psg_label.'s', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( $psg_label, 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All '.$psg_label.'s', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New '.$psg_label, 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit  '.$psg_label, 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New  '.$psg_label, 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View '.$psg_label, 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search  '.$psg_label.'s', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'No '.$psg_label.'s found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'No '.$psg_label.'s found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => '',
			'menu_name' => __(  $psg_label.'s', 'bonestheme' )
			), /* end of labels */
			'description' => __( 'Project items that will appear as projects', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'menu_position' => null, /* this is what order you want it to appear in on the left hand side menu */ 
			/*'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png',*/ /* the icon for the custom post type menu */
			//'rewrite'	=> array( 'slug' => 'project' ), /* you can specify its url slug */
			'has_archive' => 'project-archive', /* you can rename the slug here */
			'capability_type' => 'page',
			/*'hierarchical' => false,*/
			/* the next one is important, it tells what's enabled in the post editor */
			/*'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')*/
			'supports' => array('title', 'editor', 'thumbnail', 'tags', 'post-formats')
		) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
    register_taxonomy_for_object_type( 'project_categories', 'project' );
	/* this adds your post tags to your custom post type */
	register_taxonomy_for_object_type( "post_tag", 'project' );
	
}

// adding the function to the Wordpress init
add_action( 'init', 'project_post_type');

function home_slider_post_type() {
	// creating (registering) the custom type 
	register_post_type( 'homepage_slide', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Home Slides', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Slide', 'bonestheme' ), /* This is the individual type */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Slide', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Slide', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New  Slide', 'bonestheme' ), /* New Display Title */
			'all_items' => __( 'All Slides', 'bonestheme' ), /* the all items menu item */
			'view_item' => __( 'View Slide', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Slides', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'No Slides found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'No Slides found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => '',
			'menu_name' => __(  'Home Slider', 'bonestheme' )
			), /* end of labels */
			'description' => __( "Items that will appear on the home page's main content area", 'bonestheme' ), /* Custom Type Description */
			'public' => false,
			'publicly_queryable' => true,
			'hierarchical'          => false,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_nav_menus'     => false,
			'show_in_admin_bar'     => false,
			'show_in_menu' => true,
			'query_var' => true,
			'can_export' => true,
			'menu_position' => null, /* this is what order you want it to appear in on the left hand side menu */ 
			/*'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png',*/ /* the icon for the custom post type menu */
			'has_archive' => false,
			'capability_type' => 'page',
			/*'hierarchical' => false,*/
			/* the next one is important, it tells what's enabled in the post editor */
			/*'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')*/
			'supports' => array('title', 'page-attributes')
		) /* end of options */
	); /* end of register post type */
	
}

// adding the function to the Wordpress init
add_action( 'init', 'home_slider_post_type');
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
function project_register_taxonomies () {
	$labels = array(
		'name'                		  => _x( 'Project Categories', 'taxonomy general name', 'bonestheme' ),
		'singular_name'      	  => _x( 'Project Category', 'taxonomy singular name', 'bonestheme' ),
		'search_items'   	      => __( 'Search Project Category', 'bonestheme' ),
		'all_items'             	 => __( 'All Project Categories', 'bonestheme' ),
		'parent_item'             => __( 'Parent Project Category' , 'bonestheme'),
		'parent_item_colon'   => __( 'Parent Project Category: ', 'bonestheme' ),
		'edit_item'           		  => __( 'Edit Project Category' , 'bonestheme'),
		'update_item'  	  	  => __( 'Update Project Category' , 'bonestheme'),
		'add_new_item'         => __( 'Add New Project Category' , 'bonestheme'),
		'new_item_name'      => __( 'New Project Category Name' , 'bonestheme'),
		'menu_name'         	  => __( 'Project Categories' , 'bonestheme')
	);

	$args = array(
		'hierarchical'                   => true,
		'labels'                           => $labels,
		'show_ui'                       => true,
		'show_admin_column'   => true,
		'query_var'                    => true,
		'rewrite'                         => array('slug' => 'project_categories')
	);

	register_taxonomy( 'project_cat', 'project', $args );

}

add_action( 'init', 'project_register_taxonomies', 2);
	// now let's add custom categories (these act like categories)
	/*
	register_taxonomy( 'project_cat', 
		array('project'), // if you change the name of register_post_type( 'custom_type', then you have to change this
		array('hierarchical' => true,     // if this is true, it acts like categories
			'labels' => array(
				'name' => __( 'Custom Categories', 'bonestheme' ), // name of the custom taxonomy
				'singular_name' => __( 'Custom Category', 'bonestheme' ), // single taxonomy name
				'search_items' =>  __( 'Search Custom Categories', 'bonestheme' ), // search title for taxomony
				'all_items' => __( 'All Custom Categories', 'bonestheme' ), // all title for taxonomies
				'parent_item' => __( 'Parent Custom Category', 'bonestheme' ), // parent title for taxonomy
				'parent_item_colon' => __( 'Parent Custom Category:', 'bonestheme' ), // parent taxonomy title
				'edit_item' => __( 'Edit Custom Category', 'bonestheme' ), // edit custom taxonomy title
				'update_item' => __( 'Update Custom Category', 'bonestheme' ), // update title for taxonomy
				'add_new_item' => __( 'Add New Custom Category', 'bonestheme' ), // add new title for taxonomy
				'new_item_name' => __( 'New Custom Category Name', 'bonestheme' ) // name title for taxonomy
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'custom-slug' ),
		)
	);
	*/
	// now let's add custom tags (these act like categories)
	/*
	register_taxonomy( 'project_tag', 
		array('porfolio'), // if you change the name of register_post_type( 'custom_type', then you have to change this 
		array('hierarchical' => false,    // if this is false, it acts like tags 
			'labels' => array(
				'name' => __( 'Custom Tags', 'bonestheme' ), // name of the custom taxonomy 
				'singular_name' => __( 'Custom Tag', 'bonestheme' ), // single taxonomy name 
				'search_items' =>  __( 'Search Custom Tags', 'bonestheme' ), // search title for taxomony 
				'all_items' => __( 'All Custom Tags', 'bonestheme' ), // all title for taxonomies 
				'parent_item' => __( 'Parent Custom Tag', 'bonestheme' ), // parent title for taxonomy 
				'parent_item_colon' => __( 'Parent Custom Tag:', 'bonestheme' ), // parent taxonomy title 
				'edit_item' => __( 'Edit Custom Tag', 'bonestheme' ), // edit custom taxonomy title 
				'update_item' => __( 'Update Custom Tag', 'bonestheme' ), // update title for taxonomy 
				'add_new_item' => __( 'Add New Custom Tag', 'bonestheme' ), // add new title for taxonomy 
				'new_item_name' => __( 'New Custom Tag Name', 'bonestheme' ) // name title for taxonomy 
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
		)
	);
	*/
	
	/*
		looking for custom meta boxes?
		check out this fantastic tool:
		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
	*/
	

?>
