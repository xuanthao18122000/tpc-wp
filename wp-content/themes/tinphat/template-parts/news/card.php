<?php
/**
 * Thẻ tin trong lưới "Tin tức khác".
 *
 * Markup theo .news__page .other_post .item_post của template.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_cats = get_the_category();
?>
<div class="col-md-4">
	<div class="item_post" data-aos="fade-up">
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
					// MOCKUP: bài chưa có ảnh đại diện — giữ khung để lưới không vỡ.
					echo '<span class="tp-thumb-placeholder" aria-hidden="true"></span>';
				}
				?>
			</a>
		</figure>

		<div class="meta_post">
			<?php get_template_part( 'template-parts/news/date-badge' ); ?>

			<div class="post_info">
				<h4 class="fs-16 fw-bold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

				<?php if ( ! empty( $tp_cats ) ) : ?>
					<div class="post_cate fs-13"><?php echo esc_html( $tp_cats[0]->name ); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
