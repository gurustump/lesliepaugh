<?php
/*
Template Name: Contact Page
*/
get_header(); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post();
        global $wpGrade_Options;

        $hide_title = get_post_meta(get_the_ID(), '_senna_page_display_title', true);

        if ( !is_front_page() && $hide_title != "on" ) {
            if ( $wpGrade_Options->get('contact_use_gmap') ) { ?>
                <div id="gmap" class="wrapper page-header-wrapper contact-header-wrapper ">
                    <div id="map_canvas" style="width: 100%; height: 100%"></div>

                    <div class="container ">
                        <div class="row contact-info-wrapper" data-gmap-url="<?php echo $wpGrade_Options->get('contact_gmap_link'); ?>">
                            <div class="contact-info accent-background" >
                                <ul class="contact-details">
                                    <?php if (  $wpGrade_Options->get('contact_phone') ) { ?>
                                        <li class="contact-details-item">
                                            <div class="contact-detail-icon">
                                                <i class="icon-phone"></i>
                                            </div>
                                            <div class="contact-detail-text"><?php echo $wpGrade_Options->get('contact_phone'); ?></div>
                                        </li>
                                    <?php }
                                    if (  $wpGrade_Options->get('contact_email') ) { ?>
                                        <li class="contact-details-item">
                                            <div class="contact-detail-icon">
                                                <i class="icon-envelope-alt"></i>
                                            </div>
                                            <div class="contact-detail-text"><a href="mailto:<?php echo $wpGrade_Options->get('contact_email'); ?>"><?php echo $wpGrade_Options->get('contact_email'); ?></a></div>
                                        </li>
                                    <?php }
                                    if (  $wpGrade_Options->get('contact_address') ) { ?>
                                        <li class="contact-details-item">
                                            <div class="contact-detail-icon">
                                                <i class="icon-map-marker"></i>
                                            </div>
                                            <div class="contact-detail-text"><?php echo $wpGrade_Options->get('contact_address'); ?></div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } else { ?>

                <div class="wrapper page-header-wrapper contact-header-wrapper ">
                    <?php wpgrade_get_thumbnail('full', 'featured-image', true ); ?>
                </div>

            <?php }
        } ?>

        <div class="wrapper page-wrapper page-contact">
            <div class="container">
                <div class="row">
                    <div class="contact-content span5">
                        <?php echo apply_filters('the_content', $wpGrade_Options->get('contact_content_left') ) ?>
                    </div>
                    <div class="contact-form-container span7">
                        <?php /*echo apply_filters('the_content', $wpGrade_Options->get('contact_content_right') );*/

                        if ( $wpGrade_Options->get('contact_form_title') ) {
                            echo '<h3>'.$wpGrade_Options->get('contact_form_title').'</h3>';
                        }
                        if ( $wpGrade_Options->get('contact_form_7') ) {
                            echo do_shortcode( '[contact-form-7 id="'.$wpGrade_Options->get('contact_form_7').'"]' );
                        }?>


                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper the-content-contact">
            <div class="container">
                <?php the_content(); ?>
            </div>
        </div>

        <?php 
    //comments_template();
    endwhile; endif; ?>

<?php get_footer(); ?>