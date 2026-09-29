<?php
/**
 * Tab điều hướng giữa các trang con cùng nhánh.
 *
 * Hiển thị dưới ảnh bìa: lấy các trang cùng cha (hoặc con của trang
 * hiện tại nếu đang ở trang cha) và đánh dấu mục đang xem.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_id = (int) get_the_ID();

if ( $tp_id < 1 ) {
	return;
}

$tp_parent = wp_get_post_parent_id( $tp_id );

// Trang con: lấy anh em cùng cha. Trang cha: lấy các con của chính nó.
$tp_branch = $tp_parent > 0 ? $tp_parent : $tp_id;

$tp_siblings = get_posts(
	array(
		'post_type'      => 'page',
		'post_parent'    => $tp_branch,
		'posts_per_page' => -1,
		'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
		'post_status'    => 'publish',
		'lang'           => tinphat_current_lang(),
	)
);

// Chỉ có một mục thì không cần tab.
if ( count( $tp_siblings ) < 2 ) {
	return;
}
?>
<nav class="menu_about" aria-label="<?php echo esc_attr( (string) get_the_title( $tp_branch ) ); ?>">
	<div class="container">
		<div class="menu-wrapper">
			<button type="button" class="swiper-button-prev" data-tp-tabs-prev
				aria-label="<?php esc_attr_e( 'Cuộn sang trái', 'tinphat' ); ?>"></button>

			<div class="swiper menu_slider">
				<div class="swiper-wrapper" data-tp-tabs-track>
					<?php foreach ( $tp_siblings as $tp_page ) : ?>
						<?php $tp_active = ( (int) $tp_page->ID === $tp_id ); ?>
						<div class="item swiper-slide<?php echo $tp_active ? ' active' : ''; ?>">
							<a href="<?php echo esc_url( (string) get_permalink( $tp_page->ID ) ); ?>"
								<?php echo $tp_active ? 'aria-current="page"' : ''; ?>>
								<?php echo esc_html( (string) get_the_title( $tp_page->ID ) ); ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<button type="button" class="swiper-button-next" data-tp-tabs-next
				aria-label="<?php esc_attr_e( 'Cuộn sang phải', 'tinphat' ); ?>"></button>
		</div>
	</div>
</nav>
