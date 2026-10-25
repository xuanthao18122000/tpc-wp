<?php
/**
 * Thẻ tin dạng danh sách ngang: ảnh trái, nội dung phải.
 *
 * Dùng chung bố cục với danh sách dự án (theo centralcons).
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_cats = get_the_category();
?>
<div class="col-md-12 col-12">
	<div class="project_item project_list" data-aos="fade-up">
		<figure>
			<a href="<?php the_permalink(); ?>">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail(
						'medium_large',
						array(
							'class'     => 'img-fluid',
							'loading'   => 'lazy',
							'decoding'  => 'async',
							'draggable' => 'false',
						)
					);
				} else {
					// MOCKUP: bài chưa có ảnh đại diện.
					echo '<span class="tp-thumb-placeholder" aria-hidden="true"></span>';
				}
				?>
			</a>
		</figure>

		<div class="project_meta">
			<h3 class="fs-26 fw-bold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

			<p class="project_loc">
				<time datetime="<?php echo esc_attr( (string) get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( (string) get_the_date( 'd/m/Y' ) ); ?>
				</time>

				<?php if ( ! empty( $tp_cats ) ) : ?>
					<?php echo ' · ' . esc_html( $tp_cats[0]->name ); ?>
				<?php endif; ?>
			</p>

			<div class="excerpt"><p><?php echo esc_html( wp_trim_words( (string) get_the_excerpt(), 34 ) ); ?></p></div>

			<a href="<?php the_permalink(); ?>" class="read_more"><?php esc_html_e( 'Xem chi tiết', 'tinphat' ); ?></a>
		</div>
	</div>
</div>
