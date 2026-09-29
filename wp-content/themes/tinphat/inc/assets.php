<?php
/**
 * Nạp CSS/JS.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Trả về version dựa trên thời điểm sửa file — cache-bust tự động khi dev.
 *
 * @param string $relative_path Đường dẫn tương đối trong theme.
 * @return string
 */
function tinphat_asset_version( string $relative_path ): string {
	$file = TINPHAT_DIR . $relative_path;

	return file_exists( $file ) ? (string) filemtime( $file ) : TINPHAT_VERSION;
}

/**
 * Nạp asset cho frontend.
 */
function tinphat_enqueue_assets(): void {
	$css     = '/assets/dist/main.css';
	$css_lib = '/assets/dist/app.css'; // CSS thư viện do esbuild sinh (Swiper).
	$js  = '/assets/dist/app.js';

	if ( file_exists( TINPHAT_DIR . $css ) ) {
		wp_enqueue_style(
			'tinphat-main',
			TINPHAT_URI . $css,
			array( 'tinphat-lib' ),
			tinphat_asset_version( $css )
		);
	}

	if ( file_exists( TINPHAT_DIR . $css_lib ) ) {
		wp_enqueue_style(
			'tinphat-lib',
			TINPHAT_URI . $css_lib,
			array(),
			tinphat_asset_version( $css_lib )
		);
	}

	if ( file_exists( TINPHAT_DIR . $js ) ) {
		wp_enqueue_script(
			'tinphat-main',
			TINPHAT_URI . $js,
			array(),
			tinphat_asset_version( $js ),
			array( 'strategy' => 'defer', 'in_footer' => true )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'tinphat_enqueue_assets', 110 );

/**
 * Preload ảnh banner đầu tiên — đây là phần tử LCP của trang chủ.
 *
 * Ảnh nằm trong shortcode nên trình duyệt chỉ phát hiện sau khi parse
 * xong HTML; preload giúp bắt đầu tải ngay từ <head>.
 */
function tinphat_preload_lcp_image(): void {
	if ( ! is_front_page() ) {
		return;
	}

	$post = get_post();

	if ( ! $post instanceof WP_Post ) {
		return;
	}

	// Lấy ảnh của slide đầu tiên trong shortcode banner.
	if ( ! preg_match( '/\[tinphat_banner_item[^\]]*image="([^"]+)"/', $post->post_content, $m ) ) {
		return;
	}

	printf(
		'<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n",
		esc_url( $m[1] )
	);
}
add_action( 'wp_head', 'tinphat_preload_lcp_image', 1 );

/**
 * Preload font chính để tránh nhấp nháy chữ (FOUT).
 */
function tinphat_preload_fonts(): void {
	// Chỉ preload subset tiếng Việt weight 400 và 700 — hai font dùng
	// ngay ở màn hình đầu. Preload font không dùng sẽ bị cảnh báo console.
	$fonts = array(
		'baijamjuree-6.woff2',   // 400, vietnamese
		'baijamjuree-18.woff2',  // 700, vietnamese
	);

	foreach ( $fonts as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( TINPHAT_URI . '/assets/fonts/' . $font )
		);
	}
}
add_action( 'wp_head', 'tinphat_preload_fonts', 1 );

/**
 * Thêm cache header cho asset tĩnh của theme.
 *
 * Server dev không đặt Cache-Control nên Lighthouse trừ điểm.
 * Trên hosting thật nên cấu hình ở tầng web server thay vì PHP.
 */
function tinphat_static_cache_headers(): void {
	if ( is_admin() ) {
		return;
	}

	$uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

	if ( ! preg_match( '#\.(css|js|woff2?|jpg|jpeg|png|webp|avif|svg|gif)(\?|$)#i', $uri ) ) {
		return;
	}

	header( 'Cache-Control: public, max-age=31536000, immutable' );
}
add_action( 'send_headers', 'tinphat_static_cache_headers' );
