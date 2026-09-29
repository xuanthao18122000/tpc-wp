<?php
/**
 * Thiết lập theme.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khai báo hỗ trợ và vùng menu.
 */
function tinphat_setup(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary' => __( 'Menu chính', 'tinphat' ),
			'footer'  => __( 'Menu chân trang', 'tinphat' ),
		)
	);
}
add_action( 'after_setup_theme', 'tinphat_setup' );

/**
 * Nạp bản dịch của theme.
 *
 * Chạy ở `init` chứ không phải `after_setup_theme`: Polylang xác định
 * ngôn ngữ sau khi theme setup, nạp sớm sẽ luôn lấy locale mặc định.
 */
function tinphat_load_textdomain(): void {
	$locale = determine_locale();
	$mofile = TINPHAT_DIR . '/languages/tinphat-' . $locale . '.mo';

	// Nạp tường minh: WP 7.x nạp trễ theo locale của site, còn Polylang
	// đổi locale theo URL nên phải chỉ đúng file .mo cho ngôn ngữ đang xem.
	if ( is_readable( $mofile ) ) {
		unload_textdomain( 'tinphat' );
		load_textdomain( 'tinphat', $mofile, $locale );
	}
}
add_action( 'init', 'tinphat_load_textdomain', 5 );

/**
 * Gỡ các thành phần không dùng để trang nhẹ hơn.
 */
function tinphat_cleanup_head(): void {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
}
add_action( 'init', 'tinphat_cleanup_head' );

/**
 * Tắt emoji của WordPress (không dùng, tiết kiệm ~10KB mỗi trang).
 */
function tinphat_disable_emojis(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	add_filter( 'tiny_mce_plugins', 'tinphat_remove_tinymce_emoji' );
}
add_action( 'init', 'tinphat_disable_emojis' );

/**
 * Bỏ plugin emoji khỏi TinyMCE.
 *
 * @param array<int,string> $plugins Danh sách plugin TinyMCE.
 * @return array<int,string>
 */
function tinphat_remove_tinymce_emoji( $plugins ): array {
	if ( ! is_array( $plugins ) ) {
		return array();
	}

	return array_diff( $plugins, array( 'wpemoji' ) );
}
