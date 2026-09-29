<?php
/**
 * Icon SVG inline.
 *
 * Thay Font Awesome (30KB CSS + font file) — site chỉ dùng 4 icon.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Trả về mã SVG của một icon.
 *
 * @param string $name  Tên icon.
 * @param string $class Class CSS thêm vào.
 * @return string
 */
function tinphat_icon( string $name, string $class = '' ): string {
	$icons = array(
		'facebook'    => '<path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z"/>',
		'linkedin'    => '<path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3V9zm7 0h3.8v1.7h.05c.53-.95 1.83-1.95 3.75-1.95 4 0 4.75 2.6 4.75 6V21h-4v-5.5c0-1.3-.02-3-1.85-3-1.85 0-2.13 1.44-2.13 2.9V21h-4V9z"/>',
		'angle-down'  => '<path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
		'play'        => '<path d="M8 5v14l11-7z"/>',
	);

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	return sprintf(
		'<svg class="tp-icon tp-icon--%s %s" viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false">%s</svg>',
		esc_attr( $name ),
		esc_attr( $class ),
		$icons[ $name ]
	);
}

/**
 * In icon (đã escape sẵn trong tinphat_icon).
 *
 * @param string $name  Tên icon.
 * @param string $class Class CSS.
 */
function tinphat_the_icon( string $name, string $class = '' ): void {
	echo wp_kses(
		tinphat_icon( $name, $class ),
		array(
			'svg'  => array(
				'class' => array(), 'viewbox' => array(), 'width' => array(),
				'height' => array(), 'fill' => array(), 'aria-hidden' => array(), 'focusable' => array(),
			),
			'path' => array(
				'd' => array(), 'fill' => array(), 'stroke' => array(),
				'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array(),
			),
		)
	);
}
