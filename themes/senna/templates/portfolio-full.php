<div class="page-header-wrapper wrapper-small">
    <?php
    global $wpGrade_Options;
    if ( $wpGrade_Options->get('portfolio_header_image') ) { ?>
    	<div class="featured-image" style="background-image: url('<?php echo $wpGrade_Options->get('portfolio_header_image') ?>');" ></div>
    <?php } ?>
	<div class="container">
		<div class="row">
			<header class="page-header span12">
				<h4 class="page-title pull-left"><?php echo $wpGrade_Options->get('portfolio_title') ?></h4>
				<?php
				if ( is_category() ) {
					// show an optional category description
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );

				} elseif ( is_tag() ) {
					// show an optional tag description
					$tag_description = tag_description();
					if ( ! empty( $tag_description ) )
						echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
				}
				?>
				<a href="#" class="btn btn-transparent push-right categories-dropdown-toggle"><i class="icon-th-large"></i> <?php echo __('Filter By...',wpGrade_txtd) ?></a>
			</header><!-- .page-header -->
		</div>
	</div>
</div>

<?php get_template_part('templates/components/portfolio-header-dropdown'); ?>

<div class="wrapper portfolio-grid">
		<?php if (have_posts()) : ?>
			<?php portfolio_archive($wpGrade_Options->get('portfolio_archive_limit') ? absint($wpGrade_Options->get('portfolio_archive_limit')) : 6,0); /*get the image gallery thingy*/ ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<?php get_template_part( 'no-results', 'index' ); ?>
		<?php endif; ?>
</div>
