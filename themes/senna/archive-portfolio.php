<?php
/**
 * The template for displaying Archive Portfolio.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpGrade
 * @since wpGrade 1.0
 */

 get_header();

global $wpGrade_Options;
$archive_template = $wpGrade_Options->get('portfolio_archive_template');
if (empty($archive_template))
{
	get_template_part('templates/portfolio', 'full');
}
else {
	get_template_part('templates/portfolio', $archive_template);
}

get_footer(); ?>