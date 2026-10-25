<?php
/**
 * Một slide dự án trong carousel trang chủ.
 *
 * Dùng đúng cấu trúc .slider_projects có sẵn trong template: ảnh dọc
 * phủ kín khung, tên dự án chữ trắng đè lên ảnh, bảng thông tin nằm
 * trong .detail_info (max-height: 0) và chỉ xổ ra khi rê chuột.
 *
 * Trang danh sách dự án và khối "dự án liên quan" dùng
 * template-parts/project/card.php với bố cục khác.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_client   = (string) tinphat_field( 'client' );
$tp_location = (string) tinphat_field( 'location' );
$tp_scope    = (string) tinphat_field( 'scope' );
$tp_has_meta = '' !== $tp_client || '' !== $tp_location || '' !== $tp_scope;
?>
<div class="swiper-slide item">
	<div class="wrapper">
		<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>

		<figure>
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail(
					'medium_large',
					array( 'class' => 'img-fluid', 'loading' => 'lazy', 'decoding' => 'async', 'draggable' => 'false' )
				);
			} else {
				printf(
					'<img class="img-fluid" src="%s" alt="" draggable="false">',
					esc_url( tinphat_uploads_url( 'tp-cover-capability.webp' ) )
				);
			}
			?>
		</figure>

		<div class="meta_info">
			<h4 class="fs-20 fw-bold text-uppercase"><?php the_title(); ?></h4>

			<?php if ( $tp_has_meta ) : ?>
				<div class="detail_info">
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<?php if ( '' !== $tp_client ) : ?>
									<tr>
										<td><?php esc_html_e( 'Khách hàng', 'tinphat' ); ?></td>
										<td><?php echo esc_html( $tp_client ); ?></td>
									</tr>
								<?php endif; ?>

								<?php if ( '' !== $tp_location ) : ?>
									<tr>
										<td><?php esc_html_e( 'Vị trí', 'tinphat' ); ?></td>
										<td><?php echo esc_html( $tp_location ); ?></td>
									</tr>
								<?php endif; ?>

								<?php if ( '' !== $tp_scope ) : ?>
									<tr>
										<td><?php esc_html_e( 'Phạm vi công việc', 'tinphat' ); ?></td>
										<td><?php echo esc_html( $tp_scope ); ?></td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>

					<a class="read_more" href="<?php the_permalink(); ?>" tabindex="-1">
						<?php esc_html_e( 'Đọc tiếp', 'tinphat' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
