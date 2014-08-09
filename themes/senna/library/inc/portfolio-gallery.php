<?php

//=====================================
//Portfolio functions
//=====================================

// Replace the standard meta box callback with our own
// this so we can condition what posts format appear by custom post type
add_action( 'add_meta_boxes', 'wpGrade_add_meta_boxes' );
function wpGrade_add_meta_boxes( $post_type )
{
    if ( ! get_post_type_object( $post_type ) ) {
        // It's a comment or a link, or something else
        return;
    }
    remove_meta_box( 'formatdiv', $post_type, 'side' );
    add_meta_box( 'wpGrade_formatdiv', __( 'Format', wpGrade_txtd ), 'wpGrade_post_format_meta_box', $post_type, 'side', 'core' );
}

function wpGrade_post_format_meta_box( $post, $box ) {
    if ( current_theme_supports( 'post-formats' ) && post_type_supports( $post->post_type, 'post-formats' ) ) :
        $post_formats = get_theme_support( 'post-formats' );

        // This is our extra code
        // If the post type has registered post formats, use those instead
        if ( is_array( $GLOBALS['_wp_post_type_features'][$post->post_type]['post-formats'] ) ) {
            $post_formats = $GLOBALS['_wp_post_type_features'][$post->post_type]['post-formats'];
        }

        if ( is_array( $post_formats[0] ) ) :
            $post_format = get_post_format( $post->ID );
            if ( !$post_format )
                $post_format = '0';
            // Add in the current one if it isn't there yet, in case the current theme doesn't support it
            if ( $post_format && !in_array( $post_format, $post_formats[0] ) )
                $post_formats[0][] = $post_format;
            ?>
            <div id="post-formats-select">
                <input type="radio" name="post_format" class="post-format" id="post-format-0" value="0" <?php checked( $post_format, '0' ); ?> /> <label for="post-format-0"><?php _e('Standard', wpGrade_txtd); ?></label>
                <?php foreach ( $post_formats[0] as $format ) : ?>
                    <br /><input type="radio" name="post_format" class="post-format" id="post-format-<?php echo esc_attr( $format ); ?>" value="<?php echo esc_attr( $format ); ?>" <?php checked( $post_format, $format ); ?> /> <label for="post-format-<?php echo esc_attr( $format ); ?>"><?php echo esc_html( get_post_format_string( $format ) ); ?></label>
                <?php endforeach; ?><br />
            </div>
        <?php endif; endif;
}

//given and array of numbers find the position that is closest to the $search
function find_closest_number($search, $arr, $key)
{
    $closest = null;
    $closest_key = 0;
    foreach($arr as $current_key => $item)
    {
        if($closest === null || abs($search - $closest) > abs($item[$key] - $search))
        {
            $closest = $item[$key];
            $closest_key = $current_key;
        }
    }
    return $closest_key;
}

//generate the markup for the home page portfolio section
function portfolio_front_page()
{
	global $wpGrade_Options, $post;
	//show only 3 on the home page by default
	$number = 3;
	
//	if ($wpGrade_Options->get('homepage_portfolio_limit'))
//	{
//		$number = absint($wpGrade_Options->get('homepage_portfolio_limit'));
//	}
	//the width/height ratio of the sizes
	$portfolio_ratios = 
		array(
			'long' => 2.592,
			'tall' => 0.649,
			'small' => 1.299,
		);
	
	//the patterns for 6 portfolio items, 3 per row, with 9 columns grid
	$portfolio_patterns = 
		array(
			array('small','long','big','tall'),
			array('big','tall','small','long'),
			array('long','small','small','big', 'small'),
			array('long','small','tall','big'),
			array('small','big','small','long','small'),
			array('long','small','tall','big'),
		);

    //$featured_query = new WP_Query( array('post_type' => 'portfolio', 'posts_per_page' => $number));
    $query_args = array(
        'post_type'         => 'portfolio',
        'posts_per_page'    => $number,
        'meta_key'          => '_senna_portfolio_featured',
        'orderby'           => 'meta_value date',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => '_senna_portfolio_featured',
                'compare' => '=',
                'value' => 'on'
            ),
        )
    );
   
    $featured_projects = get_posts( $query_args );
	
    // if we don't have enough featured posts we fill them with reqular posts
   if ( count($featured_projects) < $number ) {
       $squery_args = array(
           'post_type'         => 'portfolio',
           'posts_per_page'    => $number - count($featured_projects),
		   'orderby'           => 'date',
           'meta_query' => array(
               'relation' => 'OR',
               array(
                   'key' => '_senna_portfolio_featured',
                   'compare' => '!=',
                   'value' => 'on'
               ),
               array(
                   'key' => '_senna_portfolio_featured',
                   'compare' => 'NOT EXISTS',
                   'value' => ''
               ),
           )
       );
       $regular_projects = get_posts( $squery_args );
	   
	   $featured_projects = array_merge($featured_projects, $regular_projects);
   } ?>
	<div class="row portfolio_frontpage portfolio_items">
		<?php
			/* Start the Loop */ 
			$counter = 0;
		    foreach ($featured_projects as $key=>$post): setup_postdata( $post );  ?>
			<?php if ($counter < $number): ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				  <ul>
				<?php
					// get the big image
					$video_markup = (get_post_format() == 'video') ? '<div class="video_icon"><span></span></div>' : '';
					$video_class = (get_post_format() == 'video') ? 'video_type' : '';
					$video_poster = get_post_meta(get_the_ID(), '_senna_video_poster', true);
					if (!empty($video_poster))
					{
						global $wpdb;
						$uploads_dir_info = wp_upload_dir();
						$temp_poster = str_replace($uploads_dir_info['baseurl'].'/', '', $video_poster);
						$featured_image_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $temp_poster));
						
						if (!empty($featured_image_id))
						{
							//get the rest of the gallery without the featured image
							$attachments = get_posts( array(
								'post_type' => 'attachment',
								'post_mime_type' => 'image',
								'posts_per_page' => -1,
								'post_parent' => get_the_ID(),
								'exclude'     => $featured_image_id
							) );
						}
						else
						{
							//get the gallery
							$attachments = get_posts( array(
								'post_type' => 'attachment',
								'post_mime_type' => 'image',
								'posts_per_page' => -1,
								'post_parent' => get_the_ID(),
							) );
						}
						
					} elseif (has_post_thumbnail( get_the_ID() ))
					{
						$featured_image_id = get_post_thumbnail_id(get_the_ID());
						
						//get the rest of the gallery without the featured image
						$attachments = get_posts( array(
							'post_type' => 'attachment',
							'post_mime_type' => 'image',
							'posts_per_page' => -1,
							'post_parent' => get_the_ID(),
							'exclude'     => $featured_image_id
						) );
					}
					else
					{
						//get all the images in the gallery
						$attachments = get_posts( array(
							'post_type' => 'attachment',
							'post_mime_type' => 'image',
							'posts_per_page' => -1,
							'post_parent' => get_the_ID()
						) );
						
						//we use the first image in the gallery for the big one
						if (!empty($attachments[0]))
						{
							$featured_image_id = $attachments[0]->ID;
							//delete the first image from the array
							array_shift($attachments);
						}
					}
					
					if ( !empty($attachments) ) 
					{
						//make an array with images url, width, height and ratio of width/height
						$attachment_images = array();
						foreach ( $attachments as $attachment ) 
						{
							$attachment_images[$attachment->ID] = wp_get_attachment_image_src($attachment->ID, 'full');
							$attachment_images[$attachment->ID]['ratio'] = $attachment_images[$attachment->ID][1] / $attachment_images[$attachment->ID][2];
						}
						
						//lets go through the pattern and find the right images for each position
						$pattern_counter = 0;
						foreach ($portfolio_patterns[$counter%6] as $pattern )
						{
							//if it's not the big one, we've found that earlier
							if ($pattern != 'big')
							{
								//if we still have images
								if (!empty($attachment_images))
								{
									//put the "Portfolio" box
									if ($counter == 0 && $pattern == 'long')
									{
										echo '<li class="'.$pattern.' text big-portfolio" >
												<a href="'.get_portfolio_page_link().'">
													<div class="title"><div>'.$wpGrade_Options->get('homepage_portfolio_title').'</div></div>
													<div class="border"><span></span></div>
												</a>
											</li>';
									}
									elseif ($counter == 2 && $pattern_counter == 4 && $pattern == 'small') //put the "More" box
									{
										echo '<li class="'.$pattern.' text more-portfolio" >
												<a href="'.get_portfolio_page_link().'">
													<div class="title"><div>'.$wpGrade_Options->get('homepage_portfolio_more').'</div></div>
													<div class="border"><span></span></div>
												</a>
											</li>';
									}
									else
									{
										//find the best image for this size
										$image_ID = find_closest_number($portfolio_ratios[$pattern], $attachment_images, "ratio");
										//delete the image from the array
										unset($attachment_images[$image_ID]);
										$image_src = wp_get_attachment_image_src($image_ID, $pattern );
										echo '<li class="'.$pattern.'" style="background-image:url('.$image_src[0].')">
											<a href="'.get_permalink(get_the_ID()).'">
												<div class="border"><span></span></div>
											</a>
										</li>';
									}
								}
								else
								{
									//put the "Portfolio" box
									if ($counter == 0 && $pattern == 'long')
									{
										echo '<li class="'.$pattern.' text big-portfolio" >
												<a href="'.get_portfolio_page_link().'">
													<div class="title"><div>'.__('Portfolio', wpGrade_txtd).'</div></div>
													<div class="border"><span></span></div>
												</a>
											</li>';
									}
									elseif ($counter == 2 && $pattern_counter == 4 && $pattern == 'small') //put the "More" box
									{
										echo '<li class="'.$pattern.' text more-portfolio" >
												<a href="'.get_portfolio_page_link().'">
													<div class="title"><div>'.__('More', wpGrade_txtd).'</div></div>
													<div class="border"><span></span></div>
												</a>
											</li>';
									}
									else
									{
										//we output an empty box, just color
										echo '<li class="'.$pattern.' empty" ><a href="'.get_post_type_archive_link('portfolio').'">
													<div class="border"><span></span></div>
												</a></li>';
									}
								}
							}
							else
							{
								if (!empty($featured_image_id))
								{
									$image_src = wp_get_attachment_image_src($featured_image_id, $pattern );
									echo '<li class="big '.$video_class.'" style="background-image:url('.$image_src[0].')">
									<a href="'.get_permalink(get_the_ID()).'">'.
										$video_markup
										.'<div class="title"><div><hr>'.get_the_title().'</div></div>
										<div class="border"><span></span></div>
									</a>
									</li>';
								}
								else if (!empty($video_poster))
								{
									echo '<li class="big '.$video_class.'" style="background-image:url('.$video_poster.')">
									<a href="'.get_permalink(get_the_ID()).'">'.
										$video_markup
										.'<div class="title"><div><hr>'.get_the_title().'</div></div>
										<div class="border"><span></span></div>
									</a>
									</li>';
								} 
								else
								{
									echo '<li class="'.$pattern.' empty '.$video_class.'">
										<a href="'.get_permalink(get_the_ID()).'">'.
										$video_markup
										.'<div class="title"><div><hr>'.get_the_title().'</div></div>
										<div class="border"><span></span></div>
									</a>
									</li>';
								}
							}
							$pattern_counter++;
						}
					}
					else
					{
						//we don't have any attachments except the featured image
						if (!empty($featured_image_id))
						{

							$image_src = wp_get_attachment_image_src($featured_image_id, 'large' );
							echo '<li class="xbig '.$video_class.'" style="background-image:url('.$image_src[0].')">
							<a href="'.get_permalink(get_the_ID()).'">'.
								$video_markup
								.'<div class="title"><div><hr>'.get_the_title().'</div></div>
								<div class="border"><span></span></div>
							</a>
							</li>';
						}
						else if (!empty($video_poster))
						{
							echo '<li class="xbig '.$video_class.'" style="background-image:url('.$video_poster.')">
							<a href="'.get_permalink(get_the_ID()).'">'.
								$video_markup
								.'<div class="title"><div><hr>'.get_the_title().'</div></div>
								<div class="border"><span></span></div>
							</a>
							</li>';
						} 
						else
						{
							echo '<li class="xbig empty '.$video_class.'">
								<a href="'.get_permalink(get_the_ID()).'">'.
								$video_markup
								.'<div class="title"><div><hr>'.get_the_title().'</div></div>
								<div class="border"><span></span></div>
							</a>
							</li>';
						}
					}
				?>
				  </ul>
				</article>
			<?php endif;
			$counter++;
			endforeach;
        wp_reset_postdata(); ?>
	</div>
    <?php
}

// different pagination for portfolio - not the number of projects from the Reading section
function portfolio_posts_per_page( $query ) {
    /*  If this isn't the main query, we'll avoid altering the results. */
    if ( !$query->is_main_query() || is_admin() )
        return;

    global $wpGrade_Options;
    if ( !empty($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'portfolio' ) {
        if (is_archive())
            $query->query_vars['posts_per_page'] = $wpGrade_Options->get('portfolio_archive_limit') ? absint($wpGrade_Options->get('portfolio_archive_limit')) : 5;
    }
    return $query;
}
add_filter( 'pre_get_posts', 'portfolio_posts_per_page' );

function portfolio_archive($number = 3, $offset = 0)
{
    //the width/height ratio of the sizes
    $portfolio_ratios =
        array(
            'long' => 2.592,
            'tall' => 0.649,
            'small' => 1.299,
        );

    //the patterns for 6 portfolio items, 3 per row, with 9 columns grid
    $portfolio_patterns =
        array(
            array('small','long','big','tall'),
            array('big','tall','small','long'),
            array('long','small','small','big', 'small'),
            array('long','small','tall','big'),
            array('small','big','small','long','small'),
            array('long','small','tall','big'),
        );
    global $paged;
    $paged = 1;
    if ( get_query_var('paged') ) $paged = get_query_var('paged');
    if ( get_query_var('page') ) $paged = get_query_var('page');

    $wp_query = new WP_Query( array('post_type' => 'portfolio', 'posts_per_page' => $number, 'paged'=>$paged));
    ?>
    <div class="row portfolio_archive portfolio_items" data-maxpages="<?php echo $wp_query->max_num_pages ?>">
    <?php
    /* Start the Loop */
    $counter = 0;
    ?>
    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

        <?php
        //Get Project Categories
        $project_categories = '';
        $terms = get_the_terms(get_the_ID(), 'portfolio_cat');
        if (!empty($terms))
        {
            foreach ($terms as $term) {
                $project_categories .= 'cat-'.str_replace(' ','-',$term->name).' ';
            }
        }

        //add another selector class
        $project_categories .= 'portfolio-item';
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class($project_categories); ?>>
            <ul>
                <?php
                // get the big image
                $video_markup = (get_post_format() == 'video') ? '<div class="video_icon"><span></span></div>' : '';
                $video_class = (get_post_format() == 'video') ? 'video_type' : '';
                $video_poster = get_post_meta(get_the_ID(), '_senna_video_poster', true);
                if (!empty($video_poster))
                {
                    global $wpdb;
                    $uploads_dir_info = wp_upload_dir();
                    $temp_poster = str_replace($uploads_dir_info['baseurl'].'/', '', $video_poster);
                    $featured_image_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $temp_poster));

                    if (!empty($featured_image_id))
                    {
                        //get the rest of the gallery without the featured image
                        $attachments = get_posts( array(
                            'post_type' => 'attachment',
                            'post_mime_type' => 'image',
                            'posts_per_page' => -1,
                            'post_parent' => get_the_ID(),
                            'exclude'     => $featured_image_id
                        ) );
                    }
                    else
                    {
                        //get the rest of the gallery without the featured image
                        $attachments = get_posts( array(
                            'post_type' => 'attachment',
                            'post_mime_type' => 'image',
                            'posts_per_page' => -1,
                            'post_parent' => get_the_ID(),
                        ) );
                    }

                }
                elseif (has_post_thumbnail( get_the_ID() ))
                {
                    $featured_image_id = get_post_thumbnail_id(get_the_ID());

                    //get the rest of the gallery without the featured image
                    $attachments = get_posts( array(
                        'post_type' => 'attachment',
                        'post_mime_type' => 'image',
                        'posts_per_page' => -1,
                        'post_parent' => get_the_ID(),
                        'exclude'     => $featured_image_id
                    ) );
                }
                else
                {
                    //get all the images in the gallery
                    $attachments = get_posts( array(
                        'post_type' => 'attachment',
                        'post_mime_type' => 'image',
                        'posts_per_page' => -1,
                        'post_parent' => get_the_ID()
                    ) );

                    //we use the first image in the gallery for the big one
                    if (!empty($attachments[0]))
                    {
                        $featured_image_id = $attachments[0]->ID;
                        //delete the first image from the array
                        array_shift($attachments);
                    }
                }

                if ( !empty($attachments) )
                {
                    //make an array with images url, width, height and ratio of width/height
                    $attachment_images = array();
                    foreach ( $attachments as $attachment )
                    {
                        $attachment_images[$attachment->ID] = wp_get_attachment_image_src($attachment->ID, 'full');
                        $attachment_images[$attachment->ID]['ratio'] = $attachment_images[$attachment->ID][1] / $attachment_images[$attachment->ID][2];
                    }

                    //lets go through the pattern and find the right images for each position
                    foreach ($portfolio_patterns[$counter%6] as $pattern )
                    {
                        //if it's not the big one, we've found that earlier
                        if ($pattern != 'big')
                        {
                            //if we still have images
                            if (!empty($attachment_images))
                            {
                                //find the best image for this size
                                $image_ID = find_closest_number($portfolio_ratios[$pattern], $attachment_images, "ratio");
                                //delete the image from the array
                                unset($attachment_images[$image_ID]);
                                $image_src = wp_get_attachment_image_src($image_ID, $pattern );
                                echo '<li class="'.$pattern.'" style="background-image:url('.$image_src[0].')">
									<a href="'.get_permalink(get_the_ID()).'"><div class="border"><span></span></div></a>
									</li>';
                            }
                            else
                            {
                                echo '<li class="'.$pattern.' empty">
										<a href="'.get_permalink(get_the_ID()).'"><div class="border"><span></span></div></a>
									</li>';
                            }
                        }
                        else
                        {
                            if (!empty($featured_image_id))
                            {
                                $image_src = wp_get_attachment_image_src($featured_image_id, $pattern );
                                echo '<li class="big '.$video_class.'" style="background-image:url('.$image_src[0].')">
									<a href="'.get_permalink(get_the_ID()).'">'.
                                    $video_markup
                                    .'<div class="title"><div><hr>'.get_the_title().'</div></div>
										<div class="border"><span></span></div>
									</a>
									</li>';
                            }
                            else if (!empty($video_poster))
                            {
                                echo '<li class="big '.$video_class.'" style="background-image:url('.$video_poster.')">
									<a href="'.get_permalink(get_the_ID()).'">'.
                                    $video_markup
                                    .'<div class="title"><div><hr>'.get_the_title().'</div></div>
										<div class="border"><span></span></div>
									</a>
									</li>';
                            }
                            else
                            {
                                echo '<li class="'.$pattern.' empty '.$video_class.'">
										<a href="'.get_permalink(get_the_ID()).'">'.
                                    $video_markup
                                    .'<div class="title"><div><hr>'.get_the_title().'</div></div>
										<div class="border"><span></span></div>
									</a>
									</li>';
                            }
                        }
                    }
                }
                else
                {
                    //we don't have any attachments except the featured image
                    if (!empty($featured_image_id))
                    {
                        $image_src = wp_get_attachment_image_src($featured_image_id, 'large' );
                        echo '<li class="xbig '.$video_class.'" style="background-image:url('.$image_src[0].')">
							<a href="'.get_permalink(get_the_ID()).'">'.
                            $video_markup
                            .'<div class="title"><div><hr>'.get_the_title().'</div></div>
								<div class="border"><span></span></div>
							</a>
							</li>';
                    }
                    else if (!empty($video_poster))
                    {
                        echo '<li class="xbig '.$video_class.'" style="background-image:url('.$video_poster.')">
							<a href="'.get_permalink(get_the_ID()).'">'.
                            $video_markup
                            .'<div class="title"><div><hr>'.get_the_title().'</div></div>
								<div class="border"><span></span></div>
							</a>
							</li>';
                    }
                    else
                    {
                        echo '<li class="xbig empty '.$video_class.'">
								<a href="'.get_permalink(get_the_ID()).'">'.
                            $video_markup
                            .'<div class="title"><div><hr>'.get_the_title().'</div></div>
								<div class="border"><span></span></div>
							</a>
							</li>';
                    }
                }
                ?>
            </ul>
        </article>
        <?php $counter++;
    endwhile; ?>
    </div>
    <?php  ?>
    <div id="portfolio-nav">
        <?php
		global $wp_rewrite;
		
        $max_page = $wp_query->max_num_pages;
        if ( !$paged ) $paged = 1;
        $nextpage = intval($paged) + 1;
        if ($nextpage <= $max_page) {
			if ($wp_rewrite->permalink_structure == '')
			{
				
				echo  '<span class="older"><a href="'.add_query_arg('paged',$nextpage,get_post_type_archive_link('portfolio')).'">Older</a></span>'; //Older Link using max_num_pages
			}
			else
			{
				echo  '<span class="older"><a href="'.get_post_type_archive_link('portfolio').'page/'.$nextpage.'/">Older</a></span>'; //Older Link using max_num_pages
			}
			
        }
        $prevpage = intval($paged) - 1;
        if ($prevpage > 0) {
			if ($wp_rewrite->permalink_structure == '')
			{
				echo  '<span class="newer"><a href="'.add_query_arg('paged',$prevpage,get_post_type_archive_link('portfolio')).'">Newer</a></span>'; //Older Link using max_num_pages
			}
			else
			{
				echo  '<span class="newer"><a href="'.get_post_type_archive_link('portfolio').'page/'.$prevpage.'/">Newer</a></span>'; //Newer Link using max_num_pages
			}
        }
        ?>
    </div>
    <?php
    wp_reset_postdata();
    ?>
    <?php if ($wp_query->max_num_pages > $paged): ?>
    <div class="load_more"><a href="#"><h2 class="accent_color"><?php echo __('Load More...',wpGrade_txtd) ?></h2></a></div>
<?php endif;
}

function portfolio_single_gallery($postID)
{
    if (get_post_format($postID) == 'video'):
        $video_embed = get_post_meta($postID, '_senna_video_embed', true);
        if( !empty( $video_embed ) ) {
            echo '<div class="video-wrap-singleproject">' . stripslashes(htmlspecialchars_decode($video_embed)) . '</div>';
        } else {
            echo '<div class="audio-wrap-singleproject">';
            wpGrade_video_selfhosted($postID);
            echo '</div>';

        }
    endif;
    if (get_post_format($postID) == 'audio')
    {
        echo '<div class="audio-wrap-singleproject">';
        wpGrade_audio_selfhosted($postID);
        echo '</div>';
    } ?>
    <div class="portfolio_single_gallery">
        <ul>
            <?php
            // get the big image
            $video_poster = get_post_meta(get_the_ID(), '_senna_video_poster', true);
            if (!empty($video_poster) && get_post_format() == 'video')
            {
                global $wpdb;
                $uploads_dir_info = wp_upload_dir();
                $temp_poster = str_replace($uploads_dir_info['baseurl'].'/', '', $video_poster);
                $video_poster_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $temp_poster));
            }

            if (has_post_thumbnail( $postID ))
            {
                $featured_image_id = get_post_thumbnail_id($postID);
                $featured_image = get_post($featured_image_id);

                $exclude_ids = $featured_image_id;
                if (!empty($video_poster_id) && $featured_image_id != $video_poster_id)
                {
                    $exclude_ids .= ','.$video_poster_id;
                }

                //get the rest of the gallery without the featured image
                $attachments = get_posts( array(
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'posts_per_page' => -1,
                    'post_parent' => $postID,
                    'exclude'     => $exclude_ids
                ) );
            }
            else
            {
                if (!empty($video_poster_id))
                {
                    //get all the images in the gallery except the video poster
                    $attachments = get_posts( array(
                        'post_type' => 'attachment',
                        'post_mime_type' => 'image',
                        'posts_per_page' => -1,
                        'post_parent' => $postID,
                        'exclude'     => $video_poster_id
                    ) );
                }
                else
                {
                    //get all the images in the gallery
                    $attachments = get_posts( array(
                        'post_type' => 'attachment',
                        'post_mime_type' => 'image',
                        'posts_per_page' => -1,
                        'post_parent' => $postID
                    ) );
                }

                //we use the first image in the gallery for the big one
                if (!empty($attachments[0]))
                {
                    $featured_image = $attachments[0];
                    //delete the first image from the array
                    array_shift($attachments);
                }
            }

            if (!empty($featured_image))
            {
                //put the big one in place
                $image_src = wp_get_attachment_image_src($featured_image->ID, 'project-big' );
                $image_full_src = wp_get_attachment_image_src($featured_image->ID, 'full' );
                $image_alt = get_post_meta($featured_image->ID, '_wp_attachment_image_alt', true);
                if (empty($image_alt))
                {
                    $image_alt = $featured_image->post_title;
                }

                $image_caption = $featured_image->post_excerpt;
                echo '<li class="big" ><a class="popup" href="'.$image_full_src[0].'" title="'.$featured_image->post_title.'">
									<div class="title"><div><span>+</span></div></div>
									<div class="border"><span></span></div>
									<img src="'.$image_src[0].'" alt="'.$image_alt.'" itemprop="image" />
								</a></li>';

                //also calculate the height factor of the big image
                $featured_height_factor = 2*100*$image_src[2]/$image_src[1];
            }
            else
            {
                $featured_height_factor = 0;
            }

            if ( !empty($attachments) )
            {
                $height_factor_sum = 0;
                //lets go through the attachment images
                foreach ($attachments as $attachment )
                {
                    //get the image data
                    $image_src = wp_get_attachment_image_src($attachment->ID, 'project-small' );
                    $image_full_src = wp_get_attachment_image_src($attachment->ID, 'full' );
                    $image_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
                    if (empty($image_alt))
                    {
                        $image_alt = $attachment->post_title;
                    }
                    $image_caption = $attachment->post_excerpt;

                    // if we still have space on the right of the featured image, put more small images
                    // we still put an image if more than 75% of the right image fits
                    if ($height_factor_sum < $featured_height_factor && (($featured_height_factor-$height_factor_sum) > 100*$image_src[2]/$image_src[1]*0.50))
                    {
                        //we make small images
                        echo '<li class="small"><a class="popup" href="'.$image_full_src[0].'" title="'.$attachment->post_title.'">
									<div class="title"><div><span>+</span></div></div>
									<div class="border"><span></span></div>
									<img src="'.$image_src[0].'" alt="'.$image_alt.'" />
								</a></li>';
                    }
                    else
                    {
                        //we make half size images
                        echo '<li class="medium"><a class="popup" href="'.$image_full_src[0].'" title="'.$attachment->post_title.'">
									<div class="title"><div><span>+</span></div></div>
									<div class="border"><span></span></div>
									<img src="'.$image_src[0].'" alt="'.$image_alt.'" />
								</a></li>';
                    }

                    //update the height_factor_sum by adding that of the current image
                    $height_factor_sum += 100*$image_src[2]/$image_src[1];
                }
            }
            ?>
        </ul>
    </div>
<?php
}

function get_portfolio_page_link() {
    global $wpdb;

    $results = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta
    WHERE meta_key='_wp_page_template' AND meta_value='template-portfolio.php'");

    if (!empty($results))
    {
        $page_id = '';
        foreach ($results as $result)
        {
            $page_id = $result->post_id;
            $the_template_page = get_post( $page_id );
            if ( $the_template_page->post_status == 'publish' ) {
                break;
            } else {
                $page_id = 'doesnt_exists';
            }
        }

        if ( $page_id == 'doesnt_exists' ) {
            return get_post_type_archive_link('portfolio');
        } else {
            return get_page_link($page_id);
        }
    }
    else
    {
        //fallback to the archive slug
        return get_post_type_archive_link('portfolio');
    }
}

//get an array of the most used tags with filter
function wpGrade_get_most_used_tags( $args = '' ) {
    $defaults = array(
        'orderby' => 'name', 'order' => 'ASC',
        'exclude' => '', 'include' => '',
        'taxonomy' => 'post_tag',
    );
    $args = wp_parse_args( $args, $defaults );

    return get_terms( $args['taxonomy'], array_merge( $args, array( 'orderby' => 'count', 'order' => 'DESC' ) ) ); // Always query top tags
}

?>