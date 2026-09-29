<?php
/**
 * Đầu trang tin: tiêu đề + menu chuyên mục.
 *
 * Markup theo .news__page .menu_news của template.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_terms = get_terms(
	array(
		'taxonomy'   => 'category',
		'hide_empty' => true,
	)
);

$tp_archive = (int) get_option( 'page_for_posts' );
$tp_title   = $tp_archive > 0 ? (string) get_the_title( $tp_archive ) : __( 'Tin tức', 'tinphat' );
$tp_current = (int) get_queried_object_id();
?>
<div class="menu_news">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h2 class="fs-40 fw-bold text-uppercase"><?php echo esc_html( $tp_title ); ?></h2>
		</div>

		<?php if ( ! is_wp_error( $tp_terms ) && ! empty( $tp_terms ) ) : ?>
			<div class="col-md-6">
				<ul>
					<li class="<?php echo is_home() ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( $tp_archive > 0 ? (string) get_permalink( $tp_archive ) : home_url( '/' ) ); ?>">
							<?php esc_html_e( 'Tất cả', 'tinphat' ); ?>
						</a>
					</li>

					<?php foreach ( $tp_terms as $tp_term ) : ?>
						<li class="<?php echo ( is_category() && $tp_current === $tp_term->term_id ) ? 'active' : ''; ?>">
							<a href="<?php echo esc_url( (string) get_term_link( $tp_term ) ); ?>">
								<?php echo esc_html( $tp_term->name ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</div>
