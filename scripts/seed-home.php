<?php
/**
 * Dựng nội dung trang chủ song ngữ bằng shortcode.
 *
 * Chạy: wp eval-file /scripts/seed-home.php
 */

$banner_base = content_url( 'uploads/tinphat' );

/**
 * URL trang theo slug + ngôn ngữ; rỗng nếu chưa có trang.
 */
function tp_page_url( string $slug, string $lang ): string {
	foreach ( get_posts(
		array(
			'post_type'      => 'page',
			'name'           => $slug,
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'fields'         => 'ids',
		)
	) as $id ) {
		if ( ! function_exists( 'pll_get_post_language' ) || pll_get_post_language( $id ) === $lang ) {
			return (string) get_permalink( $id );
		}
	}

	return '';
}

$content = array(
	'vi' => array(
		'slug'    => 'trang-chu',
		'banners' => array(
			array( 'img' => 'banner-01.webp', 'title' => 'Uy tín – Chất lượng – Tiến độ' ),
			array( 'img' => 'banner-02.webp', 'title' => 'Năng lực thi công công trình quy mô lớn' ),
			array( 'img' => 'banner-03.webp', 'title' => 'An toàn & Chất lượng là mục tiêu hàng đầu' ),
			array( 'img' => 'banner-05.webp', 'title' => 'Đồng hành cùng các dự án đô thị hiện đại' ),
			array( 'img' => 'banner-06.webp', 'title' => 'Chất lượng công trình là cam kết lâu dài' ),
		),
		'heading'    => 'THI CÔNG HẠ TẦNG KỸ THUẬT – GIAO THÔNG ĐƯỜNG BỘ – ĐƯỜNG THUỶ',
		'subheading' => 'UY TÍN – CHẤT LƯỢNG – TIẾN ĐỘ',
		'stats'      => array(
			array( 'Kỹ sư và nhân viên', '50', 'người' ),
			array( 'Dự án', '70', 'dự án' ),
			array( 'Lao động thường xuyên', '250', 'người' ),
			array( 'Loại thiết bị thi công', '30', 'loại' ),
		),
		'about_title'     => 'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT',
		'about_lead'      => 'Uy tín – Chất lượng – Tiến độ là kim chỉ nam trong mọi hoạt động',
		'about_body'      => 'Tín Phát cung cấp dịch vụ thi công xây dựng, đầu tư – thương mại, hoàn thiện công trình và giải pháp kỹ thuật cho doanh nghiệp và các dự án trên toàn quốc. Với hơn 50 kỹ sư, 250 lao động thường xuyên và 30 loại thiết bị thuộc sở hữu, chúng tôi là nhà thầu cho nhiều dự án hạ tầng của PTSC, các Ban QLDA giao thông và Sở Giao thông Vận tải cấp tỉnh.',
		'about_cta'       => 'Tìm hiểu về Tín Phát',
		'fields_title'    => 'Lĩnh vực hoạt động',
		'fields_cta'      => 'Xem năng lực thi công',
		'fields'          => array(
			array( 'tp-cap-fields.webp', 'Xây dựng dân dụng & công nghiệp', 'Nhà xưởng, kho hàng kín, hạ tầng kỹ thuật khu công nghiệp, sân bê tông và bãi đá.' ),
			array( 'tp-d991-04.webp', 'Giao thông đường bộ & đường thuỷ', 'Đường giao thông các cấp, cầu trên tuyến, hệ thống thoát nước, phao báo hiệu hàng hải.' ),
			array( 'tp-cap-vision.webp', 'Tư vấn thiết kế & quản lý dự án', 'Tư vấn thiết kế công trình, quản lý dự án, lập hồ sơ dự thầu và giám sát thi công.' ),
			array( 'tp-a5b1-03.webp', 'Khảo sát, đo đạc & lập mô hình BIM', 'Khảo sát địa hình, đo đạc trắc địa, lập mô hình BIM và kiểm tra khối lượng.' ),
		),
		'motto_title'     => 'An toàn & Chất lượng là mục tiêu hàng đầu',
		'motto_sub'       => 'Đơn vị tổng thầu thi công xây dựng hạ tầng kỹ thuật – giao thông đường bộ và đường thuỷ',
		'projects_title'  => 'Dự án',
		'news_title'      => 'Tin mới nhất',
		'career_title'    => 'Tuyển dụng',
		'career_intro'    => 'Chúng tôi luôn tìm kiếm ứng viên tiềm năng cho sự hợp tác và phát triển bền vững',
		'career_cta'      => 'Nộp hồ sơ ứng tuyển ngay',
		'partners_title'  => 'Khách hàng và đối tác',
	),
	'en' => array(
		'slug'    => 'home',
		'banners' => array(
			array( 'img' => 'banner-01.webp', 'title' => 'Integrity – Quality – Progress' ),
			array( 'img' => 'banner-02.webp', 'title' => 'Capability to deliver large-scale projects' ),
			array( 'img' => 'banner-03.webp', 'title' => 'Safety and quality are our top priorities' ),
			array( 'img' => 'banner-05.webp', 'title' => 'Partnering on modern urban developments' ),
			array( 'img' => 'banner-06.webp', 'title' => 'Build quality is a long-term commitment' ),
		),
		'heading'    => 'TECHNICAL INFRASTRUCTURE – ROAD – WATERWAY CONSTRUCTION',
		'subheading' => 'INTEGRITY – QUALITY – ON SCHEDULE',
		'stats'      => array(
			array( 'Engineers and staff', '50', 'people' ),
			array( 'Projects', '70', 'projects' ),
			array( 'Permanent employees', '250', 'people' ),
			array( 'Equipment types', '30', 'types' ),
		),
		'about_title'     => 'TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED',
		'about_lead'      => 'Integrity – Quality – Progress guide everything we do',
		'about_body'      => 'Tin Phat provides construction, investment and trading services, project completion and technical solutions for businesses and projects nationwide. With over 50 engineers, 250 permanent employees and 30 types of owned equipment, we are the contractor for numerous infrastructure projects of PTSC, provincial transport project management boards and departments of transport.',
		'about_cta'       => 'About Tin Phat',
		'fields_title'    => 'Field of operation',
		'fields_cta'      => 'View our capability',
		'fields'          => array(
			array( 'tp-cap-fields.webp', 'Civil & industrial construction', 'Factories, closed warehouses, industrial park infrastructure, concrete yards and rock areas.' ),
			array( 'tp-d991-04.webp', 'Road & waterway transport', 'Roads of all grades, bridges, drainage systems and maritime navigation buoys.' ),
			array( 'tp-cap-vision.webp', 'Design consultancy & project management', 'Design consultancy, project management, tender documentation and construction supervision.' ),
			array( 'tp-a5b1-03.webp', 'Surveying, measurement & BIM', 'Topographic surveying, geodetic measurement, BIM modeling and quantity verification.' ),
		),
		'motto_title'     => 'Safety and quality are our top priorities',
		'motto_sub'       => 'A general contractor for technical infrastructure, road and waterway construction',
		'projects_title'  => 'Projects',
		'news_title'      => 'Latest news',
		'career_title'    => 'Careers',
		'career_intro'    => 'We are always looking for talented candidates for long-term cooperation and sustainable growth',
		'career_cta'      => 'Apply now',
		'partners_title'  => 'Clients & Partners',
	),
);

foreach ( $content as $lang => $data ) {
	$page = get_page_by_path( $data['slug'], OBJECT, 'page' );

	if ( ! $page instanceof WP_Post ) {
		WP_CLI::warning( "Không thấy trang {$data['slug']}" );
		continue;
	}

	$blocks = array();

	// Banner.
	$slides = '';
	foreach ( $data['banners'] as $i => $banner ) {
		// Slide đầu tải ngay (ứng viên LCP), các slide sau lazy.
		$slides .= sprintf(
			'[tinphat_banner_item image="%s/%s" title="%s" eager="%s"]',
			esc_url( $banner_base ),
			esc_attr( $banner['img'] ),
			esc_attr( $banner['title'] ),
			0 === $i ? '1' : ''
		);
	}
	$blocks[] = '[tinphat_banner]' . $slides . '[/tinphat_banner]';

	// Số liệu.
	$items = '';
	foreach ( $data['stats'] as $stat ) {
		$items .= sprintf(
			'[tinphat_key_number_item label="%s" value="%s" unit="%s"]',
			esc_attr( $stat[0] ),
			esc_attr( $stat[1] ),
			esc_attr( $stat[2] )
		);
	}
	$blocks[] = sprintf(
		'[tinphat_key_numbers heading="%s" subheading="%s"]%s[/tinphat_key_numbers]',
		esc_attr( $data['heading'] ),
		esc_attr( $data['subheading'] ),
		$items
	);

	// Dự án.
	// Giới thiệu ngắn — rút từ trang Tổng quan.
	$blocks[] = sprintf(
		'[tinphat_about title="%s" lead="%s" body="%s" cta="%s" cta_url="%s"]',
		esc_attr( $data['about_title'] ),
		esc_attr( $data['about_lead'] ),
		esc_attr( $data['about_body'] ),
		esc_attr( $data['about_cta'] ),
		esc_url( tp_page_url( 'vi' === $lang ? 'tong-quan' : 'overview', $lang ) )
	);

	// 4 lĩnh vực — rút từ trang Năng lực thi công.
	$field_atts = '';

	foreach ( array_values( $data['fields'] ) as $i => $f ) {
		$field_atts .= sprintf( ' f%d="%s"', $i + 1, esc_attr( implode( '|', $f ) ) );
	}

	$blocks[] = sprintf(
		'[tinphat_fields title="%s" cta="%s" cta_url="%s"%s]',
		esc_attr( $data['fields_title'] ),
		esc_attr( $data['fields_cta'] ),
		esc_url( tp_page_url( 'vi' === $lang ? 'linh-vuc-hoat-dong' : 'what-we-do', $lang ) ),
		$field_atts
	);

	$blocks[] = sprintf( '[tinphat_projects title="%s" limit="9"]', esc_attr( $data['projects_title'] ) );

	// Tin tức.
	// Khẩu hiệu từ hồ sơ năng lực, đặt giữa Dự án và Tin tức.
	$blocks[] = sprintf(
		'[tinphat_motto title="%s" sub="%s"]',
		esc_attr( $data['motto_title'] ),
		esc_attr( $data['motto_sub'] )
	);

	$blocks[] = sprintf( '[tinphat_news title="%s" limit="8"]', esc_attr( $data['news_title'] ) );

	// Tuyển dụng.
	$blocks[] = sprintf(
		'[tinphat_career title="%s" intro="%s" cta="%s" limit="3"]',
		esc_attr( $data['career_title'] ),
		esc_attr( $data['career_intro'] ),
		esc_attr( $data['career_cta'] )
	);

	// Văn hóa.

	// Video.

	// Đối tác.
	$blocks[] = sprintf( '[tinphat_partners title="%s"]', esc_attr( $data['partners_title'] ) );

	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => implode( "\n\n", $blocks ),
		)
	);

	WP_CLI::log( "Trang chủ {$lang} (#{$page->ID}): " . count( $blocks ) . ' khối' );
}

WP_CLI::success( 'Đã dựng nội dung trang chủ.' );
