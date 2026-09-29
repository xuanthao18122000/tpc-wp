<?php
/**
 * Chạy script seed khi không có WP-CLI (đã bỏ Docker).
 *
 * Nạp WordPress, giả lập lớp WP_CLI để các script seed dùng chung, và đặt
 * user admin — WordPress lọc `post_content` bằng wp_kses_post nếu user hiện
 * tại không có quyền `unfiltered_html`, khi đó SVG inline sẽ bị xoá sạch.
 *
 * Dùng: php scripts/run.php scripts/seed-about-pages.php
 *
 * @package TinPhat
 */

if ( PHP_SAPI !== 'cli' ) {
	exit( 1 );
}

define( 'WP_USE_THEMES', false );

// Polylang cần hai biến này để xác định ngôn ngữ; CLI không có sẵn.
$_SERVER['HTTP_HOST']   = $_SERVER['HTTP_HOST'] ?? 'localhost:8090';
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/';

require_once dirname( __DIR__ ) . '/wp-load.php';

if ( ! class_exists( 'WP_CLI' ) ) {
	/**
	 * Lớp WP_CLI tối giản cho môi trường không có WP-CLI.
	 */
	class WP_CLI {

		/**
		 * In một dòng log.
		 *
		 * @param string $message Nội dung.
		 */
		public static function log( string $message ): void {
			echo $message . "\n";
		}

		/**
		 * In thông báo thành công.
		 *
		 * @param string $message Nội dung.
		 */
		public static function success( string $message ): void {
			echo 'Success: ' . $message . "\n";
		}

		/**
		 * In cảnh báo.
		 *
		 * @param string $message Nội dung.
		 */
		public static function warning( string $message ): void {
			echo 'Warning: ' . $message . "\n";
		}

		/**
		 * In lỗi và dừng.
		 *
		 * @param string $message Nội dung.
		 */
		public static function error( string $message ): void {
			echo 'Error: ' . $message . "\n";
			exit( 1 );
		}
	}
}

$admins = get_users(
	array(
		'role'   => 'administrator',
		'number' => 1,
		'fields' => 'ID',
	)
);

if ( empty( $admins ) ) {
	WP_CLI::error( 'Không tìm thấy user administrator.' );
}

wp_set_current_user( (int) $admins[0] );

$script = $argv[1] ?? '';

if ( '' === $script ) {
	WP_CLI::error( 'Thiếu tham số: php scripts/run.php <script.php>' );
}

if ( ! is_readable( $script ) ) {
	WP_CLI::error( "Không đọc được file: {$script}" );
}

require $script;
