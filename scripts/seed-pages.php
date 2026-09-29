<?php
/**
 * Tạo cây trang song ngữ và liên kết bản dịch VI <-> EN.
 * Chạy lại nhiều lần được: trang đã tồn tại thì bỏ qua.
 *
 * Chạy: wp eval-file /scripts/seed-pages.php
 */

/**
 * Cấu trúc trang. Slug đã đổi theo yêu cầu (bỏ di sản template Central).
 */
$tree = array(
	array(
		'vi' => array( 'title' => 'Trang chủ', 'slug' => 'trang-chu' ),
		'en' => array( 'title' => 'Home', 'slug' => 'home' ),
		'front' => true,
	),
	array(
		'vi' => array( 'title' => 'Giới thiệu', 'slug' => 'gioi-thieu' ),
		'en' => array( 'title' => 'About Us', 'slug' => 'about-us' ),
		'children' => array(
			array(
				'vi' => array( 'title' => 'Tổng quan', 'slug' => 'tong-quan' ),
				'en' => array( 'title' => 'Overview', 'slug' => 'overview' ),
			),
			array(
				'vi' => array( 'title' => 'Thông điệp Giám đốc', 'slug' => 'thong-diep-giam-doc' ),
				'en' => array( 'title' => "Director's Message", 'slug' => 'directors-message' ),
			),
			array(
				'vi' => array( 'title' => 'Tầm nhìn, giá trị cốt lõi', 'slug' => 'tam-nhin-gia-tri-cot-loi' ),
				'en' => array( 'title' => 'Vision & Core Values', 'slug' => 'vision-core-values' ),
			),
			array(
				'vi' => array( 'title' => 'Đối tác và khách hàng', 'slug' => 'doi-tac-khach-hang' ),
				'en' => array( 'title' => 'Partners & Clients', 'slug' => 'partners-clients' ),
			),
		),
	),
	array(
		'vi' => array( 'title' => 'Năng lực thi công', 'slug' => 'nang-luc' ),
		'en' => array( 'title' => 'Capabilities', 'slug' => 'capabilities' ),
		'children' => array(
			array(
				'vi' => array( 'title' => 'Lĩnh vực hoạt động', 'slug' => 'linh-vuc-hoat-dong' ),
				'en' => array( 'title' => 'What We Do', 'slug' => 'what-we-do' ),
			),
			array(
				'vi' => array( 'title' => 'Máy móc & Thiết bị', 'slug' => 'may-moc-thiet-bi' ),
				'en' => array( 'title' => 'Plant & Equipment', 'slug' => 'plant-equipment' ),
			),
			array(
				'vi' => array( 'title' => 'Quy trình thi công', 'slug' => 'quy-trinh-thi-cong' ),
				'en' => array( 'title' => 'Construction Process', 'slug' => 'construction-process' ),
			),
			array(
				'vi' => array( 'title' => 'Chứng chỉ & Giấy phép', 'slug' => 'chung-chi-giay-phep' ),
				'en' => array( 'title' => 'Certificates & Licences', 'slug' => 'certificates-licences' ),
			),
		),
	),
	array(
		'vi' => array( 'title' => 'Tin tức', 'slug' => 'tin-tuc' ),
		'en' => array( 'title' => 'News', 'slug' => 'news' ),
	),
	array(
		'vi' => array( 'title' => 'Liên hệ', 'slug' => 'lien-he' ),
		'en' => array( 'title' => 'Contact', 'slug' => 'contact' ),
	),
);

/**
 * Tạo (hoặc lấy) một trang theo slug + ngôn ngữ.
 */
function tp_upsert_page( array $data, string $lang, int $parent = 0 ): int {
	$existing = get_page_by_path( $data['slug'], OBJECT, 'page' );

	if ( $existing instanceof WP_Post && pll_get_post_language( $existing->ID ) === $lang ) {
		WP_CLI::log( "  = {$lang}/{$data['slug']} (đã có)" );
		return $existing->ID;
	}

	$id = wp_insert_post(
		array(
			'post_title'   => $data['title'],
			'post_name'    => $data['slug'],
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_parent'  => $parent,
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( "  ! {$data['slug']}: " . $id->get_error_message() );
		return 0;
	}

	pll_set_post_language( $id, $lang );
	WP_CLI::log( "  + {$lang}/{$data['slug']} (#{$id})" );

	return (int) $id;
}

/**
 * Tạo cặp VI/EN rồi nối bản dịch.
 *
 * @return array{vi:int,en:int}
 */
function tp_create_pair( array $node, int $parent_vi = 0, int $parent_en = 0 ): array {
	$vi = tp_upsert_page( $node['vi'], 'vi', $parent_vi );
	$en = tp_upsert_page( $node['en'], 'en', $parent_en );

	if ( $vi > 0 && $en > 0 ) {
		pll_save_post_translations( array( 'vi' => $vi, 'en' => $en ) );
	}

	return array( 'vi' => $vi, 'en' => $en );
}

$front_vi = 0;
$front_en = 0;

foreach ( $tree as $node ) {
	WP_CLI::log( $node['vi']['title'] );
	$ids = tp_create_pair( $node );

	if ( ! empty( $node['front'] ) ) {
		$front_vi = $ids['vi'];
		$front_en = $ids['en'];
	}

	foreach ( $node['children'] ?? array() as $child ) {
		tp_create_pair( $child, $ids['vi'], $ids['en'] );
	}
}

// Đặt trang chủ tĩnh.
if ( $front_vi > 0 ) {
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_vi );
	WP_CLI::success( "Trang chủ: #{$front_vi}" );
}

flush_rewrite_rules();
WP_CLI::success( 'Đã tạo cây trang song ngữ.' );
