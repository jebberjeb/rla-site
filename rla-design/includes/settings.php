<?php
/**
 * Site details used by the new header and footer.
 *
 * Kept in code for now. Each value can be changed with the
 * `rla_design_settings` filter, or edited here and redeployed.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the site details the template uses.
 *
 * @return array<string, mixed>
 */
function rla_design_settings() {
	static $settings = null;

	if ( null !== $settings ) {
		return $settings;
	}

	$uploads = wp_get_upload_dir();
	$base    = trailingslashit( $uploads['baseurl'] );

	$settings = apply_filters(
		'rla_design_settings',
		array(
			'name'        => get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Rising Leaders Academy',
			'tagline'     => 'A tuition-free public charter school',
			'motto'       => 'Where students rise to be leaders',
			'logo'        => $base . '2021/07/header-logo-1.png',
			'logo_w'      => 203,
			'logo_h'      => 162,
			'footer_logo' => $base . '2021/07/logo.png',
			'apply_url'   => home_url( '/application/' ),
			'apply_label' => 'Apply',
			'address'     => array( '1527 Lincoln Avenue', 'Panama City, FL 32405' ),
			'map_url'     => 'https://goo.gl/maps/UW4aNWroSEiYAQwv9',
			'phone'       => '(850) 215-0844',
			'email'       => 'risingleadersacademy@gmail.com',
			'hours'       => array( "Monday–Friday, 7:45\u{00A0}AM–3:15\u{00A0}PM", 'Closed weekends' ),
			'facebook'    => 'https://www.facebook.com/RisingLeadersAcademy',
		)
	);

	return $settings;
}

/**
 * Digits-only phone number for tel: links.
 *
 * @param string $phone Display phone number.
 * @return string
 */
function rla_design_tel( $phone ) {
	$digits = preg_replace( '/\D+/', '', (string) $phone );
	if ( 10 === strlen( $digits ) ) {
		$digits = '1' . $digits;
	}
	return '+' . $digits;
}
