<?php global $wpGrade_Options;
    global $post;
    $html_title = get_post_meta(get_the_ID(), '_senna_post_html_title', true);
    if ( has_post_thumbnail( $post->ID ) || !empty($html_title) ) { ?>
        <div class="wrapper page-header-wrapper">
            <?php wpgrade_get_thumbnail('full', 'featured-image', true );
            $html_title = get_post_meta(get_the_ID(), '_senna_post_html_title', true);
            if ( !empty($html_title) ) {?>
                <div class="container">
                    <div class="row">
                        <section class="page-header span12 bigger-headings">
                            <?php echo apply_filters('the_content', $html_title ); ?>
                        </section>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="site-content span8 offset2" role="main">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
                <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/Article">
            
                    <?php get_template_part( 'templates/post-templates/single-head', get_post_format() ); ?>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages(); ?>
					</div><!-- .entry-content -->
                    
                    <footer class="article-footer">
                        <?php the_tags(_x('<div class="article-tags pull-left">Tags: <ul class="article-tag-list"><li class="article-tag">', wpGrade_txtd), '</li><li class="article-tag">', '</li></ul></div>'); ?>
                        <div class="article-links push-right">
                            <ul class="article-link-list">
							<?php if ( $wpGrade_Options->get('blog_single_show_share_links') ): ?>
								<li class="article-link"><?php _e("Share on:", wpGrade_txtd); ?></li>
								<?php if ( $wpGrade_Options->get('blog_single_share_links_twitter') ): ?>
                                <li class="article-link"><a href="https://twitter.com/intent/tweet?original_referer=<?php echo urlencode(get_permalink(get_the_ID()))?>&amp;source=tweetbutton&amp;text=<?php echo urlencode(get_the_title())?>&amp;url=<?php echo urlencode(get_permalink(get_the_ID()))?>&amp;via=<?php echo $wpGrade_Options->get( 'twitter_card_site' ) ?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Twitter!', wpGrade_txtd) ?>">Twitter</a></li>
								<?php endif; ?>
								<?php if ( $wpGrade_Options->get('blog_single_share_links_facebook') ): ?>
                                <li class="article-link"><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink(get_the_ID()))?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Facebook!', wpGrade_txtd) ?>">Facebook</a></li>
								<?php endif; ?>
								<?php if ( $wpGrade_Options->get('blog_single_share_links_googleplus') ): ?>
								<li class="article-link"><a href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink(get_the_ID()))?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Google+!', wpGrade_txtd) ?>">Google+</a></li>
								<?php endif; ?>
							<?php endif; ?>
                                <li class="article-link to-top"><a href="#top" title="<?php _e("Jump to the top of the page", wpGrade_txtd); ?>">&uarr; <?php _e("Back to top", wpGrade_txtd); ?></a></li>
                            </ul>
                        </div>
                    </footer>
					<?php if ( $wpGrade_Options->get('blog_single_show_author') ) {
						get_template_part('templates/components/blog-single-author-box');
					} ?>
                    <?php comments_template(); ?>
                </article> <!-- end article -->
            
                <?php endwhile; ?>
            
                <?php else : ?>
            
                <article id="post-not-found" class="hentry clearfix">
                    <header class="article-header">
                        <h1><?php _e("Oops, Post Not Found!", wpGrade_txtd); ?></h1>
                    </header>
                    <section class="entry-content">
                        <p><?php _e("Uh Oh. Something is missing. Try double checking things.", wpGrade_txtd); ?></p>
                    </section>
                    <footer class="article-footer">
                        <p><?php _e("This is the error message in the single.php template.", wpGrade_txtd); ?></p>
                    </footer>
                </article>
            
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
