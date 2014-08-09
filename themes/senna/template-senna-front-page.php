<?php 
/*
Template Name: Home Page
*/
get_header();
global $wpGrade_Options;

    if ( $wpGrade_Options->get('homepage_use_slider') ) {

        $hps_query = new WP_Query(array(
            'post_type' => 'homepage_slide',
            'posts_per_page' => '-1',
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ));
        if ( $hps_query->have_posts() ) : ?>

            <div class="slider slider-front-page loading" width="500px">
                <div class="slider-pattern"></div>
                <div class="flexslider" id="frontpage_slider">
                    <ul class="slides">
                        <?php while ( $hps_query->have_posts() ) : $hps_query->the_post(); ?>
                            <li class="slide">

                                <?php $image = get_post_meta(get_the_ID(), '_senna_homepage_slide_image', true);
                                if ( !empty($image) ) {
                                    echo '<div class="featured-image" style="background-image:url(\''.$image.'\')"></div>';
                                }
                                $slide_has_video = false;
                                $the_video = '';

                                $videos = wpgrade_post_videos_ids(get_the_ID());

                                isset( $videos['youtube'] ) ?  $youtube_id = $videos['youtube'] : $youtube_id = '';
                                isset( $videos['vimeo'] ) ? $vimeo_id = $videos['vimeo'] : $vimeo_id = '';

                                if ( !empty($youtube_id) ) {
                                    $the_video = '<div class="youtube_frame" id="ytplayer_'.get_the_ID().'" data-ytid="'.$youtube_id.'"></div>';
                                    $slide_has_video = true;
                                    } elseif ( !empty($vimeo_id) ) {
                                    $the_video = '<iframe class="vimeo_frame" id="video_'.get_the_ID().'" src="http://player.vimeo.com/video/'.$vimeo_id.'?api=1&player_id=player_'.get_the_ID().'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                                    $slide_has_video = true;
                                    } elseif( !empty( $video_embed ) ) {
                                    $slide_has_video = true;
                                    $the_video = '<div class="video-wrap">' . stripslashes(htmlspecialchars_decode($video_embed)) . '</div>';
                                } else {
                                    $video_m4v = get_post_meta(get_the_ID(), '_senna_video_m4v', true);
                                    $video_webm = get_post_meta(get_the_ID(), '_senna_video_webm', true);
                                    $video_ogv = get_post_meta(get_the_ID(), '_senna_video_ogv', true);
                                    $video_poster = get_post_meta(get_the_ID(), '_senna_video_poster', true);

                                    if ( !empty($video_m4v) || !empty($video_webm) || !empty($video_ogv) || !empty($video_poster) ) {
                                        $slide_has_video = true;
                                        ob_start();
                                        wpGrade_video_selfhosted(get_the_ID());
                                        $the_video = ob_get_clean();
                                    }
                                } ?>
                                <div class="container">
                                    <div class="row">
                                        <div class="slide-content <?php if ( $slide_has_video ) echo 's-video'?>">

                                            <?php
                                            if ( $slide_has_video ) {
                                                echo '<div class="slide-video" >'.$the_video.'</div>';
                                            }
                                            $caption = get_post_meta(get_the_ID(), '_senna_homepage_slide_caption', true);
                                            if ( !empty($caption) ) {
                                                echo '<div';
                                                if ( $slide_has_video ) echo ' class="slide-content-wrapper" ';
                                                echo '>'.do_shortcode($caption);
                                            }
                                            $label = get_post_meta(get_the_ID(), '_senna_homepage_slide_label', true);
                                            $link = get_post_meta(get_the_ID(), '_senna_homepage_slide_link', true);
                                            if ( !empty($label) && !empty($link) ) {
                                                echo '<a href="'.$link.'" class="btn btn-slider btn-transparent">'.$label.'</a></div>';
                                            } ?>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        <?php endif;
    } // end if use slider

    if ( $wpGrade_Options->get('homepage_content1') ) {?>

	<div class="wrapper">
		<div class="container">
			<?php echo do_shortcode($wpGrade_Options->get('homepage_content1')); ?>
		</div>
    </div>
    <?php }
    if ( $wpGrade_Options->get('homepage_use_portfolio') ) {?>
        <div class="wrapper">
            <?php portfolio_front_page() ?>
        </div>
    <?php }
    if ( $wpGrade_Options->get('homepage_content2') ) {?>

        <div class="wrapper">
            <div class="container">
                <?php echo do_shortcode($wpGrade_Options->get('homepage_content2')); ?>
            </div>
        </div>

    <?php }

get_footer(); ?>