<?php get_header(); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post();
        global $post;
        // The user can choose to hide the wordpress title and put his own with visual editor
        $html_title = get_post_meta(get_the_ID(), '_senna_page_html_title', true);

        if ( has_post_thumbnail( $post->ID ) || !empty($html_title) ) { ?>
            <div class="wrapper page-header-wrapper">
                <?php wpgrade_get_thumbnail('full', 'featured-image', true );

                if ( !empty($html_title) ) {?>
                    <div class="container">
                        <div class="row">
                            <section class="page-header span12 bigger-headings">
                                <?php echo apply_filters('the_content', $html_title ); ?>
                            </section>
                        </div>
                    </div>
                <?php }?>
            </div>
        <?php }
        $hide_title = get_post_meta(get_the_ID(), '_senna_page_display_title', true);
        if ( $hide_title != "on" ) {  ?>
                <div class="wrapper entry-header-wrapper">
                    <header class="entry-header">
                        <hr>
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header><!-- .entry-header -->
                </div>
            <?php }?>

            <div class="wrapper">
                <div class="container">
                  <?php the_content() ?>
                </div>
            </div>

        <?php
    //comments_template();
    endwhile; endif;
get_footer(); ?>