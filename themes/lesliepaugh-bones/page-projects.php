<?php
/*
 Template Name: Projects Page
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<div id="main" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<h1 class="page-title"><?php the_title(); ?></h1>
							<div class="slider project-slider PROJECT_SLIDER">
								<div class="slider-controls">
									<a href="#" class="prev PREV"><span>Previous</span></a>
									<a href="#" class="next NEXT"><span>Next</span></a>
								</div>
								<ul class="slider-panel SLIDER_PANEL">
								<?php
								$projectSlides = get_posts(array( 'post_type' => 'portfolio', 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ));
								if ( isset($projectSlides[0]) ) { 
									foreach($projectSlides as $key => $slide) { 
									$image = get_post_meta($slide->ID, '_senna_homepage_slide_image', true); ?>
									<li <?php echo $key == 0 ? 'class="active"' : ''; ?>>
										<img src="<?php echo $image; ?>" alt="<?php echo $slide->post_name; ?>" />
									</li>
									<?php }
								} ?>
								</ul>
							</div>
							<section class="entry-content cf wrap" itemprop="articleBody">
								<?php the_content(); ?>
							</section>
							<?php endwhile; endif; ?>

						</div>

				</div>

			</div>


<?php get_footer(); ?>
