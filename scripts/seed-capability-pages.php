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

	// ===== Lĩnh vực hoạt động =====
	'linh-vuc-hoat-dong' => array(
		'content' =>
			'<h2 class="tp-lead">Năng lực thi công đa dạng</h2>'
			. '<p class="tp-lead-desc">Dân dụng, công nghiệp và thương mại — từ nhà ở riêng lẻ đến nhà máy quy mô lớn</p>'
			. tpk_stats(
				array(
					array( 'num' => '100+', 'label' => 'Dự án hoàn thành' ),
					array( 'num' => '150+', 'label' => 'Đội ngũ nhân sự' ),
					array( 'num' => '10+', 'label' => 'Năm kinh nghiệm' ),
					array( 'num' => '100%', 'label' => 'Cam kết chất lượng' ),
				)
			)
			. tpk_paras(
				array(
					'Với hơn 10 năm kinh nghiệm, đội ngũ chuyên nghiệp và trang thiết bị hiện đại, Tín Phát nhận thi công đa dạng loại hình công trình với quy mô khác nhau trên địa bàn Thành phố Hồ Chí Minh và các tỉnh lân cận.',
				)
			)
			. tpk_title( 'Lĩnh vực thi công' )
			. tpk_caps(
				array(
					array(
						'title' => 'Xây dựng dân dụng',
						'scale' => 'Quy mô: từ 100m² đến 10.000m²',
						'image' => 'project-01-Emerald-Boulevard-Le-Phong.webp',
						'items' => array( 'Nhà ở riêng lẻ (1-5 tầng)', 'Biệt thự cao cấp', 'Nhà phố thương mại', 'Chung cư mini', 'Khu đô thị', 'Cải tạo, nâng cấp nhà cũ' ),
					),
					array(
						'title' => 'Xây dựng công nghiệp',
						'scale' => 'Quy mô: từ 500m² đến 50.000m²',
						'image' => 'project-16-Cot-dien-gio-tai-nha-may-Phu-Lac.webp',
						'items' => array( 'Nhà xưởng sản xuất', 'Nhà kho, logistics', 'Nhà máy công nghiệp', 'Trạm xử lý môi trường', 'Hạ tầng kỹ thuật', 'Khu công nghiệp' ),
					),
					array(
						'title' => 'Xây dựng thương mại',
						'scale' => 'Quy mô: từ 200m² đến 20.000m²',
						'image' => 'project-09-UOA.webp',
						'items' => array( 'Văn phòng làm việc', 'Trung tâm thương mại', 'Showroom, cửa hàng', 'Khách sạn, resort', 'Nhà hàng, cafe', 'Trung tâm hội nghị' ),
					),
				)
			)
			. tpk_title( 'Năng lực kỹ thuật' )
			. tpk_caps(
				array(
					array(
						'title' => 'Thiết kế & tư vấn',
						'scale' => 'Đội ngũ kiến trúc sư và kỹ sư giàu kinh nghiệm',
						'items' => array( 'Thiết kế kiến trúc', 'Thiết kế kết cấu', 'Thiết kế hệ thống M&E', 'Tư vấn giải pháp tối ưu', 'Dự toán chi phí chi tiết' ),
					),
					array(
						'title' => 'Thi công & quản lý',
						'scale' => 'Quy trình chuyên nghiệp, quản lý chặt chẽ',
						'items' => array( 'Quản lý dự án chuyên nghiệp', 'Giám sát chất lượng 24/7', 'Kiểm soát tiến độ nghiêm ngặt', 'Báo cáo định kỳ cho chủ đầu tư', 'Xử lý vấn đề phát sinh nhanh chóng' ),
					),
					array(
						'title' => 'Chất lượng & an toàn',
						'scale' => 'Cam kết chất lượng và an toàn tuyệt đối',
						'items' => array( 'Kiểm tra chất lượng từng công đoạn', 'Vật liệu đạt chuẩn chất lượng', 'Tuân thủ quy chuẩn xây dựng', 'An toàn lao động tuyệt đối', 'Bảo hành công trình dài hạn' ),
					),
				)
			),
		'en'      => array(
			'slug'    => 'what-we-do',
			'content' =>
				'<h2 class="tp-lead">A broad construction capability</h2>'
				. '<p class="tp-lead-desc">Residential, industrial and commercial — from single houses to large-scale plants</p>'
				. tpk_stats(
					array(
						array( 'num' => '100+', 'label' => 'Completed projects' ),
						array( 'num' => '150+', 'label' => 'Team members' ),
						array( 'num' => '10+', 'label' => 'Years of experience' ),
						array( 'num' => '100%', 'label' => 'Quality commitment' ),
					)
				)
				. tpk_paras(
					array(
						'With over 10 years of experience, a professional team and modern equipment, Tin Phat builds a wide range of project types and scales across Ho Chi Minh City and neighbouring provinces.',
					)
				)
				. tpk_title( 'What we build' )
				. tpk_caps(
					array(
						array(
							'title' => 'Residential construction',
							'scale' => 'Scale: 100m² to 10,000m²',
							'image' => 'project-01-Emerald-Boulevard-Le-Phong.webp',
							'items' => array( 'Individual houses (1-5 storeys)', 'Premium villas', 'Commercial townhouses', 'Small apartment buildings', 'Urban areas', 'Renovation and upgrades' ),
						),
						array(
							'title' => 'Industrial construction',
							'scale' => 'Scale: 500m² to 50,000m²',
							'image' => 'project-16-Cot-dien-gio-tai-nha-may-Phu-Lac.webp',
							'items' => array( 'Manufacturing workshops', 'Warehousing and logistics', 'Industrial plants', 'Environmental treatment stations', 'Technical infrastructure', 'Industrial parks' ),
						),
						array(
							'title' => 'Commercial construction',
							'scale' => 'Scale: 200m² to 20,000m²',
							'image' => 'project-09-UOA.webp',
							'items' => array( 'Offices', 'Shopping centres', 'Showrooms and shops', 'Hotels and resorts', 'Restaurants and cafés', 'Conference centres' ),
						),
					)
				)
				. tpk_title( 'Technical capability' )
				. tpk_caps(
					array(
						array(
							'title' => 'Design & consultancy',
							'scale' => 'Experienced architects and engineers',
							'items' => array( 'Architectural design', 'Structural design', 'M&E systems design', 'Optimal solution advice', 'Detailed cost estimates' ),
						),
						array(
							'title' => 'Construction & management',
							'scale' => 'A professional, tightly managed process',
							'items' => array( 'Professional project management', 'Quality supervision 24/7', 'Strict schedule control', 'Regular reporting to the investor', 'Fast resolution of issues' ),
						),
						array(
							'title' => 'Quality & safety',
							'scale' => 'An absolute commitment to quality and safety',
							'items' => array( 'Quality checks at every stage', 'Certified materials', 'Compliance with building codes', 'Absolute occupational safety', 'Long-term warranty' ),
						),
					)
				),
		),
	),

	// ===== Máy móc & Thiết bị =====
	'may-moc-thiet-bi' => array(
		'content' =>
			'<h2 class="tp-lead">Máy móc và thiết bị thi công</h2>'
			. '<p class="tp-lead-desc">Thiết bị thuộc sở hữu của Tín Phát, sẵn sàng huy động cho công trình</p>'
			. tpk_paras(
				array(
					'Tín Phát chủ động về máy móc thi công nên không phụ thuộc vào đơn vị cho thuê — đây là yếu tố giúp chúng tôi giữ đúng tiến độ đã cam kết. Toàn bộ thiết bị được bảo dưỡng định kỳ và vận hành bởi đội ngũ có chứng chỉ.',
				)
			)
			. tpk_equipment(
				array(
					array(
						'title'    => 'Thiết bị nặng & san lấp',
						'subtitle' => 'Lu, đào, ủi, san nền',
						'cols'     => array( 'Thiết bị', 'Số lượng' ),
						'items'    => array(
							array( 'name' => 'Máy lu', 'en' => 'Road roller', 'qty' => '01' ),
							array( 'name' => 'Máy xúc', 'en' => 'Excavator', 'qty' => '02' ),
							array( 'name' => 'Máy đào gầu', 'en' => 'Excavator', 'qty' => '04' ),
							array( 'name' => 'Máy ủi', 'en' => 'Bulldozer', 'qty' => '01' ),
							array( 'name' => 'Xe xúc lật gầu', 'en' => 'Front loader', 'qty' => '02' ),
						),
					),
					array(
						'title'    => 'Vận tải, bê tông & cẩu',
						'subtitle' => 'Ben, trộn, cẩu các loại',
						'cols'     => array( 'Thiết bị', 'Số lượng' ),
						'items'    => array(
							array( 'name' => 'Xe ben', 'en' => 'Dump truck', 'qty' => '03' ),
							array( 'name' => 'Xe trộn bê tông', 'en' => 'Concrete mixer truck', 'qty' => '05' ),
							array( 'name' => 'Cẩu tháp', 'en' => 'Tower crane', 'qty' => '07' ),
							array( 'name' => 'Cẩu bánh hơi', 'en' => 'Mobile crane', 'qty' => '10' ),
							array( 'name' => 'Máy vận thăng', 'en' => 'Hoist / material lift', 'qty' => '11' ),
						),
					),
					array(
						'title'    => 'Hiện trường & cốp pha',
						'subtitle' => 'Điện, nước, khí, giàn giáo',
						'cols'     => array( 'Thiết bị', 'Số lượng' ),
						'items'    => array(
							array( 'name' => 'Máy phát điện', 'en' => 'Generator', 'qty' => '04' ),
							array( 'name' => 'Máy bơm nước', 'en' => 'Water pump', 'qty' => '05' ),
							array( 'name' => 'Máy nén khí', 'en' => 'Air compressor', 'qty' => '08' ),
							array( 'name' => 'Hệ giàn giáo nêm', 'en' => 'Scaffolding system', 'qty' => '12' ),
							array( 'name' => 'Cốp pha thép', 'en' => 'Steel formwork', 'qty' => '13' ),
						),
					),
				)
			)
			. tpk_title( 'Cơ cấu nhân sự' )
			. tpk_team(
				array(
					array( 'count' => '5 người', 'role' => 'Ban lãnh đạo', 'desc' => 'Chuyên gia quản lý 15+ năm kinh nghiệm' ),
					array( 'count' => '15 người', 'role' => 'Kỹ sư xây dựng', 'desc' => 'Có bằng kỹ sư, chứng chỉ hành nghề' ),
					array( 'count' => '8 người', 'role' => 'Kỹ sư BIM', 'desc' => 'Sáng tạo, giàu kinh nghiệm thiết kế' ),
					array( 'count' => '12 người', 'role' => 'Giám sát công trình', 'desc' => 'Giám sát chất lượng chặt chẽ 24/7' ),
					array( 'count' => '10 người', 'role' => 'Trưởng công trường', 'desc' => 'Quản lý tiến độ và nhân sự hiệu quả' ),
					array( 'count' => '100+ người', 'role' => 'Công nhân lành nghề', 'desc' => 'Tay nghề cao, nhiều năm kinh nghiệm' ),
				)
			),
		'en'      => array(
			'slug'    => 'plant-equipment',
			'content' =>
				'<h2 class="tp-lead">Plant and construction equipment</h2>'
				. '<p class="tp-lead-desc">Equipment owned by Tin Phat, ready to mobilise to site</p>'
				. tpk_paras(
					array(
						'Tin Phat owns its construction plant rather than relying on rental companies — a key reason we can hold to the schedules we commit to. All equipment is serviced regularly and operated by certified personnel.',
					)
				)
				. tpk_equipment(
					array(
						array(
							'title'    => 'Heavy plant & earthworks',
							'subtitle' => 'Rollers, excavators, dozers, levelling',
							'cols'     => array( 'Equipment', 'Quantity' ),
							'items'    => array(
								array( 'name' => 'Road roller', 'qty' => '01' ),
								array( 'name' => 'Excavator', 'qty' => '02' ),
								array( 'name' => 'Bucket excavator', 'qty' => '04' ),
								array( 'name' => 'Bulldozer', 'qty' => '01' ),
								array( 'name' => 'Front loader', 'qty' => '02' ),
							),
						),
						array(
							'title'    => 'Transport, concrete & cranes',
							'subtitle' => 'Dump trucks, mixers, cranes',
							'cols'     => array( 'Equipment', 'Quantity' ),
							'items'    => array(
								array( 'name' => 'Dump truck', 'qty' => '03' ),
								array( 'name' => 'Concrete mixer truck', 'qty' => '05' ),
								array( 'name' => 'Tower crane', 'qty' => '07' ),
								array( 'name' => 'Mobile crane', 'qty' => '10' ),
								array( 'name' => 'Hoist / material lift', 'qty' => '11' ),
							),
						),
						array(
							'title'    => 'Site & formwork',
							'subtitle' => 'Power, water, air, scaffolding',
							'cols'     => array( 'Equipment', 'Quantity' ),
							'items'    => array(
								array( 'name' => 'Generator', 'qty' => '04' ),
								array( 'name' => 'Water pump', 'qty' => '05' ),
								array( 'name' => 'Air compressor', 'qty' => '08' ),
								array( 'name' => 'Scaffolding system', 'qty' => '12' ),
								array( 'name' => 'Steel formwork', 'qty' => '13' ),
							),
						),
					)
				)
				. tpk_title( 'Our team' )
				. tpk_team(
					array(
						array( 'count' => '5', 'role' => 'Leadership', 'desc' => 'Management specialists with 15+ years of experience' ),
						array( 'count' => '15', 'role' => 'Construction engineers', 'desc' => 'Degree-qualified with practising certificates' ),
						array( 'count' => '8', 'role' => 'BIM engineers', 'desc' => 'Creative, experienced in design' ),
						array( 'count' => '12', 'role' => 'Site supervisors', 'desc' => 'Close quality supervision 24/7' ),
						array( 'count' => '10', 'role' => 'Site managers', 'desc' => 'Effective schedule and workforce management' ),
						array( 'count' => '100+', 'role' => 'Skilled workers', 'desc' => 'Highly skilled with many years on site' ),
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
			'<h2 class="tp-lead">Chứng chỉ và giấy phép</h2>'
			. '<p class="tp-lead-desc">Hồ sơ pháp lý đầy đủ cho hoạt động thi công xây dựng</p>'
			. tpk_paras(
				array(
					'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT hoạt động theo đúng quy định pháp luật về xây dựng, với hệ thống chứng chỉ và giấy phép được duy trì và cập nhật đầy đủ.',
				)
			)
			. tpk_list(
				array(
					'Giấy phép kinh doanh xây dựng hạng II',
					'Chứng chỉ ISO 9001:2015 về quản lý chất lượng',
					'Chứng chỉ ISO 45001 về an toàn lao động',
					'Chứng chỉ năng lực hoạt động xây dựng',
					'Các giấy phép môi trường đầy đủ',
					'Bảo hiểm trách nhiệm công trình',
				)
			)
			. tpk_title( 'Thông tin pháp nhân' )
			. '<table class="tp-company-table"><tbody>'
			. '<tr><td>Tên đầy đủ</td><td>CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT</td></tr>'
			. '<tr><td>Tên viết tắt</td><td>TIN PHAT CTI CO., LTD</td></tr>'
			. '<tr><td>Mã số thuế</td><td>3502302391</td></tr>'
			. '<tr><td>Vốn điều lệ</td><td>3.000.000.000 VNĐ</td></tr>'
			. '<tr><td>Trụ sở chính</td><td>106 Nam Kỳ Khởi Nghĩa, phường Vũng Tàu, thành phố Hồ Chí Minh</td></tr>'
			. '</tbody></table>'
			. '<p><em>Bản scan các chứng chỉ sẽ được cập nhật khi Quý khách có yêu cầu — vui lòng liên hệ hotline 0326 702 600.</em></p>',
		'en'      => array(
			'slug'    => 'certificates-licences',
			'content' =>
				'<h2 class="tp-lead">Certificates and licences</h2>'
				. '<p class="tp-lead-desc">A complete legal file for construction operations</p>'
				. tpk_paras(
					array(
						'TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED operates in full compliance with Vietnamese construction law, maintaining a complete and current set of certificates and licences.',
					)
				)
				. tpk_list(
					array(
						'Class II construction business licence',
						'ISO 9001:2015 quality management certificate',
						'ISO 45001 occupational health and safety certificate',
						'Construction capability certificate',
						'Full environmental permits',
						'Construction liability insurance',
					)
				)
				. tpk_title( 'Legal entity details' )
				. '<table class="tp-company-table"><tbody>'
				. '<tr><td>Full name</td><td>TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED</td></tr>'
				. '<tr><td>Short name</td><td>TIN PHAT CTI CO., LTD</td></tr>'
				. '<tr><td>Tax code</td><td>3502302391</td></tr>'
				. '<tr><td>Charter capital</td><td>VND 3,000,000,000</td></tr>'
				. '<tr><td>Head office</td><td>106 Nam Ky Khoi Nghia, Vung Tau Ward, Ho Chi Minh City</td></tr>'
				. '</tbody></table>'
				. '<p><em>Scanned copies of our certificates are available on request — please call our hotline on 0326 702 600.</em></p>',
		),
	),
);

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
