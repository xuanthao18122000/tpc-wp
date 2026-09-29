<?php
/**
 * Gán ảnh đại diện cho các bài tin tức.
 *
 * MOCKUP: dùng ảnh công trình/phối cảnh không mang thương hiệu nào trong
 * uploads/tinphat. Các file `news-0X-*.webp` của template KHÔNG dùng được
 * vì in rõ logo CENTRAL trên backdrop và đồng phục.
 * Thay bằng ảnh thật của Tín Phát rồi chạy lại script này.
 *
 * Chạy: php scripts/run.php scripts/seed-news-thumbnails.php
 */

/** Ảnh theo chuyên mục (bỏ hậu tố -vi/-en). */
$by_category = array(
	'tin-du-an'        => array(
		'project-01-Emerald-Boulevard-Le-Phong.webp',
		'project-16-Cot-dien-gio-tai-nha-may-Phu-Lac.webp',
		'banner-11-WEB-PHOI-CANH-scaled.webp',
	),
	'hoat-dong-noi-bo' => array(
		'banner-18-DJI-0661-scaled.webp',
		'banner-17-DJI-0664-scaled.webp',
	),
	'tin-cong-ty'      => array(
		'banner-12-Banner-Web-2-scaled.webp',
	),
);

/**
 * Tạo (hoặc lấy lại) attachment từ file trong uploads/tinphat.
 *
 * Giữ nguyên file gốc, chỉ tạo bản ghi attachment trỏ tới nó — tránh
 * nhân bản ảnh mỗi lần chạy lại.
 *
 * @param string $filename Tên file trong uploads/tinphat.
 * @return int ID attachment, 0 nếu lỗi.
 */
function tpn_attachment_id( string $filename ): int {
	$uploads = wp_get_upload_dir();
	$path    = $uploads['basedir'] . '/tinphat/' . $filename;

	if ( ! file_exists( $path ) ) {
		WP_CLI::warning( "  thiếu file: {$filename}" );
		return 0;
	}

	$url = $uploads['baseurl'] . '/tinphat/' . $filename;

	// Đã tạo attachment cho file này chưa?
	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_tinphat_source',
			'meta_value'     => $filename,
		)
	);

	if ( ! empty( $existing ) ) {
		return (int) $existing[0];
	}

	$filetype = wp_check_filetype( $filename, null );

	$attachment_id = wp_insert_attachment(
		array(
			'guid'           => $url,
			'post_mime_type' => $filetype['type'],
			'post_title'     => sanitize_file_name( pathinfo( $filename, PATHINFO_FILENAME ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$path
	);

	if ( is_wp_error( $attachment_id ) || 0 === $attachment_id ) {
		WP_CLI::warning( "  không tạo được attachment: {$filename}" );
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $path ) );
	update_post_meta( $attachment_id, '_tinphat_source', $filename );

	return (int) $attachment_id;
}

$posts   = get_posts(
	array(
		'post_type'      => 'post',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'ID',
		'order'          => 'ASC',
		'lang'           => '',
	)
);
$counter  = array();
$assigned = array();
$done     = 0;

foreach ( $posts as $post ) {
	$categories = get_the_category( $post->ID );

	if ( empty( $categories ) ) {
		continue;
	}

	// Chuyên mục có hậu tố ngôn ngữ (tin-du-an-vi / tin-du-an-en).
	$key = (string) preg_replace( '/-(vi|en)$/', '', $categories[0]->slug );

	if ( ! isset( $by_category[ $key ] ) ) {
		continue;
	}

	$images = $by_category[ $key ];

	// Bản dịch dùng lại đúng ảnh của bài gốc tiếng Việt.
	$source_id = $post->ID;

	if ( function_exists( 'pll_get_post' ) && 'vi' !== pll_get_post_language( $post->ID ) ) {
		$translated = pll_get_post( $post->ID, 'vi' );

		if ( $translated ) {
			$source_id = (int) $translated;
		}
	}

	// Mỗi bài gốc nhận một ảnh cố định, xoay vòng theo danh sách.
	if ( ! isset( $assigned[ $source_id ] ) ) {
		$counter[ $key ]        = $counter[ $key ] ?? 0;
		$assigned[ $source_id ] = $images[ $counter[ $key ] % count( $images ) ];
		++$counter[ $key ];
	}

	$image         = $assigned[ $source_id ];
	$attachment_id = tpn_attachment_id( $image );

	if ( 0 === $attachment_id ) {
		continue;
	}

	set_post_thumbnail( $post->ID, $attachment_id );
	WP_CLI::log( sprintf( '  #%d %s → %s', $post->ID, $key, $image ) );
	++$done;
}

WP_CLI::success( "Đã gán ảnh cho {$done} bài." );
