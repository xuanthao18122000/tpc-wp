<?php
/**
 * Đặt favicon (site icon) cho WordPress.
 *
 * Chạy: php scripts/set-site-icon.php
 */

require_once __DIR__ . '/../wp-load.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$source = WP_CONTENT_DIR . '/uploads/tinphat/site-icon.png';

if ( ! file_exists( $source ) ) {
	fwrite( STDERR, "Không thấy {$source}\n" );
	exit( 1 );
}

$title = 'Tín Phát Construction — Site Icon';

// Dùng lại nếu đã import trước đó.
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
	$attachment_id = (int) $existing[0];
	echo "Đã có attachment #{$attachment_id}\n";
} else {
	// media_handle_sideload di chuyển file, nên copy sang bản tạm.
	$tmp = trailingslashit( get_temp_dir() ) . wp_unique_filename( get_temp_dir(), 'site-icon.png' );

	if ( ! copy( $source, $tmp ) ) {
		fwrite( STDERR, "Không copy được file tạm\n" );
		exit( 1 );
	}

	$attachment_id = media_handle_sideload(
		array( 'name' => basename( $tmp ), 'tmp_name' => $tmp ),
		0,
		$title,
		array( 'post_title' => $title )
	);

	if ( is_wp_error( $attachment_id ) ) {
		fwrite( STDERR, 'Lỗi: ' . $attachment_id->get_error_message() . "\n" );
		exit( 1 );
	}

	$attachment_id = (int) $attachment_id;
	echo "Đã import attachment #{$attachment_id}\n";
}

update_option( 'site_icon', $attachment_id );

// Polylang: đặt cho mọi ngôn ngữ (site_icon là option chung, nhưng
// gọi lại cho chắc nếu plugin tách option theo ngôn ngữ).
if ( function_exists( 'pll_languages_list' ) ) {
	foreach ( pll_languages_list() as $lang ) {
		echo "  ngôn ngữ {$lang}: dùng chung site_icon\n";
	}
}

echo "site_icon = " . get_option( 'site_icon' ) . "\n";
echo "Xong.\n";
