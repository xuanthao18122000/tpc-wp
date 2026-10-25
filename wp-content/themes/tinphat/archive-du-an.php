<?php
/**
 * Danh sách dự án (archive CPT du-an).
 *
 * Bố cục theo centralcons.vn/du-an: dải lọc chuyên mục nền xanh dưới
 * banner, rồi danh sách ngang — ảnh trái, tiêu đề + mô tả + nút phải.
 * Dùng lại bộ class .project_item.project_list có sẵn trong template.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

get_header();

$tp_title = post_type_archive_title( '', false );
?>
<div class="page_cover">
	<div class="bg_cover">
		<img class="img-fluid"
			src="<?php echo esc_url( tinphat_uploads_url( 'tp-cover-projects.webp' ) ); ?>"
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

<?php get_template_part( 'template-parts/project/filter' ); ?>

<div class="page_project py-5">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="row justify-content-center">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/project/card' );
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
		<?php else : ?>
			<p><?php esc_html_e( 'Chưa có dự án nào.', 'tinphat' ); ?></p>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
