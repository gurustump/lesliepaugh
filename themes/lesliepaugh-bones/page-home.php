<?php
/*
 Template Name: Home Page
*/
?>

<?php get_header(); ?>
			<div id="content">
				<div id="inner-content">
						<div id="main" role="main">
							<div class="slider home-slider HOME_SLIDER">
								<div class="slider-controls">
									<a href="#" class="prev PREV"><span>Previous</span></a>
									<a href="#" class="next NEXT"><span>Next</span></a>
								</div>
								<ul class="slider-panel SLIDER_PANEL">
								<?php
								$homeSlides = get_posts(array( 'post_type' => 'homepage_slide', 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ));
								if ( isset($homeSlides[0]) ) { 
									foreach($homeSlides as $key => $slide) { 
									$image = get_post_meta($slide->ID, '_senna_homepage_slide_image', true); ?>
									<li <?php echo $key == 0 ? 'class="active"' : ''; ?>>
										<img src="<?php echo $image; ?>" alt="<?php echo $slide->post_name; ?>" />
									</li>
									<?php /*
										echo '<pre>';
										print_r($slide);
										echo '</pre>';
										echo '<pre>';
										$image = get_post_meta($slide->ID, '_senna_homepage_slide_image', true);
										echo $image;
										echo '<br />';
										echo $slide->ID;
										echo '<br />';
										print_r(get_post_meta($slide->ID));
										echo '<br />';
										echo '</pre>';
									*/ ?>
									<?php }
								}
								?>
								</ul>
							</div>
<?php /*
  <h1>H1 heading</h1>
  <h2>H2 heading</h2>
  <h3>H3 heading</h3>
  <h4>H4 heading</h4>
  <h5>H5 heading</h5>
  <h6>H6 heading</h6>
  <p>paragraph</p>
*/ ?>

						</div><?php // end main ?>
				</div><?php // end inner-content ?>
			</div><?php //end content ?>
<?php get_footer(); ?>
