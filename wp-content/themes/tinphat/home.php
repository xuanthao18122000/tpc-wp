<?php
/**
 * Trang danh sách tin tức (page_for_posts).
 *
 * Bố cục theo centralcons: tin nổi bật (1 bài lớn + 3 bài danh sách),
 * sau đó là lưới "Tin tức khác".
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

get_header();

$tp_page_id = (int) get_option( 'page_for_posts' );
$tp_title   = $tp_page_id > 0 ? (string) get_the_title( $tp_page_id ) : __( 'Tin tức', 'tinphat' );

// Trang 1 mới tách tin nổi bật; các trang sau chỉ hiện lưới cho liền mạch.
$tp_paged    = max( 1, (int) get_query_var( 'paged' ) );
$tp_featured = array();

if ( 1 === $tp_paged ) {
	while ( have_posts() && count( $tp_featured ) < 4 ) {
		the_post();
		$tp_featured[] = get_post();
	}

	rewind_posts();
}
?>
<div class="page_cover">
	<div class="bg_cover">
		<img class="img-fluid"
			src="<?php echo esc_url( tinphat_uploads_url( 'banner-02.webp' ) ); ?>"
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

<div class="news__page py-5">
	<div class="container">
		<?php get_template_part( 'template-parts/news/filter' ); ?>

		<?php if ( ! have_posts() ) : ?>
			<p><?php esc_html_e( 'Chưa có bài viết nào.', 'tinphat' ); ?></p>
		<?php else : ?>

			<?php
			if ( ! empty( $tp_featured ) ) {
				get_template_part(
					'template-parts/news/featured',
					null,
					array(
						'main'    => $tp_featured[0],
						'sidebar' => array_slice( $tp_featured, 1 ),
					)
				);
			}
			?>

			<div class="other_post">
				<?php if ( ! empty( $tp_featured ) ) : ?>
					<h2 class="fs-30 fw-bold mb-3 cl-orange"><?php esc_html_e( 'Tin tức khác', 'tinphat' ); ?></h2>
				<?php endif; ?>

				<div class="row">
					<?php
					$tp_skip = count( $tp_featured );
					$tp_i    = 0;

					while ( have_posts() ) :
						the_post();

						// Bỏ qua các bài đã hiện ở khối nổi bật.
						if ( $tp_i++ < $tp_skip ) {
							continue;
						}

						get_template_part( 'template-parts/news/card' );
					endwhile;
					?>
				</div>
			</div>

			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => '&laquo;',
					'next_text' => '&raquo;',
					'class'     => 'tp-pagination',
				)
			);
			?>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
