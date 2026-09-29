<?php
/**
 * Router cho PHP built-in server.
 *
 * Server này không có mod_rewrite, nên phải tự chuyển mọi request
 * không phải file tĩnh về index.php để permalink hoạt động.
 *
 * @package TinPhat
 */

$path = parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH );
$file = __DIR__ . $path;

// File tĩnh có thật: để server tự phục vụ.
if ( '/' !== $path && file_exists( $file ) && ! is_dir( $file ) ) {
	return false;
}

// Thư mục có index.php (vd. /wp-admin/): nạp file đó.
if ( is_dir( $file ) && file_exists( rtrim( $file, '/' ) . '/index.php' ) ) {
	$_SERVER['SCRIPT_NAME'] = rtrim( $path, '/' ) . '/index.php';
	require rtrim( $file, '/' ) . '/index.php';
	return true;
}

// Còn lại: đưa về WordPress.
$_SERVER['SCRIPT_NAME'] = '/index.php';
require __DIR__ . '/index.php';
