<?php
/**
 * AutoFocus Styles 
 *
 * Sets styles based on the AutoFocus theme options
 *
 * @package AutoFocus
 * @since AutoFocus 2.1
 */ ?>

<?php  
/* 
 * Text Color: Background  
 */
 ?>
	.sf-menu ul a:hover, .sf-menu .current_page_item ul a:hover,
	.af-layout #content header a,
	.af-layout #content .entry-meta,
	.af-layout #content .entry-meta .entry-date,
	.af-layout #content .entry-content, 
	.af-layout #content .entry-content a,
	#content .photo-credit, #content .photo-credit a,
	#content .entry-caption, #content .entry-caption a,
	.entry-gallery-container #nav a,
	.entry-gallery-container #counter,
	#content .entry-content .large-image figcaption,
	#fancybox-title,
	#content #sticky-area #nav a,
	.page-link a:link, .page-link a:visited {color:<?php echo $bg_color; ?>}
<?php 
/* 
 * Text Color: Links 
 */
 ?>
	a,a:link, a:visited, 
	.sf-menu .current_page_item ul a, 
	#content .photo-credit a:hover, 
	#content .entry-content blockquote.pull-quote, 
	.af-color {color:<?php echo $link_color; ?>}
<?php 
/* 
 * Text Color: Text 
 */
 ?>
	body,
	#content .entry-content blockquote cite,
	.ie7 #content .entry-content div.large-image p,
	a:active, a:hover, 
	.sf-menu .current_page_item a, .sf-menu .current_page_item a:hover, 
	.entry-meta a:hover, .entry-utility a:hover {color:<?php echo $text_color; ?>}
<?php 
/* 
 * Background Color: Background 
 */
 ?>
	body, #access ul ul a {background-color:<?php echo $bg_color; ?>}
<?php 
/* 
 * Background Color: Photo 
 */
 ?>
	#content .entry-image-container, 
	#content .entry-video-container, 
	#content .entry-gallery-container {background-color:<?php echo $photo_color; ?>}
<?php 
/* 
 * Background Color: Link 
 */
 ?>
	.sf-menu ul a:hover,
	.home #content .post,
	.search .af-layout #content .post,
	.archive .af-layout #content .post,
	.archive .post-image-container,
	.archive .post-video-container,
	.entry-gallery-container #nav a:hover, 
	.entry-gallery-container #nav a.activeSlide,
	.page-link a:link, 
	.page-link a:visited {background-color:<?php echo $link_color; ?>}
<?php 
/* 
 * Background Color: Text 
 */
 ?>
	.page-link a:hover, 
	.page-link a:active {background-color:<?php echo $text_color; ?>}
<?php 
/* 
 * Border Color: Text 
 */
 ?>
	hr,
	#access .sub-menu,
	#access .children,
	#content .page-title,
	#content .entry-content div.wp-caption,
	#content .entry-content blockquote,
	article header, .single #content header,
	article footer,
	.single #content header .entry-date,
	.search #content header .entry-title,
	.archive #content header .entry-title,
	.af-blog-template #content header .entry-title,
	.error404 #content .post, 
	.search-no-results #content .post, 
	#content header .archive-meta,
	#content .entry-content table, 
	#content .entry-content th, 
	#content .entry-content td,
	#content .entry-content figure,
	#content div.error404,
	#content #author-info .author-bio,
	#content #author-info #author-email,
	.single #nav-below h3,
	#respond #reply-title,
	#comments .commentlist, 
	#comments .commentlist li,
	#comments .commentlist ul li,
	#comments .pinglist, 
	#comments .pinglist li,
	.aside ul li.widgetcontainer li ul {border-color:<?php echo $text_color; ?>}
<?php 
/* 
 * Border Color: Link 
 */
 ?>
	#comments .commentlist li.bypostauthor, 
	#comments .commentlist li.bypostauthor .avatar {border-color:<?php echo $link_color; ?>}	
<?php 
/* 
 * Hide Navigation Arrows?
 */
 ?>
<?php if ( $nav_arrows == TRUE ) { ?>
	#nav-above {display:none;}
	.home #nav-below {display:block;}
<?php } ?>
<?php 
/* 
 * How should the Post Date/ Post Title be displayed?
 */
 ?>
<?php if ( $title_date == 'titledate' && is_home() || ( $title_date == 'titledate' && $archive_layout == 'images' && ( is_archive() || is_search() ) ) ) { ?>
	.af-layout #content .entry-date, 
	.af-layout #content .entry-content {display:none}
<?php } elseif ( $title_date == 'datetitle' && is_home() || ( $title_date == 'datetitle' && $archive_layout == 'images' && ( is_archive() || is_search() ) ) ) { ?>
	.af-layout #content .entry-title, 
	.af-layout #content .entry-content {display:none}
<?php } elseif ( $title_date == 'title' && is_home() || ( $title_date == 'title' && $archive_layout == 'images' && ( is_archive() || is_search() ) ) ) { ?>
	.af-layout #content .entry-title, 
	.af-layout #content .entry-date, 
	.af-layout #content .entry-content {display:none}
<?php } elseif ( $title_date == 'date' && is_home() || ( $title_date == 'date' && $archive_layout == 'images' && ( is_archive() || is_search() ) ) ) { ?>
	.af-layout #content .entry-title, 
	.af-layout #content .entry-date, 
	.af-layout #content .entry-content {display:none}
<?php } ?>
<?php 
/* 
 * Archive Styles
 */
 ?>
<?php if ( $archive_layout == 'default' && ( is_archive() || is_search() ) ) { ?>
	.archive #content article {display: table; position: relative; margin-bottom: 66px;}
	.archive #content article header {clear: right;float: none;margin-left: 204px;padding: 0; display: table;}
	.archive #content header .entry-title {padding: 11px 8px;font-size:24px; line-height: 22px; float:left; width:391px; border-right: 1px dotted #<?php echo $text_color; ?>; display: table-cell; vertical-align: middle}
	.archive #content header .entry-date {margin-left:408px; display: table-cell; vertical-align: middle; padding: 11px 16px; font-size:16px}
	.archive #content .entry-content {clear: none;float: left;margin: 0 204px 0;width: 392px;}
	.archive #content .entry-image {float: left;height: 188px;margin-right: -204px;overflow: hidden;width: 188px;}
	.archive #content .entry-image a[style] {top: 0 !important; left: 0 !important;}
	.archive #content .entry-utility {clear: none;display: block;float: right;margin: 0 0 0 -614px;padding: 0 8px 11px 16px;width: 164px;}
	.archive .af-layout #content .edit-link a {width: inherit;}
<?php // Blog category links 
	} else { ?>	
	.af-layout #content .category-<?php echo strtolower( $blogcat_slug ); ?> header a {height:200px; width:200px;}
	.af-layout.af-default #content .category-<?php echo strtolower( $blogcat_slug ); ?> header a {height:100%; width:100%;}
<?php } ?>
<?php 
/* 
 * How should the Post Date/ Post Title be displayed?
 */
 ?>
<?php // Inline Title Position
	if ( is_single() && $title_pos == 'inline' ) { ?>
	.single #content header {padding: 0; width:800px; margin:0; border-width:0; float:none; display: table}
	.single #content header .entry-title {width:595px; display: table-cell; vertical-align:middle; border-right: 1px dotted #<?php echo $text_color; ?>; margin-bottom:0; padding: 11px 8px;}
	.single #content header .entry-date {margin: 0; padding: 11px 16px; width: 156px; display: table-cell; vertical-align:middle; }
	.single #content footer {width: 164px;}
	.single #content .entry-content .narrow-column.right {margin-right: -104px;}
	.single #content .entry-content .narrow-column {width:274px;}
	.ie7 .single #content header {display:block; clear:both; float:none;}
	.ie7 .single #content header .entry-title {float:left}
	.ie7 .single #content header .entry-date {float:right}
	.ie7 .single #content footer {position: relative; right: 189px;}
<?php } ?>
<?php 
/* 
 * Edit Link Animation
 */
 ?>
<?php if ( ( is_user_logged_in() && ( current_user_can( 'edit_others_posts' ) == TRUE ) ) && ( is_home() || is_archive() || is_search() ) ) { ?>
	.af-layout #content .entry-utility {right:-100px}
	.logged-in .af-layout #content .dragthis {cursor: move;}
<?php } ?>
<?php 
/* 
 * Resize Slider Images to fit within the slider
 */
 ?>
<?php if ( is_single() && $single_image_display == 'fixed-post-thumbnail' ) { ?>
	.cycle .entry-image img,
	.entry-image-container .entry-image img {width:auto;max-height:532px;}
<?php } ?>