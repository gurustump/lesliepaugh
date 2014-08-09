<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpGrade
 * @since wpGrade 1.0
 */

get_header(); ?>
<?php
    global $wpGrade_Options;
    $archive = $wpGrade_Options->get('blog_archive_template');
    get_template_part('templates/blog', $archive); ?>

<?php get_footer(); ?>