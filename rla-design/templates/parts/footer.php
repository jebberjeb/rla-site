<?php
/**
 * New design: site footer.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$rla = rla_design_settings();
?>
<footer class="rla-footer">
	<div class="rla-footer__inner rla-wrap">
		<div class="rla-footer__brand">
			<img class="rla-footer__logo" src="<?php echo esc_url( $rla['footer_logo'] ); ?>" width="162" height="119" alt="<?php echo esc_attr( $rla['name'] ); ?>">
			<p class="rla-footer__motto"><?php echo esc_html( $rla['motto'] ); ?></p>
		</div>

		<div class="rla-footer__contact">
			<div class="rla-footer__group">
				<h2 class="rla-footer__heading"><?php esc_html_e( 'Visit', 'rla-design' ); ?></h2>
				<p>
					<a href="<?php echo esc_url( $rla['map_url'] ); ?>">
						<?php echo implode( '<br>', array_map( 'esc_html', (array) $rla['address'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</p>
			</div>
			<div class="rla-footer__group">
				<h2 class="rla-footer__heading"><?php esc_html_e( 'Contact', 'rla-design' ); ?></h2>
				<p>
					<a href="<?php echo esc_attr( 'tel:' . rla_design_tel( $rla['phone'] ) ); ?>"><?php echo esc_html( $rla['phone'] ); ?></a><br>
					<a href="<?php echo esc_url( 'mailto:' . $rla['email'] ); ?>"><?php echo str_replace( '@', '<wbr>@', esc_html( $rla['email'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped, then a line-break hint added. ?></a>
				</p>
			</div>
			<div class="rla-footer__group">
				<h2 class="rla-footer__heading"><?php esc_html_e( 'Hours', 'rla-design' ); ?></h2>
				<p><?php echo implode( '<br>', array_map( 'esc_html', (array) $rla['hours'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			</div>
		</div>

		<nav class="rla-footer__nav" aria-label="<?php esc_attr_e( 'Footer', 'rla-design' ); ?>">
			<?php rla_design_menu( 'rla-footer', 'footer-menu', 'rla-footer__list', 1 ); ?>
		</nav>
	</div>

	<div class="rla-footer__bottom">
		<div class="rla-wrap rla-footer__bottom-inner">
			<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( $rla['name'] ); ?>. <?php esc_html_e( 'All rights reserved.', 'rla-design' ); ?></p>
			<?php if ( ! empty( $rla['facebook'] ) ) : ?>
				<a class="rla-footer__social" href="<?php echo esc_url( $rla['facebook'] ); ?>">
					<svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0 0 22 12Z"/></svg>
					<span><?php esc_html_e( 'Facebook', 'rla-design' ); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</div>
</footer>
