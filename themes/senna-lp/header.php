<!DOCTYPE html>
<?php global $wpGrade_Options; ?>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js <?php if ( $wpGrade_Options->get('bw_portfolio_filter') ){ echo "bw-images"; } else { echo ''; } ?> color1 <?php if ( $wpGrade_Options->get('header_fixed') ){ echo "l-header-fixed"; } else { echo ''; } ?> lp-color-<?php echo rand(1,6); ?>" data-smooth-scroll="<?php if ( $wpGrade_Options->get('use_smooth_scrool') ){ echo "on"; } else { echo 'off'; } ?>"><!--<![endif]-->

<head>
	<meta charset="utf-8">
	<title><?php wp_title('|','true','right'); ?><?php bloginfo('name'); ?></title>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
	<meta name="HandheldFriendly" content="True">
	<meta name="apple-touch-fullscreen" content="yes" />
	<meta name="MobileOptimized" content="320">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php
    /*
     * icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/)
     */

    $favicon = $wpGrade_Options->get( 'favicon' );
    if ( $favicon ) {
        echo '<link rel="icon" href="'.$favicon.'" >';
    }
    $apple_icon = $wpGrade_Options->get( 'apple_touch_icon' );
    if ( $apple_icon ) {
        echo '<link rel="apple-touch-icon" href="'.$apple_icon.'" >';
    }
    $win8icon = $wpGrade_Options->get( 'metro_icon' );
    if ( $win8icon ) {
        echo '<meta name="msapplication-TileColor" content="#f01d4f">';
        echo '<meta name="msapplication-TileImage" content="'.$win8icon.'" >';
    }
	
    /*
     * Wordpress Head. This is REQUIRED.Never remove this
     */
	wp_head(); ?>
</head>
<body <?php body_class(); ?> >
	<div id="wrap">
		<div id="page">
			<header id="header" class="wrapper site-header-wrapper">
				<div class="container">
					<div class="row">
						<div class="site-header">
							<div class="site-branding">
								<?php if ( $wpGrade_Options->get('main_logo') ): ?>
									<div class="site-logo-container full-sized">
										<a href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo('name') ?>">
			                                    <?php
			                                    $data_retina_logo  = $wpGrade_Options->get('use_retina_logo');
			                                    if ( $data_retina_logo ) {
			                                        $data_retina_logo = 'data-retina_logo="'.$wpGrade_Options->get('retina_main_logo').'"';
			                                    } else {
			                                    	$data_retina_logo = ''; 
			                                    }
			                                    ?>
											<img class="site-logo" src="<?php echo $wpGrade_Options->get('main_logo'); ?>" <?php echo $data_retina_logo; ?> rel="logo" alt="<?php echo get_bloginfo('name') ?>"/>
										</a>
									</div>
								<?php else: ?>
									<div class="site-title"><a href="<?php echo home_url() ?>"><?php echo get_bloginfo('name') ?></a></div>
								<?php endif; ?>
							</div>							
							<div class="menu-toggle">
								<a class="nav-btn" id="nav-open-btn" href="#nav">Navigation</a>
							</div>
							<nav class="site-navigation desktop" role="navigation">
								<h6 class="hidden" hidden>Main navigation</h6>
								<div class="search-form">
									<div class="row-background full-width"></div>
									<div class="container">
										<form method="get" id="searchform" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
											<a class="search-remove" ><span></span></a>
											<button class="btn submit" name="submit" id="searchsubmit"><?php esc_attr_e( 'Search', wpGrade_txtd ); ?> <i></i></button>
											<div class="search-query-wrapper">
												<input type="text" class="field search-query" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php esc_attr_e( 'Start typing..', wpGrade_txtd ); ?>" autocomplete="off" />
											</div>
										</form>
									</div>
								</div>
								<a class="search-toggle"><i class="search-icon icon-search"></i></a>
								<?php wpgrade_main_nav(); ?>
							</nav>
						</div>
					</div>
				</div>
			</header>
			<nav class="site-navigation" id="responsive">
				<h6 class="hidden" hidden>Mobile navigation</h6>
				<?php wpgrade_main_nav(); ?>
				<a class="nav-btn" id="nav-close-btn" href="#nav">Close</a>
			</nav>
				
<div id="content">