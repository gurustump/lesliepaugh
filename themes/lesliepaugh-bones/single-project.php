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
				<div class="slider-container SLIDER_CONTAINER">
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
							
								<?php if (!empty($image[image_video]) && !empty($image[image_embed])) { ?>
								<a href="#video_<?php echo $imgKey; ?>" class="TRIGGER_VID_OV">
									<span class="ic-vid">Play</span>
								<?php } ?>
								<img src="<?php echo $image[image]; ?>" alt="<?php echo $image[image_title]; ?>" />
								<?php if (!empty($image[image_video]) && !empty($image[image_embed])) { ?>
								</a>
								<div class="vid-ov VID_OV" id="video_<?php echo $imgKey; ?>">
									<input class="VIDSRC" type="hidden" value='<?php echo $image[image_embed]; ?>' />
									<div class="vid-container VID_CONTAINER"></div>
								</div>
								<?php } ?>
								<?php /*
								<div class="caption">
									<?php echo $image[image_caption]; ?>
								</div>
								*/ ?>
							</li>
						<?php } } ?>
						</ul>
					</div>
				</div>
				<div id="inner-content" class="cf">
						<div id="main" role="main">
							<?php
							$projects = get_posts(array(
								'post_type' => 'project',
								'numberposts' => -1,
								'meta_query' => array(
									'relation' => 'AND',
									array(
										'key' => '_senna_project_featured',
										'value' => 'on',
										'compare' => '='
									)
								),
								'meta_key' => '_senna_project_order',
								'orderby' => 'meta_value_num',
								'order' => 'ASC' 
							));
							if ( isset($projects[0]) ) {  ?>
							<ul class="projects-list PROJECTS_LIST">
								<?php foreach($projects as $key => $project) { 
								$location = get_post_meta($project->ID, '_senna_project_location', true); ?>
								<li<?php if (get_the_ID() == $project->ID) { echo ' class="current"'; } ?>>
									<a id="subnav_<?php echo $project->ID; ?>" href="<?php echo get_permalink($project->ID); ?>">
										<span class="h2"><?php echo $project->post_title; ?></span>
										<span class="h3"><?php echo $location; ?></span>
									</a>
								</li>
								<?php } ?>
							</ul>
							<?php } ?>
							<?php /* if (have_posts()) : while (have_posts()) : the_post(); ?>
							<h1 class="page-title"><?php the_title(); ?></h1>
							<section class="entry-content cf wrap" itemprop="articleBody">
								<?php the_content(); ?>
							</section>
							<?php endwhile; endif; */ ?>
						</div>
				</div>
			</div>
<?php get_footer(); ?>
