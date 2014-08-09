<div class="page-header-wrapper wrapper-small">
    <?php
    global $wpGrade_Options;
    if ( $wpGrade_Options->get('blog_header_image') ) { ?>
        <div class="featured-image" style="background-image: url('<?php echo $wpGrade_Options->get('blog_header_image') ?>');" ></div>
    <?php } ?>
    <div class="container">
        <div class="row">
            <header class="page-header span12">
                <h4 class="page-title pull-left">
                    <?php
                    if ( is_search() ){
                        printf( __( '%s', wpGrade_txtd ), '<span>Search Results :</span>' );
                    } elseif ( is_category() ) {
                        printf( __( '%s', wpGrade_txtd ), '<span>' . single_cat_title( '', false ) . '</span>' );

                    } elseif ( is_tag() ) {
                        printf( __( 'Tag: %s', wpGrade_txtd ), '<span>' . single_tag_title( '', false ) . '</span>' );

                    } elseif ( is_author() ) {
                        /* Queue the first post, that way we know
                         * what author we're dealing with (if that is the case).
                        */
                        the_post();
                        printf( __( 'Author Archives: %s', wpGrade_txtd ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
                        /* Since we called the_post() above, we need to
                         * rewind the loop back to the beginning that way
                         * we can run the loop properly, in full.
                         */
                        rewind_posts();

                    } elseif ( is_day() ) {
                        printf( __( 'Daily Archives: %s', wpGrade_txtd ), '<span>' . get_the_date() . '</span>' );

                    } elseif ( is_month() ) {
                        printf( __( 'Monthly Archives: %s', wpGrade_txtd ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

                    } elseif ( is_year() ) {
                        printf( __( 'Yearly Archives: %s', wpGrade_txtd ), '<span>' . get_the_date( 'Y' ) . '</span>' );

                    } else {
                        if ($wpGrade_Options->get('blog_archive_title')){
							echo $wpGrade_Options->get('blog_archive_title');
						} else{
							_e( 'Blog & News.', wpGrade_txtd );
						}

                    }
                    ?>
                </h4>
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
                if ( $wpGrade_Options->get('blog_display_dropdown') ) { ?>
				<a href="#" class="btn btn-transparent push-right categories-dropdown-toggle"><i class="icon-th-large"></i> <?php echo __('Categories',wpGrade_txtd) ?></a>
				<?php } ?>
            </header><!-- .page-header -->
        </div>
    </div>
</div>

<?php 
	if ( $wpGrade_Options->get('blog_display_dropdown') ) {
		get_template_part('templates/components/blog-header-dropdown'); 
	} ?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="site-content span8 push4 archive" role="main">
                <?php if (have_posts()) : ?>

                <?php /* Start the Loop */ ?>
                <?php while (have_posts()) : the_post(); ?>


                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="row">
                        <div class="span12">
                         
							<?php get_template_part( 'templates/post-templates/single-head', get_post_format() ); ?>
                            
							<div class="entry-content">
								<?php echo wpgrade_better_excerpt(get_the_content()); ?>
							</div><!-- .entry-content -->
                           
                        </div>
                    </div>
                </article><!-- #post-<?php the_ID(); ?> -->

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>

            <?php wp_grade_pagination(); ?>

            <?php else : ?>

                <?php get_template_part( 'no-results', 'index' ); ?>

            <?php endif; ?>
            </div>
            <div class="span4 pull8">
                <?php get_sidebar(); ?>
            </div>
        </div> <!-- End .row -->
    </div>
</div>
    