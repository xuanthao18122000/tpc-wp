<?php
/**
 * SEO: dữ liệu có cấu trúc.
 *
 * Title/meta/sitemap/hreflang do Rank Math + Polylang lo.
 * File này chỉ bổ sung schema Organization mà plugin không tự biết.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Thông tin pháp lý của công ty (giống nhau ở mọi ngôn ngữ).
 *
 * @return array<string,string>
 */
function tinphat_company(): array {
	return array(
		'name_vi'   => 'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT',
		'name_en'   => 'TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED',
		'short'     => 'TIN PHAT CTI CO., LTD',
		'tax_id'    => '3502302391',
		'phone'     => '0326 702 600',
		'phone_e164'=> '+84326702600',
		'email'     => 'congtytinphatvungtau@gmail.com',
		'street_vi' => '106 Nam Kỳ Khởi Nghĩa, phường Vũng Tàu',
		'street_en' => '106 Nam Ky Khoi Nghia, Vung Tau Ward',
		'city_vi'   => 'thành phố Hồ Chí Minh',
		'city_en'   => 'Ho Chi Minh City',
	);
}

/**
 * In JSON-LD Organization vào <head>.
 */
function tinphat_organization_schema(): void {
	if ( ! is_front_page() ) {
		return;
	}

	$c    = tinphat_company();
	$lang = tinphat_current_lang();
	$is_vi = 'vi' === $lang;

	$schema = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'Organization',
		'name'          => $is_vi ? $c['name_vi'] : $c['name_en'],
		'alternateName' => array( 'Tín Phát Construction', 'Tin Phat Construction', $c['short'] ),
		'url'           => home_url( '/' ),
		'logo'          => TINPHAT_URI . '/assets/img/logo-ngang.png',
		'taxID'         => $c['tax_id'],
		'address'       => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $is_vi ? $c['street_vi'] : $c['street_en'],
			'addressLocality' => $is_vi ? $c['city_vi'] : $c['city_en'],
			'addressCountry'  => 'VN',
		),
		'contactPoint'  => array(
			'@type'             => 'ContactPoint',
			'telephone'         => $c['phone_e164'],
			'email'             => $c['email'],
			'contactType'       => 'customer service',
			'areaServed'        => 'VN',
			'availableLanguage' => array( 'vi', 'en' ),
		),
		'sameAs'        => array(
			'https://facebook.com/tinphatcons',
			'https://www.linkedin.com/company/tinphatcons',
		),
	);

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
	);
}
add_action( 'wp_head', 'tinphat_organization_schema', 20 );

/**
 * Bổ sung hreflang="x-default" trỏ về bản tiếng Việt.
 *
 * Polylang sinh sẵn hreflang cho từng ngôn ngữ nhưng không có x-default,
 * thẻ này giúp Google biết dùng bản nào khi không khớp ngôn ngữ nào.
 */
function tinphat_hreflang_x_default(): void {
	if ( ! function_exists( 'pll_get_post_translations' ) || ! function_exists( 'pll_home_url' ) ) {
		return;
	}

	$url = '';

	if ( is_singular() ) {
		$translations = pll_get_post_translations( (int) get_the_ID() );

		if ( isset( $translations['vi'] ) ) {
			$permalink = get_permalink( $translations['vi'] );
			$url       = is_string( $permalink ) ? $permalink : '';
		}
	} elseif ( is_front_page() || is_home() ) {
		$url = (string) pll_home_url( 'vi' );
	}

	if ( '' === $url ) {
		return;
	}

	printf(
		'<link rel="alternate" href="%s" hreflang="x-default" />' . "\n",
		esc_url( $url )
	);
}
add_action( 'wp_head', 'tinphat_hreflang_x_default', 11 );

/**
 * Meta description dự phòng.
 *
 * Rank Math chưa được cấu hình mẫu tiêu đề/mô tả cho từng loại nội dung,
 * nên bổ sung ở đây để trang nào cũng có description.
 */
function tinphat_fallback_meta_description(): void {
	// Rank Math đã in description thì thôi.
	if ( class_exists( 'RankMath' ) && ! apply_filters( 'tinphat_force_meta_description', false ) ) {
		$has_rank_math_desc = has_action( 'wp_head', 'rank_math_head' ) || defined( 'RANK_MATH_VERSION' );

		if ( $has_rank_math_desc && ! is_front_page() ) {
			return;
		}
	}

	$is_vi = 'vi' === tinphat_current_lang();

	if ( is_front_page() ) {
		$desc = $is_vi
			? 'Tín Phát Construction — thiết kế và thi công công trình dân dụng, công nghiệp, thương mại tại TP.HCM. Uy tín, chất lượng, đúng tiến độ.'
			: 'Tin Phat Construction — design and construction of residential, industrial and commercial projects in Ho Chi Minh City. Reliable delivery, on schedule.';
	} elseif ( is_singular() ) {
		$excerpt = (string) get_the_excerpt();
		$desc    = '' !== $excerpt
			? wp_trim_words( wp_strip_all_tags( $excerpt ), 30 )
			: wp_trim_words( wp_strip_all_tags( (string) get_the_content() ), 30 );
	} else {
		$desc = $is_vi
			? 'Tín Phát Construction — nhà thầu xây dựng dân dụng, công nghiệp và thương mại.'
			: 'Tin Phat Construction — residential, industrial and commercial building contractor.';
	}

	if ( '' === trim( $desc ) ) {
		return;
	}

	printf(
		'<meta name="description" content="%s" />' . "\n",
		esc_attr( $desc )
	);
}
add_action( 'wp_head', 'tinphat_fallback_meta_description', 2 );
