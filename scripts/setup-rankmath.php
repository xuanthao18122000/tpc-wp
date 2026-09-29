<?php
/**
 * Cấu hình Rank Math: bỏ wizard, bật sitemap, tắt schema trùng với theme.
 *
 * Chạy: wp eval-file /scripts/setup-rankmath.php
 */

// Bỏ qua wizard cài đặt.
update_option( 'rank_math_wizard_completed', true );
update_option( 'rank_math_view_modules', array( 'seo-analysis', 'sitemap', 'rich-snippet' ) );

// Rank Math lưu danh sách module ĐANG BẬT dưới dạng mảng tên,
// không phải cặp key => on/off.
update_option(
	'rank_math_modules',
	array(
		'sitemap',
		'rich-snippet',
		'seo-analysis',
		'local-seo',
		'image-seo',
		'acf',
	)
);

// Thông tin doanh nghiệp cho Local SEO / Knowledge Graph.
$titles = (array) get_option( 'rank-math-options-titles', array() );

$titles['knowledgegraph_type'] = 'company';
$titles['knowledgegraph_name'] = 'CÔNG TY TNHH ĐẦU TƯ XÂY DỰNG THƯƠNG MẠI TÍN PHÁT';
$titles['url']                 = 'https://tinphatcons.com';
$titles['email']               = 'congtytinphatvungtau@gmail.com';
$titles['phone']               = '+84326702600';
$titles['local_address']       = array(
	'streetAddress'   => '106 Nam Kỳ Khởi Nghĩa, phường Vũng Tàu',
	'addressLocality' => 'Thành phố Hồ Chí Minh',
	'addressCountry'  => 'VN',
);
$titles['local_business_type'] = 'GeneralContractor';

// Không index trang đính kèm và kết quả tìm kiếm.
$titles['pt_attachment_custom_robots'] = 'on';
$titles['pt_attachment_robots']        = array( 'noindex' );

update_option( 'rank-math-options-titles', $titles );

// Sitemap.
$sitemap = (array) get_option( 'rank-math-options-sitemap', array() );

$sitemap['items_per_page']            = 200;
$sitemap['include_images']            = 'on';
$sitemap['pt_page_sitemap']           = 'on';
$sitemap['pt_du-an_sitemap']          = 'on';
$sitemap['pt_attachment_sitemap']     = 'off';
$sitemap['exclude_posts']             = '';

update_option( 'rank-math-options-sitemap', $sitemap );

flush_rewrite_rules();

WP_CLI::success( 'Đã cấu hình Rank Math.' );
