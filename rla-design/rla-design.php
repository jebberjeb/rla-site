<?php
/**
 * Plugin Name:       RLA New Design
 * Description:       Opt-in "New design" page template for Rising Leaders Academy. Pages that pick it get the new header, footer, CSS and JS; every other page keeps the current theme. Preview-only until switched live per page.
 * Version:           0.2.0
 * Requires at least: 6.5
 * Requires PHP:      8.0
 * Author:            Rising Leaders Academy
 * License:           GPL-2.0-or-later
 * Text Domain:       rla-design
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RLA_DESIGN_VERSION', '0.2.0' );
define( 'RLA_DESIGN_FILE', __FILE__ );
define( 'RLA_DESIGN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RLA_DESIGN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The value stored in a page's _wp_page_template meta when it uses the new design.
 */
define( 'RLA_DESIGN_TEMPLATE', 'rla-new-design' );

/**
 * The full-width variant: no title band, content made of full-width sections.
 */
define( 'RLA_DESIGN_TEMPLATE_FULL', 'rla-new-design-full' );

/**
 * Post meta flag: when true, visitors see the new design. When false, only
 * people who can edit the page see it (preview).
 */
define( 'RLA_DESIGN_LIVE_META', '_rla_design_live' );

require_once RLA_DESIGN_DIR . 'includes/settings.php';
require_once RLA_DESIGN_DIR . 'includes/template.php';
require_once RLA_DESIGN_DIR . 'includes/menus.php';
require_once RLA_DESIGN_DIR . 'includes/assets.php';
require_once RLA_DESIGN_DIR . 'includes/admin.php';
require_once RLA_DESIGN_DIR . 'includes/patterns.php';
require_once RLA_DESIGN_DIR . 'includes/shortcodes.php';
