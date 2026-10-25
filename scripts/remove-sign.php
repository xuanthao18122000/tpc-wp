<?php
/**
 * Xoá biển hiệu "THE HALLMARK" khỏi ảnh skyline Thủ Thiêm.
 *
 * Nền sau biển là mặt kính xanh đậm có vân ngang khá đều, nên thay vì
 * tô đè một màu phẳng (sẽ thành mảng bệt lộ liễu), ta chép từng hàng
 * pixel từ vùng kính sạch bên phải sang — vân ngang khớp nhau nên
 * vết vá gần như không thấy.
 */

$src = __DIR__ . '/Metropole-Banner-2-scaled.jpg.webp';
$dst = __DIR__ . '/metropole-clean.webp';

$im = imagecreatefromwebp( $src );
if ( ! $im ) {
	fwrite( STDERR, "không đọc được ảnh\n" );
	exit( 1 );
}

// Khung chứa biển hiệu, đo trên ảnh gốc 2560x1244.
// Quét độ sáng theo hàng cho thấy thân toà nhà liền mạch x 747-966;
// các khoảng "sáng" lọt giữa dải đó chính là nét chữ.
$x0 = 758;
$y0 = 150;
$x1 = 892;
$y1 = 228;

// Vùng kính sạch dùng làm mẫu: lấy BÊN TRONG thân toà nhà, phía phải
// biển hiệu (x 900-960) — cùng mặt kính nên vân ngang và độ sáng khớp.
// Lấy ngoài biên x=966 sẽ dính nền trời và tạo mảng sáng lộ liễu.
$src_x = 900;

$w = $x1 - $x0;

for ( $y = $y0; $y <= $y1; $y++ ) {
	for ( $i = 0; $i < $w; $i++ ) {
		// Lấy mẫu lặp lại theo chiều ngang của dải kính sạch.
		$sx  = $src_x + ( $i % 62 );
		$rgb = imagecolorat( $im, $sx, $y );

		imagesetpixel( $im, $x0 + $i, $y, $rgb );
	}
}

// Làm mềm hai mép dọc của vùng vá để không lộ đường cắt.
for ( $y = $y0; $y <= $y1; $y++ ) {
	foreach ( array( $x0, $x1 ) as $edge ) {
		for ( $d = -2; $d <= 2; $d++ ) {
			$x = $edge + $d;
			$r = $g = $b = 0;

			for ( $k = -2; $k <= 2; $k++ ) {
				$c  = imagecolorat( $im, max( 0, $x + $k ), $y );
				$r += ( $c >> 16 ) & 0xFF;
				$g += ( $c >> 8 ) & 0xFF;
				$b += $c & 0xFF;
			}

			imagesetpixel(
				$im,
				$x,
				$y,
				imagecolorallocate( $im, (int) ( $r / 5 ), (int) ( $g / 5 ), (int) ( $b / 5 ) )
			);
		}
	}
}

imagewebp( $im, $dst, 92 );
imagedestroy( $im );

printf( "đã xoá biển hiệu -> %s (%dKB)\n", basename( $dst ), filesize( $dst ) / 1024 );
