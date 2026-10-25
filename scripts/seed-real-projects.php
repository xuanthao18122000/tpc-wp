<?php
/**
 * Thay 9 dự án mockup bằng 10 dự án THẬT từ hồ sơ năng lực (PDF).
 *
 * Nguồn: docs/PROFILE TIN PHAT IN.pdf — chủ đầu tư, gói thầu, địa điểm,
 * giá trị hợp đồng đều là số liệu thật.
 *
 * Chạy: php scripts/run.php scripts/seed-real-projects.php
 */

$projects = array(
	array(
		'slug'  => 'sua-chua-nang-cap-duong-a1',
		'gallery' => array( 'tp-a5b1-05.webp', 'tp-a5b1-06.webp', 'tp-a5b1-07.webp', 'tp-a5b1-08.webp', 'tp-a5b1-03.webp', 'tp-a5b1-04.webp' ),
		'grade'    => 'Công trình giao thông cấp IV',
		'grade_en' => 'Grade IV transport works',
		'signed'   => '22/4/2026',
		'done'     => '31/8/2026',
		'image' => 'tp-a5b1-05.webp',
		'vi'    => array(
			'title'    => 'Thi công sửa chữa, nâng cấp đường A1',
			'package'  => 'Xây lắp — chiều dài tuyến thiết kế 724m',
			'location' => 'Cảng PTSC, số 65A đường 30/4, phường Rạch Dừa, TP. Hồ Chí Minh',
			'client'   => 'Chi nhánh Cảng Dầu khí và Dịch vụ Năng lượng Tái tạo — Tổng Công ty CP Dịch vụ Kỹ thuật Dầu khí Việt Nam',
			'value'    => '18.300.789.152 VNĐ',
		),
		'en'    => array(
			'title'    => 'Repair and upgrade of Road A1',
			'package'  => 'Construction works — designed route length 724m',
			'location' => 'PTSC Port, No. 65A 30/4 Street, Rach Dua Ward, Ho Chi Minh City',
			'client'   => 'Oil & Gas Port and Renewable Energy Services Branch — PetroVietnam Technical Services Corporation (PTSC)',
			'value'    => 'VND 18,300,789,152',
		),
	),
	array(
		'slug'  => 'khu-dich-vu-dau-khi-35ha',
		'gallery' => array( 'tp-sanbai-01.webp', 'tp-sanbai-02.webp', 'tp-sanbai-03.webp', 'tp-sanbai-04.webp' ),
		'grade'    => 'Công trình giao thông cấp IV',
		'grade_en' => 'Grade IV transport works',
		'signed'   => '22/6/2026',
		'done'     => '31/7/2026',
		'image' => 'tp-sanbai-02.webp',
		'vi'    => array(
			'title'    => 'Thi công xây dựng Khu Dịch vụ Dầu khí 35ha',
			'package'  => 'Xây lắp — chiều dài tuyến thiết kế 851m',
			'location' => 'Căn cứ Dịch vụ Hàng hải Dầu khí Sao Mai – Bến Đình, phường Rạch Dừa, TP. Hồ Chí Minh',
			'client'   => 'Công ty Cổ phần Cảng kỹ thuật PTSC Sao Mai',
			'value'    => '4.930.000.000 VNĐ',
		),
		'en'    => array(
			'title'    => 'Construction of the 35-hectare Oil & Gas Service Zone',
			'package'  => 'Construction works — designed route length 851m',
			'location' => 'Sao Mai – Ben Dinh Oil & Gas Marine Service Base, Rach Dua Ward, Ho Chi Minh City',
			'client'   => 'PTSC Sao Mai Technical Port Joint Stock Company',
			'value'    => 'VND 4,930,000,000',
		),
	),
	array(
		'slug'  => 'ha-tang-duong-a4-a5',
		'gallery' => array( 'tp-a4a5-01.webp', 'tp-a4a5-02.webp', 'tp-a4a5-03.webp', 'tp-a4a5-04.webp' ),
		'grade'    => 'Công trình hạ tầng kỹ thuật cấp IV',
		'grade_en' => 'Grade IV technical infrastructure',
		'signed'   => '10/9/2025',
		'done'     => '29/12/2025',
		'image' => 'tp-a4a5-02.webp',
		'vi'    => array(
			'title'    => 'Thi công hạ tầng đường giao thông A4 & A5',
			'package'  => 'Xây lắp công trình — nâng cấp hệ thống thoát nước',
			'location' => 'Cảng PTSC, số 65A, phường Rạch Dừa, TP. Hồ Chí Minh',
			'client'   => 'Chi nhánh Tổng Công ty CP Dịch vụ Kỹ thuật Dầu khí Việt Nam — Công ty Cảng Dịch vụ Dầu khí',
			'value'    => '4.253.074.861 VNĐ',
		),
		'en'    => array(
			'title'    => 'Transportation infrastructure for Roads A4 & A5',
			'package'  => 'Construction works — upgrading the drainage system',
			'location' => 'PTSC Port, No. 65A, Rach Dua Ward, Ho Chi Minh City',
			'client'   => 'Branch of PetroVietnam Technical Services Corporation — Petroleum Services Port Company',
			'value'    => 'VND 4,253,074,861',
		),
	),
	array(
		'slug'  => 'nang-cap-tuyen-duong-a3',
		'gallery' => array( 'tp-a5b1-07.webp', 'tp-a5b1-08.webp', 'tp-a5b1-01.webp', 'tp-a5b1-02.webp' ),
		'grade'    => 'Công trình giao thông cấp IV',
		'grade_en' => 'Grade IV transport works',
		'signed'   => '30/12/2025',
		'done'     => '12/3/2026',
		'image' => 'tp-a5b1-07.webp',
		'vi'    => array(
			'title'    => 'Thi công nâng cấp tuyến đường A3',
			'package'  => 'Xây lắp nâng cấp',
			'location' => 'TP. Hồ Chí Minh',
			'client'   => 'Chi nhánh Tổng Công ty CP Dịch vụ Kỹ thuật Dầu khí Việt Nam — Công ty Cảng Dịch vụ Dầu khí',
			'value'    => '14.140.496.761 VNĐ',
		),
		'en'    => array(
			'title'    => 'Construction and upgrade of Road A3',
			'package'  => 'Construction and upgrade works',
			'location' => 'Ho Chi Minh City',
			'client'   => 'Branch of PetroVietnam Technical Services Corporation — Petroleum Port Services Company',
			'value'    => 'VND 14,140,496,761',
		),
	),
	array(
		'slug'  => 'can-cu-phu-quoc-poc',
		'gallery' => array( 'tp-sanbai-03.webp', 'tp-sanbai-04.webp', 'tp-sanbai-01.webp', 'tp-sanbai-02.webp' ),
		'image' => 'tp-sanbai-03.webp',
		'vi'    => array(
			'title'    => 'Xây dựng căn cứ cho Phú Quốc POC',
			'package'  => 'Xây dựng sân bê tông và bãi đá — diện tích 4.906,56m²',
			'location' => 'Cảng PTSC, số 65A, phường Rạch Dừa, TP. Hồ Chí Minh',
			'client'   => 'Chi nhánh Tổng Công ty CP Dịch vụ Kỹ thuật Dầu khí Việt Nam — Công ty Cảng Dịch vụ Dầu khí',
			'value'    => '5.617.678.389 VNĐ',
		),
		'en'    => array(
			'title'    => 'Establishing a base for Phu Quoc POC',
			'package'  => 'Construction of concrete yard and rocky area — area 4,906.56m²',
			'location' => 'PTSC Port, No. 65A, Rach Dua Ward, Ho Chi Minh City',
			'client'   => 'Branch of PetroVietnam Technical Services Corporation — Petroleum Services Port Company',
			'value'    => 'VND 5,617,678,389',
		),
	),
	array(
		'slug'  => 'duong-991-my-xuan-binh-chau',
		'gallery' => array( 'tp-d991-01.webp', 'tp-d991-02.webp', 'tp-d991-03.webp', 'tp-d991-04.webp', 'tp-d991-05.webp', 'tp-d991-06.webp', 'tp-d991-07.webp', 'tp-d991-08.webp' ),
		'grade'    => 'Công trình giao thông cấp II',
		'grade_en' => 'Grade II transport works',
		'signed'   => '29/12/2023',
		'done'     => '2/7/2024',
		'image' => 'tp-d991-04.webp',
		'vi'    => array(
			'title'    => 'Thi công đường giao thông — Đường 991',
			'package'  => 'Xây lắp các cầu trên tuyến Mỹ Xuân – Ngãi Giao – Hòa Bình – Bình Châu',
			'location' => 'Huyện Xuyên Mộc, tỉnh Bà Rịa – Vũng Tàu (cũ)',
			'client'   => 'Ban QLDA Chuyên ngành Giao thông tỉnh Bà Rịa – Vũng Tàu',
			'value'    => '13.818.888.000 VNĐ',
		),
		'en'    => array(
			'title'    => 'Road construction — Road 991',
			'package'  => 'Construction of bridges on the My Xuan – Ngai Giao – Hoa Binh – Binh Chau route',
			'location' => 'Xuyen Moc District, Ba Ria – Vung Tau Province (formerly)',
			'client'   => 'Ba Ria – Vung Tau Province Transportation Project Management Board',
			'value'    => 'VND 13,818,888,000',
		),
	),
	array(
		'slug'  => 'nha-xuong-kho-hang-kin',
		'gallery' => array( 'tp-nhaxuong-01.webp', 'tp-nhaxuong-02.webp', 'tp-nhaxuong-03.webp', 'tp-nhaxuong-04.webp' ),
		'image' => 'tp-nhaxuong-02.webp',
		'vi'    => array(
			'title'    => 'Thi công nhà xưởng — Kho hàng kín',
			'package'  => 'Xây dựng kho hàng kín — kích thước 30x98m, diện tích 2.940m²',
			'location' => 'Cảng PTSC, số 65A, phường Rạch Dừa, TP. Hồ Chí Minh',
			'client'   => 'Chi nhánh Tổng Công ty CP Dịch vụ Kỹ thuật Dầu khí Việt Nam — Công ty Cảng Dịch vụ Dầu khí',
			'value'    => '12.395.985.599 VNĐ',
		),
		'en'    => array(
			'title'    => 'Factory construction — Closed warehouse',
			'package'  => 'Construction of a closed warehouse — 30x98m, area 2,940m²',
			'location' => 'PTSC Port, No. 65A, Rach Dua Ward, Ho Chi Minh City',
			'client'   => 'Branch of PetroVietnam Technical Services Corporation — Petroleum Services Port Company',
			'value'    => 'VND 12,395,985,599',
		),
	),
	array(
		'slug'  => 'nang-cap-duong-a5-b1',
		'gallery' => array( 'tp-a5b1-01.webp', 'tp-a5b1-02.webp', 'tp-a5b1-03.webp', 'tp-a5b1-04.webp', 'tp-a5b1-05.webp', 'tp-a5b1-06.webp' ),
		'grade'    => 'Công trình giao thông cấp IV',
		'grade_en' => 'Grade IV transport works',
		'signed'   => '31/10/2024',
		'done'     => '15/1/2025',
		'image' => 'tp-a5b1-03.webp',
		'vi'    => array(
			'title'    => 'Thi công đường giao thông A5 & B1',
			'package'  => 'Xây lắp công trình — nâng cấp đường A5 & B1',
			'location' => 'Cảng PTSC, số 65A, phường Rạch Dừa, TP. Hồ Chí Minh',
			'client'   => 'Chi nhánh Tổng Công ty CP Dịch vụ Kỹ thuật Dầu khí Việt Nam — Công ty Cảng Dịch vụ Dầu khí',
			'value'    => '10.780.159.351 VNĐ',
		),
		'en'    => array(
			'title'    => 'Road construction — Roads A5 & B1',
			'package'  => 'Construction works — upgrading Roads A5 & B1',
			'location' => 'PTSC Port, No. 65A, Rach Dua Ward, Ho Chi Minh City',
			'client'   => 'Branch of PetroVietnam Technical Services Corporation — Petroleum Services Port Company',
			'value'    => 'VND 10,780,159,351',
		),
	),
	array(
		'slug'  => 'phao-bao-hieu-con-dao',
		'gallery' => array( 'tp-condao-05.webp', 'tp-condao-04.webp', 'tp-condao-06.webp', 'tp-condao-03.webp', 'tp-condao-01.webp' ),
		'grade'    => 'Công trình hàng hải cấp III',
		'grade_en' => 'Grade III maritime works',
		'signed'   => '15/9/2021',
		'done'     => '17/12/2024',
		'image' => 'tp-condao-05.webp',
		'vi'    => array(
			'title'    => 'Thi công hệ thống phao báo hiệu Côn Đảo',
			'package'  => 'Xây lắp — quản lý, bảo trì hàng năm hệ thống phao báo hiệu đường thủy nội địa',
			'location' => 'Huyện Côn Đảo, tỉnh Bà Rịa – Vũng Tàu (cũ)',
			'client'   => 'Phòng Kinh tế huyện Côn Đảo',
			'value'    => '37.533.052.531 VNĐ',
		),
		'en'    => array(
			'title'    => 'Construction of the Con Dao buoy system',
			'package'  => 'Construction — annual management and maintenance of the inland waterway buoy system',
			'location' => 'Con Dao District, Ba Ria – Vung Tau Province (formerly)',
			'client'   => 'Con Dao District Economic Department',
			'value'    => 'VND 37,533,052,531',
		),
	),
	array(
		'slug'  => 'phao-bao-hieu-dong-nai',
		'gallery' => array( 'tp-dongnai-04.webp', 'tp-dongnai-01.webp', 'tp-dongnai-02.webp', 'tp-dongnai-03.webp' ),
		'grade'    => 'Công trình giao thông cấp IV',
		'grade_en' => 'Grade IV transport works',
		'signed'   => '28/2/2023',
		'done'     => '31/12/2023',
		'image' => 'tp-dongnai-04.webp',
		'vi'    => array(
			'title'    => 'Thi công hệ thống phao báo hiệu Đồng Nai',
			'package'  => 'Xây dựng — quản lý, bảo dưỡng thường xuyên đường thủy nội địa năm 2023',
			'location' => 'Tỉnh Đồng Nai',
			'client'   => 'Sở Giao thông Vận tải tỉnh Đồng Nai',
			'value'    => '3.735.434.000 VNĐ',
		),
		'en'    => array(
			'title'    => 'Construction of the Dong Nai buoy system',
			'package'  => 'Construction — management and regular maintenance of inland waterways, 2023',
			'location' => 'Dong Nai Province',
			'client'   => 'Dong Nai Provincial Department of Transport',
			'value'    => 'VND 3,735,434,000',
		),
	),
	array(
		'slug'  => 'phao-don-luong-con-dao',
		'gallery' => array( 'tp-condao-05.webp', 'tp-condao-06.webp', 'tp-condao-03.webp', 'tp-condao-04.webp' ),
		'grade'    => 'Công trình giao thông cấp III',
		'grade_en' => 'Grade III transport works',
		'signed'   => '3/9/2025',
		'done'     => '10/1/2026',
		'image' => 'tp-condao-05.webp',
		'vi'    => array(
			'title'    => 'Sửa chữa, bảo dưỡng hệ thống phao đón luồng và phao neo',
			'package'  => 'Sửa chữa, bảo dưỡng hệ thống phao đón luồng và phao neo tại khu neo đậu tránh trú bão',
			'location' => 'Đặc khu Côn Đảo',
			'client'   => 'Ban Quản lý Cảng Bến Đầm, Đặc khu Côn Đảo',
			'value'    => '1.836.425.166 VNĐ',
		),
		'en'    => array(
			'title'    => 'Repair and maintenance of channel and mooring buoys',
			'package'  => 'Repair and maintenance of channel entry buoys and mooring buoys at the storm shelter anchorage',
			'location' => 'Con Dao Special Zone',
			'client'   => 'Ben Dam Port Management Board, Con Dao Special Zone',
			'value'    => 'VND 1,836,425,166',
		),
	),
	array(
		'slug'  => 'phao-bao-hieu-song-vam-co-dong',
		'gallery' => array( 'tp-dongnai-03.webp', 'tp-dongnai-04.webp', 'tp-dongnai-01.webp', 'tp-dongnai-02.webp' ),
		'grade'    => 'Công trình giao thông cấp III',
		'grade_en' => 'Grade III transport works',
		'signed'   => '15/9/2020',
		'done'     => '30/12/2021',
		'image' => 'tp-dongnai-03.webp',
		'vi'    => array(
			'title'    => 'Phao báo hiệu đường thuỷ nội địa sông Vàm Cỏ Đông',
			'package'  => 'Thi công xây dựng công trình phao báo hiệu và biển báo hiệu đường thuỷ nội địa sông Vàm Cỏ Đông, đoạn từ Cảng Bến Kéo đến Vàm Trảng Trâu',
			'location' => 'Tỉnh Tây Ninh (cũ)',
			'client'   => 'Sở Giao thông Vận tải Tây Ninh',
			'value'    => '5.308.326.000 VNĐ',
		),
		'en'    => array(
			'title'    => 'Inland waterway buoys on the Vam Co Dong River',
			'package'  => 'Construction of navigation buoys and signs on the Vam Co Dong inland waterway, from Ben Keo Port to Vam Trang Trau',
			'location' => 'Tay Ninh Province (formerly)',
			'client'   => 'Tay Ninh Department of Transport',
			'value'    => 'VND 5,308,326,000',
		),
	),
);

/** Tạo (hoặc lấy lại) attachment từ file trong uploads/tinphat. */
function tpr_attachment_id( string $filename ): int {
	$uploads = wp_get_upload_dir();
	$path    = $uploads['basedir'] . '/tinphat/' . $filename;

	if ( ! file_exists( $path ) ) {
		WP_CLI::warning( "  thiếu file: {$filename}" );
		return 0;
	}

	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_tinphat_source',
			'meta_value'     => $filename,
		)
	);

	if ( ! empty( $existing ) ) {
		return (int) $existing[0];
	}

	$filetype      = wp_check_filetype( $filename, null );
	$attachment_id = wp_insert_attachment(
		array(
			'guid'           => $uploads['baseurl'] . '/tinphat/' . $filename,
			'post_mime_type' => $filetype['type'],
			'post_title'     => sanitize_file_name( pathinfo( $filename, PATHINFO_FILENAME ) ),
			'post_status'    => 'inherit',
		),
		$path
	);

	if ( is_wp_error( $attachment_id ) || 0 === $attachment_id ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $path ) );
	update_post_meta( $attachment_id, '_tinphat_source', $filename );

	return (int) $attachment_id;
}

/**
 * Tạo hoặc cập nhật một dự án theo slug + ngôn ngữ.
 *
 * @param string               $slug  Slug (hậu tố -en cho bản tiếng Anh).
 * @param string               $lang  Mã ngôn ngữ.
 * @param array<string,string> $data  Nội dung.
 * @param int                  $thumb   ID ảnh đại diện.
 * @param array<int,int>       $gallery ID các ảnh công trường.
 * @return int ID bài.
 */
function tpr_upsert( string $slug, string $lang, array $data, int $thumb, array $gallery = array() ): int {
	$found = get_posts(
		array(
			'post_type'      => 'du-an',
			'name'           => $slug,
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'fields'         => 'ids',
		)
	);

	$post_id = 0;

	foreach ( $found as $id ) {
		if ( ! function_exists( 'pll_get_post_language' ) || pll_get_post_language( $id ) === $lang ) {
			$post_id = (int) $id;
			break;
		}
	}

	$args = array(
		'post_type'    => 'du-an',
		'post_status'  => 'publish',
		'post_title'   => $data['title'],
		'post_name'    => $slug,
		'post_content' => '',
	);

	if ( $post_id > 0 ) {
		$args['ID'] = $post_id;
		wp_update_post( $args );
	} else {
		$post_id = (int) wp_insert_post( $args );
	}

	if ( $post_id <= 0 ) {
		return 0;
	}

	if ( function_exists( 'pll_set_post_language' ) ) {
		pll_set_post_language( $post_id, $lang );
	}

	update_post_meta( $post_id, 'client', $data['client'] );
	update_post_meta( $post_id, 'location', $data['location'] );
	update_post_meta( $post_id, 'scope', $data['package'] );
	update_post_meta( $post_id, 'contract_value', $data['value'] );
	update_post_meta( $post_id, 'grade', $data['grade'] ?? '' );
	update_post_meta( $post_id, 'signed_date', $data['signed'] ?? '' );
	update_post_meta( $post_id, 'completion_date', $data['done'] ?? '' );

	// Thư viện ảnh công trường (mảng ID attachment).
	if ( ! empty( $gallery ) ) {
		update_post_meta( $post_id, 'gallery', $gallery );
	}

	if ( $thumb > 0 ) {
		set_post_thumbnail( $post_id, $thumb );
	}

	return $post_id;
}

// Xoá dự án mockup cũ (chỉ những bài không nằm trong danh sách thật).
$keep = array();

foreach ( $projects as $p ) {
	$keep[] = $p['slug'];
	$keep[] = $p['slug'] . '-en';
}

$removed = 0;

foreach ( get_posts( array( 'post_type' => 'du-an', 'posts_per_page' => -1, 'post_status' => 'any', 'lang' => '' ) ) as $old ) {
	if ( ! in_array( $old->post_name, $keep, true ) ) {
		wp_delete_post( $old->ID, true );
		++$removed;
	}
}

WP_CLI::log( "Đã xoá {$removed} dự án mockup." );

$done = 0;

foreach ( $projects as $p ) {
	$thumb = tpr_attachment_id( $p['image'] );

	// Ảnh thư viện dùng chung cho cả hai ngôn ngữ.
	$gallery = array();

	foreach ( $p['gallery'] ?? array() as $file ) {
		$id = tpr_attachment_id( $file );

		if ( $id > 0 ) {
			$gallery[] = $id;
		}
	}

	// Cấp công trình và mốc thời gian dùng chung, nhãn theo ngôn ngữ.
	$vi_data = $p['vi'] + array(
		'grade'  => $p['grade'] ?? '',
		'signed' => $p['signed'] ?? '',
		'done'   => $p['done'] ?? '',
	);
	$en_data = $p['en'] + array(
		'grade'  => $p['grade_en'] ?? '',
		'signed' => $p['signed'] ?? '',
		'done'   => $p['done'] ?? '',
	);

	$vi_id = tpr_upsert( $p['slug'], 'vi', $vi_data, $thumb, $gallery );
	$en_id = tpr_upsert( $p['slug'] . '-en', 'en', $en_data, $thumb, $gallery );

	// Nối bản dịch để bộ chuyển ngôn ngữ hoạt động.
	if ( function_exists( 'pll_save_post_translations' ) && $vi_id && $en_id ) {
		pll_save_post_translations( array( 'vi' => $vi_id, 'en' => $en_id ) );
	}

	WP_CLI::log( sprintf( '  %s (vi #%d / en #%d)', $p['vi']['title'], $vi_id, $en_id ) );
	++$done;
}

WP_CLI::success( "Đã tạo {$done} dự án thật từ hồ sơ năng lực." );
