<?php
/**
 * Dự án liên quan (cùng ngôn ngữ, bỏ dự án đang xem).
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_related = new WP_Query(
	array(
		'post_type'           => 'du-an',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'post__not_in'        => array( get_the_ID() ),
		'orderby'             => 'rand',
		'no_found_rows'       => true,
		'ignore_sticky_posts' => true,
	)
);

if ( ! $tp_related->have_posts() ) {
	return;
}
?>
<section class="tp-project-related">
	<div class="tp-section-head">
		<h2><?php esc_html_e( 'Dự án khác', 'tinphat' ); ?></h2>
	</div>

	<?php // .page_project để dùng chung kiểu thẻ với trang danh sách dự án. ?>
	<div class="page_project">
		<div class="row">
			<?php
			while ( $tp_related->have_posts() ) :
				$tp_related->the_post();
				get_template_part( 'template-parts/project/card' );
			endwhile;

			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
