<?php
/**
 * CSS and JS for the new design, loaded only where it is used.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Asset version: the file's modified time, so edits bust caches.
 *
 * @param string $relative Path inside the plugin.
 * @return string
 */
function rla_design_asset_version( $relative ) {
	$path = RLA_DESIGN_DIR . $relative;
	return file_exists( $path ) ? (string) filemtime( $path ) : RLA_DESIGN_VERSION;
}

/**
 * Google Fonts: Jost, the font the current site already uses.
 *
 * @return string
 */
function rla_design_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap';
}

/**
 * Whether the page being viewed is built with Beaver Builder.
 *
 * @param int $post_id Page ID.
 * @return bool
 */
function rla_design_page_uses_beaver_builder( $post_id ) {
	if ( class_exists( 'FLBuilderModel' ) && method_exists( 'FLBuilderModel', 'is_builder_enabled' ) ) {
		return (bool) FLBuilderModel::is_builder_enabled( $post_id );
	}
	return (bool) get_post_meta( $post_id, '_fl_builder_enabled', true );
}

/**
 * Front end: load the new design's assets and switch off the old theme's.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		if ( ! rla_design_is_active() ) {
			return;
		}

		wp_enqueue_style( 'rla-design-fonts', rla_design_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_enqueue_style( 'rla-design', RLA_DESIGN_URL . 'assets/css/site.css', array(), rla_design_asset_version( 'assets/css/site.css' ) );
		wp_enqueue_script(
			'rla-design',
			RLA_DESIGN_URL . 'assets/js/site.js',
			array(),
			rla_design_asset_version( 'assets/js/site.js' ),
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	},
	20
);

/**
 * Remove the old theme's CSS and JS on new-design pages, so the new
 * stylesheet starts from a clean slate. On pages that no longer use Beaver
 * Builder, its leftover layout CSS (from the old header and footer) goes too.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		if ( ! rla_design_is_active() ) {
			return;
		}

		$theme_roots = array_unique(
			array(
				trailingslashit( get_template_directory_uri() ),
				trailingslashit( get_stylesheet_directory_uri() ),
			)
		);

		$post        = get_queried_object();
		$keep_bb     = $post instanceof WP_Post && rla_design_page_uses_beaver_builder( $post->ID );
		$bb_patterns = array( '/plugins/bb-plugin/', '/plugins/bb-theme-builder/', '/plugins/bbpowerpack/', '/plugins/bb-ultimate-addon/', '/uploads/bb-plugin/', '/uploads/bb-theme/' );

		$matches = function ( $src ) use ( $theme_roots, $keep_bb, $bb_patterns ) {
			if ( ! is_string( $src ) || '' === $src ) {
				return false;
			}
			foreach ( $theme_roots as $root ) {
				if ( 0 === strpos( $src, $root ) ) {
					return true;
				}
			}
			if ( ! $keep_bb ) {
				foreach ( $bb_patterns as $pattern ) {
					if ( false !== strpos( $src, $pattern ) ) {
						return true;
					}
				}
			}
			return false;
		};

		$styles = wp_styles();
		foreach ( (array) $styles->queue as $handle ) {
			if ( 0 === strpos( $handle, 'rla-design' ) ) {
				continue;
			}
			$item = $styles->registered[ $handle ] ?? null;
			if ( $item && $matches( $item->src ) ) {
				wp_dequeue_style( $handle );
			}
		}

		$scripts = wp_scripts();
		foreach ( (array) $scripts->queue as $handle ) {
			if ( 0 === strpos( $handle, 'rla-design' ) ) {
				continue;
			}
			$item = $scripts->registered[ $handle ] ?? null;
			if ( $item && $matches( $item->src ) ) {
				wp_dequeue_script( $handle );
			}
		}
	},
	999
);

/**
 * Editor: show staff the new design while they edit pages that use it.
 * Fires for the editor canvas (including the iframed editor).
 */
add_action(
	'enqueue_block_assets',
	function () {
		if ( ! is_admin() || ! function_exists( 'get_current_screen' ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! $screen || 'page' !== $screen->post_type ) {
			return;
		}

		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! $post_id || ! rla_design_uses_template( $post_id ) ) {
			return;
		}

		wp_enqueue_style( 'rla-design-fonts', rla_design_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_enqueue_style( 'rla-design-editor', RLA_DESIGN_URL . 'assets/css/editor.css', array(), rla_design_asset_version( 'assets/css/editor.css' ) );
	}
);
