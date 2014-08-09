<?php
/**
 * The template for displaying the footer.
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */
?>
	</div><!-- #main -->

	<footer role="contentinfo">

<?php /* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' ); ?>

		<div id="colophon">

			<div id="site-info">
				<?php autofocus_display_footer_text(); ?>
			</div><!-- #site-info -->

		</div><!-- #colophon -->

	</footer><!-- #footer -->

</div><!-- #wrapper -->

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
