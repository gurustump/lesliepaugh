<?php
/*
 Template Name: Home Page
*/
?>

<?php get_header(); ?>
			<div id="content">
				<div class="slider-container SLIDER_CONTAINER">
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
							$image = get_post_meta($slide->ID, '_senna_homepage_slide_image', true); 
							$video = get_post_meta($slide->ID, '_senna_homepage_slide_embed', true); ?>
							<li <?php echo $key == 0 ? 'class="active"' : ''; ?>>
								<?php if (!empty($video)) { ?>
								<a href="#video_<?php echo $key; ?>" class="TRIGGER_VID_OV">
									<span class="ic-vid">Play</span>
								<?php } ?>
								<img src="<?php echo $image; ?>" alt="<?php echo $slide->post_name; ?>" />
								<?php if (!empty($video)) { ?>
								</a>
								<div class="vid-ov VID_OV" id="video_<?php echo $key; ?>">
									<input class="VIDSRC" type="hidden" value='<?php echo $video; ?>' />
									<div class="vid-container VID_CONTAINER"></div>
								</div>
								<?php } ?>
							</li>
							<?php }
						} ?>
						</ul>
					</div>
				</div>
				<div id="inner-content">
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
