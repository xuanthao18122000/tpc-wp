<?php
/**
 * Cấu hình Polylang: URL có tiền tố ngôn ngữ, bật dịch CPT/taxonomy.
 * Chạy: wp eval-file /scripts/setup-polylang-options.php
 */

$options = get_option( 'polylang' );

if ( ! is_array( $options ) ) {
	WP_CLI::error( 'Không đọc được option polylang.' );
}

// force_lang = 1: tiền tố ngôn ngữ trong đường dẫn (/vi/, /en/).
$options['force_lang']   = 1;
$options['hide_default'] = 0; // Luôn hiện /vi/ để hai ngôn ngữ đối xứng.
$options['rewrite']      = 1;
$options['redirect_lang'] = 1;
$options['browser']      = 1; // Tự nhận ngôn ngữ trình duyệt ở trang chủ.
$options['default_lang'] = 'vi';

// Bật dịch cho các CPT của theme.
$options['post_types'] = array( 'du-an', 'van-hoa', 'video', 'tuyen-dung', 'doi-tac' );
$options['taxonomies'] = array( 'loai-du-an', 'nhom-doi-tac' );

update_option( 'polylang', $options );

flush_rewrite_rules();

WP_CLI::success( 'Đã cấu hình Polylang (force_lang=1, hide_default=0).' );
WP_CLI::log( 'CPT dịch: ' . implode( ', ', $options['post_types'] ) );
