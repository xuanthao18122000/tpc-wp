<?php
/**
 * Đổ nội dung trang "Liên hệ" (song ngữ).
 *
 * Thông tin lấy từ hồ sơ Tín Phát (bản Next.js cũ + inc/company.php).
 *
 * Chạy: php scripts/run.php scripts/seed-contact-page.php
 */

/** URL file trong uploads/tinphat. */
function tpc_img( string $file ): string {
	return content_url( 'uploads/tinphat/' . $file );
}

/**
 * Thẻ thông tin liên hệ.
 *
 * @param array<int,array{icon:string,title:string,value:string,href?:string}> $items Danh sách.
 */
function tpc_cards( array $items ): string {
	$html = '<div class="tp-contact">';

	foreach ( $items as $item ) {
		$body = isset( $item['href'] )
			? '<a href="' . esc_url( $item['href'] ) . '">' . esc_html( $item['value'] ) . '</a>'
			: '<p>' . esc_html( $item['value'] ) . '</p>';

		$html .= '<div class="tp-contact__card">'
			. '<div class="tp-contact__icon">'
			. '<img src="' . esc_url( tpc_img( $item['icon'] ) ) . '" alt="" width="17" height="17" loading="lazy" decoding="async">'
			. '</div>'
			. '<h3>' . esc_html( $item['title'] ) . '</h3>'
			. $body
			. '</div>';
	}

	return $html . '</div>';
}

/**
 * Bản đồ nhúng.
 *
 * Dùng Google Maps embed không cần API key; `q` là địa chỉ thật nên
 * không phụ thuộc toạ độ cố định.
 *
 * @param string $query Địa chỉ tìm kiếm.
 * @param string $title Nhãn cho iframe (a11y).
 */
function tpc_map( string $query, string $title ): string {
	$src = 'https://maps.google.com/maps?' . http_build_query(
		array(
			'q'      => $query,
			'output' => 'embed',
			'hl'     => 'vi',
			'z'      => '16',
		)
	);

	return '<div class="tp-map"><iframe src="' . esc_url( $src ) . '"'
		. ' title="' . esc_attr( $title ) . '" loading="lazy"'
		. ' referrerpolicy="no-referrer-when-downgrade"></iframe></div>';
}

/**
 * Khối form liên hệ.
 *
 * Nếu WPForms đã có form thì nhúng form đầu tiên; chưa có thì hiện khối
 * hướng dẫn kèm cách liên hệ trực tiếp, để trang không bị trống.
 *
 * @param string $heading     Tiêu đề khối.
 * @param string $placeholder Nội dung khi chưa có form.
 * @param string $phone       Số điện thoại hiển thị trong placeholder.
 * @param string $email       Email hiển thị trong placeholder.
 */
function tpc_form( string $heading, string $placeholder, string $phone, string $email ): string {
	$form_id = 0;

	if ( post_type_exists( 'wpforms' ) ) {
		$forms = get_posts(
			array(
				'post_type'      => 'wpforms',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		$form_id = ! empty( $forms ) ? (int) $forms[0] : 0;
	}

	$inner = $form_id > 0
		? '[wpforms id="' . $form_id . '"]'
		: '<div class="tp-form-placeholder"><p>' . esc_html( $placeholder ) . '</p>'
			. '<p><a href="tel:' . esc_attr( preg_replace( '/\s+/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a>'
			. ' &middot; <a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a></p></div>';

	return '<div class="tp-form-wrap">' . tpa_head_simple( $heading ) . $inner . '</div>';
}

/** Tiêu đề nhỏ trong khối form. */
function tpa_head_simple( string $title ): string {
	return '<div class="tp-section-head"><h2>' . esc_html( $title ) . '</h2></div>';
}

$address_vi = '106 Nam Kỳ Khởi Nghĩa, phường Vũng Tàu, thành phố Hồ Chí Minh';
$address_en = '106 Nam Ky Khoi Nghia, Vung Tau Ward, Ho Chi Minh City';
$phone      = '0326 702 600';
$email      = 'congtytinphatvungtau@gmail.com';

$pages = array(
	'lien-he' => array(
		'content' =>
			'<h2 class="tp-lead">Liên hệ với Tín Phát</h2>'
			. '<p class="tp-lead-desc">Gửi yêu cầu tư vấn hoặc báo giá, chúng tôi phản hồi trong vòng 24 giờ làm việc</p>'
			. tpc_cards(
				array(
					array(
						'icon'  => 'icon-marker.svg',
						'title' => 'Trụ sở chính',
						'value' => $address_vi,
					),
					array(
						'icon'  => 'icon-phone.svg',
						'title' => 'Hotline',
						'value' => $phone,
						'href'  => 'tel:0326702600',
					),
					array(
						'icon'  => 'icon-email.svg',
						'title' => 'Email',
						'value' => $email,
						'href'  => 'mailto:' . $email,
					),
					array(
						'icon'  => 'icon-phone.svg',
						'title' => 'Giờ làm việc',
						'value' => 'Thứ 2 - Thứ 6: 8:00 - 18:00',
					),
				)
			)
			. '<p>CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT nhận tư vấn và báo giá cho các công trình dân dụng, công nghiệp và thương mại trên địa bàn Thành phố Hồ Chí Minh và các tỉnh lân cận. Quý khách vui lòng liên hệ theo thông tin trên hoặc gửi yêu cầu qua biểu mẫu bên dưới.</p>'
			. '<p>Mã số thuế: 3502302391</p>'
			. tpc_map( $address_vi, 'Bản đồ trụ sở Tín Phát' )
			. tpc_form(
				'Gửi yêu cầu',
				'Biểu mẫu đang được hoàn thiện. Trong lúc chờ, Quý khách vui lòng liên hệ trực tiếp:',
				$phone,
				$email
			),
		'en'      => array(
			'slug'    => 'contact',
			'content' =>
				'<h2 class="tp-lead">Contact Tin Phat</h2>'
				. '<p class="tp-lead-desc">Send us a consultancy or quotation request and we will reply within 24 working hours</p>'
				. tpc_cards(
					array(
						array(
							'icon'  => 'icon-marker.svg',
							'title' => 'Head office',
							'value' => $address_en,
						),
						array(
							'icon'  => 'icon-phone.svg',
							'title' => 'Hotline',
							'value' => $phone,
							'href'  => 'tel:0326702600',
						),
						array(
							'icon'  => 'icon-email.svg',
							'title' => 'Email',
							'value' => $email,
							'href'  => 'mailto:' . $email,
						),
						array(
							'icon'  => 'icon-phone.svg',
							'title' => 'Working hours',
							'value' => 'Monday - Friday: 8:00 - 18:00',
						),
					)
				)
				. '<p>TIN PHAT CONSTRUCTION TRADING INVESTMENT COMPANY LIMITED provides consultancy and quotations for residential, industrial and commercial projects in Ho Chi Minh City and neighbouring provinces. Please reach us using the details above or send your request through the form below.</p>'
				. '<p>Tax code: 3502302391</p>'
				. tpc_map( $address_en, 'Map of the Tin Phat head office' )
				. tpc_form(
					'Send a request',
					'Our form is being finalised. In the meantime, please contact us directly:',
					$phone,
					$email
				),
		),
	),
);

/** Tìm trang theo slug, lọc theo ngôn ngữ. */
function tpc_find_page( string $slug, string $lang ): ?WP_Post {
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
	$page = tpc_find_page( $slug, 'vi' );

	if ( $page instanceof WP_Post ) {
		wp_update_post( array( 'ID' => $page->ID, 'post_content' => $data['content'] ) );
		WP_CLI::log( "  vi/{$slug}" );
		++$updated;
	} else {
		WP_CLI::warning( "  không tìm thấy vi/{$slug}" );
	}

	if ( isset( $data['en'] ) ) {
		$en_page = tpc_find_page( $data['en']['slug'], 'en' );

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
