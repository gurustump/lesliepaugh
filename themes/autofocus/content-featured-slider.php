<?php
/**
 * The loop that displays images in the AutoFocus Featured Post Slider 
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ 
	global $post, $af_flickr, $shortname;

	if ( ( is_home() || is_front_page()) && !is_paged() ) : 
	
	$sticky = get_option( 'sticky_posts' );
	$sticky_count = ( count( $sticky ) );


	if ( is_active_sidebar( 'intro-widget-area' ) ) { ?>

		<aside id="intro-widget-area" class="widget-area" role="complementary">
			<ul class="xoxo">

			<?php
				/** 
				 * When we call the dynamic_sidebar() function, it'll spit out
				 * the widgets for that widget area. If it instead returns false,
				 * then the sidebar simply doesn't exist, so we'll hard-code in
				 * some default sidebar stuff just in case.
				 */
				if ( ! dynamic_sidebar( 'intro-widget-area' ) ) : ?>
			
					<?php dynamic_sidebar( 'intro-widget-area' ); ?>
			
			<?php endif; // end primary widget area ?>

			</ul>
		</aside><!-- #intro-widget-area .widget-area -->

	<?php } 
	
		/* if Sticky Posts exist and the slider is turned off, Show a static sticky area */
		if ( ( get_option( 'sticky_posts' ) && ( of_get_option( $shortname . '_sliding_sticky_area' ) == FALSE ) ) || ( of_get_option( $shortname . '_sliding_sticky_area' ) == TRUE && $sticky_count == '1' ) ) { ?>

			<?php /* Set Up New Query */
				$randomStickyNo = 0;
				$randomStickyNo = ( rand() % ( count( $sticky ) ) );
				$postno = $sticky[( $randomStickyNo )];
				$static_sticky_query = null;
				$temp = $static_sticky_query;
				$static_sticky_query = new WP_Query();
				$static_sticky_query->query( 'orderby=rand&post_status=publish&showposts=1&p=' . $postno ); ?>

			<?php while ( $static_sticky_query->have_posts()) : $static_sticky_query->the_post(); $do_not_duplicate = $post->ID; ?>
				<div id="sticky-area">

					<article id="post-<?php the_ID(); ?>" class="post">
						<header class="entry-header">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							<?php autofocus_posted_on(); ?>
						</header>
			
						<?php autofocus_entry_image( 'front-page-thumbnail' ); ?>
			
						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div><!-- .entry-content -->

						<?php edit_post_link( __( 'Edit', 'autofocus' ), '<footer class="entry-utility"><span class="edit-link">', '</span></footer><!-- .entry-utility -->' ); ?>

					</article><!-- #post-## -->

				</div><!-- #sticky-area -->

			<?php endwhile; ?>
			<?php $static_sticky_query = null; 
				$temp = $static_sticky_query; ?>

	<?php } /* if Sliding Featured Area option is true */
			elseif ( get_option( 'sticky_posts' ) && ( of_get_option( $shortname . '_sliding_sticky_area' ) == TRUE ) ) { ?>

		<div id="sticky-area" class="entry-gallery-container">
			<div id="gallery-container" class="cycle">

			<?php 
				/* Set Up New Query */
				$temp = null;
				$sliding_sticky_query = $temp;
				$sliding_sticky_query = new WP_Query();
				$sliding_sticky_query->query( array(
					// 'orderby' => 'rand', 
					'showposts' => '10',
					'post__in' => get_option( 'sticky_posts' )
					) ); ?>

			<?php while ( $sliding_sticky_query->have_posts() ) : $sliding_sticky_query->the_post(); $do_not_duplicate = $sliding_sticky_query->post->ID; ?>

					<article id="post-<?php the_ID(); ?>" class="post">
						<header class="entry-header">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							<?php autofocus_posted_on(); ?>
						</header>
			
						<?php autofocus_entry_image( 'front-page-thumbnail' ); ?>
			
						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div><!-- .entry-content -->
			
						<?php edit_post_link( __( 'Edit', 'autofocus' ), '<footer class="entry-utility"><span class="edit-link">', '</span></footer><!-- .entry-utility -->' ); ?>
					</article><!-- #post-## -->

			<?php endwhile; ?>
			<?php $sliding_sticky_query = $temp;
				$temp = null; ?>

			</div><!-- .cycle -->
		</div><!-- .entry-gallery-container -->

		<?php } 
	endif;
 ?>