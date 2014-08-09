<?php
/*
Template Name: Portfolio Page
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