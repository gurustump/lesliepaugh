    </div> <!-- end #content -->
            <?php global $wpGrade_Options;
            if ( $wpGrade_Options->get( 'use_site_wide_box' ) ) {?>
                <div class="wrapper call-to-action-wrapper">
                    <div class="container">
                        <div class="row">
                            <?php
                            $wide_content = $wpGrade_Options->get( 'site_wide_section' );
                            if ( !empty( $wide_content ) ) { ?>
                                <div class="call-to-action-text span5 offset2">
                                    <?php echo apply_filters('the_content', $wide_content ); ?>
                                </div>
                            <?php }
                            $CTA_label = $wpGrade_Options->get( 'site_wide_button_label' );
                            $CTA_link = $wpGrade_Options->get( 'site_wide_button_link' );
                            if ( !empty($CTA_label) && !empty($CTA_link) ) { ?>
                                <div class="call-to-action-button span4">
                                    <a class="btn" href="<?php echo $CTA_link; ?>"><?php echo $CTA_label; ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } // end of use_site_wide_box ?>
            <footer class="site-footer-wrapper wrapper">
                <div class="container">
                    <?php get_sidebar('footer'); ?>
                </div>
            </footer>
            <footer class="site-info wrapper">
                <div class="container">
                    <div class="row">
                        <div class="copyright">
                            <?php
                            $copyright =  $wpGrade_Options->get( 'copyright_text' );
                            if ( $copyright ) {
                                echo apply_filters('the_content', $copyright );
                            }?>
                        </div><!-- .site-info -->
                        <div class="footer-menu">
                            <?php wpgrade_footer_nav(); ?>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
     </div>   
    <?php wp_footer();?>
	<!-- Google Analytics tracking code -->
	<?php if ( $wpGrade_Options->get( 'google_analytics' ) ) {
		echo $wpGrade_Options->get( 'google_analytics' );
	} ?>
</body>
</html>