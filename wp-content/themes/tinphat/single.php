<?php
/**
 * Bài viết đơn (post và các CPT chưa có template riêng).
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class( 'tp-single' ); ?>>
		<?php get_template_part( 'template-parts/page/cover' ); ?>

		<div class="container tp-page__body">
			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="tp-single__meta">
					<span><time datetime="<?php echo esc_attr( (string) get_the_date( 'c' ) ); ?>">
						<?php echo esc_html( (string) get_the_date() ); ?>
					</time></span>
					<?php
					$tp_cats = get_the_category();
					if ( ! empty( $tp_cats ) ) :
						?>
						<span><?php echo esc_html( $tp_cats[0]->name ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php the_content(); ?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
