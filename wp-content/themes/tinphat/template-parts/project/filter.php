<?php
/**
 * Dải lọc dự án theo lĩnh vực (nền xanh dưới banner).
 *
 * Tín Phát chưa phân loại dự án bằng taxonomy nên dải này hiện các
 * lĩnh vực hoạt động trong hồ sơ năng lực, trỏ về trang Lĩnh vực.
 * Khi có taxonomy thật thì thay bằng vòng lặp term.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_archive = (string) get_post_type_archive_link( 'du-an' );

// wp_count_posts() đếm cả hai ngôn ngữ; dùng query để Polylang lọc đúng.
$tp_count = new WP_Query(
	array(
		'post_type'      => 'du-an',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'fields'         => 'ids',
	)
);

$tp_total = (int) $tp_count->found_posts;
?>
<div class="project_filter">
	<div class="container">
		<ul class="project_filter__list">
			<li class="active">
				<a href="<?php echo esc_url( $tp_archive ); ?>">
					<?php esc_html_e( 'Tất cả', 'tinphat' ); ?>
				</a>
			</li>
		</ul>

		<span class="project_filter__count">
			<?php
			printf(
				/* translators: %d: số dự án. */
				esc_html( _n( '%d dự án', '%d dự án', $tp_total, 'tinphat' ) ),
				(int) $tp_total
			);
			?>
		</span>
	</div>
</div>
