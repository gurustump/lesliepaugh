<?php

/*
 * Register Widgets areas.
 */

function wpgrade_register_sidebars() {

	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __('Sidebar 1', wpGrade_txtd),
		'description' => __('The first (primary) sidebar.', wpGrade_txtd),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'sidebar-footer',
		'name' => __('Footer', wpGrade_txtd),
		'description' => __('Widgets Area for footer.', wpGrade_txtd),
		'before_widget' => '<div class="span4"><div id="%1$s" class="widget %2$s"><hr class="left white">',
		'after_widget' => '</div></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	));

}
add_action('widgets_init', 'wpgrade_register_sidebars');

/*
 * Register custom widgets.
 */

/*
 * The social icons widget
 */
class wpgrade_social_links_widget extends WP_Widget {

	public function __construct()
	{
		parent::__construct( 'senna_social_links', __( 'Senna Social Links', wpGrade_txtd ), array('description' => __( "Display the social links defined in the theme's options", wpGrade_txtd )) );
	}

	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		global $wpGrade_Options;

		$social_links = $wpGrade_Options->get('social_icons');
		$target = '';
		if ( $wpGrade_Options->get('social_icons_target_blank') ) {
			$target = 'target="_blank"';
		}
		// Reset Post Data
		wp_reset_postdata();

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;
			if ($social_links) {?>
			<ul class="social-links">
				<?php foreach ($social_links as $domain => $value): ?>
				<?php if ($value): ?>
					<li class="social-link social-link-<?php echo $domain ?>">
						<a href="<?php echo $value ?>" <?php echo $target ?>></a>
					</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
			<?php }
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form($instance) {
		!empty($instance['title'])  ? $title = esc_attr($instance['title']) : $title = __('We Are Social',wpGrade_txtd); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', wpGrade_txtd); ?>:</label>
			<input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
	<?php }
}

/*
 * Display the latest posts
 */
class wpgrade_latest_posts_widget extends WP_Widget {
	
	public function __construct()
	{
		parent::__construct( 'wpgrade_latest_posts_widget', __('Senna Latest Posts',wpGrade_txtd), array('description' => __('Display the latest blog posts in your sidebar or footer', wpGrade_txtd)) );
	}

	function widget($args, $instance) {
		extract( $args );
		$title 		= apply_filters('widget_title', $instance['title']);
		// default to 4 posts
		$number 	= isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;

		// The Query
		$options = array( 'posts_per_page' => $number );
		$latest_posts = new WP_Query( $options );

		// Reset Post Data
		wp_reset_postdata();

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;
		if ( $latest_posts->have_posts() ): ?>
			<ul class="latest-posts">
				<?php while ( $latest_posts->have_posts() ) : $latest_posts->the_post(); ?>
					<li class="latest-posts-post">
						<a class="latest-posts-permalink" href="<?php the_permalink(); ?>">
							<article>
								<h4 class="latest-posts-title"><i class="icon-chevron-right"></i><?php the_title(); ?></h4>
								<div class="latest-posts-excerpt"><?php echo substr(get_the_excerpt(), 0, 180) . '...' ?></div>
							</article>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php endif;
		echo $after_widget;
		
		wp_reset_query();
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint($new_instance['number']);
		return $instance;
	}

	function form($instance) {
		!empty($instance['title'])  ? $title = esc_attr($instance['title']) : $title = __('From the Blog',wpGrade_txtd);
		// default to 4 posts
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4; ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php __('Title:', wpGrade_txtd); ?>
			</label>
			<input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">
				<?php __('Number of posts:', wpGrade_txtd); ?>
			</label>
			<input id="<?php echo $this->get_field_id('number'); ?>" class="widefat" type="number" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $number; ?>" />
		</p>
		<?php
	}
}

class wpgrade_dribbble_widget extends WP_Widget {
	
	public function __construct()
	{
		parent::__construct( 'wpgrade_dribbble_widget', __('Senna Dribbble Widget',wpGrade_txtd), array('description' => __('Display Dribbble images in your sidebar or footer', wpGrade_txtd)) );
	}

	function widget($args, $instance) {
		extract( $args );
		$title 		= apply_filters('widget_title', $instance['title']);
		$username 	= $instance['username'];

	    require_once('vendor/dribbble/src/Dribbble/Dribbble.php');
	    require_once('vendor/dribbble/src/Dribbble/Exception.php');
	    $dribbble = new Dribbble();

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;

		try {
			//limit the number of images
			$count = isset( $args['count'] ) ? absint( $args['count'] ) : 8;

		    $my_shots = $dribbble->getPlayerShots($username, 0, $count);
			// $my_shots = array_slice( $my_shots, 0, $count );
			
		    echo '<ul class="wpgrade-dribbble-items">';
		    
		    foreach ($my_shots->shots as $shot) {
		        echo '<li class="wpgrade-dribbble-item"><a href="' . $shot->url . '"><img src="' . $shot->image_teaser_url . '" alt="' . $shot->title . '"></a></li>';
		    }
			
		    echo '</ul>';
		}
		catch (DribbbleException $e) {
		    echo 'Upss... Something is wrong. Check the widget settings.';
		}

		echo $after_widget;
	}
	
	/**
	 * Validate and update widget options.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['count'] = absint( $new_instance['count'] );
		return $instance;
	}

	function form($instance) {
		$title = isset( $instance['title'] ) ? $instance['title'] : __('Dribbble shots',wpGrade_txtd);
		$username = isset ($instance['username']) ? esc_attr($instance['username']) : '';
		//default to 8 images
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 8;
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', wpGrade_txtd); ?>:</label>
			<input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Dribbble username', wpGrade_txtd); ?>:</label>
			<input id="<?php echo $this->get_field_id('username'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo $username; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of images',wpGrade_txtd); ?>:</label><br />
			<input type="number" min="1" max="20" value="<?php echo esc_attr( $count ); ?>" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" />
		</p>
		<?php
	}
}

/*
 * Display the tag cloud
 */
function custom_tag_cloud_widget($args)
{
	$args['number'] = 0; //adding a 0 will display all tags
	$args['largest'] = 19; //largest tag
	$args['smallest'] = 19; //smallest tag
	$args['unit'] = 'px'; //tag font unit
	$args['format'] = 'list'; //ul with a class of wp-tag-cloud
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'custom_tag_cloud_widget' );

/*
 * Display a Flickr photo stream
 */
class wpgrade_flickr_widget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct( 'wpgrade_flickr_widget', __('Senna Flickr Widget',wpGrade_txtd), array('description' => __('Display Flickr images in your sidebar or footer (maximum 20 but we recommend less).',wpGrade_txtd),) );
	}

	/**
	 * The widget contents
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) )
		{
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$photos = $this->get_photos( array(
			'username' => $instance['username'],
			'count' => $instance['count'],
			'tags' => $instance['tags'],
		) );

		if ( is_wp_error( $photos ) )
		{
			echo $photos->get_error_message();
		}
		else
		{
			echo '<ul class="wpgrade-flickr-items">';
			foreach ( $photos as $photo )
			{
				$link = esc_url( $photo->link );
				$src = esc_url($this->resize($photo->media->m));
				$title = esc_attr( $photo->title );
				$item = sprintf( '<a href="%s"><img src="%s" alt="%s" /></a>', $link, $src, $title );
				$item = sprintf( '<li class="wpgrade-flickr-item">%s</li>', $item );
				echo $item;
			}
			echo '</ul>';
		}

		echo $args['after_widget'];
	}

	/**
	 * Returns an array of photos
	 */
	private function get_photos( $args = array() )
	{
		// do some caching to prevent Flickr from banning us
		$transient_key = md5( 'wpgrade-flickr-cache-' . print_r( $args, true ) );
		$cached = get_transient( $transient_key );
		
		//if there is a cached version use that one
		if ( $cached )
		{
			return $cached;
		}

		$username = isset( $args['username'] ) ? $args['username'] : '';
		$tags = isset( $args['tags'] ) ? $args['tags'] : '';
		$count = isset( $args['count'] ) ? absint( $args['count'] ) : 8;
		$query = array('tagmode' => 'any','tags' => $tags);

		// If username is actually an RSS feed
		if ( preg_match( '#^https?://api\.flickr\.com/services/feeds/photos_public\.gne#', $username ) )
		{
			$url = parse_url( $username );
			$url_query = array();
			wp_parse_str( $url['query'], $url_query );
			$query = array_merge( $query, $url_query );
		}
		else
		{
			$user = $this->request( 'flickr.people.findByUsername', array( 'username' => $username ) );
			if ( is_wp_error( $user ) )
			{
				return $user;
			}

			$user_id = $user->user->id;
			$query['id'] = $user_id;
		}

		$photos = $this->request_feed( 'photos_public', $query );

		if ( ! $photos )
		{
			return new WP_Error( 'error', 'Something went wrong.' );
		}

		$photos = array_slice( $photos, 0, $count );
		//cache the photos for an hour
		set_transient( $transient_key, $photos, apply_filters( 'wpgrade_flickr_widget_cache_timeout', 3600 ) );
		return $photos;
	}

	/**
	 * Make a request to the Flickr API.
	 */
	private function request( $method, $args )
	{
		$args['method'] = $method;
		$args['format'] = 'json';
		// the api key we've aquired from Flickr
		$args['api_key'] = 'cf07a23ac8100c1b53c0fb164941bf62';
		$args['nojsoncallback'] = 1;
		$url = esc_url_raw( add_query_arg( $args, 'http://api.flickr.com/services/rest/' ) );

		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) )
		{
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
 		$obj = json_decode( $body );

		if ( $obj && $obj->stat == 'fail' )
		{
			return new WP_Error( 'error', $obj->message );
		}

		return $obj ? $obj : false;
	}

	/**
	 * Fetch items from the Flickr Feed API.
	 */
	private function request_feed( $feed = 'photos_public', $args = array() )
	{
		$args['format'] = 'json';
		$args['nojsoncallback'] = 1;
		$url = sprintf( 'http://api.flickr.com/services/feeds/%s.gne', $feed );
		$url = esc_url_raw( add_query_arg( $args, $url ) );

		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) )
		{
			return false;
		}
		
		$body = wp_remote_retrieve_body( $response );
		$body = preg_replace( "#\\\\'#", "\\\\\\'", $body );
 		$obj = json_decode( $body );

		return $obj ? $obj->items : false;

	}
	
	/**
	 * Modify the url to get a new size of the image
	 */
	private function resize($url, $size = 'square')
	{
		$url_array = explode('/', $url);
		//strip the filename
		$photo = array_pop($url_array);

		switch($size)
		{
		  case 'square': $suffix = '_s.';  break;
		  case 'thumbnail': $suffix = '_t.';  break;
		  case 'small': $suffix = '_m.';  break;
		  case 'm640': $suffix = '_z.';  break;
		  case 'm800': $suffix = '_c.';  break;
		  case 's320': $suffix = '_n.';  break; 
		  case 's150': $suffix = '_q.';  break;           
		  case 'large': $suffix = '_b.';  break;
		  default:  $suffix = '.';  break; // Medium
		}
		
		// replace the old size marker with the needed one
		$url_array[] =  preg_replace('/(_(s|t|c|n|q|m|b|z))?\./i', $suffix, $photo);
		return implode('/', $url_array);
	}

	/**
	 * Validate and update widget options.
	 */
	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['tags'] = strip_tags( $new_instance['tags'] );
		$instance['count'] = absint( $new_instance['count'] );
		return $instance;
	}

	/**
	 * Render widget controls.
	 */
	public function form( $instance )
	{
		$title = isset( $instance['title'] ) ? $instance['title'] : __('Flickr Shots',wpGrade_txtd);
		$username = isset( $instance['username'] ) ? $instance['username'] : '';
		$tags = isset( $instance['tags'] ) ? $instance['tags'] : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 8;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title',wpGrade_txtd); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Username or RSS url',wpGrade_txtd); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tags' ); ?>"><?php _e( 'Tags' ,wpGrade_txtd); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" type="text" value="<?php echo esc_attr( $tags ); ?>" /><br />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of images',wpGrade_txtd); ?>:</label><br />
			<input type="number" min="1" max="20" value="<?php echo esc_attr( $count ); ?>" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" />
		</p>

		<?php
	}
}

// Register the widgets
add_action('widgets_init', create_function('', 'return register_widget("wpgrade_social_links_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("wpgrade_dribbble_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("wpgrade_latest_posts_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("wpgrade_flickr_widget");'));
