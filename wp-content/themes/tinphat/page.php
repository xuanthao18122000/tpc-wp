<?php
/**
 * Template mặc định cho trang.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	// Trang chủ dựng hoàn toàn bằng shortcode nên không cần khung tiêu đề.
	if ( is_front_page() ) {
		the_content();
		continue;
	}
	?>
	<article <?php post_class( 'tp-page' ); ?>>
		<?php get_template_part( 'template-parts/page/cover' ); ?>
		<?php get_template_part( 'template-parts/page/section-tabs' ); ?>

		<div class="container tp-page__body">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="tp-page__pagination">',
					'after'  => '</div>',
				)
			);
			?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
