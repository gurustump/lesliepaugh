<?php
/*
Template Name: Blog Archive Page
*/

get_header(); ?>
    <?php 
		global $paged;
		global $wp_query;
		$temp = $wp_query;
		$paged = 1;
		if ( get_query_var('paged') ) $paged = get_query_var('paged');  
		if ( get_query_var('page') ) $paged = get_query_var('page');
		$wp_query = null;
		$wp_query = new WP_Query( array('post_type' => 'post', 'paged'=>$paged));
		
		global $wpGrade_Options;
	    $archive = $wpGrade_Options->get('blog_archive_template');
	    get_template_part('templates/blog', $archive);
		$wp_query = null; 
		$wp_query = $temp;  // Reset
	?>
<?php get_footer(); ?>