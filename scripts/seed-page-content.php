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
		'content' => '<h2 class="tp-lead">UY TÍN - CHẤT LƯỢNG - TIẾN BỘ</h2>'
			. '<p class="tp-lead-desc">Đối tác tin cậy cho các dự án xây dựng dân dụng, thương mại và công nghiệp</p>'
			. tp_table(
				array(
					array( 'Tên đầy đủ', 'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT' ),
					array( 'Tên tiếng Anh', 'TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED' ),
					array( 'Tên viết tắt', 'TIN PHAT CTI CO., LTD' ),
					array( 'Mã số thuế', '3502302391' ),
					array( 'Vốn điều lệ', '3.000.000.000 VNĐ' ),
					array( 'Trụ sở chính', '106 Nam Kỳ Khởi Nghĩa, phường Vũng Tàu, thành phố Hồ Chí Minh' ),
					array( 'Hotline', '0326 702 600' ),
					array( 'Website', 'tinphatcons.com' ),
					array( 'Email', 'congtytinphatvungtau@gmail.com' ),
				)
			)
			. '<h3 class="tp-mission">"Uy Tín - Chất Lượng - Tiến Bộ"</h3>'
			. tp_paras(
				array(
					'Được thành lập với sứ mệnh mang đến những công trình xây dựng chất lượng cao, CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT đã và đang khẳng định vị thế của mình trên thị trường xây dựng tại TP.HCM.',
					'Với đội ngũ kỹ sư, kiến trúc sư giàu kinh nghiệm cùng đội ngũ công nhân lành nghề, chúng tôi cam kết mang đến cho khách hàng những công trình đạt chất lượng cao nhất, đúng tiến độ và giá cả hợp lý.',
					'Chúng tôi chuyên thi công các dự án dân dụng, công nghiệp và thương mại với quy trình làm việc chuyên nghiệp, minh bạch và luôn đặt sự hài lòng của khách hàng lên hàng đầu.',
				)
			),
		'en'      => array(
			'slug'    => 'overview',
			'content' => '<h2 class="tp-lead">INTEGRITY - QUALITY - PROGRESS</h2>'
				. '<p class="tp-lead-desc">A trusted partner for residential, commercial and industrial construction projects</p>'
				. tp_table(
					array(
						array( 'Full name', 'TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED' ),
						array( 'Vietnamese name', 'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT' ),
						array( 'Short name', 'TIN PHAT CTI CO., LTD' ),
						array( 'Tax code', '3502302391' ),
						array( 'Charter capital', 'VND 3,000,000,000' ),
						array( 'Head office', '106 Nam Ky Khoi Nghia, Vung Tau Ward, Ho Chi Minh City' ),
						array( 'Hotline', '0326 702 600' ),
						array( 'Website', 'tinphatcons.com' ),
						array( 'Email', 'congtytinphatvungtau@gmail.com' ),
					)
				)
				. '<h3 class="tp-mission">"Integrity - Quality - Progress"</h3>'
				. tp_paras(
					array(
						'Founded with the mission of delivering high-quality construction works, TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED has steadily established its position in the Ho Chi Minh City construction market.',
						'With experienced engineers and architects alongside a skilled workforce, we are committed to delivering works of the highest quality, on schedule and at a reasonable cost.',
						'We specialise in residential, industrial and commercial projects, working to a professional and transparent process that always puts client satisfaction first.',
					)
				),
		),
	),

	// ===== Thông điệp Giám đốc =====
	'thong-diep-giam-doc' => array(
		'content' => '<blockquote class="tp-quote"><p>CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT xin gửi đến Quý Đối Tác, Quý Khách Hàng lời chúc sức khỏe, thành công và thịnh vượng.</p>'
			. '<cite><strong>Bùi Đức Hùng</strong><br>Giám Đốc</cite></blockquote>'
			. tp_paras(
				array(
					'Kính gửi: Quý Đối Tác – Quý Khách Hàng,',
					'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT xin gửi đến Quý Đối Tác, Quý Khách Hàng lời chúc sức khỏe, thành công và thịnh vượng.',
					'Với định hướng phát triển bền vững, chúng tôi cam kết mang đến những giải pháp xây dựng chất lượng cao, đáp ứng mọi nhu cầu về đầu tư, thương mại, hoàn thiện dự án và giải pháp kỹ thuật trên toàn quốc. Với phương châm hoạt động "Uy tín - Chất lượng - Tiến bộ", chúng tôi tự hào về đội ngũ kỹ sư, kỹ thuật viên giàu kinh nghiệm, quy trình làm việc chuyên nghiệp và năng lực thi công mạnh mẽ.',
					'Mỗi công trình của chúng tôi đều thể hiện cam kết về chất lượng, an toàn và giá trị bền vững cho khách hàng. Chúng tôi mong muốn trở thành đối tác tin cậy, sẵn sàng đồng hành cùng Quý khách hàng trong tất cả các giai đoạn của dự án, từ tư vấn, thiết kế đến thi công, bàn giao và bảo trì dài hạn.',
					'Chúng tôi rất mong nhận được sự tin tưởng, hợp tác và đồng hành của Quý Đối Tác, Quý Khách Hàng trong thời gian tới.',
					'Trân trọng kính chào!',
				)
			),
		'en'      => array(
			'slug'    => 'directors-message',
			'content' => '<blockquote class="tp-quote"><p>TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED wishes our Partners and Clients health, success and prosperity.</p>'
				. '<cite><strong>Bui Duc Hung</strong><br>Director</cite></blockquote>'
				. tp_paras(
					array(
						'Dear Partners and Clients,',
						'TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED wishes our Partners and Clients health, success and prosperity.',
						'Guided by a strategy of sustainable growth, we are committed to delivering high-quality construction solutions that meet every need in investment, trade, project completion and technical services nationwide. Working to our motto "Integrity - Quality - Progress", we take pride in our experienced engineers and technicians, our professional working process and our strong construction capability.',
						'Every project we deliver reflects our commitment to quality, safety and lasting value for our clients. We aim to be a trusted partner, ready to accompany you through every stage of a project — from consultancy and design to construction, handover and long-term maintenance.',
						'We look forward to your continued trust, cooperation and partnership in the years ahead.',
						'Yours sincerely,',
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
