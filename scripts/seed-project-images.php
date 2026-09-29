<?php
/**
 * Gán ảnh đại diện cho các dự án.
 * Ảnh import từ uploads/tinphat vào Media Library rồi set thumbnail.
 *
 * Chạy: wp eval-file /scripts/seed-project-images.php
 */

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

// Ảnh mockup từ template, khớp thứ tự dự án ở seed-projects.php.
$images = array(
	'project-01-Emerald-Boulevard-Le-Phong.webp',
	'project-02-Sarene-Dai-Quang-Minh.webp',
	'project-03-Sunset-Town-High-rise.webp',
	'project-04-The-Legend-City.webp',
	'project-05-SOL-FOREST.webp',
	'project-06-ALMA-RESORT-CAM-RANH-tam-retouch-do-CC-A.webp',
	'project-07-HPO.webp',
	'project-08-opal.webp',
	'project-09-UOA.webp',
);

$dir = WP_CONTENT_DIR . '/uploads/tinphat/';

/**
 * Import một file vào Media Library, trả về attachment ID.
 * Dùng lại nếu đã import trước đó.
 */
function tp_import_image( string $path, string $title ): int {
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

	if ( ! file_exists( $path ) ) {
		return 0;
	}

	$id = media_handle_sideload(
		array(
			'name'     => basename( $path ),
			'tmp_name' => $path,
		),
		0,
		$title,
		array( 'post_title' => $title )
	);

	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( basename( $path ) . ': ' . $id->get_error_message() );
		return 0;
	}

	return (int) $id;
}

// Lấy dự án theo thứ tự tạo (ID tăng dần), ghép cặp VI/EN.
$vi_projects = get_posts(
	array(
		'post_type'      => 'du-an',
		'posts_per_page' => -1,
		'orderby'        => 'ID',
		'order'          => 'ASC',
		'lang'           => 'vi',
		'fields'         => 'ids',
	)
);

$count = 0;

foreach ( array_values( $vi_projects ) as $index => $post_id ) {
	if ( ! isset( $images[ $index ] ) ) {
		break;
	}

	// media_handle_sideload di chuyển file, nên copy sang bản tạm.
	// Giữ nguyên phần mở rộng: WP kiểm tra kiểu file theo đuôi, .tmp sẽ bị từ chối.
	$source = $dir . $images[ $index ];
	$tmp    = trailingslashit( get_temp_dir() ) . wp_unique_filename( get_temp_dir(), $images[ $index ] );

	if ( ! file_exists( $source ) || ! copy( $source, $tmp ) ) {
		WP_CLI::warning( 'Không đọc được ' . $images[ $index ] );
		continue;
	}

	$title = (string) get_the_title( $post_id );
	$att   = tp_import_image( $tmp, $title );

	if ( 0 === $att ) {
		continue;
	}

	set_post_thumbnail( $post_id, $att );

	// Bản dịch EN dùng chung ảnh.
	$translations = pll_get_post_translations( $post_id );

	foreach ( $translations as $lang => $translated_id ) {
		if ( (int) $translated_id !== (int) $post_id ) {
			set_post_thumbnail( (int) $translated_id, $att );
		}
	}

	++$count;
	WP_CLI::log( "  ✓ {$title}" );
}

WP_CLI::success( "Đã gán ảnh cho {$count} dự án (kèm bản dịch)." );
