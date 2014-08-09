<?php
/**
 * Template Name: Archive Page Template
 * A custom page template that displays a post archive.
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */

get_header(); ?>

		<div id="container" class="one-column">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'autofocus' ), 'after' => '</div>' ) ); ?>

						<ul id="archives-page" class="xoxo">
							<li id="category-archives" class="content-column">
								<h2><?php _e( 'Archives by Category', 'autofocus' ) ?></h2>
								<ul>
									<?php wp_list_categories( 'optioncount=1&feed=RSS&title_li=&show_count=1' ) ?> 
								</ul>
							</li>

							<li id="monthly-archives" class="content-column">
								<h2><?php _e( 'Archives by Month', 'autofocus' ) ?></h2>
								<ul>
									<?php wp_get_archives( 'type=monthly&show_post_count=1' ) ?>
								</ul>
							</li>
						</ul><!-- #archives-page -->

						<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>

					</div><!-- .entry-content -->

				</article><!-- #post-## -->

				<?php /* Only show the Comments Form if the post has comments open */
					if ( comments_open() || get_comments_number() != '0' ) {
						comments_template( '', true ); 
					} ?>

<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>