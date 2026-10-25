<?php
/**
 * Đổ nội dung cho các trang con (song ngữ).
 * Nội dung lấy từ dictionary bản Next.js.
 *
 * Chạy: wp eval-file /scripts/seed-page-content.php
 */

/**
 * Bọc danh sách đoạn văn thành HTML.
 *
 * @param array<int,string> $paras Các đoạn.
 * @return string
 */
function tp_paras( array $paras ): string {
	return implode( "\n\n", array_map( static fn( $p ) => '<p>' . $p . '</p>', $paras ) );
}

/**
 * Bảng thông tin công ty.
 *
 * @param array<int,array{0:string,1:string}> $rows Cặp nhãn/giá trị.
 * @return string
 */
function tp_table( array $rows ): string {
	$html = '<table class="tp-company-table"><tbody>';

	foreach ( $rows as $row ) {
		$html .= '<tr><td>' . esc_html( $row[0] ) . '</td><td>' . esc_html( $row[1] ) . '</td></tr>';
	}

	return $html . '</tbody></table>';
}

/**
 * Danh sách gạch đầu dòng.
 *
 * @param array<int,string> $items Mục.
 * @return string
 */
function tp_list( array $items ): string {
	return '<ul class="tp-list">' . implode( '', array_map( static fn( $i ) => '<li>' . esc_html( $i ) . '</li>', $items ) ) . '</ul>';
}

$pages = array(

	// ===== Tổng quan =====
	'tong-quan' => array(
		'content' => '<h2 class="tp-lead">UY TÍN – CHẤT LƯỢNG – TIẾN ĐỘ</h2>'
			. '<p class="tp-lead-desc">Nhà thầu thi công hạ tầng kỹ thuật, giao thông đường bộ và đường thuỷ, hàng hải</p>'
			. tp_table(
				array(
					array( 'Tên công ty', 'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT' ),
					array( 'Tên tiếng Anh', 'TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED' ),
					array( 'Tên viết tắt', 'TIN PHAT CTI CO., LTD' ),
					array( 'Tên giao dịch', 'TIN PHAT CTI CO., LTD' ),
					array( 'Mã số thuế', '3502302391' ),
					array( 'Vốn điều lệ', '3.000.000.000 VNĐ' ),
					array( 'Đại diện', 'Ông Bùi Đức Hùng — Giám đốc' ),
					array( 'Trụ sở chính', '106 Nam Kỳ Khởi Nghĩa, phường Vũng Tàu, thành phố Hồ Chí Minh' ),
					array( 'Hotline', '0326 702 600' ),
					array( 'Email', 'congtytinphatvungtau@gmail.com' ),
					array( 'Website', 'tinphatcons.com' ),
				)
			)
			. '<h3 class="tp-mission">"Uy tín – Chất lượng – Tiến độ"</h3>'
			. tp_paras(
				array(
					'Với định hướng phát triển bền vững và mục tiêu mang đến những giải pháp xây dựng chất lượng – tối ưu – hiệu quả, Tín Phát được thành lập nhằm cung cấp các dịch vụ thi công xây dựng, đầu tư – thương mại, hoàn thiện công trình và cung ứng giải pháp kỹ thuật cho doanh nghiệp và các dự án trên toàn quốc.',
					'Tín Phát luôn đặt uy tín – chất lượng – tiến độ làm kim chỉ nam trong mọi hoạt động. Chúng tôi tự hào sở hữu đội ngũ kỹ sư – kỹ thuật viên giàu kinh nghiệm, quy trình làm việc chuyên nghiệp cùng năng lực thi công vững mạnh.',
					'Công ty hiện có hơn 50 kỹ sư và nhân viên, hơn 250 lao động thường xuyên, cùng 30 loại máy móc thiết bị thuộc sở hữu. Tín Phát là nhà thầu thi công cho nhiều dự án hạ tầng của Tổng Công ty CP Dịch vụ Kỹ thuật Dầu khí Việt Nam (PTSC), các Ban QLDA giao thông và Sở Giao thông Vận tải cấp tỉnh.',
				)
			),
		'en'      => array(
			'slug'    => 'overview',
			'content' => '<h2 class="tp-lead">INTEGRITY – QUALITY – PROGRESS</h2>'
				. '<p class="tp-lead-desc">A contractor for technical infrastructure, road, waterway and maritime construction</p>'
				. tp_table(
					array(
						array( 'Company name', 'TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED' ),
						array( 'Vietnamese name', 'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT' ),
						array( 'Short name', 'TIN PHAT CTI CO., LTD' ),
						array( 'Trade name', 'TIN PHAT CTI CO., LTD' ),
						array( 'Tax code', '3502302391' ),
						array( 'Charter capital', 'VND 3,000,000,000' ),
						array( 'Representative', 'Mr. Bui Duc Hung — Director' ),
						array( 'Main office', '106 Nam Ky Khoi Nghia, Vung Tau Ward, Ho Chi Minh City' ),
						array( 'Hotline', '0326 702 600' ),
						array( 'Email', 'congtytinphatvungtau@gmail.com' ),
						array( 'Website', 'tinphatcons.com' ),
					)
				)
				. '<h3 class="tp-mission">"Integrity – Quality – Progress"</h3>'
				. tp_paras(
					array(
						'With the orientation of sustainable development and the goal of providing quality - optimal - effective construction solutions, Tin Phat was established to provide construction, investment - trade, project completion and technical solutions for businesses and projects nationwide.',
						'Tin Phat always puts prestige - quality - progress as the guiding principle in all activities. We are proud to have a team of experienced engineers and technicians, a professional working process and strong construction capacity.',
						'The company currently has more than 50 engineers and staff, over 250 permanent employees and 30 types of owned plant and equipment. Tin Phat is the construction contractor for numerous infrastructure projects of PetroVietnam Technical Services Corporation (PTSC), provincial transport project management boards and departments of transport.',
					)
				),
		),
	),

	'thong-diep-giam-doc' => array(
		'content' => '<blockquote class="tp-quote"><p>Tín Phát luôn đặt uy tín – chất lượng – tiến độ làm kim chỉ nam trong mọi hoạt động.</p>'
			. '<cite><strong>Bùi Đức Hùng</strong><br>Giám đốc</cite></blockquote>'
			. tp_paras(
				array(
					'Kính gửi: Quý Đối Tác – Quý Khách Hàng',
					'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT xin gửi đến Quý Khách hàng lời chào trân trọng và lời chúc sức khỏe, thành công và thịnh vượng.',
					'Với định hướng phát triển bền vững và mục tiêu mang đến những giải pháp xây dựng chất lượng – tối ưu – hiệu quả, Tín Phát được thành lập nhằm cung cấp các dịch vụ thi công xây dựng, đầu tư – thương mại, hoàn thiện công trình và cung ứng giải pháp kỹ thuật cho doanh nghiệp và các dự án trên toàn quốc.',
					'Tín Phát luôn đặt uy tín – chất lượng – tiến độ làm kim chỉ nam trong mọi hoạt động. Chúng tôi tự hào sở hữu đội ngũ kỹ sư – kỹ thuật viên giàu kinh nghiệm, quy trình làm việc chuyên nghiệp cùng năng lực thi công vững mạnh. Mỗi dự án mà Tín Phát thực hiện đều là sự cam kết về chất lượng, an toàn và giá trị bền vững cho khách hàng.',
					'Với mong muốn trở thành đối tác tin cậy, Tín Phát luôn sẵn sàng đồng hành cùng Quý Khách hàng trong mọi giai đoạn của dự án, từ tư vấn giải pháp, triển khai thi công cho đến bàn giao và bảo trì dài hạn.',
					'Chúng tôi rất mong tiếp tục nhận được sự tin tưởng, hợp tác và đồng hành của Quý Khách trong thời gian tới.',
					'Trân trọng kính chào!',
					'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT',
				)
			)
			. '<h3 class="tp-mission">Lời cảm ơn</h3>'
			. tp_paras(
				array(
					'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT xin gửi lời chào trân trọng và lời cảm ơn chân thành đến Quý Khách hàng đã luôn tin tưởng và đồng hành cùng chúng tôi.',
					'Với định hướng phát triển bền vững, Tín Phát cam kết mang đến các giải pháp xây dựng chất lượng – uy tín – hiệu quả, cùng đội ngũ kỹ sư giàu kinh nghiệm và quy trình thi công chuyên nghiệp. Mỗi dự án của chúng tôi đều là sự cam kết về an toàn, tiến độ và giá trị bền vững.',
					'Chúng tôi trân trọng sự hợp tác của Quý Khách hàng và mong tiếp tục đồng hành trong những dự án tiếp theo.',
				)
			),
		'en'      => array(
			'slug'    => 'directors-message',
			'content' => '<blockquote class="tp-quote"><p>Tin Phat always puts prestige – quality – progress as the guiding principle in all activities.</p>'
				. '<cite><strong>Bui Duc Hung</strong><br>Director</cite></blockquote>'
				. tp_paras(
					array(
						'Dear Partners - Customers',
						'TIN PHAT TRADING CONSTRUCTION INVESTMENT COMPANY LIMITED would like to send our customers our best wishes for health, success and prosperity.',
						'With the orientation of sustainable development and the goal of providing quality - optimal - effective construction solutions, Tin Phat was established to provide construction, investment - trade, project completion and technical solutions for businesses and projects nationwide.',
						'Tin Phat always puts prestige - quality - progress as the guiding principle in all activities. We are proud to have a team of experienced engineers - technicians, professional working process and strong construction capacity. Every project that Tin Phat implements is a commitment to quality, safety and sustainable value for customers.',
						'With the desire to become a trusted partner, Tin Phat is always ready to accompany customers in every stage of the project, from consulting solutions, implementing construction to handover and long-term maintenance.',
						'We look forward to continuing to receive your trust, cooperation and companionship in the future.',
						'Best regards!',
						'TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED',
					)
				)
				. '<h3 class="tp-mission">Thanks</h3>'
				. tp_paras(
					array(
						'TIN PHAT INVESTMENT – CONSTRUCTION – TRADING CO., LTD would like to express our sincere thanks for your trust and cooperation.',
						'With a commitment to sustainable development, we provide high-quality, reliable and efficient construction solutions, supported by an experienced engineering team and a professional working process. Every project reflects our dedication to safety, progress, and lasting value.',
						'We truly appreciate your partnership and look forward to continuing our cooperation in future projects.',
					)
				),
		),
	),

);

/**
 * Tìm trang theo slug bất kể cấp cha, lọc theo ngôn ngữ.
 */
function tp_find_page( string $slug, string $lang ): ?WP_Post {
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

$updated = 0;

foreach ( $pages as $slug => $data ) {
	// Bản tiếng Việt.
	$page = tp_find_page( $slug, 'vi' );

	if ( $page instanceof WP_Post ) {
		wp_update_post( array( 'ID' => $page->ID, 'post_content' => $data['content'] ) );
		WP_CLI::log( "  vi/{$slug}" );
		++$updated;
	}

	// Bản tiếng Anh.
	if ( isset( $data['en'] ) ) {
		$en_page = tp_find_page( $data['en']['slug'], 'en' );

		if ( $en_page instanceof WP_Post ) {
			wp_update_post( array( 'ID' => $en_page->ID, 'post_content' => $data['en']['content'] ) );
			WP_CLI::log( "  en/{$data['en']['slug']}" );
			++$updated;
		}
	}
}

WP_CLI::success( "Đã cập nhật {$updated} trang." );
