<?php
/**
 * The Template for displaying all single posts.
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php 
					/* AutoFocus Nav Above (See: functions.php) */
					autofocus_nav_above(); 
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php 
						global $posts, $shortname;

						/* Grab The Blog Category Option */
						$af_blog_catid = of_get_option( $shortname . '_blog_cat' );

						/* Grab The Image Display Option */
						$af_img_display = of_get_option( $shortname . '_image_display' );

						/* Grab The Image Slider Count Option */
						$af_img_slider_count = get_post_meta( $post->ID, 'slider_count_value', true );

						/* If this isn’t a blog post, show the AutoFocus Entry Image (See: functions.php) */
						if ( !in_category( $af_blog_catid ) ) 
							autofocus_single_entry_image( $af_img_display, $af_img_slider_count ); ?>

					<header>
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php autofocus_posted_on(); ?>
					</header>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'autofocus' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-utility">
						<p class="entry-meta">
							<?php autofocus_post_meta(); ?>

							<?php comments_popup_link( '<span class="comments-link">' . __( 'Leave a comment', 'autofocus' ) . '</span>', '<span class="comments-link">' . __( '1 Comment', 'autofocus' ) . '</span>', '<span class="comments-link">' . __( '% Comments', 'autofocus' ) . '</span>', '', '' ); ?>

							<?php if ( get_post_meta($post->ID, 'enable_flickr', true) == FALSE && of_get_option($shortname . '_show_exif_data') == TRUE && has_post_thumbnail() && ( get_post_meta($post->ID, 'videoembed_value', true) == '' && get_post_meta($post->ID, 'show_gallery', true) == FALSE )) { ?>
								<span class="exif-data"><a href="<?php echo autofocus_exif_link(); ?>#exif-data" title="<?php echo esc_attr__( 'View EXIF data', 'autofocus' ) ?>"><?php _e('View EXIF Data', 'autofocus') ?></a>.</span>
							<?php } ?>

							<?php if ( get_post_meta($post->ID, 'enable_flickr', true) && get_post_meta($post->ID, 'flickr_link', true) ) { ?>
								<span class="flickr-link"><?php _e('View ', 'autofocus'); ?><a href="<?php echo get_flickr_photo_set_link($post->ID); ?>" target="_blank" title="<?php echo esc_attr__( 'View Flickr set', 'autofocus' ) ?>"><?php _e('Flickr set', 'autofocus') ?></a>.</span>
							<?php } ?>

							<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>
						</p><!-- .entry-meta -->
						<?php get_sidebar(); ?>
					</footer><!-- .entry-utility -->

				</article><!-- #post-## -->

				<?php 
					/* AutoFocus Nav Below (See: functions.php) */
					autofocus_nav_below(); ?>

				<?php 
					/* Only show the Comments Form if the post has comments open */
					if ( comments_open() || get_comments_number() != '0' ) {
						comments_template( '', true ); 
					}
				?>

<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
