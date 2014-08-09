<?php
/**
 * AutoFocus Image Functions
 *
 * Builds the functions, galleries, and sliders for images. 
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
*/



/**
 * Create the AutoFocus entry image loop
 */
function autofocus_entry_image( $af_size = 'medium' ) {
	global $post;
	
	/* Is Flickr is enabled? */
	if ( get_post_meta( get_the_ID(), 'enable_flickr', true ) ) : 
	
		/* Set Flickr Sizes */
		$af_flickr_size = null;
		if ( $af_size == 'full' || $af_size == 'large' || $af_size == 'single-post-thumbnail' || $af_size == 'front-page-thumbnail' || $af_size == 'full-post-thumbnail' ) { 
			$af_flickr_size = '_b';
		} elseif ( $af_size == 'medium' ) { 
			$af_flickr_size = '_z';
		} elseif ( $af_size == 'thumbnail' || $af_size == 'archive-thumbnail' ) {
			$af_flickr_size = '_z';
		} ?>

		<span class="entry-image flickr-image">
			<a class="entry-image-post-link" title="<?php printf( esc_attr__( '%s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" href="<?php the_permalink(); ?>">
				<img src="<?php echo get_flickr_set_primary_uri( get_the_ID(), $af_flickr_size ); ?>" class="attachment-ha-full-gallery wp-post-image" alt="<?php printf( esc_attr__( 'View %s &rarr;', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" />
			</a>
		</span><!-- .entry-image -->
		<?php autofocus_image_credit(); ?>	
	
	<?php elseif ( has_post_thumbnail() ) : ?>

		<span class="entry-image">
			<a class="entry-image-post-link" title="<?php printf( esc_attr__( '%s aaa', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( $af_size ); ?>
			</a>
		</span><!-- .entry-image -->
		<?php autofocus_image_credit(); ?>	

	<?php else : 

		$linkedimgtag = get_post_meta( get_the_ID(), 'image_tag', true );

		$args = array(
			'order'          => 'ASC',
			'post_type'      => 'attachment',
			'post_parent'    => get_the_ID(),
			'post_mime_type' => 'image',
			'post_status'    => null,
			'numberposts'    => 1,
		);

		$attachments = get_posts( $args );
		
		if ( $attachments ) {
			foreach ( $attachments as $attachment ) { ?>
			
				<span class="entry-image">
					<a class="entry-image-post-link" title="<?php printf( esc_attr__( '%s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" href="<?php the_permalink(); ?>">
						<?php echo wp_get_attachment_image( $attachment->ID, $af_size ); ?>
					</a>
				</span><!-- .entry-image -->
				<?php autofocus_image_credit(); ?>	

			<?php }

		} elseif ( $linkedimgtag != '' ) { ?>
				<span class="entry-image">
					<a class="entry-image-post-link" title="<?php printf( esc_attr__( '%s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" href="<?php the_permalink(); ?>">
						<?php echo $linkedimgtag; ?>
					</a>
				</span><!-- .entry-image -->
				<?php autofocus_image_credit(); ?>	

		<?php } else { 
			echo '<!-- ' . __( 'This post does not have an image attachment :-/', 'autofocus' ) . ' -->';
		}
		
		endif;

}





/**
 *	Setup Images for posts without attachments
 */
function autofocus_entry_image_setup( $postid ) {
	global $post;
	$post = get_post( $postid );

	/* Get url */
	if ( ! preg_match( '/<img ([^>]*)src=(\"|\')(.+?)(\2)([^>\/]*)\/*>/', $post->post_content, $matches ) ) {
		return false;
	}

	/* Url setup */
	$post->image_url = $matches[3];
	if ( ! $post->image_url = preg_replace('/\?w\=[0-9]+/','', $post->image_url ) )
		return false;

	$post->image_url = esc_url( $post->image_url, 'raw' );
	
	delete_post_meta( $post->ID, 'image_url' );
	delete_post_meta( $post->ID, 'image_tag' );

	add_post_meta( $post->ID, 'image_url', $post->image_url );
	add_post_meta( $post->ID, 'image_tag', '<img src="' . $post->image_url . '" />' );

}
add_action( 'publish_post', 'autofocus_entry_image_setup' );
add_action( 'publish_page', 'autofocus_entry_image_setup' );





/**
 *	Image Author/Credit Display
 */
function autofocus_image_credit() { 
	global $post;
		
	if ( get_post_meta( get_the_ID(), 'autofocus_copyright_value', true ) ) {  ?>
		<span class="photo-credit"><?php echo get_post_meta( get_the_ID(), 'autofocus_copyright_value', true ); ?></span>
	<?php } elseif ( get_the_author_meta( 'user_url' ) == '' ) { ?>
		<span class="photo-credit">&copy; <?php the_time( 'Y' ); ?> <?php the_author_meta( 'display_name' ); ?>. <?php _e( 'All rights reserved.', 'autofocus' ); ?></span>
	<?php } else { ?>
		<span class="photo-credit">&copy; <?php the_time( 'Y' ); ?> <a href="<?php the_author_meta( 'user_url' ); ?>" target="_blank" rel="author"><?php the_author_meta( 'display_name' ); ?></a>. <?php _e( 'All rights reserved.', 'autofocus' ); ?></span>
	<?php } ?>

<?php } 





/**
 * Create the AutoFocus image slider
 */
function autofocus_single_entry_image( $af_size = 'full-post-thumbnail', $af_slider_count ) {
	global $post;

		/* Show Flickr Image */
		if ( get_post_meta( get_the_ID(), 'autofocus_enable_flickr', true ) ) { 
			
			/* Pull images from Flickr and display them in the slider */
			if ( get_post_meta( get_the_ID(), 'autofocus_show_gallery', true ) == 'on' ) :

				get_flickr_photo_slider( $af_size, $af_slider_count );
			
			else : ?>
			
			<div class="entry-image-container">
				<?php autofocus_entry_image( $af_size ); ?>
			</div><!-- .entry-image-container -->

			<?php endif;

		/* Show Video */
		} elseif ( get_post_meta( get_the_ID(), 'autofocus_videoembed_value', true ) ) {  ?>

			<div class="entry-video-container">
				<?php 
					$af_video_url = get_post_meta( get_the_ID(), 'autofocus_videoembed_value', true );
					$oembed_url = wp_oembed_get( $af_video_url, array( 'width' => 800, 'height' => 600 ) );
					echo $oembed_url; 
				?>
			</div><!-- .entry-video-container -->

		<?php /* Show Gallery */
		} elseif ( ( get_post_meta( get_the_ID(), 'autofocus_show_gallery', true) == 'on' ) ) { ?>

			<div class="entry-gallery-container">
				<div id="cycle-gallery" class="cycle">
					<?php 
						$af_slider_count = get_post_meta( get_the_ID(), 'autofocus_slider_count_value', true );
						$args = array(
							'order' => 'ASC',
							'orderby' => 'menu_order ID',
							'post_type' => 'attachment',
							'post_parent' => get_the_ID(),
							'post_mime_type' => 'image',
							'post_status' => null,
							// Change the number of images to show in the gallery below
							'numberposts' => $af_slider_count, 
						);
						$attachments = get_posts( $args );
						if ( $attachments ) {
							foreach ( $attachments as $attachment ) {
								echo "\t\t\t\t\t<span class=\"entry-image\">" . wp_get_attachment_image( $attachment->ID, $af_size, false, false ) . "</span>\n";
							}
						} ?>
				</div><!-- .cycle -->
			</div><!-- .entry-gallery-container	 -->

		<?php } else { ?>
	
			<div class="entry-image-container">
				<?php autofocus_entry_image( $af_size ); ?>
			</div><!-- .entry-image-container -->
		<?php } 
}




/**
 *	Grab EXIF Data from Attachments
 *	http://www.bloggingtips.com/2008/07/20/wordpress-gallery-and-exif/
 */
function autofocus_display_exif_data() {
	global $id, $post;

	$imgmeta = wp_get_attachment_metadata( $id );

	$shutterspeed_meta = $imgmeta['image_meta']['shutter_speed'];
	if ( $shutterspeed_meta > 0 ) {
		$display_shutterspeed_meta = "1/" . 1 / $shutterspeed_meta;
	} else {
		$display_shutterspeed_meta = 0;
	}

	/* Start to display EXIF and IPTC data of digital photograph */
	echo '<h3 id="exif-data">' . __('Exif Data', 'autofocus') . '</h3>';
	echo '<ul>';
	echo '<li><span class="exif-title">' . __('Date Taken:', 'autofocus') . '</span> ' . date( "d-M-Y H:i:s", $imgmeta['image_meta']['created_timestamp'] ) . '</li>';
	echo '<li><span class="exif-title">' . __('Copyright:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['copyright'] . '</li>';
	echo '<li><span class="exif-title">' . __('Credit:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['credit'] . '</li>';
	echo '<li><span class="exif-title">' . __('Title:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['title'] . '</li>';
	echo '<li><span class="exif-title">' . __('Caption:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['caption'] . '</li>';
	echo '<li><span class="exif-title">' . __('Camera:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['camera'] . '</li>';
	echo '<li><span class="exif-title">' . __('Focal Length:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['focal_length'] . 'mm</li>';
	echo '<li><span class="exif-title">' . __('Aperture:', 'autofocus') . '</span> f/' . $imgmeta['image_meta']['aperture'] . '</li>';
	echo '<li><span class="exif-title">' . __('ISO:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['iso'] . '</li>';
	echo '<li><span class="exif-title">' . __('Shutter Speed:', 'autofocus') . '</span> ' . $display_shutterspeed_meta . '</li>';
	echo '</ul>';
}





/**
 *	Get the Post Thumbnail URL for the EXIF link
 */
function autofocus_exif_link( $post_id = NULL, $size = 'full-post-thumbnail', $attr = '' ) {
	global $id;
	$post_id = ( NULL === $post_id ) ? $id : $post_id;
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	$size = apply_filters( 'full-post-thumbnail', $size );
	if ( $post_thumbnail_id ) { 
		$thumburl = get_attachment_link( $post_thumbnail_id, $size, false, $attr );
	} else {
		$thumburl = '';
	}
	return $thumburl;
}

