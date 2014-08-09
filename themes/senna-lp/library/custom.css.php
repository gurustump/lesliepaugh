<?php header("Content-type: text/css; charset: UTF-8");

if ( isset($_GET["color"]) ){
    $main_color = '#'.$_GET["color"]; ?>

    /*color*/
    .wrapper.site-footer-wrapper .widget-area a,.widget a:hover,.widget.widget_tag_cloud ul li a:hover,#login,#login h1 a,#login #nav a, #login #backtoblog a,.site-branding a,.site-branding .site-logo,.site-title,.row-shortcode.inverse a:hover > i.shc,.widget-category .article-title,.widget-recommended .article-title,.category-list a:hover,.category-list-title, a, .accent_color
    {
    color: <?php echo $main_color; ?>;
    }

    /*border*/
    nav.site-navigation .site-mainmenu > li ul.sub-menu li:hover a,
    #login #loginform #wp-submit,
    .article-header .date-entry,
    .site-header-wrapper,
    .btn,
    .btn.btn-transparent:hover
    {
    border-color: <?php echo $main_color; ?>;
    }
    .btn.btn-transparent {	border-color: white; }

    /*border-bottom*/
    .contact-info:after
    {
    border-bottom-color: <?php echo $main_color ?>;
    }
    @media only screen and (min-width: 60em) {
    .contact-info:after {border-right-color: <?php echo $main_color ?>;border-bottom-color: transparent;}
    }
    /*background*/
    .accent-background,input[type="submit"],input[type="submit"]:hover,.site-header-wrapper .search-form,.site-header-wrapper .search-form.is-visible,.site-header-wrapper .search-form .row-background,nav.site-navigation .search-toggle:hover,nav.site-navigation .site-mainmenu > li:hover > a,nav.site-navigation .site-mainmenu > li.active a,.nav-btn,#login #loginform #wp-submit,.portfolio_items article li,.form .submit,.btn,.btn.btn-transparent:hover,.contact-widget-icon-container,.pie-chart, .contact-form-container input[type="submit"]:hover, .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .mejs-controls .mejs-time-rail .mejs-time-current
    {
    background-color: <?php echo $main_color; ?>;
    }
    .btn.btn-transparent {	background-color: transparent;}
    nav.site-navigation .search-toggle,nav.site-navigation .site-mainmenu > li > a {
    background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, <?php echo $main_color ?>), color-stop(50%, <?php echo $main_color ?>), color-stop(50%, #ffffff), color-stop(100%, #ffffff));
    background-image: -webkit-linear-gradient(<?php echo $main_color ?>, <?php echo $main_color ?> 50%, #ffffff 50%, #ffffff);
    background-image: -moz-linear-gradient(<?php echo $main_color ?>, <?php echo $main_color ?> 50%, #ffffff 50%, #ffffff);
    background-image: -o-linear-gradient(<?php echo $main_color ?>, <?php echo $main_color ?> 50%, #ffffff 50%, #ffffff);
    background-image: linear-gradient(<?php echo $main_color ?>, <?php echo $main_color ?> 50%, #ffffff 50%, #ffffff);
    }

    <?php
}

if ( isset($_GET["main_font"]) ){
    $main_font = $_GET["main_font"]; ?>

    h1, h2, h3, h4, h5, h6, .portfolio_items article li a .title, input.dial, blockquote, blockquote p, .site-branding a {
        font-family: "<?php echo $main_font; ?>" !important;
    }

<?php }

if ( isset($_GET["menu_font"]) ){
    $menu_font = $_GET["menu_font"]; ?>
    .site-navigation a {
        font-family: "<?php echo $menu_font; ?>" !important;
    }
<?php }

if ( isset($_GET["body_font"]) ){
    $body_font = $_GET["body_font"]; ?>
    body {
        font-family: "<?php echo $body_font; ?>" !important;
    }
<?php }

if ( isset($_GET["port_color"]) ){
    $port_color = '#'.$_GET["port_color"]; ?>
.portfolio_items article li.big a div.title, .portfolio_single_gallery li a { color: <?php echo $port_color ?> }
.portfolio_items article li.big a div.title hr {border-color: <?php echo $port_color ?>}
.portfolio_items article li a .border span, .portfolio_single_gallery li a .border span {border: 1px solid <?php echo $port_color ?>}
<?php }

if ( isset($_GET["custom_css"]) ){
    echo $_GET["custom_css"];
}?>