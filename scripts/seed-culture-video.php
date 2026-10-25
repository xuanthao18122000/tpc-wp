<?php
/**
 * Gán ảnh đại diện cho CPT văn hoá và video.
 *
 * MOCKUP: dùng ảnh công trình không mang thương hiệu nào. Bộ
 * `culture-*.webp` / `video-*.webp` của template KHÔNG dùng được vì in
 * rõ "NGƯỜI CENTRAL" và logo Central trên thumbnail.
 * Thay ảnh thật của Tín Phát rồi chạy lại script này.
 *
 * Chạy: php scripts/run.php scripts/seed-culture-video.php
 */

/** Ảnh theo CPT, gán lần lượt cho từng bài gốc tiếng Việt. */
$images = array(
	'van-hoa' => array( 'tp-culture-1.webp', 'tp-culture-2.webp', 'tp-culture-3.webp' ),
	'video'   => array( 'tp-video-1.webp', 'tp-video-2.webp', 'tp-video-3.webp' ),
);

/**
 * Tạo (hoặc lấy lại) attachment từ file trong uploads/tinphat.
 *
 * @param string $filename Tên file.
 * @return int ID attachment, 0 nếu lỗi.
 */
function tpc_attachment_id( string $filename ): int {
	$uploads = wp_get_upload_dir();
	$path    = $uploads['basedir'] . '/tinphat/' . $filename;

	if ( ! file_exists( $path ) ) {
		WP_CLI::warning( "  thiếu file: {$filename}" );
		return 0;
	}

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

	$filetype      = wp_check_filetype( $filename, null );
	$attachment_id = wp_insert_attachment(
		array(
			'guid'           => $uploads['baseurl'] . '/tinphat/' . $filename,
			'post_mime_type' => $filetype['type'],
			'post_title'     => sanitize_file_name( pathinfo( $filename, PATHINFO_FILENAME ) ),
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

$done = 0;

foreach ( $images as $post_type => $files ) {
	$assigned = array();
	$index    = 0;

	$posts = get_posts(
		array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'lang'           => '',
		)
	);

	foreach ( $posts as $post ) {
		// Bản dịch dùng lại đúng ảnh của bài gốc tiếng Việt.
		$source_id = $post->ID;

		if ( function_exists( 'pll_get_post' ) && 'vi' !== pll_get_post_language( $post->ID ) ) {
			$translated = pll_get_post( $post->ID, 'vi' );

			if ( $translated ) {
				$source_id = (int) $translated;
			}
		}

		if ( ! isset( $assigned[ $source_id ] ) ) {
			$assigned[ $source_id ] = $files[ $index % count( $files ) ];
			++$index;
		}

		$attachment_id = tpc_attachment_id( $assigned[ $source_id ] );

		if ( 0 === $attachment_id ) {
			continue;
		}

		set_post_thumbnail( $post->ID, $attachment_id );
		WP_CLI::log( sprintf( '  #%d %s → %s', $post->ID, $post_type, $assigned[ $source_id ] ) );
		++$done;
	}
}

WP_CLI::success( "Đã gán ảnh cho {$done} bài." );
