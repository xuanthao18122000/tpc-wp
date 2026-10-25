<?php
/**
 * Đổ nội dung 2 trang: "Tầm nhìn, giá trị cốt lõi" và "Đối tác và khách hàng".
 *
 * Bố cục tham khảo centralcons.vn; nội dung là dữ liệu thật của Tín Phát
 * (sứ mệnh / tầm nhìn / giá trị cốt lõi / lĩnh vực / thế mạnh lấy từ bản Next.js).
 *
 * Chạy: wp eval-file scripts/seed-about-pages.php
 */

/** URL ảnh trong uploads/tinphat. */
function tpa_img( string $file ): string {
	return content_url( 'uploads/tinphat/' . $file );
}

/**
 * Tiêu đề khối kiểu template (.title_section — chữ trên dải gạch ngang).
 *
 * @param string $title Tiêu đề.
 * @param string $tag   Thẻ heading (h1 cho tiêu đề chính của trang).
 */
function tpa_title_section( string $title, string $tag = 'h2' ): string {
	return '<div class="title_section"><div class="row align-items-center"><div class="col-md-6">'
		. '<' . $tag . ' class="fs-40 mb-0 fw-bold"><span>' . esc_html( $title ) . '</span></' . $tag . '>'
		. '</div></div></div>';
}

/**
 * Khối tầm nhìn: ảnh lệch phải, hộp xanh chồng lên bên trái.
 *
 * @param string $image     Tên file ảnh.
 * @param string $statement Câu phát biểu tầm nhìn.
 * @param string $alt       Alt của ảnh.
 */
function tpa_vision_hero( string $image, string $statement, string $alt ): string {
	return '<div class="tp-vision-hero">'
		. '<div class="tp-vision-hero__media">'
		. '<img src="' . esc_url( tpa_img( $image ) ) . '" alt="' . esc_attr( $alt ) . '"'
		. ' width="1280" height="697" fetchpriority="high" decoding="async"></div>'
		. '<div class="tp-vision-hero__box"><p>' . esc_html( $statement ) . '</p></div>'
		. '</div>';
}

/**
 * Mosaic giá trị cốt lõi.
 *
 * Nhận danh sách phần tử theo đúng thứ tự hiển thị; mỗi phần tử là ảnh
 * (`image`) hoặc thẻ giá trị (`icon`/`title`/`desc`). Số thứ tự 01, 02…
 * được đánh tự động theo các thẻ giá trị.
 *
 * @param array<int,array<string,string>> $items Danh sách.
 */
function tpa_value_grid( array $items ): string {
	$html  = '<div class="tp-value-grid">';
	$index = 0;

	foreach ( $items as $item ) {
		if ( isset( $item['image'] ) ) {
			$html .= '<div class="tp-value-grid__media">'
				. '<img src="' . esc_url( tpa_img( $item['image'] ) ) . '"'
				. ' alt="' . esc_attr( $item['alt'] ?? '' ) . '"'
				. ' width="856" height="856" loading="lazy" decoding="async"></div>';
			continue;
		}

		++$index;

		$html .= '<div class="tp-value-card">'
			. '<div class="tp-value-card__icon">'
			. '<img src="' . esc_url( tpa_img( $item['icon'] ) ) . '" alt=""'
			. ' width="50" height="70" loading="lazy" decoding="async"></div>'
			. '<div class="tp-value-card__num">' . esc_html( sprintf( '%02d', $index ) ) . '</div>'
			. '<h3>' . esc_html( $item['title'] ) . '</h3>'
			. '<p>' . esc_html( $item['desc'] ) . '</p>'
			. '</div>';
	}

	return $html . '</div>';
}

/** Tiêu đề khối có gạch chân cam. *//** Tiêu đề khối có gạch chân cam. */
function tpa_head( string $title, string $sub = '' ): string {
	return '<div class="tp-section-head"><h2>' . esc_html( $title ) . '</h2>'
		. ( '' !== $sub ? '<p>' . esc_html( $sub ) . '</p>' : '' )
		. '</div>';
}

/**
 * Lưới logo có tiêu đề nhóm.
 *
 * @param string            $title Tiêu đề nhóm.
 * @param array<int,string> $files Tên file ảnh trong uploads/tinphat.
 */
function tpa_logo_group( string $title, array $files ): string {
	$html = '<div class="tp-logo-group"><div class="tp-logo-group__head"><h2>' . esc_html( $title ) . '</h2></div>'
		. '<div class="tp-logo-grid">';

	foreach ( $files as $file ) {
		$html .= '<div class="tp-logo-grid__cell">'
			. '<img src="' . esc_url( tpa_img( $file ) ) . '" alt="" width="150" height="94" loading="lazy" decoding="async">'
			. '</div>';
	}

	// Không chèn ô trống: số cột do CSS quyết định theo bề rộng màn hình,
	// chèn thêm ở PHP sẽ thừa ô xám khi hai bên lệch nhau.
	return $html . '</div></div>';
}

/**
 * Thẻ lĩnh vực phục vụ (ảnh + danh sách).
 *
 * @param array<int,array{image:string,title:string,items:array<int,string>}> $sectors Danh sách.
 */
function tpa_sectors( array $sectors ): string {
	$html = '<div class="tp-sectors">';

	foreach ( $sectors as $sector ) {
		$html .= '<div class="tp-sector">'
			. '<img src="' . esc_url( tpa_img( $sector['image'] ) ) . '" alt="' . esc_attr( $sector['title'] ) . '" width="520" height="325" loading="lazy" decoding="async">'
			. '<div class="tp-sector__body"><h3>' . esc_html( $sector['title'] ) . '</h3><ul>'
			. implode( '', array_map( static fn( $i ) => '<li>' . esc_html( $i ) . '</li>', $sector['items'] ) )
			. '</ul></div></div>';
	}

	return $html . '</div>';
}

/** Tìm trang theo slug, lọc theo ngôn ngữ. */
function tpa_find_page( string $slug, string $lang ): ?WP_Post {
	$found = get_posts(
		array(
			'post_type'      => 'page',
			'name'           => $slug,
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		)
	);

	foreach ( $found as $page ) {
		if ( ! function_exists( 'pll_get_post_language' ) || pll_get_post_language( $page->ID ) === $lang ) {
			return $page;
		}
	}

	return null;
}

/**
 * Link trang theo slug + ngôn ngữ; rỗng nếu chưa có trang.
 */
function tpa_page_url( string $slug, string $lang ): string {
	$page = tpa_find_page( $slug, $lang );

	return $page instanceof WP_Post ? (string) get_permalink( $page->ID ) : '';
}

/**
 * Link archive CPT dự án theo ngôn ngữ.
 *
 * LƯU Ý: slug archive hiện vẫn là `du-an` ở cả hai ngôn ngữ (Polylang chỉ
 * đổi tiền tố /vi /en). URL /en/du-an/ trả 200 nên link hoạt động; muốn
 * /en/projects/ thì phải dịch slug CPT — việc riêng, không làm ở đây.
 */
function tpa_projects_url( string $lang ): string {
	$archive = (string) get_post_type_archive_link( 'du-an' );

	if ( '' === $archive ) {
		return '';
	}

	// Ghép lại từ home_url của đúng ngôn ngữ để không phải cắt chuỗi.
	$path = (string) wp_parse_url( $archive, PHP_URL_PATH );
	$slug = trim( (string) preg_replace( '#^/[a-z]{2}/#', '/', $path ), '/' );
	$home = function_exists( 'pll_home_url' ) ? (string) pll_home_url( $lang ) : home_url( '/' );

	return trailingslashit( $home ) . trailingslashit( $slug );
}

/** Khối kêu gọi liên hệ. */
function tpa_cta( string $title, string $desc, string $primary, string $primary_url, string $secondary, string $secondary_url ): string {
	return '<div class="tp-cta"><h2>' . esc_html( $title ) . '</h2><p>' . esc_html( $desc ) . '</p>'
		. '<div class="tp-cta__actions">'
		. '<a class="tp-btn" href="' . esc_url( $primary_url ) . '">' . esc_html( $primary ) . '</a>'
		. '<a class="tp-btn tp-btn--outline" href="' . esc_url( $secondary_url ) . '">' . esc_html( $secondary ) . '</a>'
		. '</div></div>';
}

// 12 đối tác THẬT, logo trích từ hồ sơ năng lực (docs/PROFILE TIN PHAT IN.pdf).
$partners_oil = array(
	'tp-partner-02-ptsc-mc.png',
	'tp-partner-03-ptsc-supply-base.png',
	'tp-partner-11-long-son-port.png',
	'tp-partner-08-pacific-industry.png',
);

$partners_state = array(
	'tp-partner-06-brvt.png',
	'tp-partner-04-so-xd-dong-nai.png',
);

$partners_industry = array(
	'tp-partner-01-phan-vu.png',
	'tp-partner-09-hoa-phat.png',
	'tp-partner-12-hoa-sen.png',
	'tp-partner-05-an-lac.png',
	'tp-partner-10-son-vu.png',
	'tp-partner-07-fpt.png',
);

$pages = array(

	// ===== Tầm nhìn, giá trị cốt lõi =====
	'tam-nhin-gia-tri-cot-loi' => array(
		'content' =>
			'<div class="tp-vision-page"><div class="tp-vision-page__inner">'
			. tpa_title_section( 'Tầm nhìn', 'h2' )
			. tpa_vision_hero(
				'tp-cover-capability.webp',
				'Trở thành một trong những doanh nghiệp xây dựng – đầu tư – thương mại uy tín tại Việt Nam, không ngừng đổi mới để mang lại các giải pháp thi công chất lượng, an toàn và bền vững cho các công trình trên toàn quốc.',
				'Công trường do Tín Phát thi công'
			)
			. tpa_title_section( 'Giá trị cốt lõi', 'h2' )
			. tpa_value_grid(
				array(
					array( 'image' => 'value.webp', 'alt' => 'Giá trị cốt lõi của Tín Phát' ),
					array(
						'icon'  => 'value-01.webp',
						'title' => 'Chất lượng – Đúng tiến độ',
						'desc'  => 'Mang đến cho khách hàng các dịch vụ thi công xây dựng chuyên nghiệp, đúng tiến độ và đạt chuẩn chất lượng cao.',
					),
					array(
						'icon'  => 'value-04.webp',
						'title' => 'Bền vững – Thân thiện môi trường',
						'desc'  => 'Góp phần tạo nên những công trình vững bền, thân thiện môi trường và giá trị lâu dài cho cộng đồng.',
					),
					array(
						'icon'  => 'value-05.webp',
						'title' => 'Con người – Tận tâm',
						'desc'  => 'Xây dựng đội ngũ nhân sự có chuyên môn, trách nhiệm và tinh thần phục vụ tận tâm trong mọi giai đoạn dự án.',
					),
					array( 'image' => 'tp-cover-projects.webp', 'alt' => 'Công trường Tín Phát' ),
				)
			)
			. '</div></div>',
		'en'      => array(
			'slug'    => 'vision-core-values',
			'content' =>
				'<div class="tp-vision-page"><div class="tp-vision-page__inner">'
				. tpa_title_section( 'Our vision', 'h2' )
				. tpa_vision_hero(
					'tp-cover-capability.webp',
					'To become a reputable construction – investment – trading enterprise in Vietnam, continuously innovating to deliver high-quality, safe and sustainable construction solutions for projects nationwide.',
					'A project built by Tin Phat'
				)
				. tpa_title_section( 'Core values', 'h2' )
				. tpa_value_grid(
					array(
						array( 'image' => 'value.webp', 'alt' => 'Tin Phat core values' ),
						array(
							'icon'  => 'value-01.webp',
							'title' => 'Quality – On schedule',
							'desc'  => 'Provide clients with professional construction services that meet schedule and deliver high-quality standards.',
						),
						array(
							'icon'  => 'value-04.webp',
							'title' => 'Durable – Environmentally friendly',
							'desc'  => 'Contribute to creating durable, environmentally friendly and long-lasting projects for the community.',
						),
						array(
							'icon'  => 'value-05.webp',
							'title' => 'People – Dedication',
							'desc'  => 'Build a workforce with expertise, responsibility and dedication to service excellence at every project stage.',
						),
						array( 'image' => 'tp-cover-projects.webp', 'alt' => 'A Tin Phat site' ),
					)
				)
				. '</div></div>',
		),
	),

	// ===== Đối tác và khách hàng =====
	'doi-tac-khach-hang' => array(
		'content' =>
			'<h2 class="tp-lead">Đồng hành cùng Tín Phát</h2>'
			. '<p class="tp-lead-desc">70+ dự án cùng các chủ đầu tư ngành dầu khí, cảng biển và cơ quan quản lý nhà nước</p>'
			. '<p>Tín Phát là nhà thầu thi công cho nhiều dự án hạ tầng thuộc Tổng Công ty CP Dịch vụ Kỹ thuật Dầu khí Việt Nam (PTSC), Cảng Quốc tế Long Sơn và các Ban QLDA giao thông cấp tỉnh. Chúng tôi xây dựng quan hệ đối tác dựa trên ba nguyên tắc: cam kết rõ ràng bằng hợp đồng, tiến độ đúng hạn và chất lượng được kiểm soát ở mọi khâu.</p>'
			. '<p>Với khách hàng, chúng tôi đóng vai trò nhà thầu đồng hành từ bước tư vấn phương án, bóc tách khối lượng, thi công cho đến bàn giao và bảo hành. Với nhà thầu phụ và nhà cung cấp, chúng tôi là đối tác dài hạn, cùng chia sẻ tiêu chuẩn thi công và tiến độ.</p>'
			. tpa_head( 'Lĩnh vực chúng tôi phục vụ' )
			. tpa_sectors(
				array(
					array(
						'image' => 'tp-prj-dich-vu-dau-khi.webp',
						'title' => 'Hạ tầng dầu khí & cảng biển',
						'items' => array(
							'Đường nội bộ cảng PTSC',
							'Sân bê tông, bãi đá',
							'Kho hàng kín, nhà xưởng',
							'Hệ thống thoát nước',
						),
					),
					array(
						'image' => 'tp-prj-duong-991.webp',
						'title' => 'Giao thông đường bộ',
						'items' => array(
							'Đường giao thông cấp IV',
							'Cầu trên tuyến',
							'Sửa chữa, nâng cấp mặt đường',
							'Thảm bê tông nhựa',
						),
					),
					array(
						'image' => 'tp-prj-phao-con-dao.webp',
						'title' => 'Đường thuỷ & hàng hải',
						'items' => array(
							'Hệ thống phao báo hiệu',
							'Quản lý, bảo trì đường thuỷ nội địa',
							'Công trình hàng hải',
							'Khảo sát, đo đạc',
						),
					),
				)
			)
			. tpa_logo_group( 'Chủ đầu tư ngành dầu khí & cảng biển', $partners_oil )
			. tpa_logo_group( 'Cơ quan quản lý nhà nước', $partners_state )
			. tpa_logo_group( 'Đối tác công nghiệp & cung ứng', $partners_industry )
			. tpa_cta(
				'Trở thành đối tác của Tín Phát',
				'Gửi yêu cầu báo giá hoặc hồ sơ hợp tác, chúng tôi phản hồi trong vòng 24 giờ làm việc.',
				'Liên hệ ngay',
				tpa_page_url( 'lien-he', 'vi' ),
				'Xem dự án đã thực hiện',
				tpa_projects_url( 'vi' )
			),
		'en'      => array(
			'slug'    => 'partners-clients',
			'content' =>
				'<h2 class="tp-lead">Working with Tin Phat</h2>'
				. '<p class="tp-lead-desc">70+ projects with oil and gas investors, seaport operators and state agencies</p>'
				. '<p>Tin Phat is the construction contractor for numerous infrastructure projects of PetroVietnam Technical Services Corporation (PTSC), Long Son International Port and provincial transport project management boards. We build partnerships on three principles: clear contractual commitments, schedules kept on time, and quality controlled at every stage.</p>'
				. '<p>For our clients we act as a contractor who stays involved from design advice and quantity take-off through construction, handover and warranty. For subcontractors and suppliers we are a long-term partner sharing the same construction standards and schedule discipline.</p>'
				. tpa_head( 'Sectors we serve' )
				. tpa_sectors(
					array(
						array(
							'image' => 'tp-prj-dich-vu-dau-khi.webp',
							'title' => 'Oil, gas and seaport infrastructure',
							'items' => array(
								'Internal roads at PTSC Port',
								'Concrete yards and rock areas',
								'Closed warehouses and factories',
								'Drainage systems',
							),
						),
						array(
							'image' => 'tp-prj-duong-991.webp',
							'title' => 'Road transport',
							'items' => array(
								'Grade IV roads',
								'Bridges on route',
								'Road repair and upgrade',
								'Asphalt concrete paving',
							),
						),
						array(
							'image' => 'tp-prj-phao-con-dao.webp',
							'title' => 'Waterways and maritime',
							'items' => array(
								'Navigation buoy systems',
								'Inland waterway management',
								'Maritime works',
								'Surveying and measurement',
							),
						),
					)
				)
				. tpa_logo_group( 'Oil, gas and seaport investors', $partners_oil )
				. tpa_logo_group( 'State management agencies', $partners_state )
				. tpa_logo_group( 'Industrial and supply partners', $partners_industry )
				. tpa_cta(
					'Become a Tin Phat partner',
					'Send us a quotation request or a partnership profile and we will reply within 24 working hours.',
					'Contact us',
					tpa_page_url( 'contact', 'en' ),
					'View our projects',
					tpa_projects_url( 'en' )
				),
		),
	),
);

$updated = 0;

foreach ( $pages as $slug => $data ) {
	$page = tpa_find_page( $slug, 'vi' );

	if ( $page instanceof WP_Post ) {
		wp_update_post( array( 'ID' => $page->ID, 'post_content' => $data['content'] ) );
		WP_CLI::log( "  vi/{$slug}" );
		++$updated;
	} else {
		WP_CLI::warning( "  không tìm thấy vi/{$slug}" );
	}

	if ( isset( $data['en'] ) ) {
		$en_page = tpa_find_page( $data['en']['slug'], 'en' );

		if ( $en_page instanceof WP_Post ) {
			wp_update_post( array( 'ID' => $en_page->ID, 'post_content' => $data['en']['content'] ) );
			WP_CLI::log( "  en/{$data['en']['slug']}" );
			++$updated;
		} else {
			WP_CLI::warning( "  không tìm thấy en/{$data['en']['slug']}" );
		}
	}
}

WP_CLI::success( "Đã cập nhật {$updated} trang." );
