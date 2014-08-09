<?php get_header(); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div class="wrapper page-wrapper" itemscope itemtype="http://schema.org/WebPage">
            <div class="container">
                <div class="row">
                    <div class="span7">
                       <?php portfolio_single_gallery(get_the_ID()) ?>
                    </div>
                    <div class="span5 l_portfolio_content fade_in">
                        <div class="navigation-portfolio">
                            <?php wpgrade_content_nav('single-nav'); ?>
                        </div>
                        <h1 itemprop="name"><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>

    <?php //comments_template();
    endwhile; endif; ?>

<?php get_footer(); ?>