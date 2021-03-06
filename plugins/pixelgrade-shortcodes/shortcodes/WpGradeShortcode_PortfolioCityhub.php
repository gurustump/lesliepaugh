<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_PortfolioCityhub extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->self_closed = true;
        $this->direct = false;
        $this->name = "Portfolio";
        $this->code = "portfolio";
        $this->icon = "icon-qrcode";

	    // prepare categories
	    $opts_cats = get_terms('portfolio_cat', array( 'fields' => 'all' ) );

	    $all_categories = array();
	    if ( !is_wp_error($opts_cats) ) {
		    foreach( $opts_cats as $key => $opt_cat ) {
			    $all_categories[$key] = $opt_cat->slug;
	        }
	    }

        $this->params = array(
	        'title' => array(
		        'type' => 'text',
		        'name' => 'Title',
		        'admin_class' => 'span12'
	        ),
            'number' => array(
                'type' => 'text',
                'name' => 'Number of Items',
                'admin_class' => 'span6'
            ),
            'class' => array(
                'type' => 'text',
                'name' => 'Class',
                'admin_class' => 'span5 push1'
            ),
	        'orderby' => array(
		        'type' => 'select',
		        'name' => 'Order By',
		        'options' => array('' => '-- Default --', 'date' => 'Date', 'title' => 'Title', 'rand' => 'Random'),
		        'admin_class' => 'span6'
	        ),
	        'order' => array(
		        'type' => 'select',
		        'name' => 'Order',
		        'options' => array('' => '-- Select order --', 'ASC' => 'Ascending', 'DESC' => 'Descending'),
		        'admin_class' => 'span5 push1'
	        ),
            array(
                'type' => 'info',
                'value' => 'If you want specific projects, include bellow posts IDs separated by comma.'
            ),
            'include' => array(
	            'type' => 'text',
	            'name' => 'Include IDs',
	            'admin_class' => 'span6'
            ),
                'exclude' => array(
                'type' => 'text',
                'name' => 'Exclude IDs',
                'admin_class' => 'span5 push1'
            ),
	        'category' => array(
		        'type' => 'tags',
		        'name' => 'Category',
		        'admin_class' => 'span12',
		        'options' => $all_categories,
		        'value' => array( '' )
	        ),
        );

        add_shortcode('portfolio', array( $this, 'add_shortcode') );

        // frontend assets needs to be loaded after the add_shortcode function
        // $this->frontend_assets["js"] = array(
        //     'columns' => array(
        //         'name' => 'frontend_portfolio',
        //         'path' => 'js/shortcodes/frontend_portfolio.js',
        //         'deps'=> array( 'jquery' )
        //     )
        // );
        // add_action('wp_footer', array($this, 'load_frontend_assets'));
    }

    public function add_shortcode($atts){

        $this->load_frontend_scripts = true;

        // init vars
        $number = -1;
        $orderby = 'menu_order';
        $order = 'ASC';
	    $class = $title = '';
         extract( shortcode_atts( array(
	         'title' => '',
             'number' => '-1',
             'order' => 'ASC',
             'orderby' => 'menu_order',
             'include' => '',
             'exclude' => '',
	         'class' => '',
	         'category' => ''
         ), $atts ) );

        ob_start();

        $query_args = array(
            'post_type' => 'portfolio',
            'posts_per_page' => $number,
            'orderby' => $orderby,
            'order' => $order
        );

         if ( !empty( $include ) ) {
             $include_array = explode( ',', $include );
             $query_args['post__in'] = $include_array;
         }

         if ( !empty( $exclude ) ) {
             $exclude_array = explode( ',', $exclude );
             $query_args['post__not_in'] = $exclude_array;
         }

	    if ( !empty($category) ) {

		    $category = strtolower($category);
		    if ( strpos($category, ',') !== false ) {
			    $category = explode( ',', $category);
		    }

		    $query_args['tax_query'] = array(
			    'relation' => 'OR',
			    array(
				    'taxonomy' => 'portfolio_cat',
				    'field' => 'slug',
				    'terms' => $category
			    ),
		    );
	    }

        $query = new WP_Query($query_args);
	    if ( !empty( $query ) ) :
		    if ( $title ) : ?>
                <div class="portfolio-container">
				    <h2 class="featuredworks-title"><?php echo $title; ?></h2>
		    <?php else: ?>
                <div class="portfolio-container portfolio-container-no-title">
            <?php endif; ?>
			    <ul class="flex-direction-nav">
				    <li>
					    <a id="portfolio-works-previous" class="flex-prev" href="#"></a>
				    </li>
				    <li>
					    <a id="portfolio-works-next" class="flex-next" href="#"></a>
				    </li>
			    </ul>
			    <ul class="portfolio-items-list homepage-portfolio-items-list<?php if($query->post_count < 4) echo ' portfolio-items-list-full-width'; ?>">
				    <?php while ( $query->have_posts() ) : $query->the_post();
					    global $post;
//					    $thumb_url = false;
//						if ( has_post_thumbnail() ) {
//							$thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
//						} else { // get the first image attached
//							$args = array( 'post_type' => 'attachment', 'posts_per_page' => 1, 'post_status' => 'any', 'post_parent' => null );
//							$attachments = get_posts( $args );
//							if ( $attachments ) {
//								foreach ($attachments as $att ) {
//									$thumb_url = wp_get_attachment_url($att->ID);
//								}
//							}
//						} // end if has featured image
//					    if ( !empty($thumb_url) ) {
//						    echo '<img class="thumbnail" src="'. $thumb_url .'">';
//					    } ?>
					    <li class="portfolio-item <?php if(!has_post_thumbnail()) echo 'project-no-image '; ?>">
						    <a class="portfolio-item-link" href="<?php the_permalink(); ?>">
							    <div class="portfolio-item-featured-image">
								    <?php if(has_post_thumbnail()) the_post_thumbnail('homepage-portfolio'); ?>
							    </div>
							    <div class="portfolio-item-info">
								    <div class="portfolio-item-table">
									    <div class="portfolio-item-cell">
										    <h3 class="portfolio-item-title"><?php echo get_the_title(); ?></h3>
										    <?php $categories = get_the_terms($post->ID, 'portfolio_cat');
										    if($categories) : ?>
											    <hr class="separator light">
											    <ul class="portfolio-item-categories-list">
												    <?php foreach($categories as $cat){ ?>
													    <li class="portfolio-item-category">
														    <span class="portfolio-item-category-link"><?php echo $cat->name; ?></span>
													    </li>
												    <?php } ?>
											    </ul>
										    <?php endif; ?>
									    </div>
								    </div>
							    </div>
						    </a>
					    </li>
			        <?php
				    /* Restore original Post Data */
				    wp_reset_postdata();
				    endwhile; ?>
			    </ul>
		    </div>
	    <?php endif;wp_reset_query();
        return ob_get_clean();
    }
}