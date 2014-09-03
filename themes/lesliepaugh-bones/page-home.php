<?php
/*
 Template Name: Home Page
*/
?>

<?php get_header(); ?>
			<div id="content">
				<ul class="slider-container SLIDER_CONTAINER">
					<li>
						<div class="slider home-slider HOME_SLIDER">
							<div class="slider-controls">
								<a href="#" class="prev PREV"><span>Previous</span></a>
								<a href="#" class="next NEXT"><span>Next</span></a>
							</div>
							<ul class="slider-panel SLIDER_PANEL active">
							<?php
							$homeSlides = get_posts(array(
								'post_type' => 'homepage_slide',
								'numberposts' => -1,
								'orderby' => 'menu_order',
								'order' => 'ASC'
							));
							if ( isset($homeSlides[0]) ) { 
								foreach($homeSlides as $key => $slide) { 
								$image = get_post_meta($slide->ID, '_senna_homepage_slide_image', true); ?>
								<li <?php echo $key == 0 ? 'class="active"' : ''; ?>>
									<img src="<?php echo $image; ?>" alt="<?php echo $slide->post_name; ?>" />
								</li>
								<?php }
							} ?>
							</ul>
						<div>
					</li>
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
					if ( isset($projects[0]) ) { foreach($projects as $key => $project) { ?>
					<li>
						<div class="slider project-slider PROJECT_SLIDER_<?php echo $project->ID; ?>">
							<div class="slider-controls">
								<a href="#" class="prev PREV"><span>Previous</span></a>
								<a href="#" class="next NEXT"><span>Next</span></a>
							</div>
							<ul class="slider-panel SLIDER_PANEL active">
							<?php 
							$projectImages = get_post_meta($project->ID, '_senna_project_gallery_images',true);
							 /*?><li style="opacity:1;text-align:left;"><pre><?php print_r($projectImages) ?></pre></li><?php */
							if ( isset($projectImages[0] ) ) { foreach($projectImages as $imgKey => $image) { ?>
								<?php if ($image[image_featured] == 'on') { ?>
								<li <?php echo $imgKey == 0 ? 'class="active"' : ''; ?>>
									<img src="<?php echo $image[image]; ?>" alt="<?php echo $image[image_title]; ?>" />
								</li>
								<?php } ?>
							<?php } } ?>
							</ul>
						</div>
					</li>
					<?php } } ?>
				</ul>
				<div id="inner-content" class="wrap">
					<div id="main" role="main">
						<?php
						if ( isset($projects[0]) ) {  ?>
						<ul class="projects-list PROJECTS_LIST">
							<?php foreach($projects as $key => $project) { 
							$location = get_post_meta($project->ID, '_senna_project_location', true); ?>
							<li>
								<a id="subnav_<?php echo $project->ID; ?>" href="<?php echo get_permalink($project->ID); ?>">
									<span class="h2"><?php echo $project->post_title; ?></span>
									<span class="h3"><?php echo $location; ?></span>
								</a>
							</li>
							<?php } ?>
						</ul>
						<?php } ?>
					</div><?php // end main ?>
				</div><?php // end inner-content ?>
			</div><?php //end content ?>
<?php get_footer(); ?>
