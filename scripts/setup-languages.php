<?php
/**
 * Tạo hai ngôn ngữ VI/EN cho Polylang.
 * Chạy: wp eval-file /scripts/setup-languages.php
 */

if ( ! function_exists( 'PLL' ) ) {
	WP_CLI::error( 'Polylang chưa sẵn sàng.' );
}

$model = PLL()->model;

$languages = array(
	array(
		'name'       => 'Tiếng Việt',
		'slug'       => 'vi',
		'locale'     => 'vi',
		'rtl'        => 0,
		'term_group' => 0,
		'flag'       => 'vn',
	),
	array(
		'name'       => 'English',
		'slug'       => 'en',
		'locale'     => 'en_US',
		'rtl'        => 0,
		'term_group' => 1,
		'flag'       => 'us',
	),
);

foreach ( $languages as $lang ) {
	$existing = $model->get_language( $lang['slug'] );

	if ( $existing ) {
		WP_CLI::log( "Đã có: {$lang['slug']}" );
		continue;
	}

	$result = $model->add_language( $lang );

	if ( is_wp_error( $result ) ) {
		WP_CLI::warning( "{$lang['slug']}: " . $result->get_error_message() );
		continue;
	}

	WP_CLI::success( "Tạo ngôn ngữ {$lang['slug']}" );
}

$model->clean_languages_cache();
WP_CLI::success( 'Xong.' );
