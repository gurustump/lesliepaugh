<?php get_header(); ?>
<?php
    global $wpGrade_Options;
    $archive = $wpGrade_Options->get('blog_archive_template');
    get_template_part('templates/blog', $archive); ?>

<?php get_footer(); ?>