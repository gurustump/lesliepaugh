
	<?php
		global $wpGrade_Options;
		$template = '';
		if (is_single()) {
			$template = ' ' . $wpGrade_Options->get('blog_single_template');
		} else {
			$template = ' ' . $wpGrade_Options->get('blog_archive_template');
		}
	?>

    <?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>
    	<div id="sidebar1" class="clearfix widget-area sidebar <?php echo $template ?>" role="complementary">
       		<?php dynamic_sidebar( 'sidebar1' ); ?>
    	</div>
    <?php endif; ?>
