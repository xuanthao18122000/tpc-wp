<?php
/**
 * Thẻ dự án dạng danh sách ngang.
 *
 * Dùng ở trang danh sách dự án và khối "dự án liên quan"; khớp với
 * CSS .page_project .project_item (ảnh 30% bên trái, nội dung bên phải).
 * Carousel trang chủ dùng template-parts/project/slide.php.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_client   = (string) tinphat_field( 'client' );
$tp_location = (string) tinphat_field( 'location' );
$tp_scope    = (string) tinphat_field( 'scope' );
?>
<div class="col-12">
	<div class="project_item project_list">
		<div class="row g-0 align-items-stretch">
			<div class="col-md-4">
				<figure>
					<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail(
								'medium_large',
								array( 'loading' => 'lazy', 'decoding' => 'async' )
							);
						} else {
							echo '<span class="tp-thumb-placeholder"></span>';
						}
						?>
					</a>
				</figure>
			</div>

			<div class="col-md-8">
				<div class="project_meta">
					<h3>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>

					<?php if ( '' !== $tp_location ) : ?>
						<p class="project_loc"><?php echo esc_html( $tp_location ); ?></p>
					<?php endif; ?>

					<?php if ( '' !== $tp_scope ) : ?>
						<div class="excerpt">
							<p><?php echo esc_html( $tp_scope ); ?></p>
						</div>
					<?php elseif ( '' !== $tp_client ) : ?>
						<div class="excerpt">
							<p><?php echo esc_html( $tp_client ); ?></p>
						</div>
					<?php endif; ?>

					<a class="read_more" href="<?php the_permalink(); ?>">
						<?php esc_html_e( 'Xem chi tiết', 'tinphat' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
