<?php
/**
 * Thiết kế banner trang chủ.
 *
 * Mỗi banner gồm:
 *   1. Ảnh công trường/ảnh bìa từ hồ sơ năng lực làm nền
 *   2. Lớp phủ gradient chéo xanh thương hiệu (đậm trái → trong suốt phải)
 *   3. Dải sọc chéo mảnh ở góc, lấy nhịp từ hoa văn của template
 *   4. Khối màu cam + vạch dọc làm điểm neo cho chữ
 *
 * Chữ do HTML phủ lên (shortcode tinphat_banner_item) để đúng font
 * tiếng Việt và co giãn theo màn hình.
 *
 * Chạy: PDF_PYTHON=<python-co-pymupdf> php scripts/make-banners.php
 */

if ( PHP_SAPI !== 'cli' ) {
	exit( 1 );
}

$uploads = dirname( __DIR__ ) . '/wp-content/uploads/tinphat';

/** Màu thương hiệu. */
const TP_NAVY   = array( 15, 20, 91 );
const TP_ORANGE = array( 225, 113, 38 );

// Xuất ở 2560px để màn hình Retina (mật độ điểm ảnh gấp đôi) không
// phải kéo giãn ảnh lên — đó là lý do bản 1600px nhìn mờ. Ảnh gốc
// trong hồ sơ năng lực đủ lớn (1500-2880px) nên không bị phóng non.
const TP_W = 2560;
const TP_H = 1440;

// Mọi toạ độ trang trí bên dưới đo theo khung 1600x900 ban đầu;
// nhân hệ số này để giữ nguyên bố cục khi đổi độ phân giải.
const TP_SCALE = TP_W / 1600;

/**
 * Cắt ảnh nguồn về khung banner.
 *
 * @param string $src  Đường dẫn ảnh.
 * @param float  $bias Vị trí cắt theo chiều dọc (0 = trên, 1 = dưới).
 * @return GdImage|null
 */
function tp_crop( string $src, float $bias = 0.4 ) {
	$ext = strtolower( pathinfo( $src, PATHINFO_EXTENSION ) );
	$im  = 'webp' === $ext ? @imagecreatefromwebp( $src ) : @imagecreatefromjpeg( $src );

	if ( ! $im ) {
		return null;
	}

	$w      = imagesx( $im );
	$h      = imagesy( $im );
	$target = TP_W / TP_H;

	if ( $w / $h > $target ) {
		$cw = (int) round( $h * $target );
		$ch = $h;
		$cx = (int) round( ( $w - $cw ) / 2 );
		$cy = 0;
	} else {
		$cw = $w;
		$ch = (int) round( $w / $target );
		$cx = 0;
		$cy = (int) round( ( $h - $ch ) * $bias );
	}

	$out = imagecreatetruecolor( TP_W, TP_H );
	imagecopyresampled( $out, $im, 0, 0, $cx, $cy, TP_W, TP_H, $cw, $ch );
	imagedestroy( $im );

	return $out;
}

/**
 * Phủ gradient dọc: trong suốt ở trên, đậm dần xuống đáy.
 *
 * Giữ nguyên bầu trời và công trình ở nửa trên, chỉ làm tối phần
 * dưới để chữ trắng nổi mà ảnh không bị xỉn.
 *
 * @param GdImage $im  Ảnh đích.
 * @param float   $max Độ đục tối đa ở đáy.
 */
function tp_overlay( $im, float $max = 0.82 ): void {
	imagealphablending( $im, true );

	// Bắt đầu tối từ 40% chiều cao trở xuống.
	//
	// Gradient này chỉ để ảnh có chiều sâu và ăn nhập với chân trang;
	// phần nền bảo đảm tương phản cho chữ do CSS đảm nhiệm
	// (.banner_slider .meta_info::before), nên ở đây giữ tay nhẹ
	// để ảnh không bị xỉn.
	$from = (int) round( TP_H * 0.40 );

	for ( $y = $from; $y < TP_H; $y++ ) {
		$t     = ( $y - $from ) / ( TP_H - $from - 1 );
		$alpha = $max * ( $t * $t );  // cong bậc 2 cho chuyển mượt

		$a = (int) round( 127 * ( 1 - max( 0, min( 1, $alpha ) ) ) );
		$c = imagecolorallocatealpha( $im, TP_NAVY[0], TP_NAVY[1], TP_NAVY[2], $a );
		imagefilledrectangle( $im, 0, $y, TP_W, $y, $c );
	}

	// Vệt tối nhẹ bên trái để khối chữ luôn có nền.
	$left = (int) round( 760 * TP_SCALE );

	for ( $x = 0; $x < $left; $x++ ) {
		$alpha = 0.30 * ( 1 - $x / $left );
		$a     = (int) round( 127 * ( 1 - $alpha ) );
		$c     = imagecolorallocatealpha( $im, TP_NAVY[0], TP_NAVY[1], TP_NAVY[2], $a );
		imagefilledrectangle( $im, $x, 0, $x, TP_H, $c );
	}
}

/**
 * Dải sọc chéo mảnh ở góc phải — lấy nhịp từ hoa văn của template.
 *
 * @param GdImage $im Ảnh đích.
 */
function tp_stripes( $im ): void {
	imagealphablending( $im, true );
	$c = imagecolorallocatealpha( $im, 225, 113, 38, 88 );

	$k = TP_SCALE;

	// 14 sọc nghiêng 45° ở góc phải trên.
	for ( $i = 0; $i < 14; $i++ ) {
		$x = TP_W - (int) round( 300 * $k ) + (int) round( $i * 16 * $k );
		$t = (int) round( 4 * $k );     // bề dày sọc
		$d = (int) round( 110 * $k );   // độ dài theo đường chéo

		imagefilledpolygon(
			$im,
			array(
				$x, 0,
				$x + $t, 0,
				$x + $t - $d, $d,
				$x - $d, $d,
			),
			$c
		);
	}
}

/**
 * Vạch cam neo khối chữ ở góc trái dưới.
 *
 * @param GdImage $im Ảnh đích.
 */
function tp_accent( $im ): void {
	$orange = imagecolorallocate( $im, TP_ORANGE[0], TP_ORANGE[1], TP_ORANGE[2] );

	$k = TP_SCALE;

	// Vạch dọc cạnh dòng chữ (chữ do HTML đặt ở khoảng y 620-760).
	imagefilledrectangle(
		$im,
		(int) round( 96 * $k ),
		(int) round( 614 * $k ),
		(int) round( 102 * $k ),
		(int) round( 762 * $k ),
		$orange
	);

	// Thanh ngang mảnh sát đáy.
	imagefilledrectangle(
		$im,
		0,
		TP_H - (int) round( 6 * $k ),
		(int) round( 460 * $k ),
		TP_H,
		$orange
	);
}

/**
 * Dựng một banner hoàn chỉnh.
 *
 * @param string $src   Ảnh nền.
 * @param string $dst   File đích.
 * @param float  $bias  Vị trí cắt dọc.
 * @param float  $start Độ đục tối đa ở đáy.
 */
function tp_banner( string $src, string $dst, float $bias = 0.4, float $start = 0.82 ): void {
	$im = tp_crop( $src, $bias );

	if ( ! $im ) {
		fwrite( STDERR, "  không đọc được " . basename( $src ) . "\n" );
		return;
	}

	tp_overlay( $im, $start );
	tp_stripes( $im );
	tp_accent( $im );

	imagewebp( $im, $dst, 82 );
	imagedestroy( $im );

	printf( "  %-20s %dx%d  %dKB\n", basename( $dst ), TP_W, TP_H, filesize( $dst ) / 1024 );
}

// Ảnh nền: chọn theo phong cách công trình hoàn thiện, sáng, bố cục
// thoáng. Tránh ảnh công nhân cận cảnh và ảnh có logo thương hiệu khác.
$banners = array(
	array( 'xref' =>  97, 'dst' => 'banner-01.webp', 'bias' => 0.45, 'start' => 0.80 ),  // tr.19 thi công móng cọc (5580px)
	array( 'xref' => 286, 'dst' => 'banner-02.webp', 'bias' => 0.34, 'start' => 0.58 ),  // tr.14 thảm nhựa mặt đường cảng PTSC (2560px)
	array( 'xref' => 364, 'dst' => 'banner-03.webp', 'bias' => 0.45, 'start' => 0.80 ),  // tr.10 cần cẩu, mây hoàng hôn
	// Ảnh công trình trong tập đoàn (nguồn: centralcons.vn), lưu tại
	// assets/banner-src/. Ảnh skyline đã xoá biển hiệu "THE HALLMARK"
	// bằng scripts/remove-sign.php.
	array( 'file' => 'skyline-thu-thiem.webp', 'dst' => 'banner-05.webp', 'bias' => 0.45, 'start' => 0.80 ),
	array( 'file' => 'can-ho-ven-song.webp',   'dst' => 'banner-06.webp', 'bias' => 0.50, 'start' => 0.80 ),
);

// Trích ảnh cần lấy từ PDF.
$xrefs = array_filter( array_column( $banners, 'xref' ) );

if ( ! empty( $xrefs ) ) {
	$python = getenv( 'PDF_PYTHON' ) ?: '';
	$pdf    = dirname( __DIR__, 2 ) . '/docs/PROFILE TIN PHAT IN.pdf';

	if ( '' === $python || ! is_executable( $python ) ) {
		fwrite( STDERR, "Đặt biến PDF_PYTHON trỏ tới python có PyMuPDF.\n" );
		exit( 1 );
	}

	$script = <<<'PY'
import pymupdf, sys
doc = pymupdf.open(sys.argv[1])
for xref in sys.argv[2].split(','):
    d = doc.extract_image(int(xref))
    open(f"{sys.argv[3]}/tpbn_{xref}.{d['ext']}", "wb").write(d["image"])
    print(f"{xref}.{d['ext']}")
PY;

	$tmp_py = sys_get_temp_dir() . '/tp_bn_' . getmypid() . '.py';
	file_put_contents( $tmp_py, $script );
	exec(
		sprintf(
			'%s %s %s %s %s 2>&1',
			escapeshellcmd( $python ),
			escapeshellarg( $tmp_py ),
			escapeshellarg( $pdf ),
			escapeshellarg( implode( ',', $xrefs ) ),
			escapeshellarg( sys_get_temp_dir() )
		),
		$lines,
		$code
	);
	unlink( $tmp_py );

	if ( 0 !== $code ) {
		fwrite( STDERR, "Lỗi trích ảnh: " . implode( "\n", $lines ) . "\n" );
		exit( 1 );
	}

	$exts = array();

	foreach ( $lines as $line ) {
		[ $xref, $ext ]      = explode( '.', trim( $line ) );
		$exts[ (int) $xref ] = $ext;
	}
}

foreach ( $banners as $b ) {
	if ( isset( $b['xref'] ) ) {
		$src = sys_get_temp_dir() . '/tpbn_' . $b['xref'] . '.' . ( $exts[ $b['xref'] ] ?? 'jpeg' );
	} else {
		// Ảnh nguồn ngoài PDF, lưu kèm repo để chạy lại được.
		$src = dirname( __DIR__ ) . '/assets/banner-src/' . $b['file'];
	}

	if ( ! file_exists( $src ) ) {
		fwrite( STDERR, "  thiếu nguồn cho {$b['dst']}\n" );
		continue;
	}

	tp_banner( $src, $uploads . '/' . $b['dst'], $b['bias'], $b['start'] );

	if ( isset( $b['xref'] ) ) {
		unlink( $src );
	}
}
