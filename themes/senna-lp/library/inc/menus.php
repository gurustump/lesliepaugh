<?php

/*
 * Register custom menus.
 * This works on 3.1+
 */
function wpgrade_register_custom_menus(){

    add_theme_support( 'menus' );

    register_nav_menus(
        array(
            'header_menu' => __( 'Header Menu', wpGrade_txtd ),   // main nav in header
            'footer_menu' => __( 'Footer Menu', wpGrade_txtd ) // secondary nav in footer
        )
    );
}

add_action("after_setup_theme", "wpgrade_register_custom_menus");

function wpgrade_main_nav() {

    /*
     * Test if there are menu locations to prevent errors.
     */
    $theme_locations = get_nav_menu_locations();
    if ( isset( $theme_locations["header_menu"] ) && ( $theme_locations["header_menu"] != 0 ) ) {

        $menu = wp_nav_menu(array(
            'theme_location' => 'header_menu',              // where it's located in the theme
            'container' => false,                           // remove nav container
            //'container_class' => '',           // class of container (should you choose to use it)
            'menu' => __( 'Header Menu', wpGrade_txtd ),  // nav name
            'menu_class' => 'site-mainmenu',         // adding custom nav class
            'depth' => 0,                                   // limit the depth of the nav
            'walker' => new Arrow_Walker_Nav_Menu,
            'echo' => false,
        ));

        echo $menu;
    }
}

function wpgrade_footer_nav() {

    $theme_locations = get_nav_menu_locations();
    if ( isset( $theme_locations["footer_menu"] ) && ( $theme_locations["footer_menu"] != 0 ) ) {

        $menu = wp_nav_menu( array(
            'theme_location'  => 'footer_menu',
            'container'       => 'div',
            'container_id'    => 'menu-main-navigation',
            'depth' => 1,
            'echo' => false
        ) );

        echo $menu;
    }
}

/*
 * Create a walker which will add a class to items with submenus
 * More http://stackoverflow.com/questions/3558198/php-wordpress-add-arrows-to-parent-menus
 */

class Arrow_Walker_Nav_Menu extends Walker_Nav_Menu {
    function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
        $id_field = $this->db_fields['id'];
        if (!empty($children_elements[$element->$id_field])) {
            $element->classes[] = 'menu-parent-item'; //enter any classname you like here!
        }
        Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
} ?>