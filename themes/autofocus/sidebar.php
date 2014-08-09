<?php
/**
 * The Sidebar containing the Singular Sidebar widget areas.
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */
?>

<?php if ( is_active_sidebar( 'singular-widget-area' ) ) : ?>
	
		<aside id="singular-sidebar" class="widget-area" role="complementary">
			<ul class="xoxo">

<?php if ( ! dynamic_sidebar( 'singular-widget-area' ) ) : ?>

		<?php dynamic_sidebar( 'singular-widget-area' ); ?>

<?php endif; // end Singular Widget Area ?>

			</ul>
		</aside><!-- #singular-sidebar .widget-area -->

<?php endif; // end singular sidebar check ?>
