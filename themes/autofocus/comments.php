<?php
/**
 * The template for displaying Comments.
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */
?>

			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'autofocus' ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;

	endif;
?>

<?php if ( have_comments() ) : ?>

	<?php /* numbers of pings and comments */
	$ping_count = $comment_count = 0;
	foreach ( $comments as $comment )
		get_comment_type() == "comment" ? ++$comment_count : ++$ping_count; ?>

	<?php if ( ! empty( $comments_by_type['comment'] ) ) : ?>

			<h3 id="comments-title"><?php printf( $comment_count > 1 ? __( '%d Comments', 'autofocus' ) : __( 'One Comment', 'autofocus' ), $comment_count ) ?></h3>

			<ol class="commentlist">
				<?php wp_list_comments( array( 'callback' => 'autofocus_comment', 'type' => 'comment' ) ); ?>
			</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( '<span class="meta-nav">&larr;</span> ' . __( 'Older Comments', 'autofocus' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'autofocus' ) . ' <span class="meta-nav">&rarr;</span>' ); ?></div>
			</div><!-- .navigation -->
		<?php endif; /* check for comment navigation */ ?>

	<?php endif; /* if ( $comment_count ) */ ?>

	<?php if ( ! empty( $comments_by_type['pings'] ) ) : ?>

			<h3 id="pings-title"><?php printf( $ping_count > 1 ? __( '%d Trackbacks', 'autofocus' ) : __( 'One Trackback', 'autofocus' ), $ping_count ); ?></h3>

			<ol class="pinglist">
				<?php wp_list_comments( array( 'callback' => 'autofocus_comment', 'type' => 'pings' ) ); ?>
			</ol>

	<?php endif; /* if ( $comment_count ) */ ?>

	<?php else : // or, if we don't have comments:

		/** 
		 * If there are no comments and comments are closed,
		 * let's leave a little note, shall we?
		 */
		if ( ! comments_open() ) : ?>
	
		<p class="nocomments"><?php _e( 'Comments are closed.', 'autofocus' ); ?></p>
	
	<?php endif; // end ! comments_open() ?>
	
<?php endif; // end have_comments() ?>

<?php /* Add <p> tags to comment field notes */
	$af_comment_fields =  array(
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'autofocus' ) . ( $req ? __( '<br>Required fields are marked:<span class="required">*</span>', 'autofocus' ) : '' ) . '</p>'
	);
	
	comment_form( $af_comment_fields ); ?>

</div><!-- #comments -->