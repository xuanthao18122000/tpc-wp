<?php
/**
 * Hàm tiện ích dùng chung.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Lấy URL ảnh theo ID, có fallback rỗng.
 *
 * @param int    $attachment_id ID ảnh.
 * @param string $size          Kích thước.
 * @return string
 */
function tinphat_image_url( int $attachment_id, string $size = 'large' ): string {
	if ( $attachment_id < 1 ) {
		return '';
	}

	$src = wp_get_attachment_image_url( $attachment_id, $size );

	return is_string( $src ) ? $src : '';
}

/**
 * Đọc ACF field an toàn khi chưa cài ACF.
 *
 * @param string   $selector Tên field.
 * @param int|null $post_id  ID bài viết.
 * @return mixed
 */
function tinphat_field( string $selector, ?int $post_id = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}

	return get_field( $selector, $post_id ?? get_the_ID() );
}

/**
 * Dịch chuỗi theo Polylang, trả về nguyên văn nếu chưa cài.
 *
 * @param string $text Chuỗi cần dịch.
 * @return string
 */
function tinphat_translate( string $text ): string {
	return function_exists( 'pll__' ) ? pll__( $text ) : $text;
}

/**
 * Lấy mã ngôn ngữ hiện tại.
 *
 * @return string Mã 2 ký tự, mặc định 'vi'.
 */
function tinphat_current_lang(): string {
	if ( function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language( 'slug' );

		if ( is_string( $lang ) && '' !== $lang ) {
			return $lang;
		}
	}

	return 'vi';
}

/**
 * In HTML đã lọc theo whitelist an toàn cho nội dung biên tập.
 *
 * @param string $html Chuỗi HTML.
 */
function tinphat_safe_html( string $html ): void {
	echo wp_kses(
		$html,
		array(
			'br'     => array(),
			'strong' => array(),
			'em'     => array(),
			'span'   => array( 'class' => array() ),
			'a'      => array( 'href' => array(), 'title' => array(), 'target' => array(), 'rel' => array() ),
		)
	);
}

/**
 * Nhãn tháng ngắn cho ô ngày trên thẻ tin.
 *
 * Tiếng Việt dùng dạng "Th9" như centralcons. Không dựa vào date_i18n()
 * vì gói ngôn ngữ vi_VN có thể chưa được cài, khi đó WordPress trả về
 * tên tháng tiếng Anh.
 *
 * @param int|string|null $post Bài viết (mặc định: bài hiện tại).
 * @return string
 */
function tinphat_month_label( $post = null ): string {
	$month = (int) get_the_date( 'n', $post );

	if ( 'vi' === tinphat_current_lang() ) {
		return 'Th' . $month;
	}

	return (string) get_the_date( 'M', $post );
}
