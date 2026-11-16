<?php
/**
 * The opt-in "New design" page template and its preview gate.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the new design's templates to the Template dropdown for pages:
 * - "New design": green title band, then the content in a readable column.
 * - "New design: full width": no title band; the content is built from
 *   full-width sections (used for the home page and landing pages).
 */
add_filter(
	'theme_page_templates',
	function ( $templates ) {
		$templates[ RLA_DESIGN_TEMPLATE ]      = __( 'New design', 'rla-design' );
		$templates[ RLA_DESIGN_TEMPLATE_FULL ] = __( 'New design: full width', 'rla-design' );
		return $templates;
	}
);

/**
 * Whether a page uses the full-width variant (no title band).
 *
 * @param int|WP_Post|null $post Page.
 * @return bool
 */
function rla_design_is_full_width( $post = null ) {
	$post = get_post( $post );
	return $post && RLA_DESIGN_TEMPLATE_FULL === get_page_template_slug( $post );
}

/**
 * Pages get a Summary (excerpt) field, shown under the title in the new design.
 */
add_action(
	'init',
	function () {
		add_post_type_support( 'page', 'excerpt' );
	}
);

/**
 * Whether a page uses one of the new design's templates.
 *
 * @param int|WP_Post|null $post Page.
 * @return bool
 */
function rla_design_uses_template( $post = null ) {
	$post = get_post( $post );
	return $post
		&& 'page' === $post->post_type
		&& in_array( get_page_template_slug( $post ), array( RLA_DESIGN_TEMPLATE, RLA_DESIGN_TEMPLATE_FULL ), true );
}

/**
 * Whether the new design has been switched live for visitors.
 *
 * @param int $post_id Page ID.
 * @return bool
 */
function rla_design_is_live( $post_id ) {
	return (bool) get_post_meta( $post_id, RLA_DESIGN_LIVE_META, true );
}

/**
 * Whether an editor asked to see the old design for comparison (?rla-old=1).
 *
 * @return bool
 */
function rla_design_old_requested() {
	// Read-only display toggle; no state changes, so no nonce needed.
	return isset( $_GET['rla-old'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}

/**
 * Whether the current request should render with the new design.
 *
 * @return bool
 */
function rla_design_is_active() {
	static $active = null;

	// The main query isn't ready yet; answer without caching.
	if ( ! did_action( 'wp' ) ) {
		return false;
	}

	if ( null !== $active ) {
		return $active;
	}

	$active = false;

	if ( is_admin() || ! is_singular( 'page' ) ) {
		return $active;
	}

	$post = get_queried_object();
	if ( ! $post instanceof WP_Post || ! rla_design_uses_template( $post ) ) {
		return $active;
	}

	$can_edit = current_user_can( 'edit_post', $post->ID );

	if ( $can_edit && rla_design_old_requested() ) {
		return $active;
	}

	$active = rla_design_is_live( $post->ID ) || $can_edit;

	return $active;
}

/**
 * Serve the plugin's template for pages that use it. Pages still in preview
 * fall through to the theme's normal page template for visitors.
 */
add_filter(
	'template_include',
	function ( $template ) {
		if ( rla_design_is_active() ) {
			return RLA_DESIGN_DIR . 'templates/new-design.php';
		}
		return $template;
	},
	1000
);

/**
 * Keep previews out of shared caches: a preview response is personal to the
 * editor who requested it.
 */
add_action(
	'template_redirect',
	function () {
		if ( ! is_singular( 'page' ) ) {
			return;
		}
		$post = get_queried_object();
		if ( $post instanceof WP_Post && rla_design_uses_template( $post ) && ! rla_design_is_live( $post->ID ) && is_user_logged_in() ) {
			nocache_headers();
		}
	}
);

/**
 * Drop the "Private:" prefix from titles on new-design pages, so a private
 * draft previews the way the real page will look.
 */
add_filter(
	'private_title_format',
	function ( $format ) {
		return rla_design_is_active() ? '%s' : $format;
	}
);

/**
 * Body classes for the new design.
 */
add_filter(
	'body_class',
	function ( $classes ) {
		if ( rla_design_is_active() ) {
			$classes[] = 'rla';
			$post      = get_queried_object();
			if ( $post instanceof WP_Post && ! rla_design_is_live( $post->ID ) ) {
				$classes[] = 'rla-is-preview';
			}
		}
		return $classes;
	}
);
