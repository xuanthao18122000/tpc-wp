<?php
/**
 * Seed nội dung cho văn hóa, video, tuyển dụng, đối tác (song ngữ)
 * rồi dựng lại trang chủ với đủ 8 khối như bản Next.js.
 *
 * Chạy: wp eval-file /scripts/seed-home-sections.php
 */

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

/**
 * Tạo bài cho một CPT, trả về ID.
 */
function tp_cpt_post( string $type, array $data, string $lang ): int {
	$found = get_posts(
		array(
			'post_type'      => $type,
			'title'          => $data['title'],
			'posts_per_page' => 1,
			'post_status'    => 'any',
			'fields'         => 'ids',
		)
	);

	foreach ( $found as $id ) {
		if ( ! function_exists( 'pll_get_post_language' ) || pll_get_post_language( $id ) === $lang ) {
			return (int) $id;
		}
	}

	$id = wp_insert_post(
		array(
			'post_title'   => $data['title'],
			'post_content' => $data['body'] ?? '',
			'post_type'    => $type,
			'post_status'  => 'publish',
		),
		true
	);

	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( $id->get_error_message() );
		return 0;
	}

	$id = (int) $id;

	if ( function_exists( 'pll_set_post_language' ) ) {
		pll_set_post_language( $id, $lang );
	}

	if ( isset( $data['meta'] ) ) {
		foreach ( $data['meta'] as $k => $v ) {
			update_post_meta( $id, $k, $v );
		}
	}

	return $id;
}

/**
 * Import ảnh từ uploads/tinphat vào Media Library.
 */
function tp_attach( string $filename, string $title ): int {
	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'title'          => $title,
			'posts_per_page' => 1,
			'post_status'    => 'inherit',
			'fields'         => 'ids',
		)
	);

	if ( ! empty( $existing ) ) {
		return (int) $existing[0];
	}

	$source = WP_CONTENT_DIR . '/uploads/tinphat/' . $filename;

	if ( ! file_exists( $source ) ) {
		return 0;
	}

	$tmp = trailingslashit( get_temp_dir() ) . wp_unique_filename( get_temp_dir(), $filename );

	if ( ! copy( $source, $tmp ) ) {
		return 0;
	}

	$id = media_handle_sideload(
		array( 'name' => basename( $tmp ), 'tmp_name' => $tmp ),
		0,
		$title,
		array( 'post_title' => $title )
	);

	return is_wp_error( $id ) ? 0 : (int) $id;
}

/**
 * Tạo cặp VI/EN và nối bản dịch.
 */
function tp_pair( string $type, array $vi, array $en, string $image = '' ): void {
	$vi_id = tp_cpt_post( $type, $vi, 'vi' );
	$en_id = tp_cpt_post( $type, $en, 'en' );

	if ( $vi_id > 0 && $en_id > 0 ) {
		if ( function_exists( 'pll_save_post_translations' ) ) {
			pll_save_post_translations( array( 'vi' => $vi_id, 'en' => $en_id ) );
		}

		if ( '' !== $image ) {
			$att = tp_attach( $image, $vi['title'] );

			if ( $att > 0 ) {
				set_post_thumbnail( $vi_id, $att );
				set_post_thumbnail( $en_id, $att );
			}
		}

		WP_CLI::log( "  + {$type}: {$vi['title']}" );
	}
}

// ===== Văn hóa =====
// MOCKUP: thumbnail template có logo "NGƯỜI CENTRAL" nên KHÔNG gán ảnh.
tp_pair( 'van-hoa',
	array( 'title' => '[Mẫu] Văn hóa làm việc tại Tín Phát', 'body' => '<p>Nội dung mẫu — thay bằng bài viết thật.</p>' ),
	array( 'title' => '[Sample] Working culture at Tin Phat', 'body' => '<p>Sample content — replace with a real article.</p>' )
);
tp_pair( 'van-hoa',
	array( 'title' => '[Mẫu] Câu chuyện từ công trường', 'body' => '<p>Nội dung mẫu — thay bằng bài viết thật.</p>' ),
	array( 'title' => '[Sample] Stories from the site', 'body' => '<p>Sample content — replace with a real article.</p>' )
);
tp_pair( 'van-hoa',
	array( 'title' => '[Mẫu] Đội ngũ kỹ sư Tín Phát', 'body' => '<p>Nội dung mẫu — thay bằng bài viết thật.</p>' ),
	array( 'title' => '[Sample] The Tin Phat engineering team', 'body' => '<p>Sample content — replace with a real article.</p>' )
);

// ===== Video =====
tp_pair( 'video',
	array( 'title' => '[Mẫu] Video giới thiệu công ty', 'meta' => array( 'video_url' => '#' ) ),
	array( 'title' => '[Sample] Company introduction video', 'meta' => array( 'video_url' => '#' ) )
);
tp_pair( 'video',
	array( 'title' => '[Mẫu] Video dự án tiêu biểu', 'meta' => array( 'video_url' => '#' ) ),
	array( 'title' => '[Sample] Featured project video', 'meta' => array( 'video_url' => '#' ) )
);
tp_pair( 'video',
	array( 'title' => '[Mẫu] Video hoạt động công ty', 'meta' => array( 'video_url' => '#' ) ),
	array( 'title' => '[Sample] Company activities video', 'meta' => array( 'video_url' => '#' ) )
);

// ===== Tuyển dụng =====
tp_pair( 'tuyen-dung',
	array( 'title' => 'TÍN PHÁT TUYỂN DỤNG KỸ SƯ XÂY DỰNG', 'body' => 'MOCKUP: nội dung tuyển dụng mẫu — thay bằng tin thật của Tín Phát.' ),
	array( 'title' => 'TIN PHAT IS HIRING CONSTRUCTION ENGINEERS', 'body' => 'MOCKUP: sample recruitment content — replace with a real posting.' )
);
tp_pair( 'tuyen-dung',
	array( 'title' => '[Mẫu] Tuyển dụng Giám sát công trình', 'body' => 'Nội dung mẫu — thay bằng mô tả công việc thật.' ),
	array( 'title' => '[Sample] Site Supervisor vacancy', 'body' => 'Sample content — replace with the real job description.' )
);
tp_pair( 'tuyen-dung',
	array( 'title' => '[Mẫu] Tuyển dụng Kỹ sư QS', 'body' => 'Nội dung mẫu — thay bằng mô tả công việc thật.' ),
	array( 'title' => '[Sample] QS Engineer vacancy', 'body' => 'Sample content — replace with the real job description.' )
);

WP_CLI::success( 'Đã seed văn hóa, video, tuyển dụng.' );
