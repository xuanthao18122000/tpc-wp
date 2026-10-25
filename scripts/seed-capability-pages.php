<?php
/**
 * Đổ nội dung 4 trang năng lực (song ngữ).
 *
 * Toàn bộ số liệu (lĩnh vực, quy mô, máy móc, nhân sự, chứng chỉ, quy
 * trình) lấy từ bản Next.js cũ — dữ liệu thật của Tín Phát.
 *
 * Chạy: php scripts/run.php scripts/seed-capability-pages.php
 */

/** URL ảnh trong uploads/tinphat. */
function tpk_img( string $file ): string {
	return content_url( 'uploads/tinphat/' . $file );
}

/** Tiêu đề khối kiểu template (.title_section). */
function tpk_title( string $title ): string {
	return '<div class="title_section"><div class="row align-items-center"><div class="col-md-6">'
		. '<h2 class="fs-40 mb-0 fw-bold"><span>' . esc_html( $title ) . '</span></h2>'
		. '</div></div></div>';
}

/** Đoạn văn. */
function tpk_paras( array $paras ): string {
	return implode( '', array_map( static fn( $p ) => '<p>' . esc_html( $p ) . '</p>', $paras ) );
}

/**
 * Dải số liệu.
 *
 * @param array<int,array{num:string,label:string}> $stats Số liệu.
 */
function tpk_stats( array $stats ): string {
	$html = '<div class="tp-stats">';

	foreach ( $stats as $stat ) {
		$html .= '<div class="tp-stat">'
			. '<div class="tp-stat__num">' . esc_html( $stat['num'] ) . '</div>'
			. '<div class="tp-stat__label">' . esc_html( $stat['label'] ) . '</div>'
			. '</div>';
	}

	return $html . '</div>';
}

/**
 * Lưới thẻ năng lực (ảnh tuỳ chọn + danh sách).
 *
 * @param array<int,array{title:string,scale?:string,image?:string,items:array<int,string>}> $caps Thẻ.
 */
function tpk_caps( array $caps ): string {
	$html = '<div class="tp-cap-grid">';

	foreach ( $caps as $cap ) {
		$html .= '<div class="tp-cap">';

		if ( ! empty( $cap['image'] ) ) {
			$html .= '<img src="' . esc_url( tpk_img( $cap['image'] ) ) . '"'
				. ' alt="' . esc_attr( $cap['title'] ) . '"'
				. ' width="520" height="325" loading="lazy" decoding="async">';
		}

		$html .= '<div class="tp-cap__body"><h3>' . esc_html( $cap['title'] ) . '</h3>';

		if ( ! empty( $cap['scale'] ) ) {
			$html .= '<p class="tp-cap__scale">' . esc_html( $cap['scale'] ) . '</p>';
		}

		$html .= '<ul>'
			. implode( '', array_map( static fn( $i ) => '<li>' . esc_html( $i ) . '</li>', $cap['items'] ) )
			. '</ul></div></div>';
	}

	return $html . '</div>';
}

/**
 * Bảng máy móc thiết bị.
 *
 * @param array<int,array{title:string,subtitle:string,cols:array{0:string,1:string},items:array<int,array{name:string,en?:string,qty:string}>}> $groups Nhóm.
 */
function tpk_equipment( array $groups ): string {
	$html = '';

	foreach ( $groups as $group ) {
		$html .= '<div class="tp-equip">'
			. '<div class="tp-equip__head"><h3>' . esc_html( $group['title'] ) . '</h3>'
			. '<p>' . esc_html( $group['subtitle'] ) . '</p></div>'
			. '<table><thead><tr>'
			. '<th>' . esc_html( $group['cols'][0] ) . '</th>'
			. '<th>' . esc_html( $group['cols'][1] ) . '</th>'
			. '</tr></thead><tbody>';

		foreach ( $group['items'] as $item ) {
			$name = esc_html( $item['name'] );

			if ( ! empty( $item['en'] ) ) {
				$name .= '<span class="tp-equip__en">' . esc_html( $item['en'] ) . '</span>';
			}

			$html .= '<tr><td>' . $name . '</td><td>' . esc_html( $item['qty'] ) . '</td></tr>';
		}

		$html .= '</tbody></table></div>';
	}

	return $html;
}

/**
 * Các bước quy trình.
 *
 * @param array<int,array{step:string,title:string,desc:string}> $steps Bước.
 */
function tpk_steps( array $steps ): string {
	$html = '<div class="tp-steps">';

	foreach ( $steps as $step ) {
		$html .= '<div class="tp-step">'
			. '<div class="tp-step__num">' . esc_html( $step['step'] ) . '</div>'
			. '<h3>' . esc_html( $step['title'] ) . '</h3>'
			. '<p>' . esc_html( $step['desc'] ) . '</p>'
			. '</div>';
	}

	return $html . '</div>';
}

/**
 * Cơ cấu nhân sự.
 *
 * @param array<int,array{role:string,count:string,desc:string}> $team Nhân sự.
 */
function tpk_team( array $team ): string {
	$html = '<div class="tp-team">';

	foreach ( $team as $member ) {
		$html .= '<div class="tp-team__item">'
			. '<div class="tp-team__count">' . esc_html( $member['count'] ) . '</div>'
			. '<div class="tp-team__role">' . esc_html( $member['role'] ) . '</div>'
			. '<p>' . esc_html( $member['desc'] ) . '</p>'
			. '</div>';
	}

	return $html . '</div>';
}

/** Danh sách có dấu tick. */
function tpk_list( array $items ): string {
	return '<ul class="tp-list">'
		. implode( '', array_map( static fn( $i ) => '<li>' . esc_html( $i ) . '</li>', $items ) )
		. '</ul>';
}

$pages = array(

	// ===== Lĩnh vực hoạt động (trang Năng lực thi công theo hồ sơ PDF) =====
	'linh-vuc-hoat-dong' => array(
		'content' =>
			'<h2 class="tp-lead">Năng lực thi công</h2>'
			. '<p class="tp-lead-desc">Hồ sơ năng lực CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT</p>'
			. tpk_download(
				'Tải hồ sơ năng lực đầy đủ',
				'Bản PDF 21 trang song ngữ Việt – Anh, gồm thông tin pháp nhân, sơ đồ tổ chức, danh mục thiết bị và toàn bộ dự án tiêu biểu (62 MB).',
				'Tải hồ sơ PDF'
			)
			. tpk_stats(
				array(
					array( 'num' => '50+', 'label' => 'Kỹ sư và nhân viên' ),
					array( 'num' => '70+', 'label' => 'Dự án' ),
					array( 'num' => '250+', 'label' => 'Lao động thường xuyên' ),
					array( 'num' => '30', 'label' => 'Loại thiết bị' ),
				)
			)
			. tpk_title( 'Lĩnh vực hoạt động' )
			. tpk_rows(
				array(
					array(
						'image' => 'tp-cap-fields.webp',
						'title' => '01 · Thi công xây dựng dân dụng và công nghiệp – Hạ tầng kỹ thuật',
						'en'    => 'Construction of civil and industrial buildings – technical infrastructure',
						'items' => array( 'Nhà xưởng, kho hàng kín', 'Công trình dân dụng', 'Hạ tầng kỹ thuật khu công nghiệp', 'Sân bê tông, bãi đá' ),
					),
					array(
						'image' => 'tp-prj-duong-991.webp',
						'title' => '02 · Thi công xây dựng công trình giao thông đường bộ và đường thuỷ, hàng hải',
						'en'    => 'Construction transportation infrastructure road and waterway infrastructure, maritime',
						'items' => array( 'Đường giao thông các cấp', 'Cầu trên tuyến', 'Hệ thống thoát nước', 'Phao báo hiệu đường thuỷ nội địa' ),
					),
					array(
						'image' => 'tp-cap-vision.webp',
						'title' => '03 · Tư vấn thiết kế và quản lý dự án xây dựng',
						'en'    => 'Construction project design and management consulting',
						'items' => array( 'Tư vấn thiết kế công trình', 'Quản lý dự án', 'Lập hồ sơ dự thầu', 'Giám sát thi công' ),
					),
					array(
						'image' => 'tp-prj-duong-a3.webp',
						'title' => '04 · Khảo sát, đo đạc & lập mô hình BIM',
						'en'    => 'Surveying, Measurement & BIM Modeling',
						'items' => array( 'Khảo sát địa hình', 'Đo đạc trắc địa', 'Lập mô hình BIM', 'Kiểm tra khối lượng' ),
					),
				)
			)
			. tpk_title( 'Tầm nhìn – Sứ mệnh' )
			. tpk_paras(
				array(
					'TẦM NHÌN — Tín Phát hướng đến trở thành một trong những doanh nghiệp xây dựng – đầu tư – thương mại uy tín tại Việt Nam, không ngừng đổi mới để mang lại các giải pháp thi công chất lượng, an toàn và bền vững cho các công trình trên toàn quốc.',
				)
			)
			. tpk_list(
				array(
					'SỨ MỆNH — Mang đến cho khách hàng các dịch vụ thi công xây dựng chuyên nghiệp, đúng tiến độ và đạt chuẩn chất lượng cao.',
					'Góp phần tạo nên những công trình vững bền, thân thiện môi trường và giá trị lâu dài.',
					'Xây dựng đội ngũ nhân sự có chuyên môn, trách nhiệm và tinh thần phục vụ tận tâm.',
				)
			)
			. tpk_title( 'Sơ đồ tổ chức' )
			. tpk_org(
				array(
					array(
						'class' => 'tp-org__level--top',
						'nodes' => array( array( 'Giám đốc', 'General Director' ) ),
					),
					array(
						'class' => 'tp-org__level--mid',
						'nodes' => array( array( 'Phó Giám đốc', 'Deputy Director' ) ),
					),
					array(
						'class' => 'tp-org__level--dept',
						'nodes' => array(
							array( 'P. Tài chính Kế toán', 'Finance & Accounting Department' ),
							array( 'P. Hành chính – Nhân sự', 'Administration & Human Resources Department' ),
							array( 'P. Dự án – Kế hoạch – Đấu thầu', 'Project – Planning & Bidding Department' ),
							array( 'P. Vật tư – Thiết bị', 'Materials & Equipment Department' ),
						),
					),
					array(
						'class' => 'tp-org__level--site',
						'nodes' => array( array( 'Các Ban chỉ huy công trường thi công', 'Construction Site Management Teams' ) ),
					),
				)
			)
			. tpk_title( 'Năng lực nhân sự' )
			. tpk_rows(
				array(
					array(
						'image' => 'tp-cap-hr.webp',
						'title' => 'Đầu tư phát triển nguồn nhân lực',
						'en'    => 'Investing in human resources – investing in people is the foundation of sustainable development.',
						'items' => array( '50+ kỹ sư và nhân viên', '70+ dự án đã và đang triển khai', '250+ lao động thường xuyên' ),
					),
				)
			)
			. tpk_edu(
				array(
					array( 'Trình độ đại học trở lên', 'Bachelor’s degree or higher', 70 ),
					array( 'Trình độ cao đẳng', 'College’s degree', 20 ),
					array( 'Trình độ trung cấp', 'Vocational degree', 10 ),
				)
			)
			. do_shortcode( '[tinphat_motto title="Đơn vị tổng thầu thi công xây dựng hàng đầu Việt Nam" sub="Vietnam’s leading general construction contractor"]' ),
		'en'      => array(
			'slug'    => 'what-we-do',
			'content' =>
				'<h2 class="tp-lead">Construction capability</h2>'
				. '<p class="tp-lead-desc">Company profile — TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED</p>'
				. tpk_download(
					'Download the full company profile',
					'A 21-page bilingual PDF covering legal details, the organization chart, the equipment list and every featured project (62 MB).',
					'Download PDF'
				)
				. tpk_stats(
					array(
						array( 'num' => '50+', 'label' => 'Engineers and staff' ),
						array( 'num' => '70+', 'label' => 'Projects' ),
						array( 'num' => '250+', 'label' => 'Permanent employees' ),
						array( 'num' => '30', 'label' => 'Equipment types' ),
					)
				)
				. tpk_title( 'Field of operation' )
				. tpk_rows(
					array(
						array(
							'image' => 'tp-cap-fields.webp',
							'title' => '01 · Construction of civil and industrial buildings – technical infrastructure',
							'en'    => '',
							'items' => array( 'Factories and closed warehouses', 'Civil works', 'Industrial park infrastructure', 'Concrete yards and rock areas' ),
						),
						array(
							'image' => 'tp-prj-duong-991.webp',
							'title' => '02 · Construction of road and waterway transport infrastructure, maritime',
							'en'    => '',
							'items' => array( 'Roads of all grades', 'Bridges on route', 'Drainage systems', 'Inland waterway buoy systems' ),
						),
						array(
							'image' => 'tp-cap-vision.webp',
							'title' => '03 · Construction project design and management consulting',
							'en'    => '',
							'items' => array( 'Design consultancy', 'Project management', 'Tender documentation', 'Construction supervision' ),
						),
						array(
							'image' => 'tp-prj-duong-a3.webp',
							'title' => '04 · Surveying, measurement & BIM modeling',
							'en'    => '',
							'items' => array( 'Topographic surveying', 'Geodetic measurement', 'BIM modeling', 'Quantity verification' ),
						),
					)
				)
				. tpk_title( 'Vision – Mission' )
				. tpk_paras(
					array(
						'VISION — Tin Phat aims to become a reputable construction – investment – trading enterprise in Vietnam, continuously innovating to deliver high-quality, safe and sustainable construction solutions for projects nationwide.',
					)
				)
				. tpk_list(
					array(
						'MISSION — Provide clients with professional construction services that meet schedule and deliver high-quality standards.',
						'Contribute to creating durable, environmentally friendly and long-lasting projects.',
						'Build a workforce with expertise, responsibility and dedication to service excellence.',
					)
				)
				. tpk_title( 'Organization chart' )
				. tpk_org(
					array(
						array(
							'class' => 'tp-org__level--top',
							'nodes' => array( array( 'General Director', 'Giám đốc' ) ),
						),
						array(
							'class' => 'tp-org__level--mid',
							'nodes' => array( array( 'Deputy Director', 'Phó Giám đốc' ) ),
						),
						array(
							'class' => 'tp-org__level--dept',
							'nodes' => array(
								array( 'Finance & Accounting Department', 'P. Tài chính Kế toán' ),
								array( 'Administration & Human Resources', 'P. Hành chính – Nhân sự' ),
								array( 'Project – Planning & Bidding', 'P. Dự án – Kế hoạch – Đấu thầu' ),
								array( 'Materials & Equipment Department', 'P. Vật tư – Thiết bị' ),
							),
						),
						array(
							'class' => 'tp-org__level--site',
							'nodes' => array( array( 'Construction Site Management Teams', 'Các Ban chỉ huy công trường' ) ),
						),
					)
				)
				. tpk_title( 'Human resources' )
				. tpk_rows(
					array(
						array(
							'image' => 'tp-cap-hr.webp',
							'title' => 'Investing in human resources',
							'en'    => 'Investing in people is the foundation of sustainable development.',
							'items' => array( '50+ engineers and staff', '70+ projects completed and under way', '250+ permanent employees' ),
						),
					)
				)
				. tpk_edu(
					array(
						array( 'Bachelor’s degree or higher', '', 70 ),
						array( 'College’s degree', '', 20 ),
						array( 'Vocational degree', '', 10 ),
					)
				)
				. do_shortcode( '[tinphat_motto title="Vietnam’s leading general construction contractor" sub="Đơn vị tổng thầu thi công xây dựng hàng đầu Việt Nam"]' ),
		),
	),

	// ===== Máy móc & Thiết bị =====
	'may-moc-thiet-bi' => array(
		'content' =>
			'<h2 class="tp-lead">Năng lực thiết bị</h2>'
			. '<p class="tp-lead-desc">30 loại máy móc, thiết bị thuộc sở hữu của Tín Phát, sẵn sàng huy động cho công trình</p>'
			. tpk_paras(
				array(
					'Nhằm mang đến cho khách hàng những sản phẩm và dịch vụ chất lượng cao nhất, Công ty đã không ngừng đầu tư vào hệ thống máy móc, thiết bị mới, hiện đại và có công suất lớn từ các thương hiệu uy tín trên thế giới.',
					'Hệ thống trang thiết bị này không chỉ nâng cao năng suất và hiệu quả thi công mà còn đảm bảo an toàn cho người vận hành, với quy trình sử dụng được kiểm soát nghiêm ngặt theo tiêu chuẩn an toàn lao động.',
				)
			)
			. tpk_equipment(
				array(
					array(
						'title'    => 'Thiết bị thi công và vận tải',
						'subtitle' => 'Lu, xúc, đào, trộn bê tông, sà lan, tàu kéo',
						'cols'     => array( 'Tên thiết bị', 'Số lượng' ),
						'items'    => array(
							array( 'name' => 'Máy lu', 'en' => 'Road roller', 'qty' => '01' ),
							array( 'name' => 'Máy xúc', 'en' => 'Excavator', 'qty' => '02' ),
							array( 'name' => 'Xe ben', 'en' => 'Dump truck', 'qty' => '03' ),
							array( 'name' => 'Máy đào gầu', 'en' => 'Excavator', 'qty' => '04' ),
							array( 'name' => 'Xe trộn bê tông', 'en' => 'Concrete tank truck', 'qty' => '05' ),
							array( 'name' => 'Đầm bàn', 'en' => 'Vibrating table', 'qty' => '06' ),
							array( 'name' => 'Máy tời thép', 'en' => 'Steel winch', 'qty' => '07' ),
							array( 'name' => 'Máy cắt uốn thép', 'en' => 'Rebar cutting machine', 'qty' => '08' ),
							array( 'name' => 'Máy trắc đạc điện tử', 'en' => 'Electronic total station', 'qty' => '09' ),
							array( 'name' => 'Máy đánh mặt', 'en' => 'Screed machine', 'qty' => '10' ),
							array( 'name' => 'Máy toàn đạc', 'en' => 'Total station', 'qty' => '11' ),
							array( 'name' => 'Máy thủy bình', 'en' => 'Spirit level', 'qty' => '12' ),
							array( 'name' => 'Băng tải vận chuyển', 'en' => 'Conveyor belt', 'qty' => '13' ),
							array( 'name' => 'Máy hàn', 'en' => 'Welding machine', 'qty' => '14' ),
							array( 'name' => 'Sà lan', 'en' => 'Barge', 'qty' => '02' ),
							array( 'name' => 'Tàu kéo', 'en' => 'Tugboat', 'qty' => '02' ),
						),
					),
					array(
						'title'    => 'Thiết bị nâng hạ và hiện trường',
						'subtitle' => 'Ủi, cẩu, phát điện, giàn giáo, cốp pha',
						'cols'     => array( 'Tên thiết bị', 'Số lượng' ),
						'items'    => array(
							array( 'name' => 'Máy ủi', 'en' => 'Bulldozer', 'qty' => '01' ),
							array( 'name' => 'Xe xúc lật gầu', 'en' => 'Front loader', 'qty' => '02' ),
							array( 'name' => 'Xe cào bóc', 'en' => 'Road stabilizer', 'qty' => '03' ),
							array( 'name' => 'Máy phát điện', 'en' => 'Generator', 'qty' => '04' ),
							array( 'name' => 'Máy bơm nước', 'en' => 'Water pump', 'qty' => '05' ),
							array( 'name' => 'Xe dục búa', 'en' => 'Jack hammer excavator', 'qty' => '06' ),
							array( 'name' => 'Cẩu tháp', 'en' => 'Tower crane', 'qty' => '07' ),
							array( 'name' => 'Máy nén khí', 'en' => 'Air compressor', 'qty' => '08' ),
							array( 'name' => 'Cẩu bánh xích', 'en' => 'Crawler crane', 'qty' => '02' ),
							array( 'name' => 'Cẩu bánh hơi', 'en' => 'Mobile crane', 'qty' => '10' ),
							array( 'name' => 'Máy vận thăng', 'en' => 'Elevator / hoist', 'qty' => '11' ),
							array( 'name' => 'Hệ giàn giáo nêm', 'en' => 'Scaffolding', 'qty' => '12' ),
							array( 'name' => 'Xà gồ hộp', 'en' => 'Square purlin', 'qty' => '13' ),
							array( 'name' => 'Cốp pha thép', 'en' => 'Steel formwork', 'qty' => '13' ),
						),
					),
				)
			)
			. tpk_title( 'Năng lực nhân sự' )
			. tpk_paras(
				array(
					'Đầu tư phát triển nguồn nhân lực – đầu tư cho con người là nền tảng của sự phát triển bền vững.',
				)
			)
			. tpk_team(
				array(
					array( 'count' => '50+', 'role' => 'Kỹ sư và nhân viên', 'desc' => 'Engineers and Staff — đội ngũ kỹ thuật nòng cốt của công ty' ),
					array( 'count' => '70+', 'role' => 'Dự án', 'desc' => 'Projects — số dự án đã và đang triển khai' ),
					array( 'count' => '250+', 'role' => 'Lao động thường xuyên', 'desc' => 'Permanent Employees — công nhân tay nghề gắn bó dài hạn' ),
					array( 'count' => '70%', 'role' => 'Trình độ đại học trở lên', 'desc' => 'Bachelor’s degree or higher' ),
					array( 'count' => '20%', 'role' => 'Trình độ cao đẳng', 'desc' => 'College’s degree' ),
					array( 'count' => '10%', 'role' => 'Trình độ trung cấp', 'desc' => 'Vocational degree' ),
				)
			)
			. tpk_title( 'Sơ đồ tổ chức' )
			. tpk_list(
				array(
					'Giám đốc',
					'Phó Giám đốc',
					'P. Tài chính Kế toán',
					'P. Hành chính – Nhân sự',
					'P. Dự án – Kế hoạch – Đấu thầu',
					'P. Vật tư – Thiết bị',
					'Các Ban chỉ huy công trường thi công',
				)
			),
		'en'      => array(
			'slug'    => 'plant-equipment',
			'content' =>
				'<h2 class="tp-lead">Equipment capability</h2>'
				. '<p class="tp-lead-desc">30 types of plant and equipment owned by Tin Phat, ready to mobilise to site</p>'
				. tpk_paras(
					array(
						'In order to provide customers with the highest quality products and services, the Company has continuously invested in new, modern equipment with high capacity from globally renowned brands.',
						'This machinery and equipment not only enhance productivity and performance but also ensure safety for operators through strict procedures that comply with occupational safety standards.',
					)
				)
				. tpk_equipment(
					array(
						array(
							'title'    => 'Construction and transport equipment',
							'subtitle' => 'Rollers, excavators, mixers, barges, tugboats',
							'cols'     => array( 'Equipment', 'Quantity' ),
							'items'    => array(
								array( 'name' => 'Road roller', 'en' => '', 'qty' => '01' ),
								array( 'name' => 'Excavator', 'en' => '', 'qty' => '02' ),
								array( 'name' => 'Dump truck', 'en' => '', 'qty' => '03' ),
								array( 'name' => 'Excavator', 'en' => '', 'qty' => '04' ),
								array( 'name' => 'Concrete tank truck', 'en' => '', 'qty' => '05' ),
								array( 'name' => 'Vibrating table', 'en' => '', 'qty' => '06' ),
								array( 'name' => 'Steel winch', 'en' => '', 'qty' => '07' ),
								array( 'name' => 'Rebar cutting machine', 'en' => '', 'qty' => '08' ),
								array( 'name' => 'Electronic total station', 'en' => '', 'qty' => '09' ),
								array( 'name' => 'Screed machine', 'en' => '', 'qty' => '10' ),
								array( 'name' => 'Total station', 'en' => '', 'qty' => '11' ),
								array( 'name' => 'Spirit level', 'en' => '', 'qty' => '12' ),
								array( 'name' => 'Conveyor belt', 'en' => '', 'qty' => '13' ),
								array( 'name' => 'Welding machine', 'en' => '', 'qty' => '14' ),
								array( 'name' => 'Barge', 'en' => '', 'qty' => '02' ),
								array( 'name' => 'Tugboat', 'en' => '', 'qty' => '02' ),
							),
						),
						array(
							'title'    => 'Lifting and site equipment',
							'subtitle' => 'Dozers, cranes, generators, scaffolding, formwork',
							'cols'     => array( 'Equipment', 'Quantity' ),
							'items'    => array(
								array( 'name' => 'Bulldozer', 'en' => '', 'qty' => '01' ),
								array( 'name' => 'Front loader', 'en' => '', 'qty' => '02' ),
								array( 'name' => 'Road stabilizer', 'en' => '', 'qty' => '03' ),
								array( 'name' => 'Generator', 'en' => '', 'qty' => '04' ),
								array( 'name' => 'Water pump', 'en' => '', 'qty' => '05' ),
								array( 'name' => 'Jack hammer excavator', 'en' => '', 'qty' => '06' ),
								array( 'name' => 'Tower crane', 'en' => '', 'qty' => '07' ),
								array( 'name' => 'Air compressor', 'en' => '', 'qty' => '08' ),
								array( 'name' => 'Crawler crane', 'en' => '', 'qty' => '02' ),
								array( 'name' => 'Mobile crane', 'en' => '', 'qty' => '10' ),
								array( 'name' => 'Elevator / hoist', 'en' => '', 'qty' => '11' ),
								array( 'name' => 'Scaffolding', 'en' => '', 'qty' => '12' ),
								array( 'name' => 'Square purlin', 'en' => '', 'qty' => '13' ),
								array( 'name' => 'Steel formwork', 'en' => '', 'qty' => '13' ),
							),
						),
					)
				)
				. tpk_title( 'Human resources' )
				. tpk_paras(
					array(
						'Investing in human resources – investing in people is the foundation of sustainable development.',
					)
				)
				. tpk_team(
					array(
						array( 'count' => '50+', 'role' => 'Engineers and staff', 'desc' => 'The company’s core technical team' ),
						array( 'count' => '70+', 'role' => 'Projects', 'desc' => 'Projects completed and under way' ),
						array( 'count' => '250+', 'role' => 'Permanent employees', 'desc' => 'Skilled workers with long-term commitment' ),
						array( 'count' => '70%', 'role' => 'Bachelor’s degree or higher', 'desc' => 'Highest qualification level' ),
						array( 'count' => '20%', 'role' => 'College’s degree', 'desc' => 'Second qualification level' ),
						array( 'count' => '10%', 'role' => 'Vocational degree', 'desc' => 'Third qualification level' ),
					)
				)
				. tpk_title( 'Organization chart' )
				. tpk_list(
					array(
						'General Director',
						'Deputy Director',
						'Finance & Accounting Department',
						'Administration & Human Resources Department',
						'Project – Planning & Bidding Department',
						'Materials & Equipment Department',
						'Construction Site Management Teams',
					)
				),
		),
	),

	// ===== Quy trình thi công =====
	'quy-trinh-thi-cong' => array(
		'content' =>
			'<h2 class="tp-lead">Quy trình thi công 6 bước</h2>'
			. '<p class="tp-lead-desc">Minh bạch từ khảo sát đến bàn giao, Khách hàng nắm được tiến độ ở mọi giai đoạn</p>'
			. tpk_steps(
				array(
					array( 'step' => '01', 'title' => 'Khảo sát & tư vấn', 'desc' => 'Khảo sát thực địa, tư vấn giải pháp và lập dự toán chi tiết.' ),
					array( 'step' => '02', 'title' => 'Thiết kế', 'desc' => 'Thiết kế bản vẽ kiến trúc, kết cấu và hệ thống kỹ thuật.' ),
					array( 'step' => '03', 'title' => 'Ký kết hợp đồng', 'desc' => 'Thoả thuận điều khoản, ký hợp đồng và thanh toán theo tiến độ.' ),
					array( 'step' => '04', 'title' => 'Chuẩn bị mặt bằng', 'desc' => 'San lấp, đào móng, chuẩn bị vật tư thiết bị.' ),
					array( 'step' => '05', 'title' => 'Thi công xây dựng', 'desc' => 'Thi công theo đúng bản vẽ, tiến độ và kiểm soát chất lượng.' ),
					array( 'step' => '06', 'title' => 'Nghiệm thu & bàn giao', 'desc' => 'Nghiệm thu công trình, hoàn thiện hồ sơ và bàn giao cho chủ đầu tư.' ),
				)
			)
			. tpk_title( 'Cam kết trong suốt quá trình' )
			. tpk_list(
				array(
					'Báo giá minh bạch, không phát sinh ngoài hợp đồng',
					'Giám sát chất lượng ở từng công đoạn',
					'Báo cáo tiến độ định kỳ cho chủ đầu tư',
					'An toàn lao động tuân thủ quy định hiện hành',
					'Bảo hành công trình dài hạn sau bàn giao',
				)
			),
		'en'      => array(
			'slug'    => 'construction-process',
			'content' =>
				'<h2 class="tp-lead">A six-step construction process</h2>'
				. '<p class="tp-lead-desc">Transparent from survey to handover, so clients know where the project stands at every stage</p>'
				. tpk_steps(
					array(
						array( 'step' => '01', 'title' => 'Survey & consultancy', 'desc' => 'Site survey, solution advice and a detailed cost estimate.' ),
						array( 'step' => '02', 'title' => 'Design', 'desc' => 'Architectural, structural and building-services drawings.' ),
						array( 'step' => '03', 'title' => 'Contract signing', 'desc' => 'Agreeing terms, signing the contract and staged payments.' ),
						array( 'step' => '04', 'title' => 'Site preparation', 'desc' => 'Levelling, foundation excavation, materials and plant mobilisation.' ),
						array( 'step' => '05', 'title' => 'Construction', 'desc' => 'Building to the drawings and programme with quality control throughout.' ),
						array( 'step' => '06', 'title' => 'Acceptance & handover', 'desc' => 'Inspection, completion of records and handover to the investor.' ),
					)
				)
				. tpk_title( 'What we commit to throughout' )
				. tpk_list(
					array(
						'Transparent quotations with no charges outside the contract',
						'Quality supervision at every stage',
						'Regular progress reporting to the investor',
						'Occupational safety in line with current regulations',
						'Long-term warranty after handover',
					)
				),
		),
	),

	// ===== Chứng chỉ & Giấy phép =====
	'chung-chi-giay-phep' => array(
		'content' =>
			'<h2 class="tp-lead">Cơ sở pháp lý và chứng chỉ</h2>'
			. '<p class="tp-lead-desc">Hồ sơ pháp nhân đầy đủ cho hoạt động thi công xây dựng</p>'
			. tpk_paras(
				array(
					'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT hoạt động theo đúng quy định pháp luật về xây dựng, với hệ thống hồ sơ pháp lý và chứng chỉ được duy trì, cập nhật đầy đủ.',
				)
			)
			. tpk_legal( 'Cơ sở pháp lý và chứng chỉ — trích hồ sơ năng lực Tín Phát' )
			. tpk_title( 'Thông tin pháp nhân' )
			. '<table class="tp-company-table"><tbody>'
			. '<tr><td>Tên công ty</td><td>CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT</td></tr>'
			. '<tr><td>Tên tiếng Anh</td><td>TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED</td></tr>'
			. '<tr><td>Tên viết tắt</td><td>TIN PHAT CTI CO., LTD</td></tr>'
			. '<tr><td>Tên giao dịch</td><td>TIN PHAT CTI CO., LTD</td></tr>'
			. '<tr><td>Mã số thuế</td><td>3502302391</td></tr>'
			. '<tr><td>Vốn điều lệ</td><td>3.000.000.000 VNĐ</td></tr>'
			. '<tr><td>Đại diện</td><td>Ông Bùi Đức Hùng — Giám đốc</td></tr>'
			. '<tr><td>Trụ sở chính</td><td>106 Nam Kỳ Khởi Nghĩa, phường Vũng Tàu, thành phố Hồ Chí Minh</td></tr>'
			. '<tr><td>Hotline</td><td>0326 702 600</td></tr>'
			. '<tr><td>Email</td><td>congtytinphatvungtau@gmail.com</td></tr>'
			. '<tr><td>Website</td><td>tinphatcons.com</td></tr>'
			. '</tbody></table>'
			. tpk_title( 'Hồ sơ năng lực' )
			. tpk_paras(
				array(
					'Giấy chứng nhận đăng ký doanh nghiệp, chứng chỉ năng lực hoạt động xây dựng và hồ sơ pháp lý đầy đủ được cung cấp theo yêu cầu của Chủ đầu tư trong quá trình dự thầu.',
					'Quý khách vui lòng liên hệ hotline 0326 702 600 hoặc email congtytinphatvungtau@gmail.com để nhận bản hồ sơ năng lực đầy đủ.',
				)
			),
		'en'      => array(
			'slug'    => 'certificates-licences',
			'content' =>
				'<h2 class="tp-lead">Legal basis and certificates</h2>'
				. '<p class="tp-lead-desc">A complete corporate file for construction operations</p>'
				. tpk_paras(
					array(
						'TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED operates in full compliance with Vietnamese construction law, maintaining a complete and current set of legal documents and certificates.',
					)
				)
				. tpk_legal( 'Legal basis and certificates — from the Tin Phat company profile' )
				. tpk_title( 'Company information' )
				. '<table class="tp-company-table"><tbody>'
				. '<tr><td>Company name</td><td>TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED</td></tr>'
				. '<tr><td>Vietnamese name</td><td>CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT</td></tr>'
				. '<tr><td>Short name</td><td>TIN PHAT CTI CO., LTD</td></tr>'
				. '<tr><td>Trade name</td><td>TIN PHAT CTI CO., LTD</td></tr>'
				. '<tr><td>Tax code</td><td>3502302391</td></tr>'
				. '<tr><td>Charter capital</td><td>VND 3,000,000,000</td></tr>'
				. '<tr><td>Representative</td><td>Mr. Bui Duc Hung — Director</td></tr>'
				. '<tr><td>Main office</td><td>106 Nam Ky Khoi Nghia, Vung Tau Ward, Ho Chi Minh City</td></tr>'
				. '<tr><td>Hotline</td><td>0326 702 600</td></tr>'
				. '<tr><td>Email</td><td>congtytinphatvungtau@gmail.com</td></tr>'
				. '<tr><td>Website</td><td>tinphatcons.com</td></tr>'
				. '</tbody></table>'
				. tpk_title( 'Capability profile' )
				. tpk_paras(
					array(
						'Business registration certificates, construction capability certificates and the full legal file are provided at the Investor\'s request during tendering.',
						'Please contact our hotline on 0326 702 600 or email congtytinphatvungtau@gmail.com to receive the complete capability profile.',
					)
				),
		),
	),

);


/**
 * Ảnh cơ sở pháp lý (trang đôi 08–09 của hồ sơ năng lực).
 *
 * Render 2200px để nét trên màn Retina (hiển thị ~1100px, DPR 2).
 *
 * LƯU Ý: ảnh ở độ phân giải này ĐỌC ĐƯỢC số CCCD, số tài khoản ngân hàng
 * và địa chỉ thường trú của người đại diện. Khách hàng đã xác nhận đồng ý
 * công khai. Nếu đổi ý, giảm dpi trong script tạo ảnh hoặc bôi đen vùng
 * nhạy cảm trước khi đăng.
 *
 * @param string $caption Chú thích dưới ảnh.
 */
function tpk_legal( string $caption ): string {
	return '<figure class="tp-legal">'
		. '<img src="' . esc_url( tpk_img( 'tp-legal-page.webp' ) ) . '"'
		. ' alt="' . esc_attr( $caption ) . '"'
		. ' width="2200" height="1560" loading="lazy" decoding="async">'
		. '<figcaption>' . esc_html( $caption ) . '</figcaption>'
		. '</figure>';
}

/**
 * Hàng ảnh + nội dung, xen kẽ trái/phải theo bố cục hồ sơ năng lực.
 *
 * @param array<int,array{image:string,title:string,en:string,items:array<int,string>}> $rows Hàng.
 */
function tpk_rows( array $rows ): string {
	$html = '';

	foreach ( $rows as $i => $row ) {
		$flip = 1 === $i % 2 ? ' tp-cap-row--flip' : '';

		$html .= '<div class="tp-cap-row' . $flip . '">'
			. '<div class="tp-cap-row__media">'
			. '<img src="' . esc_url( tpk_img( $row['image'] ) ) . '" alt="' . esc_attr( $row['title'] ) . '"'
			. ' width="960" height="600" loading="lazy" decoding="async"></div>'
			. '<div class="tp-cap-row__body"><h3>' . esc_html( $row['title'] ) . '</h3>'
			. ( '' !== $row['en'] ? '<p class="tp-cap-row__en">' . esc_html( $row['en'] ) . '</p>' : '' )
			. '<ul>'
			. implode( '', array_map( static fn( $x ) => '<li>' . esc_html( $x ) . '</li>', $row['items'] ) )
			. '</ul></div></div>';
	}

	return $html;
}

/**
 * Sơ đồ tổ chức dạng cây (giám đốc → phó GĐ → phòng ban → ban chỉ huy).
 *
 * @param array<int,array{class:string,nodes:array<int,array{0:string,1:string}>}> $levels Các cấp.
 */
function tpk_org( array $levels ): string {
	$html  = '<div class="tp-org">';
	$total = count( $levels );

	foreach ( $levels as $i => $level ) {
		$html .= '<div class="tp-org__level ' . esc_attr( $level['class'] ) . '">';

		foreach ( $level['nodes'] as $node ) {
			$html .= '<div class="tp-org__node"><strong>' . esc_html( $node[0] ) . '</strong>'
				. '<span>' . esc_html( $node[1] ) . '</span></div>';
		}

		$html .= '</div>';

		if ( $i < $total - 1 ) {
			$html .= '<div class="tp-org__connector"></div>';
		}
	}

	return $html . '</div>';
}

/**
 * Biểu đồ trình độ nhân sự dạng thanh ngang.
 *
 * @param array<int,array{0:string,1:string,2:int}> $items Nhãn VI, nhãn EN, phần trăm.
 */
function tpk_edu( array $items ): string {
	$html = '<div class="tp-edu">';

	foreach ( $items as $item ) {
		$html .= '<div class="tp-edu__item">'
			. '<div class="tp-edu__head"><span>' . esc_html( $item[0] ) . ' <em>' . esc_html( $item[1] ) . '</em></span>'
			. '<span>' . (int) $item[2] . '%</span></div>'
			. '<div class="tp-edu__bar"><div class="tp-edu__fill" style="width:' . (int) $item[2] . '%"></div></div>'
			. '</div>';
	}

	return $html . '</div>';
}

/**
 * Khối tải hồ sơ năng lực PDF.
 *
 * @param string $title Tiêu đề.
 * @param string $desc  Mô tả (kèm dung lượng).
 * @param string $label Nhãn nút.
 */
function tpk_download( string $title, string $desc, string $label ): string {
	$url = content_url( 'uploads/tinphat-docs/ho-so-nang-luc-tin-phat.pdf' );

	return '<div class="tp-download">'
		. '<div class="tp-download__text"><h3>' . esc_html( $title ) . '</h3>'
		. '<p>' . esc_html( $desc ) . '</p></div>'
		. '<a class="tp-download__btn" href="' . esc_url( $url ) . '" download>'
		. '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"'
		. ' stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
		. '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>'
		. '<path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>'
		. esc_html( $label ) . '</a></div>';
}

/** Tìm trang theo slug, lọc theo ngôn ngữ. */
function tpk_find_page( string $slug, string $lang ): ?WP_Post {
	foreach ( get_posts(
		array(
			'post_type'      => 'page',
			'name'           => $slug,
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		)
	) as $page ) {
		if ( ! function_exists( 'pll_get_post_language' ) || pll_get_post_language( $page->ID ) === $lang ) {
			return $page;
		}
	}

	return null;
}

$updated = 0;

foreach ( $pages as $slug => $data ) {
	$page = tpk_find_page( $slug, 'vi' );

	if ( $page instanceof WP_Post ) {
		wp_update_post( array( 'ID' => $page->ID, 'post_content' => $data['content'] ) );
		WP_CLI::log( "  vi/{$slug}" );
		++$updated;
	} else {
		WP_CLI::warning( "  không tìm thấy vi/{$slug}" );
	}

	if ( isset( $data['en'] ) ) {
		$en_page = tpk_find_page( $data['en']['slug'], 'en' );

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
