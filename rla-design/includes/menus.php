<?php
/**
 * Menu locations for the new header and footer.
 *
 * If nothing is assigned to these locations under Appearance → Menus →
 * Manage Locations, the template falls back to the site's existing menus
 * ("main" in the header, "Footer Menu" in the footer), so a menu edit shows
 * up in both the old and the new design.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function () {
		register_nav_menus(
			array(
				'rla-primary' => __( 'New design: main menu', 'rla-design' ),
				'rla-footer'  => __( 'New design: footer menu', 'rla-design' ),
			)
		);
	},
	20
);

/**
 * Prints a menu for the new design.
 *
 * @param string $location      Menu location registered above.
 * @param string $fallback_menu Slug of the existing menu to use when the location is empty.
 * @param string $menu_class    Class for the <ul>.
 * @param int    $depth         Levels to show.
 */
function rla_design_menu( $location, $fallback_menu, $menu_class, $depth = 2 ) {
	$args = array(
		'container'   => false,
		'menu_class'  => $menu_class,
		'depth'       => $depth,
		'fallback_cb' => false,
	);

	if ( has_nav_menu( $location ) ) {
		$args['theme_location'] = $location;
	} elseif ( wp_get_nav_menu_object( $fallback_menu ) ) {
		$args['menu'] = $fallback_menu;
	} else {
		return;
	}

	wp_nav_menu( $args );
}
