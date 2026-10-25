<?php
/**
 * Trang danh sách tin tức (page_for_posts).
 *
 * Bố cục theo centralcons/du-an: danh sách ngang — ảnh trái,
 * tiêu đề + mô tả + nút "Xem chi tiết" bên phải.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

get_header();

$tp_page_id = (int) get_option( 'page_for_posts' );
$tp_title   = $tp_page_id > 0 ? (string) get_the_title( $tp_page_id ) : __( 'Tin tức', 'tinphat' );

?>
<div class="page_cover">
	<div class="bg_cover">
		<img class="img-fluid"
			src="<?php echo esc_url( tinphat_uploads_url( 'banner-01.webp' ) ); ?>"
			alt="" draggable="false">
	</div>

	<div class="meta_info">
		<h1 class="fs-40 fw-bold"><?php echo esc_html( $tp_title ); ?></h1>

		<div class="breadcrumb_site">
			<span>
				<span><a href="<?php echo esc_url( tinphat_home_url() ); ?>"><?php esc_html_e( 'Trang chủ', 'tinphat' ); ?></a></span>
				<?php echo ' » '; ?>
				<span class="breadcrumb_last" aria-current="page"><?php echo esc_html( $tp_title ); ?></span>
			</span>
		</div>
	</div>
</div>

<div class="news__page page_project py-5">
	<div class="container">
		<?php get_template_part( 'template-parts/news/filter' ); ?>

		<?php if ( ! have_posts() ) : ?>
			<p><?php esc_html_e( 'Chưa có bài viết nào.', 'tinphat' ); ?></p>
		<?php else : ?>
			<div class="row justify-content-center">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/news/card' );
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => '&laquo;',
					'next_text' => '&raquo;',
				)
			);
			?>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
