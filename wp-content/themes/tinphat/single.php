<?php
/**
 * Bài viết đơn (post và các CPT chưa có template riêng).
 *
 * Bố cục theo centralcons: banner → menu chuyên mục → 2 cột
 * (nội dung 8/12 + sidebar "Tin mới nhất" 4/12).
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$tp_is_post = 'post' === get_post_type();
	?>
	<article <?php post_class( 'tp-single' ); ?>>
		<?php get_template_part( 'template-parts/page/cover' ); ?>

		<?php if ( ! $tp_is_post ) : ?>
			<div class="container tp-page__body">
				<?php the_content(); ?>
			</div>
		<?php else : ?>
			<div class="news__page py-5">
				<div class="container">
					<?php get_template_part( 'template-parts/news/filter' ); ?>

					<div class="row">
						<div class="col-md-8">
							<div class="tp-single__main">
								<h1 class="tp-single__title"><?php the_title(); ?></h1>

								<div class="tp-single__meta">
									<time datetime="<?php echo esc_attr( (string) get_the_date( 'c' ) ); ?>">
										<?php echo esc_html( (string) get_the_date( 'd/m/Y' ) ); ?>
									</time>

									<?php
									$tp_cats = get_the_category();

									if ( ! empty( $tp_cats ) ) :
										?>
										<span class="tp-single__cat"><?php echo esc_html( $tp_cats[0]->name ); ?></span>
									<?php endif; ?>
								</div>

								<?php if ( has_post_thumbnail() ) : ?>
									<figure class="tp-single__figure">
										<?php the_post_thumbnail( 'large', array( 'decoding' => 'async' ) ); ?>
									</figure>
								<?php endif; ?>

								<div class="tp-single__content">
									<?php the_content(); ?>
								</div>

								<?php get_template_part( 'template-parts/news/share' ); ?>
							</div>
						</div>

						<div class="col-md-4">
							<?php get_template_part( 'template-parts/news/sidebar' ); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</article>
	<?php
endwhile;

get_footer();
