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
 * @param int               $cols  Số cột để chèn ô trống cho thẳng lưới.
 */
function tpa_logo_group( string $title, array $files, int $cols = 5 ): string {
	$html = '<div class="tp-logo-group"><div class="tp-logo-group__head"><h2>' . esc_html( $title ) . '</h2></div>'
		. '<div class="tp-logo-grid">';

	foreach ( $files as $file ) {
		$html .= '<div class="tp-logo-grid__cell">'
			. '<img src="' . esc_url( tpa_img( $file ) ) . '" alt="" width="150" height="94" loading="lazy" decoding="async">'
			. '</div>';
	}

	// Ô trống để hàng cuối không bị hụt.
	$remainder = count( $files ) % $cols;

	if ( 0 !== $remainder ) {
		$html .= str_repeat( '<div class="tp-logo-grid__cell tp-logo-grid__cell--empty"></div>', $cols - $remainder );
	}

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

// MOCKUP: đây là logo khách hàng của Central, KHÔNG phải của Tín Phát.
// Giữ lại để thấy bố cục; thay bằng logo thật khi khách gửi file.
$mock_investors = array(
	'partner-01-1200px-Vingroup-logo-svg.webp',
	'partner-03-ssg-group-logo-1.webp',
	'partner-05-logo-chu-dau-tu-van-xuan-land-group-1608.webp',
	'partner-06-logo-masterise-group-1.webp',
	'partner-11-LOGO-HUNG-VUONG-2.webp',
	'partner-12-Phat-Dat-Logo-ngang-new-01.webp',
	'partner-13-logo-saigon-pearl-1-1.webp',
	'partner-15-logo-bim-group-2.webp',
	'partner-08-ttc-logo-1.webp',
	'partner-09-son-kim-1.webp',
);

$mock_contractors = array(
	'partner-10-shimz.webp',
	'partner-02-1200px-Tokyu-logo-svg.webp',
	'partner-16-1584004197668-1583807295821-TTG-Logo-Hir.webp',
	'partner-17-logo-bw-1.webp',
	'partner-19-logo-en-1.webp',
);

$mock_suppliers = array(
	'partner-04-empire-city-logo2.webp',
	'partner-07-hoa-lam.webp',
	'partner-14-27587.webp',
	'partner-18-EMASI-logo-6.webp',
);

$pages = array(

	// ===== Tầm nhìn, giá trị cốt lõi =====
	'tam-nhin-gia-tri-cot-loi' => array(
		'content' =>
			'<div class="tp-vision-page"><div class="tp-vision-page__inner">'
			. tpa_title_section( 'Tầm nhìn', 'h2' )
			. tpa_vision_hero(
				'banner-17-DJI-0664-scaled.webp',
				'Trở thành công ty xây dựng hàng đầu tại Thành phố Hồ Chí Minh, được Khách hàng tin tưởng và lựa chọn trong lĩnh vực xây dựng dân dụng, thương mại và công nghiệp.',
				'Công trình do Tín Phát thi công'
			)
			. tpa_title_section( 'Giá trị cốt lõi', 'h2' )
			. tpa_value_grid(
				array(
					array( 'image' => 'value.webp', 'alt' => 'Giá trị cốt lõi của Tín Phát' ),
					array(
						'icon'  => 'value-01.webp',
						'title' => 'Uy tín',
						'desc'  => 'Giữ đúng cam kết với Khách hàng, Đối tác và người lao động. Báo giá minh bạch, hợp đồng rõ ràng, nói được làm được — đây là nền tảng cho mọi quan hệ hợp tác lâu dài của Tín Phát.',
					),
					array(
						'icon'  => 'value-02.webp',
						'title' => 'Chất lượng',
						'desc'  => 'Sử dụng vật liệu đạt chuẩn, thi công theo quy trình kiểm soát chặt chẽ ở từng hạng mục và bảo hành dài hạn. Chúng tôi chịu trách nhiệm đến cùng với chất lượng công trình đã bàn giao.',
					),
					array(
						'icon'  => 'value-03.webp',
						'title' => 'Đúng tiến độ',
						'desc'  => 'Lập kế hoạch chi tiết cho từng giai đoạn, huy động đủ nhân lực và thiết bị để bàn giao đúng thời hạn đã ký. Tiến độ là cam kết, không phải mong muốn.',
					),
					array(
						'icon'  => 'value-04.webp',
						'title' => 'Tiến bộ',
						'desc'  => 'Không ngừng cải tiến biện pháp thi công, cập nhật công nghệ và nâng cao tay nghề đội ngũ qua từng dự án, nhằm mang lại chi phí hợp lý hơn và chất lượng tốt hơn cho Khách hàng.',
					),
					array(
						'icon'  => 'value-05.webp',
						'title' => 'Tận tâm',
						'desc'  => 'Đặt sự hài lòng của Khách hàng lên hàng đầu: tư vấn miễn phí, đồng hành từ khâu thiết kế đến bàn giao và hỗ trợ lâu dài sau khi công trình đưa vào sử dụng.',
					),
					array( 'image' => 'overview_2.webp', 'alt' => 'Công trường Tín Phát' ),
				)
			)
			. '</div></div>',
		'en'      => array(
			'slug'    => 'vision-core-values',
			'content' =>
				'<div class="tp-vision-page"><div class="tp-vision-page__inner">'
				. tpa_title_section( 'Our vision', 'h2' )
				. tpa_vision_hero(
					'banner-17-DJI-0664-scaled.webp',
					'To become a leading construction company in Ho Chi Minh City, trusted and chosen by our Clients across residential, commercial and industrial construction.',
					'A project built by Tin Phat'
				)
				. tpa_title_section( 'Core values', 'h2' )
				. tpa_value_grid(
					array(
						array( 'image' => 'value.webp', 'alt' => 'Tin Phat core values' ),
						array(
							'icon'  => 'value-01.webp',
							'title' => 'Integrity',
							'desc'  => 'We keep our commitments to Clients, Partners and workers. Transparent quotations, clear contracts, and we do what we say — the foundation of every lasting relationship at Tin Phat.',
						),
						array(
							'icon'  => 'value-02.webp',
							'title' => 'Quality',
							'desc'  => 'We use certified materials, build to a tightly controlled process at every stage and provide long-term warranty. We stand behind the quality of every project we hand over.',
						),
						array(
							'icon'  => 'value-03.webp',
							'title' => 'On schedule',
							'desc'  => 'We plan each stage in detail and mobilise enough people and equipment to hand over on the agreed date. A schedule is a commitment, not an aspiration.',
						),
						array(
							'icon'  => 'value-04.webp',
							'title' => 'Progress',
							'desc'  => 'We continuously improve our construction methods, adopt new technology and raise our teams skills project by project, to deliver better quality at a more reasonable cost.',
						),
						array(
							'icon'  => 'value-05.webp',
							'title' => 'Dedication',
							'desc'  => 'Client satisfaction comes first: free consultancy, support from design through handover, and long-term care once the building is in use.',
						),
						array( 'image' => 'overview_2.webp', 'alt' => 'A Tin Phat site' ),
					)
				)
				. '</div></div>',
		),
	),

	// ===== Đối tác và khách hàng =====
	'doi-tac-khach-hang' => array(
		'content' =>
			'<h2 class="tp-lead">Đồng hành cùng Tín Phát</h2>'
			. '<p class="tp-lead-desc">Hơn 10 năm và 100+ công trình hoàn thành cùng các chủ đầu tư, nhà thầu và nhà cung cấp</p>'
			. '<p>Mỗi công trình hoàn thành là kết quả của sự hợp tác giữa Tín Phát với chủ đầu tư, các nhà thầu phụ và nhà cung cấp vật liệu. Chúng tôi xây dựng quan hệ đối tác dựa trên ba nguyên tắc: cam kết rõ ràng bằng hợp đồng, thanh toán đúng hạn và chất lượng được kiểm soát ở mọi khâu.</p>'
			. '<p>Với khách hàng, chúng tôi đóng vai trò nhà thầu đồng hành từ bước tư vấn phương án, bóc tách khối lượng, thi công cho đến bàn giao và bảo hành. Với nhà thầu phụ và nhà cung cấp, chúng tôi là đối tác dài hạn, cùng chia sẻ tiêu chuẩn thi công và tiến độ.</p>'
			. tpa_head( 'Lĩnh vực chúng tôi phục vụ' )
			. tpa_sectors(
				array(
					array(
						'image' => 'project-01-Emerald-Boulevard-Le-Phong.webp',
						'title' => 'Xây dựng dân dụng',
						'items' => array(
							'Thiết kế và thi công nhà ở',
							'Biệt thự, nhà phố cao cấp',
							'Chung cư, khu đô thị',
							'Cải tạo, sửa chữa nhà cũ',
						),
					),
					array(
						'image' => 'project-16-Cot-dien-gio-tai-nha-may-Phu-Lac.webp',
						'title' => 'Xây dựng công nghiệp',
						'items' => array(
							'Nhà xưởng sản xuất',
							'Kho bãi, logistics',
							'Nhà máy, công trình công nghiệp',
							'Hạ tầng kỹ thuật',
						),
					),
					array(
						'image' => 'project-09-UOA.webp',
						'title' => 'Xây dựng thương mại',
						'items' => array(
							'Văn phòng làm việc',
							'Trung tâm thương mại',
							'Khách sạn, resort',
							'Nhà hàng, cafe',
						),
					),
				)
			)
			. tpa_logo_group( 'Chủ đầu tư', $mock_investors )
			. tpa_logo_group( 'Đối tác thi công', $mock_contractors )
			. tpa_logo_group( 'Nhà cung cấp vật liệu', $mock_suppliers )
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
				. '<p class="tp-lead-desc">Over 10 years and 100+ completed projects alongside investors, contractors and suppliers</p>'
				. '<p>Every completed project is the result of collaboration between Tin Phat, the investor, our subcontractors and our material suppliers. We build partnerships on three principles: clear contractual commitments, payment on time, and quality controlled at every stage.</p>'
				. '<p>For our clients we act as a contractor who stays involved from design advice and quantity take-off through construction, handover and warranty. For subcontractors and suppliers we are a long-term partner sharing the same construction standards and schedule discipline.</p>'
				. tpa_head( 'Sectors we serve' )
				. tpa_sectors(
					array(
						array(
							'image' => 'project-01-Emerald-Boulevard-Le-Phong.webp',
							'title' => 'Residential construction',
							'items' => array(
								'House design and construction',
								'Premium villas and townhouses',
								'Apartment buildings and urban areas',
								'Renovation and refurbishment',
							),
						),
						array(
							'image' => 'project-16-Cot-dien-gio-tai-nha-may-Phu-Lac.webp',
							'title' => 'Industrial construction',
							'items' => array(
								'Manufacturing plants',
								'Warehousing and logistics',
								'Factories and industrial works',
								'Technical infrastructure',
							),
						),
						array(
							'image' => 'project-09-UOA.webp',
							'title' => 'Commercial construction',
							'items' => array(
								'Offices',
								'Shopping centres',
								'Hotels and resorts',
								'Restaurants and cafés',
							),
						),
					)
				)
				. tpa_logo_group( 'Investors', $mock_investors )
				. tpa_logo_group( 'Construction partners', $mock_contractors )
				. tpa_logo_group( 'Material suppliers', $mock_suppliers )
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
