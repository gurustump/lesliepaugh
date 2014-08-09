<?php get_header(); ?>
<div class="content">
    <div class="container">
        <div id="primary" class="content-area archive">

            <?php
            global $wpGrade_Options;
            $archive = $wpGrade_Options->get('blog_archive_template');

            get_template_part('templates/blog', $archive); ?>

        </div><!-- #primary .content-area -->

    </div>
</div> <!-- End .content -->
<?php get_footer(); ?>