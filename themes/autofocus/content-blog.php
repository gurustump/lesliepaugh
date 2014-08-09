<?php
/**
 * The loop that displays posts in the AutoFocus blog.
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */
?>

<?php /* Display the Blog post content */ ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php autofocus_posted_on(); ?>
		</header>

		<div class="entry-content">
			<?php the_content( __( 'Continue reading', 'autofocus' ) . ' <span class="meta-nav">&rarr;</span>' ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages: ', 'autofocus' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-utility">
			<?php autofocus_post_meta(); ?>

			<?php comments_popup_link( '<span class="comments-link">' . __( 'Leave a comment', 'autofocus' ) . '</span>', '<span class="comments-link">' . __( '1 Comment', 'autofocus' ) . '</span>', '<span class="comments-link">' . __( '% Comments', 'autofocus' ) . '</span>', '', '' ); ?>

			<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-utility -->
	</article><!-- #post-## -->
			
