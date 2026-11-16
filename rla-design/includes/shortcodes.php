<?php
/**
 * Shortcodes.
 *
 * [rla_map] embeds a Google map of the school. The plugin outputs the map
 * itself because the site's firewall rejects page saves that contain an
 * <iframe>.
 *
 * Usage:
 *   [rla_map]
 *   [rla_map address="1527 Lincoln Avenue, Panama City, FL 32405" height="420"]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		add_shortcode( 'rla_map', 'rla_design_map_shortcode' );
	}
);

/**
 * Renders [rla_map].
 *
 * @param array|string $atts Shortcode attributes.
 * @return string
 */
function rla_design_map_shortcode( $atts ) {
	$settings = rla_design_settings();

	$atts = shortcode_atts(
		array(
			'address' => implode( ', ', (array) $settings['address'] ),
			'height'  => 420,
			'link'    => 'yes',
		),
		$atts,
		'rla_map'
	);

	$address = trim( (string) $atts['address'] );
	if ( '' === $address ) {
		return '';
	}

	$height = max( 200, min( 900, absint( $atts['height'] ) ) );
	$src    = 'https://www.google.com/maps?q=' . rawurlencode( $address ) . '&output=embed';
	$open   = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $address );

	/* translators: %s: street address */
	$title = sprintf( __( 'Map of %s', 'rla-design' ), $address );

	$html  = '<div class="rla-map">';
	$html .= '<iframe src="' . esc_url( $src ) . '" title="' . esc_attr( $title ) . '" width="100%" height="' . esc_attr( (string) $height ) . '" style="border:0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>';
	if ( 'no' !== $atts['link'] ) {
		$html .= '<p class="rla-map__link"><a href="' . esc_url( $open ) . '">' . esc_html__( 'Open in Google Maps', 'rla-design' ) . '</a></p>';
	}
	$html .= '</div>';

	return $html;
}
