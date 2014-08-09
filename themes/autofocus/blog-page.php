<?php
/**
 * Template Name: Blog Template
 * A custom page template that display posts from the defined Blog Category
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */

get_header(); ?>

<?php /* Start the loop for the Blog Category */
    global $paged, $more, $shortname;
	$more = 0;
    
	/* Grab the blog Category */
	$af_blog_catid = of_get_option( $shortname . '_blog_cat' );

	$temp = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query();
	$wp_query->query( array(
		'showposts' => get_option( 'posts_per_page' ),
		'category__in' => array( $af_blog_catid ),
		'paged' => $paged
	)); ?>

		<div id="container" class="af-blog-template">
			<div id="content" role="main">

			<h1 class="page-title"><a href="<?php print get_category_feed_link( $af_blog_catid, '' ) ?>" title="<?php _e( 'Subscribe', 'autofocus' ); ?>"><?php _e( 'Subscribe', 'autofocus' ) ?></a><span><?php the_title(); ?></span></h1>

			<?php if ( $wp_query->max_num_pages > 1 ) : ?>
				<nav id="nav-above" class="navigation">
					<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span>' ); ?></div>
					<div class="nav-next"><?php previous_posts_link( '<span class="meta-nav">&rarr;</span>' ); ?></div>
				</nav><!-- #nav-above -->
			<?php endif; ?>
			
			<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
			
				<?php get_template_part( 'content', 'blog' ); ?>
			
			<?php endwhile; /* end of the loop. */ ?>
			
			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php if (  $wp_query->max_num_pages > 1 ) : ?>
					<nav id="nav-below" class="navigation">
						<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> ' . __( 'Older posts', 'autofocus' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'autofocus' ) . ' <span class="meta-nav">&rarr;</span>' ); ?></div>
					</nav><!-- #nav-below -->
			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #container -->

	<?php $wp_query = null; $wp_query = $temp; ?>

<?php get_footer(); ?>