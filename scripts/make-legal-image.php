<?php
/**
 * Tạo ảnh "Cơ sở pháp lý & Chứng chỉ" từ hồ sơ năng lực PDF,
 * có che các thông tin cá nhân của người đại diện.
 *
 * Che bằng ô trắng: chỉ số CCCD và ngày sinh của người đại diện.
 * Giữ nguyên mọi thông tin còn lại, mộc đỏ và chữ ký.
 *
 * Yêu cầu: Python venv có PyMuPDF (xem README).
 * Chạy: php scripts/make-legal-image.php
 */

if ( PHP_SAPI !== 'cli' ) {
	exit( 1 );
}

$pdf    = dirname( __DIR__, 2 ) . '/docs/PROFILE TIN PHAT IN.pdf';
$python = getenv( 'PDF_PYTHON' ) ?: '';
$dest   = dirname( __DIR__ ) . '/wp-content/uploads/tinphat/tp-legal-page.webp';

if ( ! file_exists( $pdf ) ) {
	fwrite( STDERR, "Không thấy PDF: {$pdf}\n" );
	exit( 1 );
}

if ( '' === $python || ! is_executable( $python ) ) {
	fwrite( STDERR, "Đặt biến PDF_PYTHON trỏ tới python có PyMuPDF.\n" );
	exit( 1 );
}

$script = <<<'PY'
import pymupdf, sys

pdf, out_png = sys.argv[1], sys.argv[2]
doc  = pymupdf.open(pdf)
page = doc[4]  # trang đôi 08-09: Cơ sở pháp lý / Chứng chỉ

# Vùng cần che, toạ độ theo điểm (pt) trên trang PDF.
# Mỗi ảnh scan là một khung; số liệu lấy từ get_image_rects().
redactions = [
    # --- Giấy thông tin chủ sở hữu (khung trên, 212,168 - 494,567) ---
    (280, 213, 316, 220),   # Sinh ngày
    (328, 229, 371, 237),   # Số CCCD

    # --- Giấy CN ĐKDN (khung trái dưới, 35,358 - 317,757) ---
    (101, 585, 134, 593),   # Sinh ngày
    (147, 601, 190, 610),   # Số CCCD
]

for x0, y0, x1, y1 in redactions:
    page.draw_rect(pymupdf.Rect(x0, y0, x1, y1), color=(1, 1, 1),
                   fill=(1, 1, 1), overlay=True)

page.get_pixmap(dpi=265).save(out_png)
print(f"{page.rect.width:.0f}x{page.rect.height:.0f}")
PY;

$tmp_py  = sys_get_temp_dir() . '/tp_legal_' . getmypid() . '.py';
$tmp_png = sys_get_temp_dir() . '/tp_legal_' . getmypid() . '.png';

file_put_contents( $tmp_py, $script );

exec( sprintf( '%s %s %s %s 2>&1', escapeshellcmd( $python ), escapeshellarg( $tmp_py ), escapeshellarg( $pdf ), escapeshellarg( $tmp_png ) ), $out, $code );
unlink( $tmp_py );

if ( 0 !== $code || ! file_exists( $tmp_png ) ) {
	fwrite( STDERR, "Lỗi render: " . implode( "\n", $out ) . "\n" );
	exit( 1 );
}

// Thu về 2200px: đủ nét cho màn Retina, file không quá nặng.
$im = imagecreatefrompng( $tmp_png );
$w  = imagesx( $im );
$h  = imagesy( $im );
$tw = 2200;
$th = (int) round( $h * $tw / $w );

$resized = imagecreatetruecolor( $tw, $th );
imagecopyresampled( $resized, $im, 0, 0, 0, 0, $tw, $th, $w, $h );
imagewebp( $resized, $dest, 84 );

unlink( $tmp_png );

printf( "Đã tạo %s  %dx%d  %dKB\n", basename( $dest ), $tw, $th, filesize( $dest ) / 1024 );
