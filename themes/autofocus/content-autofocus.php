<?php
/**
 * The loop that displays images in the AutoFocus format.
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ 
global $shortname;
$blog_catid = of_get_option( $shortname . '_blog_cat' ); ?>

<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<nav id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span>' ); ?></div>
		<div class="nav-next"><?php previous_posts_link( '<span class="meta-nav">&rarr;</span>' ); ?></div>
	</nav><!-- #nav-above -->
<?php endif; ?>

	<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

	<?php /* How to display Blog posts and Pages */
	if ( 'page' == get_post_type() || in_category( $blog_catid ) ) { ?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php autofocus_posted_on(); ?>
			</header>

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->

			<footer class="entry-utility">
				<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-utility -->
		</article><!-- #post-## -->	
	
	<?php 
	
	/* How to display all other posts */
	} else { ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php autofocus_posted_on(); ?>
			</header>

			<?php 
			global $posts, $shortname;
			$af_home_layout = of_get_option( $shortname . '_home_layout' );

			if ( $af_home_layout == 'default' )
		
				autofocus_entry_image( 'front-page-thumbnail' );
		
			elseif ( $af_home_layout == 'grid' ) 

				autofocus_entry_image( 'thumbnail' ); ?>

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->

			<?php edit_post_link( __( 'Edit', 'autofocus' ), '<footer class="entry-utility"><span class="edit-link">', '</span></footer><!-- .entry-utility -->' ); ?>			

		</article><!-- #post-## -->

	<?php }
	
	endwhile; // end of the loop. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="nav-below" class="navigation">
			<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> ' . __( 'Older posts', 'autofocus' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'autofocus' ) . ' <span class="meta-nav">&rarr;</span>' ); ?></div>
		</nav><!-- #nav-below -->
<?php endif; ?>
