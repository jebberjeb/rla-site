<?php
/**
 * New design: site header.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$rla = rla_design_settings();
?>
<header class="rla-header">
	<div class="rla-header__inner rla-wrap">
		<a class="rla-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img class="rla-brand__logo" src="<?php echo esc_url( $rla['logo'] ); ?>" width="<?php echo (int) $rla['logo_w']; ?>" height="<?php echo (int) $rla['logo_h']; ?>" alt="">
			<span class="rla-brand__text">
				<span class="rla-brand__name"><?php echo esc_html( $rla['name'] ); ?></span>
				<span class="rla-brand__tagline"><?php echo esc_html( $rla['tagline'] ); ?></span>
			</span>
		</a>

		<button class="rla-nav-toggle" type="button" aria-expanded="false" aria-controls="rla-nav">
			<span class="rla-nav-toggle__icon" aria-hidden="true"></span>
			<span class="rla-nav-toggle__label"><?php esc_html_e( 'Menu', 'rla-design' ); ?></span>
		</button>

		<nav id="rla-nav" class="rla-nav" aria-label="<?php esc_attr_e( 'Main', 'rla-design' ); ?>">
			<?php rla_design_menu( 'rla-primary', 'main', 'rla-nav__list', 2 ); ?>
			<a class="rla-button rla-button--gold rla-nav__cta" href="<?php echo esc_url( $rla['apply_url'] ); ?>"><?php echo esc_html( $rla['apply_label'] ); ?></a>
		</nav>
	</div>
</header>
