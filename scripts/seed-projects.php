<?php
/**
 * Seed CPT du-an song ngữ.
 * Dữ liệu lấy từ dictionary của bản Next.js (tinphat-new).
 *
 * Chạy: wp eval-file /scripts/seed-projects.php
 */

$projects = array(
	array(
		'vi' => array(
			'title'    => 'Biệt thự Quận 2',
			'client'   => 'Khách hàng cá nhân',
			'location' => 'Thảo Điền, Quận 2, TP.HCM',
			'scope'    => 'Dân dụng · 500m² · Hoàn thành 2024. Biệt thự cao cấp với thiết kế hiện đại, sử dụng vật liệu nhập khẩu.',
			'cat'      => 'Dân dụng',
		),
		'en' => array(
			'title'    => 'District 2 Villa',
			'client'   => 'Private client',
			'location' => 'Thao Dien, District 2, HCMC',
			'scope'    => 'Residential · 500 sqm · Completed 2024. Premium villa with modern design and imported materials.',
			'cat'      => 'Residential',
		),
	),
	array(
		'vi' => array(
			'title'    => 'Nhà xưởng KCN Hiệp Phước',
			'client'   => 'Chủ đầu tư công nghiệp',
			'location' => 'KCN Hiệp Phước, TP.HCM',
			'scope'    => 'Công nghiệp · 5.000m² · Đang thi công. Nhà xưởng khung thép tiền chế, đáp ứng tiêu chuẩn công nghiệp hiện đại.',
			'cat'      => 'Công nghiệp',
		),
		'en' => array(
			'title'    => 'Hiep Phuoc IZ Factory',
			'client'   => 'Industrial investor',
			'location' => 'Hiep Phuoc IZ, HCMC',
			'scope'    => 'Industrial · 5,000 sqm · Under construction. Pre-engineered steel factory meeting modern industrial standards.',
			'cat'      => 'Industrial',
		),
	),
	array(
		'vi' => array(
			'title'    => 'Nhà phố Bình Thạnh',
			'client'   => 'Khách hàng cá nhân',
			'location' => 'Quận Bình Thạnh, TP.HCM',
			'scope'    => 'Dân dụng · 64m² · Đang thi công. Nhà phố 4 tầng, thiết kế tối ưu công năng sử dụng.',
			'cat'      => 'Dân dụng',
		),
		'en' => array(
			'title'    => 'Binh Thanh Townhouse',
			'client'   => 'Private client',
			'location' => 'Binh Thanh District, HCMC',
			'scope'    => 'Residential · 64 sqm · Under construction. Four-storey townhouse with optimised layout.',
			'cat'      => 'Residential',
		),
	),
	array(
		'vi' => array(
			'title'    => 'Vinhomes Smart City',
			'client'   => 'Vingroup',
			'location' => 'Quận 9, TP.HCM',
			'scope'    => 'Dân dụng · 100 căn hộ · Hoàn thành 2023. Khu đô thị thông minh với đầy đủ tiện ích hiện đại.',
			'cat'      => 'Dân dụng',
		),
		'en' => array(
			'title'    => 'Vinhomes Smart City',
			'client'   => 'Vingroup',
			'location' => 'District 9, HCMC',
			'scope'    => 'Residential · 100 apartments · Completed 2023. Smart urban area with full modern amenities.',
			'cat'      => 'Residential',
		),
	),
	array(
		'vi' => array(
			'title'    => 'Nhà Máy Điện Gió Phú Lạc 2',
			'client'   => 'Chủ đầu tư năng lượng',
			'location' => 'Bình Thuận',
			'scope'    => 'Công nghiệp · 50MW · Hoàn thành 2023. Dự án điện gió quy mô lớn, góp phần phát triển năng lượng sạch.',
			'cat'      => 'Công nghiệp',
		),
		'en' => array(
			'title'    => 'Phu Lac 2 Wind Farm',
			'client'   => 'Energy investor',
			'location' => 'Binh Thuan',
			'scope'    => 'Industrial · 50MW · Completed 2023. Large-scale wind power project supporting clean energy.',
			'cat'      => 'Industrial',
		),
	),
	array(
		'vi' => array(
			'title'    => 'SELAVIA Resort',
			'client'   => 'Chủ đầu tư nghỉ dưỡng',
			'location' => 'Phú Quốc',
			'scope'    => 'Thương mại · 10 hecta · Hoàn thành 2024. Khu nghỉ dưỡng cao cấp với view biển tuyệt đẹp.',
			'cat'      => 'Thương mại',
		),
		'en' => array(
			'title'    => 'SELAVIA Resort',
			'client'   => 'Resort investor',
			'location' => 'Phu Quoc',
			'scope'    => 'Commercial · 10 hectares · Completed 2024. Premium resort with panoramic sea views.',
			'cat'      => 'Commercial',
		),
	),
	array(
		'vi' => array(
			'title'    => 'Văn Phòng Hiện Đại CBD',
			'client'   => 'Chủ đầu tư văn phòng',
			'location' => 'Quận 1, TP.HCM',
			'scope'    => 'Thương mại · 20 tầng · Hoàn thành 2023. Tòa nhà văn phòng hạng A tại trung tâm thành phố.',
			'cat'      => 'Thương mại',
		),
		'en' => array(
			'title'    => 'CBD Modern Office',
			'client'   => 'Office investor',
			'location' => 'District 1, HCMC',
			'scope'    => 'Commercial · 20 floors · Completed 2023. Grade A office tower in the city centre.',
			'cat'      => 'Commercial',
		),
	),
	array(
		'vi' => array(
			'title'    => 'Khu Dân Cư Cao Cấp Riverside',
			'client'   => 'Chủ đầu tư bất động sản',
			'location' => 'Quận 7, TP.HCM',
			'scope'    => 'Dân dụng · 50 căn · Hoàn thành 2024. Khu dân cư ven sông với không gian xanh mát.',
			'cat'      => 'Dân dụng',
		),
		'en' => array(
			'title'    => 'Riverside Premium Residences',
			'client'   => 'Real estate investor',
			'location' => 'District 7, HCMC',
			'scope'    => 'Residential · 50 units · Completed 2024. Riverside residential area with green open space.',
			'cat'      => 'Residential',
		),
	),
	array(
		'vi' => array(
			'title'    => 'Trụ sở Công ty ABC',
			'client'   => 'Khách hàng doanh nghiệp',
			'location' => 'Quận Tân Bình, TP.HCM',
			'scope'    => 'Thương mại · 800m² · Hoàn thành 2024. Cải tạo và nâng cấp toàn bộ trụ sở công ty.',
			'cat'      => 'Thương mại',
		),
		'en' => array(
			'title'    => 'ABC Company Headquarters',
			'client'   => 'Corporate client',
			'location' => 'Tan Binh District, HCMC',
			'scope'    => 'Commercial · 800 sqm · Completed 2024. Full renovation and upgrade of the company headquarters.',
			'cat'      => 'Commercial',
		),
	),
);

/**
 * Tạo hoặc lấy term theo tên + ngôn ngữ.
 */
function tp_term( string $name, string $lang ): int {
	$slug     = sanitize_title( $name . '-' . $lang );
	$existing = get_term_by( 'slug', $slug, 'loai-du-an' );

	if ( $existing instanceof WP_Term ) {
		return $existing->term_id;
	}

	$result = wp_insert_term( $name, 'loai-du-an', array( 'slug' => $slug ) );

	if ( is_wp_error( $result ) ) {
		return 0;
	}

	$term_id = (int) $result['term_id'];
	pll_set_term_language( $term_id, $lang );

	return $term_id;
}

/**
 * Tạo một dự án.
 */
function tp_project( array $data, string $lang ): int {
	$existing = get_posts(
		array(
			'post_type'      => 'du-an',
			'title'          => $data['title'],
			'posts_per_page' => 1,
			'post_status'    => 'any',
			'fields'         => 'ids',
		)
	);

	foreach ( $existing as $id ) {
		if ( pll_get_post_language( $id ) === $lang ) {
			WP_CLI::log( "  = {$lang}: {$data['title']}" );
			return (int) $id;
		}
	}

	$id = wp_insert_post(
		array(
			'post_title'  => $data['title'],
			'post_type'   => 'du-an',
			'post_status' => 'publish',
		),
		true
	);

	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( $id->get_error_message() );
		return 0;
	}

	$id = (int) $id;
	pll_set_post_language( $id, $lang );

	update_post_meta( $id, 'client', $data['client'] );
	update_post_meta( $id, 'location', $data['location'] );
	update_post_meta( $id, 'scope', $data['scope'] );

	$term_id = tp_term( $data['cat'], $lang );

	if ( $term_id > 0 ) {
		wp_set_object_terms( $id, array( $term_id ), 'loai-du-an' );
	}

	WP_CLI::log( "  + {$lang}: {$data['title']} (#{$id})" );

	return $id;
}

$count = 0;

foreach ( $projects as $pair ) {
	$vi = tp_project( $pair['vi'], 'vi' );
	$en = tp_project( $pair['en'], 'en' );

	if ( $vi > 0 && $en > 0 ) {
		pll_save_post_translations( array( 'vi' => $vi, 'en' => $en ) );
		++$count;
	}
}

WP_CLI::success( "Đã seed {$count} dự án song ngữ." );
