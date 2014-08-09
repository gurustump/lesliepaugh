<?php get_header(); ?>

    <?php
    global $wpGrade_Options;
    $single_template = $wpGrade_Options->get('blog_single_template');
	if (empty($single_template))
	{
		get_template_part('templates/single', 'full');
	}
	else {
		get_template_part('templates/single', $single_template);
	} ?>

<?php get_footer(); ?>
