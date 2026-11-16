<?php
/**
 * Page template: New design.
 *
 * A complete page of its own: it doesn't load the old theme's header or
 * footer, so pages that use it look the same whatever theme is active.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="rla-skip-link" href="#rla-main"><?php esc_html_e( 'Skip to content', 'rla-design' ); ?></a>

<?php require RLA_DESIGN_DIR . 'templates/parts/header.php'; ?>

<main id="rla-main" class="rla-main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'rla-page' ); ?>>
			<?php if ( rla_design_is_full_width() ) : ?>
				<div class="rla-content rla-content--full">
					<?php the_content(); ?>
				</div>
			<?php else : ?>
				<header class="rla-page-header">
					<div class="rla-wrap">
						<h1 class="rla-page-header__title"><?php the_title(); ?></h1>
						<?php if ( has_excerpt() ) : ?>
							<p class="rla-page-header__lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>
					</div>
				</header>

				<div class="rla-content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		</article>
		<?php
	endwhile;
	?>
</main>

<?php require RLA_DESIGN_DIR . 'templates/parts/footer.php'; ?>

<?php wp_footer(); ?>
</body>
</html>
