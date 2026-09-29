<?php
/**
 * Khối tin nổi bật: bài mới nhất (trái) + 3 bài kế tiếp dạng danh sách (phải).
 *
 * Markup theo .news__page .post_featured của template.
 * Nhận biến qua get_template_part():
 *   - 'main'    WP_Post   bài nổi bật
 *   - 'sidebar' WP_Post[] các bài trong danh sách bên phải
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_main    = $args['main'] ?? null;
$tp_sidebar = $args['sidebar'] ?? array();

if ( ! $tp_main instanceof WP_Post ) {
	return;
}
?>
<div class="post_featured mb-md-5">
	<div class="row">
		<div class="col-md-8">
			<?php
			global $post;
			$post = $tp_main; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			setup_postdata( $post );
			?>
			<div class="item_post">
				<figure>
					<a href="<?php the_permalink(); ?>">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail(
								'large',
								array(
									'class'         => 'img-fluid',
									'decoding'      => 'async',
									'fetchpriority' => 'high',
									'draggable'     => 'false',
								)
							);
						} else {
							// MOCKUP: chưa có ảnh đại diện.
							echo '<span class="tp-thumb-placeholder" aria-hidden="true"></span>';
						}
						?>
					</a>
				</figure>

				<div class="meta_post">
					<?php get_template_part( 'template-parts/news/date-badge' ); ?>

					<div class="post_info">
						<h4 class="fs-24 fw-bold mb-4">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h4>

						<div class="description text-justify">
							<p><?php echo esc_html( wp_trim_words( (string) get_the_excerpt(), 34 ) ); ?></p>
						</div>

						<a href="<?php the_permalink(); ?>">
							<?php esc_html_e( 'Xem thêm', 'tinphat' ); ?> &raquo;
						</a>
					</div>
				</div>
			</div>
			<?php wp_reset_postdata(); ?>
		</div>

		<?php if ( ! empty( $tp_sidebar ) ) : ?>
			<div class="col-md-4">
				<div class="post_sidebar">
					<?php
					foreach ( $tp_sidebar as $tp_item ) :
						$post = $tp_item; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						setup_postdata( $post );
						$tp_cats = get_the_category();
						?>
						<div class="item_post_sb">
							<div class="meta_post">
								<?php get_template_part( 'template-parts/news/date-badge' ); ?>

								<div class="post_info">
									<h4 class="fs-16 fw-bold">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h4>

									<?php if ( ! empty( $tp_cats ) ) : ?>
										<div class="post_cate fs-13"><?php echo esc_html( $tp_cats[0]->name ); ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<?php
					endforeach;
					wp_reset_postdata();
					?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
