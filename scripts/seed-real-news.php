<?php
/**
 * Thay 6 bài tin mẫu bằng 8 bài dựa trên dự án THẬT.
 *
 * LƯU Ý: sự kiện (khởi công, hoàn thành, giá trị hợp đồng) là số liệu
 * thật từ hồ sơ năng lực; câu chữ do soạn lại. Khách nên đọc duyệt
 * trước khi lên production.
 *
 * Chạy: php scripts/run.php scripts/seed-real-news.php
 */

/** Bọc các đoạn thành HTML. */
function tpn_paras( array $paras ): string {
	return implode( "\n\n", array_map( static fn( $p ) => '<p>' . $p . '</p>', $paras ) );
}

$news = array(
	array(
		'slug'  => 'hoan-thanh-nang-cap-duong-991',
		'cat'   => 'tin-du-an',
		'image' => 'tp-d991-04.webp',
		'date'  => '2024-07-02 09:00:00',
		'vi'    => array(
			'title'   => 'Hoàn thành thi công các cầu trên tuyến đường 991',
			'excerpt' => 'Tín Phát bàn giao gói thầu xây lắp các cầu trên tuyến Mỹ Xuân – Ngãi Giao – Hòa Bình – Bình Châu, công trình giao thông cấp II với giá trị hợp đồng 13,8 tỷ đồng.',
			'body'    => array(
				'Ngày 2/7/2024, CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT đã hoàn thành và bàn giao gói thầu xây lắp các cầu trên tuyến đường Mỹ Xuân – Ngãi Giao – Hòa Bình – Bình Châu (Đường 991), huyện Xuyên Mộc.',
				'Đây là công trình giao thông cấp II do Ban QLDA Chuyên ngành Giao thông tỉnh Bà Rịa – Vũng Tàu làm chủ đầu tư, giá trị hợp đồng 13.818.888.000 đồng. Hợp đồng được ký ngày 29/12/2023 và hoàn thành đúng tiến độ cam kết.',
				'Trong suốt quá trình thi công, đội ngũ kỹ sư và công nhân Tín Phát đã triển khai đồng bộ các hạng mục nền đường, hệ thống thoát nước và thảm bê tông nhựa, đảm bảo an toàn giao thông cho người dân trong khu vực.',
			),
		),
		'en'    => array(
			'title'   => 'Completion of bridges on Road 991',
			'excerpt' => 'Tin Phat handed over the bridge construction package on the My Xuan – Ngai Giao – Hoa Binh – Binh Chau route, a Grade II transport project worth VND 13.8 billion.',
			'body'    => array(
				'On 2 July 2024, TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED completed and handed over the bridge construction package on the My Xuan – Ngai Giao – Hoa Binh – Binh Chau route (Road 991), Xuyen Moc District.',
				'This Grade II transport project was commissioned by the Ba Ria – Vung Tau Province Transportation Project Management Board, with a contract value of VND 13,818,888,000. The contract was signed on 29 December 2023 and completed on schedule.',
				'Throughout construction, Tin Phat engineers and workers carried out roadbed works, drainage systems and asphalt paving in parallel, maintaining traffic safety for local residents.',
			),
		),
	),
	array(
		'slug'  => 'ban-giao-he-thong-phao-bao-hieu-con-dao',
		'cat'   => 'tin-du-an',
		'image' => 'tp-condao-05.webp',
		'date'  => '2024-12-17 09:00:00',
		'vi'    => array(
			'title'   => 'Bàn giao hệ thống phao báo hiệu đường thuỷ nội địa Côn Đảo',
			'excerpt' => 'Gói thầu quản lý, bảo trì hàng năm hệ thống phao báo hiệu tại huyện Côn Đảo hoàn thành sau hơn 3 năm triển khai, giá trị hợp đồng 37,5 tỷ đồng.',
			'body'    => array(
				'Ngày 17/12/2024, Tín Phát hoàn thành gói thầu quản lý, bảo trì hàng năm đối với hệ thống phao báo hiệu đường thuỷ nội địa trên địa bàn huyện Côn Đảo, tỉnh Bà Rịa – Vũng Tàu.',
				'Công trình hàng hải cấp III này do Phòng Kinh tế huyện Côn Đảo làm chủ đầu tư, giá trị hợp đồng 37.533.052.531 đồng — gói thầu lớn nhất của Tín Phát tính đến nay. Hợp đồng ký ngày 15/9/2021.',
				'Thi công trên biển đòi hỏi đội ngũ phải làm chủ cả nghiệp vụ hàng hải lẫn kỹ thuật kết cấu thép. Các hạng mục sơn chống ăn mòn, thay xích neo và hiệu chỉnh đèn báo hiệu được thực hiện định kỳ, bảo đảm an toàn luồng tàu quanh đảo.',
			),
		),
		'en'    => array(
			'title'   => 'Handover of the Con Dao inland waterway buoy system',
			'excerpt' => 'The annual management and maintenance package for the Con Dao buoy system was completed after more than three years, with a contract value of VND 37.5 billion.',
			'body'    => array(
				'On 17 December 2024, Tin Phat completed the annual management and maintenance package for the inland waterway buoy system in Con Dao District, Ba Ria – Vung Tau Province.',
				'This Grade III maritime project was commissioned by the Con Dao District Economic Department, with a contract value of VND 37,533,052,531 — the largest package Tin Phat has delivered to date. The contract was signed on 15 September 2021.',
				'Offshore work requires the team to master both maritime operations and steel structure engineering. Anti-corrosion painting, mooring chain replacement and beacon calibration were carried out on a regular cycle to keep the shipping channel around the island safe.',
			),
		),
	),
	array(
		'slug'  => 'hoan-thanh-nang-cap-duong-a5-b1-cang-ptsc',
		'cat'   => 'tin-du-an',
		'image' => 'tp-a5b1-03.webp',
		'date'  => '2025-01-15 09:00:00',
		'vi'    => array(
			'title'   => 'Hoàn thành nâng cấp tuyến đường A5 & B1 tại cảng PTSC',
			'excerpt' => 'Tuyến đường dài 560,92m trong cảng PTSC được nâng cấp hoàn chỉnh, giá trị hợp đồng 10,78 tỷ đồng.',
			'body'    => array(
				'Ngày 15/1/2025, Tín Phát bàn giao gói thầu xây lắp nâng cấp tuyến đường A5 & B1 tại Cảng PTSC, số 65A đường 30/4, phường Rạch Dừa, TP. Hồ Chí Minh.',
				'Công trình giao thông cấp IV với chiều dài tuyến thiết kế 560,92m, do Chi nhánh Tổng Công ty CP Dịch vụ Kỹ thuật Dầu khí Việt Nam — Công ty Cảng Dịch vụ Dầu khí làm chủ đầu tư. Giá trị hợp đồng 10.780.159.351 đồng.',
				'Thi công trong khu vực cảng đang vận hành đòi hỏi tổ chức mặt bằng chặt chẽ để không gián đoạn hoạt động xuất nhập hàng. Tín Phát bố trí thi công theo phân đoạn, kết hợp làm đêm ở những hạng mục cần phong toả mặt đường.',
			),
		),
		'en'    => array(
			'title'   => 'Completion of Roads A5 & B1 upgrade at PTSC Port',
			'excerpt' => 'A 560.92m road section inside PTSC Port was fully upgraded, with a contract value of VND 10.78 billion.',
			'body'    => array(
				'On 15 January 2025, Tin Phat handed over the construction package upgrading Roads A5 & B1 at PTSC Port, No. 65A 30/4 Street, Rach Dua Ward, Ho Chi Minh City.',
				'This Grade IV transport project had a designed route length of 560.92m and was commissioned by the Branch of PetroVietnam Technical Services Corporation — Petroleum Services Port Company. The contract value was VND 10,780,159,351.',
				'Working inside an operating port required tight site organisation so cargo handling was never interrupted. Tin Phat built in sections and ran night shifts for items that required closing the carriageway.',
			),
		),
	),
	array(
		'slug'  => 'hoan-thanh-ha-tang-thoat-nuoc-duong-a4-a5',
		'cat'   => 'tin-du-an',
		'image' => 'tp-a4a5-02.webp',
		'date'  => '2025-12-29 09:00:00',
		'vi'    => array(
			'title'   => 'Hoàn thành nâng cấp hệ thống thoát nước đường A4 & A5',
			'excerpt' => 'Công trình hạ tầng kỹ thuật cấp IV với chiều dài tuyến 586,3m tại cảng PTSC, giá trị hợp đồng 4,25 tỷ đồng.',
			'body'    => array(
				'Tín Phát hoàn thành gói thầu xây lắp nâng cấp hệ thống thoát nước tuyến đường A4 & A5 tại Cảng PTSC, phường Rạch Dừa, TP. Hồ Chí Minh.',
				'Công trình hạ tầng kỹ thuật cấp IV, chiều dài tuyến thiết kế 586,3m, chủ đầu tư là Chi nhánh Tổng Công ty CP Dịch vụ Kỹ thuật Dầu khí Việt Nam — Công ty Cảng Dịch vụ Dầu khí. Giá trị hợp đồng 4.253.074.861 đồng.',
				'Hạng mục chính gồm đào đặt cống bê tông ly tâm, xây hố ga và hoàn trả mặt đường. Việc thi công được triển khai trong mùa mưa nên đội ngũ phải bố trí bơm thoát nước liên tục để giữ tiến độ.',
			),
		),
		'en'    => array(
			'title'   => 'Completion of the A4 & A5 drainage upgrade',
			'excerpt' => 'A Grade IV technical infrastructure project covering 586.3m at PTSC Port, with a contract value of VND 4.25 billion.',
			'body'    => array(
				'Tin Phat completed the construction package upgrading the drainage system along Roads A4 & A5 at PTSC Port, Rach Dua Ward, Ho Chi Minh City.',
				'This Grade IV technical infrastructure project had a designed route length of 586.3m and was commissioned by the Branch of PetroVietnam Technical Services Corporation — Petroleum Services Port Company. The contract value was VND 4,253,074,861.',
				'The main items covered excavation and laying of spun concrete culverts, manhole construction and carriageway reinstatement. As work fell in the rainy season, the team ran continuous dewatering pumps to hold the schedule.',
			),
		),
	),
	array(
		'slug'  => 'khoi-cong-khu-dich-vu-dau-khi-35ha',
		'cat'   => 'tin-du-an',
		'image' => 'tp-sanbai-02.webp',
		'date'  => '2026-06-22 09:00:00',
		'vi'    => array(
			'title'   => 'Khởi công xây dựng Khu Dịch vụ Dầu khí 35ha',
			'excerpt' => 'Tín Phát triển khai gói thầu công trình giao thông cấp IV, chiều dài tuyến 851m tại Căn cứ Sao Mai – Bến Đình.',
			'body'    => array(
				'Ngày 22/6/2026, Tín Phát chính thức khởi công gói thầu xây dựng Khu Dịch vụ Dầu khí 35ha tại Căn cứ Dịch vụ Hàng hải Dầu khí Sao Mai – Bến Đình, phường Rạch Dừa, TP. Hồ Chí Minh.',
				'Công trình giao thông cấp IV với chiều dài tuyến thiết kế 851m, chủ đầu tư là Công ty Cổ phần Cảng kỹ thuật PTSC Sao Mai. Giá trị hợp đồng 4.930.000.000 đồng, dự kiến hoàn thành ngày 31/7/2026.',
				'Đây là dự án tiếp nối chuỗi công trình Tín Phát thực hiện cho các đơn vị thuộc ngành dầu khí, khẳng định năng lực thi công hạ tầng trong khu vực cảng biển chuyên dụng.',
			),
		),
		'en'    => array(
			'title'   => 'Groundbreaking of the 35-hectare Oil & Gas Service Zone',
			'excerpt' => 'Tin Phat began a Grade IV transport package with a designed route length of 851m at the Sao Mai – Ben Dinh base.',
			'body'    => array(
				'On 22 June 2026, Tin Phat officially began construction of the 35-hectare Oil & Gas Service Zone at the Sao Mai – Ben Dinh Oil & Gas Marine Service Base, Rach Dua Ward, Ho Chi Minh City.',
				'This Grade IV transport project has a designed route length of 851m and is commissioned by PTSC Sao Mai Technical Port Joint Stock Company. The contract value is VND 4,930,000,000, with completion expected on 31 July 2026.',
				'The project continues a series of works Tin Phat has delivered for oil and gas operators, confirming our capability in infrastructure construction inside specialised seaport areas.',
			),
		),
	),
	array(
		'slug'  => 'hoan-thanh-nha-xuong-kho-hang-kin-ptsc',
		'cat'   => 'tin-du-an',
		'image' => 'tp-nhaxuong-02.webp',
		'date'  => '2025-06-20 09:00:00',
		'vi'    => array(
			'title'   => 'Hoàn thành nhà xưởng kho hàng kín 2.940m² tại cảng PTSC',
			'excerpt' => 'Công trình kho hàng kín kích thước 30x98m thuộc dự án căn cứ Phú Quốc POC, giá trị hợp đồng 12,4 tỷ đồng.',
			'body'    => array(
				'Tín Phát hoàn thành gói thầu xây dựng kho hàng kín thuộc dự án xây dựng căn cứ cho Phú Quốc POC tại Cảng PTSC, phường Rạch Dừa, TP. Hồ Chí Minh.',
				'Nhà xưởng có kích thước 30x98m, tổng diện tích 2.940m². Chủ đầu tư là Chi nhánh Tổng Công ty CP Dịch vụ Kỹ thuật Dầu khí Việt Nam — Công ty Cảng Dịch vụ Dầu khí, giá trị hợp đồng 12.395.985.599 đồng.',
				'Công trình sử dụng kết cấu khung thép tiền chế, thi công song song phần móng và lắp dựng khung để rút ngắn thời gian. Toàn bộ hạng mục đạt yêu cầu nghiệm thu ngay từ lần kiểm tra đầu tiên.',
			),
		),
		'en'    => array(
			'title'   => 'Completion of a 2,940m² closed warehouse at PTSC Port',
			'excerpt' => 'A 30x98m closed warehouse under the Phu Quoc POC base project, with a contract value of VND 12.4 billion.',
			'body'    => array(
				'Tin Phat completed the closed warehouse package under the Phu Quoc POC base project at PTSC Port, Rach Dua Ward, Ho Chi Minh City.',
				'The warehouse measures 30x98m with a total area of 2,940m². The investor is the Branch of PetroVietnam Technical Services Corporation — Petroleum Services Port Company, with a contract value of VND 12,395,985,599.',
				'The building uses a pre-engineered steel frame, with foundation works and frame erection running in parallel to shorten the programme. All items passed acceptance inspection at the first review.',
			),
		),
	),
	array(
		'slug'  => 'bao-duong-phao-thuy-noi-dia-dong-nai',
		'cat'   => 'tin-du-an',
		'image' => 'tp-dongnai-04.webp',
		'date'  => '2023-12-31 09:00:00',
		'vi'    => array(
			'title'   => 'Hoàn thành bảo dưỡng đài phao thuỷ nội địa tỉnh Đồng Nai',
			'excerpt' => 'Gói thầu quản lý, bảo dưỡng thường xuyên đài phao thuỷ nội địa năm 2023 do Sở Giao thông Vận tải tỉnh Đồng Nai làm chủ đầu tư.',
			'body'    => array(
				'Ngày 31/12/2023, Tín Phát hoàn thành gói thầu quản lý, bảo dưỡng thường xuyên đài phao thuỷ nội địa năm 2023 trên địa bàn tỉnh Đồng Nai.',
				'Công trình giao thông cấp IV do Sở Giao thông Vận tải tỉnh Đồng Nai làm chủ đầu tư, giá trị hợp đồng 3.735.434.000 đồng. Đây là năm thứ hai liên tiếp Tín Phát được tin tưởng giao gói thầu này.',
				'Công việc bao gồm kiểm tra định kỳ, sơn lại thân phao, thay thế đèn báo hiệu và hiệu chỉnh vị trí neo. Đội thi công làm việc trên sông trong mọi điều kiện thời tiết để bảo đảm an toàn luồng tuyến.',
			),
		),
		'en'    => array(
			'title'   => 'Completion of inland waterway buoy maintenance in Dong Nai',
			'excerpt' => 'The 2023 regular management and maintenance package for inland waterway buoys, commissioned by the Dong Nai Department of Transport.',
			'body'    => array(
				'On 31 December 2023, Tin Phat completed the 2023 package for regular management and maintenance of inland waterway buoys across Dong Nai Province.',
				'This Grade IV transport project was commissioned by the Dong Nai Provincial Department of Transport, with a contract value of VND 3,735,434,000. It was the second consecutive year Tin Phat was entrusted with this package.',
				'The scope covered periodic inspection, repainting of buoy bodies, replacement of navigation lights and re-positioning of moorings. Crews worked on the river in all weather to keep the channel safe.',
			),
		),
	),
	array(
		'slug'  => 'tin-phat-mo-rong-nang-luc-thiet-bi',
		'cat'   => 'tin-cong-ty',
		'image' => 'tp-a5b1-06.webp',
		'date'  => '2026-01-10 09:00:00',
		'vi'    => array(
			'title'   => 'Tín Phát đầu tư mở rộng năng lực thiết bị thi công',
			'excerpt' => 'Công ty hiện sở hữu 30 loại máy móc thiết bị, từ máy lu, cẩu tháp đến sà lan và tàu kéo phục vụ thi công đường thuỷ.',
			'body'    => array(
				'Nhằm mang đến cho khách hàng những sản phẩm và dịch vụ chất lượng cao nhất, trong thời gian qua Tín Phát đã không ngừng đầu tư vào hệ thống máy móc, thiết bị mới, hiện đại và có công suất lớn từ các thương hiệu uy tín.',
				'Đến nay công ty sở hữu 30 loại thiết bị, bao gồm máy lu, máy xúc, xe trộn bê tông, cẩu tháp, cẩu bánh xích, hệ giàn giáo nêm và cốp pha thép. Đặc biệt, đội sà lan và tàu kéo cho phép Tín Phát chủ động thi công các công trình hàng hải, đường thuỷ.',
				'Hệ thống trang thiết bị này không chỉ nâng cao năng suất và hiệu quả thi công mà còn đảm bảo an toàn cho người vận hành, với quy trình sử dụng được kiểm soát nghiêm ngặt theo tiêu chuẩn an toàn lao động.',
			),
		),
		'en'    => array(
			'title'   => 'Tin Phat expands its construction equipment capacity',
			'excerpt' => 'The company now owns 30 types of plant and equipment, from rollers and tower cranes to barges and tugboats for waterway construction.',
			'body'    => array(
				'To provide customers with the highest quality products and services, Tin Phat has continuously invested in new, modern, high-capacity equipment from renowned brands.',
				'The company now owns 30 types of equipment, including rollers, excavators, concrete mixer trucks, tower cranes, crawler cranes, wedge scaffolding systems and steel formwork. Our barges and tugboats in particular allow Tin Phat to take on maritime and waterway projects independently.',
				'This machinery not only enhances productivity and performance but also ensures operator safety, with usage procedures strictly controlled to occupational safety standards.',
			),
		),
	),
);

/** Tạo (hoặc lấy lại) attachment từ file trong uploads/tinphat. */
function tpn_attachment_id( string $filename ): int {
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

/** Lấy term chuyên mục theo slug gốc + ngôn ngữ. */
function tpn_category( string $base, string $lang ): int {
	$term = get_term_by( 'slug', $base . '-' . $lang, 'category' );

	return $term instanceof WP_Term ? (int) $term->term_id : 0;
}

/** Tạo hoặc cập nhật một bài. */
function tpn_upsert( string $slug, string $lang, array $data, int $thumb, int $cat, string $date ): int {
	$found = get_posts(
		array(
			'post_type'      => 'post',
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
		'post_type'    => 'post',
		'post_status'  => 'publish',
		'post_title'   => $data['title'],
		'post_name'    => $slug,
		'post_excerpt' => $data['excerpt'],
		'post_content' => tpn_paras( $data['body'] ),
		'post_date'    => $date,
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

	// Đặt ngôn ngữ TRƯỚC khi gán chuyên mục: Polylang lọc term theo
	// ngôn ngữ của bài, gán sớm sẽ rơi vào Uncategorized.
	if ( function_exists( 'pll_set_post_language' ) ) {
		pll_set_post_language( $post_id, $lang );
	}

	if ( $cat > 0 ) {
		// false = thay thế toàn bộ, bỏ Uncategorized WordPress tự gán.
		wp_set_post_terms( $post_id, array( $cat ), 'category', false );
	}

	if ( $thumb > 0 ) {
		set_post_thumbnail( $post_id, $thumb );
	}

	return $post_id;
}

// Xoá bài mẫu cũ.
$keep = array();

foreach ( $news as $n ) {
	$keep[] = $n['slug'];
	$keep[] = $n['slug'] . '-en';
}

$removed = 0;

foreach ( get_posts( array( 'post_type' => 'post', 'posts_per_page' => -1, 'post_status' => 'any', 'lang' => '' ) ) as $old ) {
	if ( ! in_array( $old->post_name, $keep, true ) ) {
		wp_delete_post( $old->ID, true );
		++$removed;
	}
}

WP_CLI::log( "Đã xoá {$removed} bài mẫu." );

$done = 0;

foreach ( $news as $n ) {
	$thumb = tpn_attachment_id( $n['image'] );

	$vi_id = tpn_upsert( $n['slug'], 'vi', $n['vi'], $thumb, tpn_category( $n['cat'], 'vi' ), $n['date'] );
	$en_id = tpn_upsert( $n['slug'] . '-en', 'en', $n['en'], $thumb, tpn_category( $n['cat'], 'en' ), $n['date'] );

	if ( function_exists( 'pll_save_post_translations' ) && $vi_id && $en_id ) {
		pll_save_post_translations( array( 'vi' => $vi_id, 'en' => $en_id ) );
	}

	WP_CLI::log( sprintf( '  %s (vi #%d / en #%d)', $n['vi']['title'], $vi_id, $en_id ) );
	++$done;
}

WP_CLI::success( "Đã tạo {$done} bài tin từ dự án thật." );
