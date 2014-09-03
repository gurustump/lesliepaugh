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
				<div class="slider-container">
					<div class="slider project-slider PROJECT_SLIDER">
						<div class="slider-controls">
							<a href="#" class="prev PREV"><span>Previous</span></a>
							<a href="#" class="next NEXT"><span>Next</span></a>
						</div>
						<ul class="slider-panel SLIDER_PANEL">
						<?php 
						$projectImages = get_post_meta(get_the_ID(), '_senna_project_gallery_images',true);
						 /*?><li style="opacity:1;text-align:left;"><pre><?php print_r($projectImages) ?></pre></li><?php */
						if ( isset($projectImages[0] ) ) { foreach($projectImages as $imgKey => $image) { ?>
							<li <?php echo $imgKey == 0 ? 'class="active"' : ''; ?>>
								<img src="<?php echo $image[image]; ?>" alt="<?php echo $image[image_title]; ?>" />
							</li>
						<?php } } ?>
						</ul>
					</div>
				</div>
				<div id="inner-content" class="wrap cf">
						<div id="main" role="main">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<h1 class="page-title"><?php the_title(); ?></h1>
							<section class="entry-content cf wrap" itemprop="articleBody">
								<?php the_content(); ?>
							</section>
							<?php endwhile; endif; ?>
						</div>
				</div>
			</div>
<?php get_footer(); ?>
