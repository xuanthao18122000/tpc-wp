<?php
/**
 * Dựng nội dung trang chủ song ngữ bằng shortcode.
 *
 * Chạy: wp eval-file /scripts/seed-home.php
 */

$banner_base = content_url( 'uploads/tinphat' );

$content = array(
	'vi' => array(
		'slug'    => 'trang-chu',
		'banners' => array(
			array( 'img' => 'banner-01.webp', 'title' => 'Khu căn hộ cao tầng' ),
			array( 'img' => 'banner-02.webp', 'title' => 'Khu đô thị ven sông' ),
			array( 'img' => 'banner-03.webp', 'title' => 'Khu chung cư phức hợp' ),
		),
		'heading'    => 'NHÀ THẦU XÂY DỰNG DÂN DỤNG – CÔNG NGHIỆP – THƯƠNG MẠI',
		'subheading' => 'UY TÍN – CHẤT LƯỢNG – TIẾN ĐỘ',
		'stats'      => array(
			array( 'Dự án hoàn thành', '100', 'dự án' ),
			array( 'Năm kinh nghiệm', '10', 'năm' ),
			array( 'Đội ngũ nhân sự', '150', 'nhân sự' ),
			array( 'Cam kết chất lượng', '100', '%' ),
		),
		'projects_title'  => 'Dự án',
		'news_title'      => 'Tin mới nhất',
		'career_title'    => 'Tuyển dụng',
		'career_intro'    => 'Chúng tôi luôn tìm kiếm ứng viên tiềm năng cho sự hợp tác và phát triển bền vững',
		'career_cta'      => 'Nộp hồ sơ ứng tuyển ngay',
		'culture_title'   => 'Văn hóa Tín Phát',
		'videos_title'    => 'Videos',
		'partners_title'  => 'Khách hàng và đối tác',
	),
	'en' => array(
		'slug'    => 'home',
		'banners' => array(
			array( 'img' => 'banner-01.webp', 'title' => 'High-rise apartment complex' ),
			array( 'img' => 'banner-02.webp', 'title' => 'Riverside urban development' ),
			array( 'img' => 'banner-03.webp', 'title' => 'Mixed-use residential complex' ),
		),
		'heading'    => 'RESIDENTIAL – INDUSTRIAL – COMMERCIAL CONSTRUCTION CONTRACTOR',
		'subheading' => 'INTEGRITY – QUALITY – ON SCHEDULE',
		'stats'      => array(
			array( 'Completed projects', '100', 'projects' ),
			array( 'Years of experience', '10', 'years' ),
			array( 'Team members', '150', 'people' ),
			array( 'Quality commitment', '100', '%' ),
		),
		'projects_title'  => 'Projects',
		'news_title'      => 'Latest news',
		'career_title'    => 'Careers',
		'career_intro'    => 'We are always looking for talented candidates for long-term cooperation and sustainable growth',
		'career_cta'      => 'Apply now',
		'culture_title'   => 'Tin Phat Culture',
		'videos_title'    => 'Videos',
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
	$blocks[] = sprintf( '[tinphat_projects title="%s" limit="9"]', esc_attr( $data['projects_title'] ) );

	// Tin tức.
	$blocks[] = sprintf( '[tinphat_news title="%s" limit="8"]', esc_attr( $data['news_title'] ) );

	// Tuyển dụng.
	$blocks[] = sprintf(
		'[tinphat_career title="%s" intro="%s" cta="%s" limit="3"]',
		esc_attr( $data['career_title'] ),
		esc_attr( $data['career_intro'] ),
		esc_attr( $data['career_cta'] )
	);

	// Văn hóa.
	$blocks[] = sprintf( '[tinphat_culture title="%s" limit="3"]', esc_attr( $data['culture_title'] ) );

	// Video.
	$blocks[] = sprintf( '[tinphat_videos title="%s" limit="3"]', esc_attr( $data['videos_title'] ) );

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
