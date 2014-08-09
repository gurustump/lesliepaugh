<?php
/**	
 *	Create Post Meta Options for Flickr Settings
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */



/**	
 *	Flickr Options Meta Boxes 
 */
function autofocus_flickr_meta_boxes() {
	global $post, $af_flickr;
	$flickr_user_id = flickrUserId();
	$flickr_api_key = flickrApiKey();

	if ( !empty( $flickr_user_id ) && !empty( $flickr_api_key ) ) {
		$flickr_sets = $af_flickr->photosets_getList( flickrUserId() );
		if ( count( $flickr_sets['photoset'] ) == 0 ) {
			?>
			<div><?php _e( 'You currently have no publicly viewable Flickr sets.', 'autofocus' ); ?></div>
			<?php
		} else { ?>
			<div>
				<?php wp_nonce_field( 'af-phpflickr-custom-fields', 'af-phpflickr-custom-fields_wpnonce', false, true ); ?>
				<div style="padding: 15px 0 15px 5px">
					<label for="enable_flickr"><?php _e( 'Enable Flickr:', 'autofocus' ); ?></label> 
					<input type="checkbox" id="enable_flickr" name="enable_flickr" <?php if ( get_post_meta( $post->ID, 'enable_flickr', true ) ) { echo 'checked="checked"'; }?> />
				</div>
				<div style="padding: 0 0 10px 5px">
					<?php _e( 'Choose Flickr set:', 'autofocus' ); ?>
					<select id="flickr_set" name="flickr_set" >
						<?php foreach ( $flickr_sets['photoset'] as $photoset ) { ?>
							<option value="<?php echo $photoset["id"]; ?>" <?php if ( (string)get_post_meta( $post->ID, 'flickr_set', true ) == (string)$photoset["id"] ) { echo 'selected'; }?>><?php echo $photoset["title"]; ?></option>
						<?php } ?>
					</select>
				</div>
				<div style="padding: 15px 0 15px 5px">
					<label for="flickr_link"><?php _e( 'Add a link to the Flickr Gallery?:', 'autofocus' ); ?></label> 
					<input type="checkbox" id="flickr_link" name="flickr_link" <?php if ( get_post_meta( $post->ID, 'flickr_link', true ) ) { echo 'checked="checked"'; }?> />
				</div>
			</div>

	<?php }
	
	} else { ?>
		<div><?php _e( 'You must provide your Flickr user ID and API Key under Appearance &rarr; Theme Options &rarr; Flickr Settings', 'autofocus' ); ?></div>
	<?php }

}
/* Add Action Hooks */
add_action( 'save_post', 'save_autofocus_flickr_data');




/**	
 *	Create Form Data 
 */
function create_autofocus_flickr_meta_boxes() {
	global $theme_name;
	if ( function_exists( 'add_meta_box' ) ) {
		add_meta_box( 'autofocus_flickr_meta_boxes', __( 'Flickr Settings', 'autofocus' ), 'autofocus_flickr_meta_boxes', 'post', 'normal', 'high' );
	}
}
add_action( 'admin_menu', 'create_autofocus_flickr_meta_boxes' );




/**	
 * Save Flickr Form Data
 */
function save_autofocus_flickr_data( $post_id ) {
	global $post;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	if ( !isset( $_POST[ 'af-phpflickr-custom-fields_wpnonce' ] ) || !wp_verify_nonce( $_POST[ 'af-phpflickr-custom-fields_wpnonce' ], 'af-phpflickr-custom-fields' ) )
		return $post_id;

	$flickr_data = array( 'enable_flickr', 'flickr_set', 'flickr_link' );

	foreach ( $flickr_data as $field ) {
		if ( isset( $_POST[ $field ] ) && trim( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, $_POST[ $field ] );
		} else {
			delete_post_meta( $post_id, $field );
		}
	}

	return true;
}