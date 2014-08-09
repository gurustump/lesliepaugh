<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to wpgrade_comment() which is
 * located in the functions.php file.
 *
 * @package wpGrade
 * @since wpGrade 1.0
 */
?>

<?php
	global $wpGrade_Options;
    /*
     * If the current post is protected by a password and
     * the visitor has not yet entered the password we will
     * return early without loading the comments.
     */
    if ( post_password_required() )
        return;
?>

    <div id="comments" class="comments-area row">

    <?php // You can start editing here -- including this comment! ?>

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title <?php echo $wpGrade_Options->get('blog_single_show_comments_title') ? '' : 'hidden'?>">
            <?php
                printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), wpGrade_txtd ),
                    number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
            ?>
        </h2>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
        <nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
            <h1 class="assistive-text"><?php _e( 'Comment navigation', wpGrade_txtd ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', wpGrade_txtd ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', wpGrade_txtd ) ); ?></div>
        </nav><!-- #comment-nav-before .site-navigation .comment-navigation -->
        <?php endif; // check for comment navigation ?>

        <ol class="commentlist">
            <?php
                /* Loop through and list the comments. Tell wp_list_comments()
                 * to use wpgrade_comment() to format the comments.
                 * If you want to overload this in a child theme then you can
                 * define wpgrade_comment() and that will be used instead.
                 * See wpgrade_comment() in inc/template-tags.php for more.
                 */
                wp_list_comments( array( 'callback' => 'wpgrade_comments' ) );
            ?>
        </ol><!-- .commentlist -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
        <nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
            <h1 class="assistive-text"><?php _e( 'Comment navigation', wpGrade_txtd ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', wpGrade_txtd ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', wpGrade_txtd ) ); ?></div>
        </nav><!-- #comment-nav-below .site-navigation .comment-navigation -->
        <?php endif; // check for comment navigation ?>

    <?php endif; // have_comments() ?>

    <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
        <p class="nocomments"><?php _e( 'Comments are closed.', wpGrade_txtd ); ?></p>
    <?php endif; ?>

    <?php 
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $comments_args = array(
        // change the title of send button 
        'title_reply'=> __('Post your thoughts', wpGrade_txtd ),
        // remove "Text or HTML to be displayed after the set of comment fields"
        'comment_notes_before' => '',
        'comment_notes_after' => '',
        'fields' => apply_filters( 'comment_form_default_fields', array(
                'author' => '<p class="comment-form-author">' . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="' . __( 'Name (required)', wpGrade_txtd ) . '"' . $aria_req . ' /></p>',
                'email' => '<p class="comment-form-email">' . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="' . __( 'Email (required)', wpGrade_txtd ) . '" size="30"' . $aria_req . ' /></p>' ) ),
        // redefine your own textarea (the comment body)
        'comment_field' => 
        '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true" placeholder="' . _x( 'Your thoughts', 'noun', wpGrade_txtd ) . '" rows="5" cols="100"></textarea></p>');

    comment_form($comments_args); ?>

</div><!-- #comments .comments-area -->
