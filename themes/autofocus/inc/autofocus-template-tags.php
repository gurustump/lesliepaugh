<?php
/**
 * Template tags for AutoFocus 
 *
 * Creates various functions and template tags used throught this theme 
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */



/**
 * Display Author Avatar
 */
function autofocus_author_info_avatar() {
    global $wp_query; 
    $curauth = $wp_query->get_queried_object();
	
	$email = $curauth->user_email;
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( "$email" ) );
	echo $avatar;
}



/**
 * Previous / Next Excerpts
 * - Thanks very much to Thin & Light (http://thinlight.org/) for this custom function!
 */
function autofocus_excerpt( $text, $excerpt_length = 25 ) {
	$text = str_replace( ']]>', ']]&gt;', $text );
	$text = strip_tags( $text );
	$text = preg_replace( "/\[.*?]/", "", $text );
	$words = explode( ' ', $text, $excerpt_length + 1 );
	if ( count( $words ) > $excerpt_length ) {
		array_pop( $words );
		array_push( $words, '...' );
		$text = implode( ' ', $words );
	}	
	return apply_filters( 'the_excerpt', $text );
}



/**
 * Setup AF Post Excerpt (Used in Prev & Next links on Single Posts) 
 */
function autofocus_post_excerpt( $post ) {
	$excerpt = ( $post->post_excerpt == '' ) ? ( autofocus_excerpt( $post->post_content ) )
			: ( apply_filters( 'the_excerpt', $post->post_excerpt ) );
	return $excerpt;
}



/**
 * Setup Previous Post Excerpt
 */
function autofocus_previous_post_excerpt( $in_same_cat = 1, $excluded_categories = '' ) {
	if ( is_attachment() )
		$post = &get_post( $GLOBALS['post']->post_parent );
	else
		$post = get_previous_post( $in_same_cat, $excluded_categories );

	if ( !$post )
		return;
	$post = &get_post( $post->ID );
	echo  autofocus_post_excerpt( $post );
}



/**
 * Setup Next Post Excerpt
 */
function autofocus_next_post_excerpt( $in_same_cat = 1, $excluded_categories = '' ) {
	if ( is_attachment() )
		$post = &get_post( $GLOBALS['post']->post_parent );
	else
		$post = get_next_post( $in_same_cat, $excluded_categories );

	if ( !$post )
		return;
	$post = &get_post( $post->ID );
	echo  autofocus_post_excerpt( $post );
}



/**
 *	AutoFocus Navigation Above
 */
function autofocus_nav_above() {
	global $post, $excluded_categories, $in_same_cat, $shortname;

	/* Grab The Blog Category */
	$af_blog_catid = of_get_option( $shortname . '_blog_cat' );

	if ( in_category( $af_blog_catid ) ) : ?>
				<nav id="nav-above" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span>', TRUE ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '<span class="meta-nav">&rarr;</span>', TRUE ); ?></div>
				</nav><!-- #nav-above -->
	<?php else : ?>
				<nav id="nav-above" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span>', 0, $af_blog_catid ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '<span class="meta-nav">&rarr;</span>', 0, $af_blog_catid ); ?></div>
				</nav><!-- #nav-above -->
	<?php endif; 
}

/**
 * AutoFocus Navigation Below
 */
function autofocus_nav_below() {
	global $post, $excluded_categories, $in_same_cat, $shortname;
	
	/* Grab The Blog Category */
	$af_blog_catid = of_get_option( $shortname . '_blog_cat' );

	if ( in_category( $af_blog_catid ) ) : ?>
			<nav id="nav-below" class="navigation">
				<h3><?php _e( 'Browse', 'autofocus' ) ?></h3>
			<?php 
				$previouspost = get_previous_post( TRUE );
				if ($previouspost != null) {
					echo '<div class="nav-previous">';
					previous_post_link( '<span class="meta-nav">&larr;</span>' . __( 'Older: %link', 'autofocus' ), '%title', TRUE );
					echo '<div class="nav-excerpt">';
					autofocus_previous_post_excerpt( TRUE );
					echo '</div></div>';
				 } ?>
	
			<?php 
				$nextpost = get_next_post( TRUE );
				if ( $nextpost != null ) {
					echo '<div class="nav-next">';
					next_post_link( __( 'Newer: %link', 'autofocus' ) . '<span class="meta-nav">&rarr;</span>', '%title', TRUE );
					echo '<div class="nav-excerpt">';
					autofocus_next_post_excerpt( TRUE );
					echo '</div></div>';
				 } ?>

			</nav><!-- #nav-below -->

	<?php else : ?>

			<nav id="nav-below" class="navigation">
				<h3><?php _e( 'Browse', 'autofocus' ) ?></h3>
			<?php 
				$previouspost = get_previous_post( FALSE, $af_blog_catid );
				if ($previouspost != null) { 
					echo '<div class="nav-previous">';
					previous_post_link( '<span class="meta-nav">&larr;</span>' . __( 'Older: %link', 'autofocus' ), '%title', FALSE, $af_blog_catid );
					echo '<div class="nav-excerpt">';
					autofocus_previous_post_excerpt( FALSE, $af_blog_catid );
					echo '</div></div>';
				 } ?>
	
			<?php 
				$nextpost = get_next_post( FALSE, $af_blog_catid );
				if ($nextpost != null) {
					echo '<div class="nav-next">';
					next_post_link( __( 'Newer: %link', 'autofocus' ) . '<span class="meta-nav">&rarr;</span>', '%title', FALSE, $af_blog_catid );
					echo '<div class="nav-excerpt">';
					autofocus_next_post_excerpt( FALSE, $af_blog_catid );
					echo '</div></div>';
				 } ?>

			</nav><!-- #nav-below -->

	<?php endif;
}



/**
 * Prints HTML5 with meta information for the current post—date/time 
 */ 
if ( ! function_exists( 'autofocus_posted_on' ) ) :
function autofocus_posted_on() {
	printf( '<a class="%1$s" href="%2$s" title="%3$s" rel="bookmark"><time datetime="%4$s" pubdate>%5$s</time></a>',
		'entry-date',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'Y-m-d\TH:i' ) ),
		esc_attr( get_the_date() )
	);
}
endif;



/**
 * Prints HTML with meta information for the current post (date, author, category, tags and permalink).
 */
if ( ! function_exists( 'autofocus_post_meta' ) ) :
function autofocus_post_meta() { 
	printf( __( '<span class="%1$s">By: %2$s</span>', 'autofocus' ),
		'entry-author',
		sprintf( '<a class="author vcard url fn n" href="%1$s" title="%2$s">%3$s</a>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'autofocus' ), get_the_author() ),
			esc_html( get_the_author() )
		)
	);

	/* Retrieves tag list of current post, separated by commas. */
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( '<span class="entry-cats">Filed under %1$s.</span> <span class="entry-tags">Tagged %2$s.</span> <span class="entry-permalink">Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.</span>', 'autofocus' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( '<span class="entry-cats">Filed under %1$s.</span> <span class="entry-permalink">Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.</span>', 'autofocus' );
	} else {
		$posted_in = __( '<span class="entry-permalink">Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.</span>', 'autofocus' );
	}

	/* Prints the string, replacing the placeholders. */
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		esc_url( get_permalink() ),
		the_title_attribute( 'echo=0' )
	);
}
endif;



/**
 * Template for comments and pingbacks.
 *
 * To override this in a child theme, add your own autofocus_comment function.
 */
if ( ! function_exists( 'autofocus_comment' ) ) : 
	function autofocus_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'comment' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 50 ); ?>
				<?php printf( __( '%s', 'autofocus' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'autofocus' ); ?></em>
				<br />
			<?php endif; ?>
	
			<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'autofocus' ), get_comment_date(),  get_comment_time() ); ?></a>
					<?php edit_comment_link( __( 'Edit', 'autofocus' ), ' ' );
				?>
			</div><!-- .comment-meta .commentmetadata -->
	
			<div class="comment-body"><?php comment_text(); ?></div>
	
			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</div><!-- #comment-##  -->
	
		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'By ', 'autofocus' ); ?><?php comment_author_link(); ?>
				<?php /* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'autofocus' ), get_comment_date(),  get_comment_time() ); ?>
					<?php edit_comment_link( __( 'Edit', 'autofocus'), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
endif;



/** 
 *	Customise the omments fields with HTML5 form elements
 *
 *	Adds support for placeholder, required, type="email", type="url"
 */
function autofocus_comment_text_form() {
	global $commenter, $aria_req;
	
	$req = get_option( 'require_name_email' );

	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'autofocus' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder = "First and/or last name"' . ( $req ? ' required' : '' ) . '/></p>',
		            
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'autofocus' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="xxxxx@xxxxxxxxx.com"' . ( $req ? ' required' : '' ) . ' /></p>',
		            
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'autofocus' ) . '</label>' .
		            '<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="http://www.xxxxxxx.com" /></p>'
	);
	return $fields;
}

function autofocus_comment_textarea_form() {	
	$commentArea = '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'autofocus' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required placeholder="What\'s on your mind?"	></textarea></p>';
	return $commentArea;
}
add_filter( 'comment_form_default_fields', 'autofocus_comment_text_form' );
add_filter( 'comment_form_field_comment', 'autofocus_comment_textarea_form' );
