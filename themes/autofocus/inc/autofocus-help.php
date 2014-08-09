<?php 
/**	
 * AutoFocus Instructions
 * Adds instructions to the post and page edit screens under the HELP dropdown
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */

add_action( 'load-post-new.php', 'autofocus_shortcode_instructions' );
add_action( 'load-post.php', 'autofocus_shortcode_instructions' );
add_action( 'load-page-new.php', 'autofocus_shortcode_instructions' );
add_action( 'load-page.php', 'autofocus_shortcode_instructions' );

function autofocus_shortcode_instructions() {
	add_filter( 'contextual_help', 'autofocus_shortcode_instr_text' );
}

function autofocus_shortcode_instr_text( $help ) {
	$shortcode_instr_text = __( '<h3>How to use AutoFocus Shortcodes</h3> 
	<h4>[flickrgallery] </h4>
	<p>Adds a flickr gallery to your post content.<br/> 
	<p><strong>Usage:</strong> [flickrgallery setid=&quot;52157624866504110&quot; limit=&quot;10&quot;]</p> 
	<p><strong>Parameters:</strong><br/>
	setid=&quot;Your-Flickr-Set-Id&quot; (Your Flickr Set ID should look like something this: 52157624866504110).<br/> 
	limit= &quot;#&quot; Replace # with the number of images you wish to show in the gallery (Default =&quot;10&quot;).</p> 
	<h4>[pullquote]</h4><p>Adds a pull quote about the project.<br/> 
	<p><strong>Usage:</strong> [pullquote foo=&quot;bar&quot;]%quoted text%[/pullquote]</p> 
	<p><strong>Parameters:</strong><br/>
	author=&quot;The Author&#39;s Name&quot;</p> 
	<h4>[largeimage]</h4><p>Adds a larger post image with a hovering description. Requires an image at least 800px wide.<br/> 
	<p><strong>Usage:</strong> [largeimage foo=&quot;bar&quot;]%large size image%[/largeimage]</p> 
	<p><strong>Parameters:</strong><br/>
	description=&quot;This is your description.&quot;</p> 
	<h4>[narrowcolumn]</h4><p>Adds a narrow paragraph area. Use 2 narrow columns together with left and right parameters to create a 2 column area.<br/> 
	<p><strong>Usage:</strong> [narrowcolumn foo=&quot;bar&quot; ]%content%[/narrowcolumn]</p> 
	<p><strong>Parameters:</strong><br/>
	side=&quot;left&quot;<br/> 
	side=&quot;right&quot;</p>
	<p>Visit the <a href="http://fthrwght.com/autofocus/#documentation" target="_blank">full documentation</a>.' );
	
	get_current_screen()->add_help_tab( array(
			'id' => 'shortcode_instr_text',
			'title' => __( 'Autofocus Shortcodes', 'autofocus' ),
			'content' => $shortcode_instr_text,
		) 
	);
}