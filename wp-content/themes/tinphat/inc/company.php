<?php
/**
 * Thông tin công ty và các hàm truy xuất dùng chung cho template.
 *
 * Giá trị mặc định lấy từ hồ sơ Tín Phát; có thể ghi đè bằng
 * filter `tinphat_options` mà không cần sửa file này.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Bảng thông tin công ty theo ngôn ngữ hiện tại.
 *
 * @return array<string,string>
 */
function tinphat_options(): array {
	$is_vi = 'vi' === tinphat_current_lang();

	$options = array(
		'company_name' => $is_vi
			? 'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT'
			: 'TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED',
		'address'      => $is_vi
			? '106 Nam Kỳ Khởi Nghĩa, phường Vũng Tàu, thành phố Hồ Chí Minh'
			: '106 Nam Ky Khoi Nghia, Vung Tau Ward, Ho Chi Minh City',
		'hours'        => $is_vi
			? 'Thứ 2 - Thứ 6: 8:00 - 18:00'
			: 'Monday - Friday: 8:00 - 18:00',
		'phone'        => '0326 702 600',
		'email'        => 'congtytinphatvungtau@gmail.com',
		'tax_id'       => '3502302391',
	);

	/**
	 * Cho phép ghi đè thông tin công ty.
	 *
	 * @param array<string,string> $options Bảng thông tin.
	 */
	return (array) apply_filters( 'tinphat_options', $options );
}

/**
 * Lấy một giá trị thông tin công ty.
 *
 * @param string $key Khoá cần lấy.
 * @return string
 */
function tinphat_option( string $key ): string {
	$options = tinphat_options();

	return isset( $options[ $key ] ) ? (string) $options[ $key ] : '';
}

/**
 * Danh sách mạng xã hội.
 *
 * @return array<int,array<string,string>>
 */
function tinphat_socials(): array {
	return (array) apply_filters(
		'tinphat_socials',
		array(
			array( 'name' => 'Facebook', 'icon' => 'facebook', 'url' => 'https://facebook.com/tinphatcons' ),
			array( 'name' => 'LinkedIn', 'icon' => 'linkedin', 'url' => 'https://www.linkedin.com/company/tinphatcons' ),
		)
	);
}

/**
 * URL file trong thư mục uploads/tinphat.
 *
 * @param string $filename Tên file.
 * @return string
 */
function tinphat_uploads_url( string $filename ): string {
	return content_url( 'uploads/tinphat/' . ltrim( $filename, '/' ) );
}

/**
 * URL logo theo vị trí sử dụng.
 *
 * @param string $variant 'header' hoặc 'footer'.
 * @return string
 */
function tinphat_logo( string $variant = 'header' ): string {
	$file = 'footer' === $variant ? 'logo-footer-white.png' : 'logo-ngang-transparent.png';

	return tinphat_uploads_url( $file );
}

/**
 * Trang chủ đúng ngôn ngữ đang xem.
 *
 * @return string
 */
function tinphat_home_url(): string {
	if ( function_exists( 'pll_home_url' ) ) {
		return (string) pll_home_url();
	}

	return home_url( '/' );
}

/**
 * In bộ chuyển ngôn ngữ theo markup .menu_lang của template.
 */
function tinphat_language_switcher(): void {
	if ( ! function_exists( 'pll_the_languages' ) ) {
		return;
	}

	$languages = pll_the_languages( array( 'raw' => 1 ) );

	if ( ! is_array( $languages ) || count( $languages ) < 2 ) {
		return;
	}

	$current = null;
	$others  = array();

	foreach ( $languages as $language ) {
		if ( ! empty( $language['current_lang'] ) ) {
			$current = $language;
			continue;
		}
		$others[] = $language;
	}

	if ( null === $current ) {
		return;
	}
	?>
	<ul class="menu_lang">
		<li>
			<a href="#" onclick="return false;">
				<?php tinphat_language_flag( $current ); ?>
				<span><?php echo esc_html( strtoupper( $current['slug'] ) ); ?></span>
			</a>
			<ul>
				<?php foreach ( $others as $language ) : ?>
					<li class="lang-item lang-item-<?php echo esc_attr( $language['slug'] ); ?>">
						<a href="<?php echo esc_url( $language['url'] ); ?>" hreflang="<?php echo esc_attr( $language['slug'] ); ?>">
							<?php tinphat_language_flag( $language ); ?>
							<span><?php echo esc_html( strtoupper( $language['slug'] ) ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</li>
	</ul>
	<?php
}

/**
 * In lá cờ của một ngôn ngữ trong bộ chuyển ngôn ngữ.
 *
 * Polylang trả URL ảnh cờ trong khoá 'flag' (ảnh PNG 16x11 nằm trong
 * thư mục plugin). Chữ VI/EN ngay bên cạnh đã nói rõ ngôn ngữ nên cờ
 * chỉ là trang trí — để alt rỗng cho trình đọc màn hình bỏ qua, tránh
 * đọc lặp.
 *
 * @param array<string,mixed> $language Một phần tử từ pll_the_languages( raw ).
 */
function tinphat_language_flag( array $language ): void {
	$flag = (string) ( $language['flag'] ?? '' );

	if ( '' === $flag ) {
		return;
	}

	printf(
		'<img class="lang_flag" src="%s" alt="" width="16" height="11" decoding="async">',
		esc_url( $flag )
	);
}

/**
 * Bộ 12 logo đối tác THẬT, trích từ hồ sơ năng lực
 * (docs/PROFILE TIN PHAT IN.pdf, trang 19).
 *
 * Dùng khi CPT `doi-tac` chưa có bài nào.
 *
 * @return array<int,string>
 */
function tinphat_sample_partner_logos(): array {
	$files = array(
		'tp-partner-02-ptsc-mc.png',
		'tp-partner-03-ptsc-supply-base.png',
		'tp-partner-11-long-son-port.png',
		'tp-partner-08-pacific-industry.png',
		'tp-partner-06-brvt.png',
		'tp-partner-04-so-xd-dong-nai.png',
		'tp-partner-01-phan-vu.png',
		'tp-partner-09-hoa-phat.png',
		'tp-partner-12-hoa-sen.png',
		'tp-partner-05-an-lac.png',
		'tp-partner-10-son-vu.png',
		'tp-partner-07-fpt.png',
	);

	return array_map( 'tinphat_uploads_url', $files );
}

/**
 * Link e-Brochure.
 *
 * MOCKUP: Tín Phát chưa có file brochure — trả về '#'.
 * Ghi đè bằng filter `tinphat_brochure_url` khi có file thật.
 *
 * @return string
 */
function tinphat_brochure_url(): string {
	return (string) apply_filters( 'tinphat_brochure_url', '#' );
}
