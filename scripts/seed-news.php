<?php
/**
 * Seed tin tức (post) + chuyên mục, song ngữ VI/EN.
 * Chạy lại được: bài đã có thì bỏ qua.
 *
 * Chạy: wp eval-file /scripts/seed-news.php
 */

/**
 * Chuyên mục theo ngôn ngữ.
 */
$categories = array(
	'tin-du-an'          => array( 'vi' => 'Tin dự án', 'en' => 'Project news' ),
	'hoat-dong-noi-bo'   => array( 'vi' => 'Hoạt động nội bộ', 'en' => 'Internal activities' ),
	'tin-cong-ty'        => array( 'vi' => 'Tin công ty', 'en' => 'Company news' ),
);

/**
 * Bài viết mẫu. MOCKUP: nội dung và ảnh cần thay bằng tin thật của Tín Phát.
 */
$posts = array(
	array(
		'cat' => 'tin-du-an',
		'vi'  => array(
			'title'   => '[Mẫu] Lễ cất nóc dự án Biệt thự Quận 2',
			'excerpt' => 'Nội dung mẫu — thay bằng tin dự án thật của Tín Phát.',
			'body'    => 'Đây là bài viết mẫu để kiểm tra bố cục trang tin tức. Thay toàn bộ nội dung này bằng tin thật của Tín Phát Construction.',
		),
		'en'  => array(
			'title'   => '[Sample] Topping-out ceremony at District 2 Villa',
			'excerpt' => 'Sample content — replace with a real Tin Phat project update.',
			'body'    => 'This is a placeholder article used to check the news layout. Replace all of this with real Tin Phat Construction content.',
		),
	),
	array(
		'cat' => 'tin-du-an',
		'vi'  => array(
			'title'   => '[Mẫu] Hoàn thành hạng mục kết cấu nhà xưởng KCN Hiệp Phước',
			'excerpt' => 'Nội dung mẫu — thay bằng tin dự án thật của Tín Phát.',
			'body'    => 'Đây là bài viết mẫu để kiểm tra bố cục trang tin tức. Thay toàn bộ nội dung này bằng tin thật của Tín Phát Construction.',
		),
		'en'  => array(
			'title'   => '[Sample] Structural works completed at Hiep Phuoc IZ Factory',
			'excerpt' => 'Sample content — replace with a real Tin Phat project update.',
			'body'    => 'This is a placeholder article used to check the news layout. Replace all of this with real Tin Phat Construction content.',
		),
	),
	array(
		'cat' => 'tin-du-an',
		'vi'  => array(
			'title'   => '[Mẫu] Triển khai thi công phần móng khu dân cư Riverside',
			'excerpt' => 'Nội dung mẫu — thay bằng tin dự án thật của Tín Phát.',
			'body'    => 'Đây là bài viết mẫu để kiểm tra bố cục trang tin tức. Thay toàn bộ nội dung này bằng tin thật của Tín Phát Construction.',
		),
		'en'  => array(
			'title'   => '[Sample] Foundation works underway at Riverside Residences',
			'excerpt' => 'Sample content — replace with a real Tin Phat project update.',
			'body'    => 'This is a placeholder article used to check the news layout. Replace all of this with real Tin Phat Construction content.',
		),
	),
	array(
		'cat' => 'hoat-dong-noi-bo',
		'vi'  => array(
			'title'   => '[Mẫu] Chương trình huấn luyện an toàn lao động',
			'excerpt' => 'Nội dung mẫu — thay bằng tin thật của Tín Phát.',
			'body'    => 'Đây là bài viết mẫu để kiểm tra bố cục trang tin tức. Thay toàn bộ nội dung này bằng tin thật của Tín Phát Construction.',
		),
		'en'  => array(
			'title'   => '[Sample] Occupational safety training programme',
			'excerpt' => 'Sample content — replace with real Tin Phat news.',
			'body'    => 'This is a placeholder article used to check the news layout. Replace all of this with real Tin Phat Construction content.',
		),
	),
	array(
		'cat' => 'hoat-dong-noi-bo',
		'vi'  => array(
			'title'   => '[Mẫu] Hoạt động team building thường niên',
			'excerpt' => 'Nội dung mẫu — thay bằng tin thật của Tín Phát.',
			'body'    => 'Đây là bài viết mẫu để kiểm tra bố cục trang tin tức. Thay toàn bộ nội dung này bằng tin thật của Tín Phát Construction.',
		),
		'en'  => array(
			'title'   => '[Sample] Annual team building activities',
			'excerpt' => 'Sample content — replace with real Tin Phat news.',
			'body'    => 'This is a placeholder article used to check the news layout. Replace all of this with real Tin Phat Construction content.',
		),
	),
	array(
		'cat' => 'tin-cong-ty',
		'vi'  => array(
			'title'   => '[Mẫu] Tín Phát mở rộng năng lực thi công 2026',
			'excerpt' => 'Nội dung mẫu — thay bằng tin thật của Tín Phát.',
			'body'    => 'Đây là bài viết mẫu để kiểm tra bố cục trang tin tức. Thay toàn bộ nội dung này bằng tin thật của Tín Phát Construction.',
		),
		'en'  => array(
			'title'   => '[Sample] Tin Phat expands construction capacity in 2026',
			'excerpt' => 'Sample content — replace with real Tin Phat news.',
			'body'    => 'This is a placeholder article used to check the news layout. Replace all of this with real Tin Phat Construction content.',
		),
	),
);

/**
 * Tạo (hoặc lấy) chuyên mục theo ngôn ngữ.
 */
function tp_news_cat( string $slug, string $name, string $lang ): int {
	$term_slug = $slug . '-' . $lang;
	$existing  = get_term_by( 'slug', $term_slug, 'category' );

	if ( $existing instanceof WP_Term ) {
		return (int) $existing->term_id;
	}

	$result = wp_insert_term( $name, 'category', array( 'slug' => $term_slug ) );

	if ( is_wp_error( $result ) ) {
		WP_CLI::warning( "term {$term_slug}: " . $result->get_error_message() );
		return 0;
	}

	$term_id = (int) $result['term_id'];

	if ( function_exists( 'pll_set_term_language' ) ) {
		pll_set_term_language( $term_id, $lang );
	}

	return $term_id;
}

/**
 * Tạo một bài viết.
 */
function tp_news_post( array $data, string $lang, int $cat_id, int $offset_days ): int {
	$found = get_posts(
		array(
			'post_type'      => 'post',
			'title'          => $data['title'],
			'posts_per_page' => 1,
			'post_status'    => 'any',
			'fields'         => 'ids',
		)
	);

	foreach ( $found as $id ) {
		if ( ! function_exists( 'pll_get_post_language' ) || pll_get_post_language( $id ) === $lang ) {
			WP_CLI::log( "  = {$lang}: {$data['title']}" );
			return (int) $id;
		}
	}

	$id = wp_insert_post(
		array(
			'post_title'   => $data['title'],
			'post_excerpt' => $data['excerpt'],
			'post_content' => '<p>' . $data['body'] . '</p>',
			'post_type'    => 'post',
			'post_status'  => 'publish',
			'post_date'    => gmdate( 'Y-m-d H:i:s', strtotime( "-{$offset_days} days" ) ),
		),
		true
	);

	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( $id->get_error_message() );
		return 0;
	}

	$id = (int) $id;

	if ( function_exists( 'pll_set_post_language' ) ) {
		pll_set_post_language( $id, $lang );
	}

	if ( $cat_id > 0 ) {
		wp_set_post_categories( $id, array( $cat_id ) );
	}

	WP_CLI::log( "  + {$lang}: {$data['title']} (#{$id})" );

	return $id;
}

// ----- Tạo chuyên mục -----
$cat_ids = array();

foreach ( $categories as $slug => $names ) {
	$vi = tp_news_cat( $slug, $names['vi'], 'vi' );
	$en = tp_news_cat( $slug, $names['en'], 'en' );

	if ( $vi > 0 && $en > 0 && function_exists( 'pll_save_term_translations' ) ) {
		pll_save_term_translations( array( 'vi' => $vi, 'en' => $en ) );
	}

	$cat_ids[ $slug ] = array( 'vi' => $vi, 'en' => $en );
}

WP_CLI::log( 'Đã tạo ' . count( $cat_ids ) . ' chuyên mục song ngữ.' );

// ----- Tạo bài viết -----
$count = 0;

foreach ( $posts as $index => $pair ) {
	$cat = $cat_ids[ $pair['cat'] ];

	$vi = tp_news_post( $pair['vi'], 'vi', $cat['vi'], $index * 5 );
	$en = tp_news_post( $pair['en'], 'en', $cat['en'], $index * 5 );

	if ( $vi > 0 && $en > 0 && function_exists( 'pll_save_post_translations' ) ) {
		pll_save_post_translations( array( 'vi' => $vi, 'en' => $en ) );
		++$count;
	}
}

WP_CLI::success( "Đã seed {$count} bài viết song ngữ." );
