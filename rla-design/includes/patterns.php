<?php
/**
 * Block patterns: pre-designed sections staff can insert and fill in
 * (block inserter → Patterns → RLA).
 *
 * Each pattern is plain block markup in /patterns/<name>.html.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		if ( ! function_exists( 'register_block_pattern' ) ) {
			return;
		}

		register_block_pattern_category( 'rla', array( 'label' => __( 'RLA', 'rla-design' ) ) );

		$patterns = array(
			'photo-text' => array(
				'title'       => __( 'Photo beside text', 'rla-design' ),
				'description' => __( 'A photo on one side, a heading and a paragraph on the other.', 'rla-design' ),
			),
			'file-list'  => array(
				'title'       => __( 'List of documents', 'rla-design' ),
				'description' => __( 'A heading and a list of document links, such as PDFs.', 'rla-design' ),
			),
			'callout'    => array(
				'title'       => __( 'Call to action', 'rla-design' ),
				'description' => __( 'A highlighted box with a heading, a sentence and a button.', 'rla-design' ),
			),
			'cards'      => array(
				'title'       => __( 'Three cards', 'rla-design' ),
				'description' => __( 'Three short items side by side, each with a heading and a sentence.', 'rla-design' ),
			),
			'map'        => array(
				'title'       => __( 'Map and address', 'rla-design' ),
				'description' => __( 'A Location heading, the school address and a Google map.', 'rla-design' ),
			),
		);

		foreach ( $patterns as $slug => $meta ) {
			$file = RLA_DESIGN_DIR . 'patterns/' . $slug . '.html';
			if ( ! file_exists( $file ) ) {
				continue;
			}
			register_block_pattern(
				'rla/' . $slug,
				array(
					'title'       => $meta['title'],
					'description' => $meta['description'],
					'categories'  => array( 'rla' ),
					'postTypes'   => array( 'page' ),
					'content'     => file_get_contents( $file ), // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
				)
			);
		}
	}
);
