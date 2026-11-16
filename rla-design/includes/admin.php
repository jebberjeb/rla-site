<?php
/**
 * Admin pieces: the "Show to visitors" switch, a Design column in the Pages
 * list, and an admin-bar badge on the front end.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The "New design" box in the page editor's sidebar.
 */
add_action(
	'add_meta_boxes_page',
	function () {
		add_meta_box( 'rla-design', __( 'New design', 'rla-design' ), 'rla_design_render_meta_box', 'page', 'side', 'default' );
	}
);

/**
 * Renders the meta box.
 *
 * @param WP_Post $post Page being edited.
 */
function rla_design_render_meta_box( $post ) {
	wp_nonce_field( 'rla_design_save', 'rla_design_nonce' );
	$live = rla_design_is_live( $post->ID );
	?>
	<p>
		<label>
			<input type="checkbox" name="rla_design_live" value="1" <?php checked( $live ); ?> />
			<?php esc_html_e( 'Show the new design to visitors', 'rla-design' ); ?>
		</label>
	</p>
	<p class="description">
		<?php esc_html_e( 'Applies when this page\'s Template is set to "New design". Until this box is checked, only people who can edit the page see the new design; visitors keep seeing the old one.', 'rla-design' ); ?>
	</p>
	<p class="description">
		<?php esc_html_e( 'After switching a page live, flush the cache: GoDaddy menu → Tools → Flush Cache.', 'rla-design' ); ?>
	</p>
	<?php
}

/**
 * Saves the switch.
 */
add_action(
	'save_post_page',
	function ( $post_id ) {
		if ( ! isset( $_POST['rla_design_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rla_design_nonce'] ) ), 'rla_design_save' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( ! empty( $_POST['rla_design_live'] ) ) {
			update_post_meta( $post_id, RLA_DESIGN_LIVE_META, 1 );
		} else {
			delete_post_meta( $post_id, RLA_DESIGN_LIVE_META );
		}
	}
);

/**
 * "Design" column in Pages → All Pages.
 */
add_filter(
	'manage_pages_columns',
	function ( $columns ) {
		$columns['rla_design'] = __( 'Design', 'rla-design' );
		return $columns;
	}
);

add_action(
	'manage_pages_custom_column',
	function ( $column, $post_id ) {
		if ( 'rla_design' !== $column ) {
			return;
		}
		if ( ! rla_design_uses_template( $post_id ) ) {
			echo '<span aria-hidden="true">—</span><span class="screen-reader-text">' . esc_html__( 'Old design', 'rla-design' ) . '</span>';
			return;
		}
		echo rla_design_is_live( $post_id )
			? esc_html__( 'New (live)', 'rla-design' )
			: esc_html__( 'New (preview)', 'rla-design' );
	},
	10,
	2
);

/**
 * Admin-bar badge on new-design pages, with a link to compare against the
 * old design.
 */
add_action(
	'admin_bar_menu',
	function ( $bar ) {
		if ( is_admin() || ! is_singular( 'page' ) ) {
			return;
		}
		$post = get_queried_object();
		if ( ! $post instanceof WP_Post || ! rla_design_uses_template( $post ) || ! current_user_can( 'edit_post', $post->ID ) ) {
			return;
		}

		$live  = rla_design_is_live( $post->ID );
		$title = $live ? __( 'New design: live', 'rla-design' ) : __( 'New design: preview only', 'rla-design' );

		$bar->add_node(
			array(
				'id'    => 'rla-design',
				'title' => esc_html( $title ),
				'href'  => get_edit_post_link( $post->ID ),
			)
		);

		$showing_old = rla_design_old_requested();
		$bar->add_node(
			array(
				'parent' => 'rla-design',
				'id'     => 'rla-design-compare',
				'title'  => esc_html( $showing_old ? __( 'View the new design', 'rla-design' ) : __( 'View the old design', 'rla-design' ) ),
				'href'   => $showing_old ? remove_query_arg( 'rla-old' ) : add_query_arg( 'rla-old', '1' ),
			)
		);
	},
	100
);
