<?php
/**
 * Tạo menu chính + menu chân trang cho cả hai ngôn ngữ.
 * Chạy lại được: menu đã có thì làm mới các mục.
 *
 * Chạy: wp eval-file /scripts/seed-menus.php
 */

/**
 * Lấy ID trang theo slug + ngôn ngữ.
 */
function tp_page_id( string $slug, string $lang ): int {
	$page = get_page_by_path( $slug, OBJECT, 'page' );

	if ( $page instanceof WP_Post && pll_get_post_language( $page->ID ) === $lang ) {
		return (int) $page->ID;
	}

	// Trang con trùng slug: tìm theo ngôn ngữ.
	$found = get_posts(
		array(
			'post_type'      => 'page',
			'name'           => $slug,
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'fields'         => 'ids',
		)
	);

	foreach ( $found as $id ) {
		if ( pll_get_post_language( $id ) === $lang ) {
			return (int) $id;
		}
	}

	return 0;
}

/**
 * Cấu trúc menu: slug trang + các mục con.
 */
$structure = array(
	'vi' => array(
		'primary' => array(
			array( 'slug' => 'trang-chu', 'children' => array() ),
			array(
				'slug'     => 'gioi-thieu',
				'children' => array( 'tong-quan', 'thong-diep-giam-doc', 'tam-nhin-gia-tri-cot-loi', 'doi-tac-khach-hang' ),
			),
			array(
				'slug'     => 'nang-luc',
				'children' => array( 'linh-vuc-hoat-dong', 'may-moc-thiet-bi', 'quy-trinh-thi-cong', 'chung-chi-giay-phep' ),
			),
			array( 'slug' => 'tin-tuc', 'children' => array() ),
			array( 'slug' => 'lien-he', 'children' => array() ),
		),
		'footer'  => array( 'gioi-thieu', 'nang-luc', 'tin-tuc', 'lien-he' ),
		'names'   => array( 'primary' => 'Menu chính (VI)', 'footer' => 'Menu chân trang (VI)' ),
	),
	'en' => array(
		'primary' => array(
			array( 'slug' => 'home', 'children' => array() ),
			array(
				'slug'     => 'about-us',
				'children' => array( 'overview', 'directors-message', 'vision-core-values', 'partners-clients' ),
			),
			array(
				'slug'     => 'capabilities',
				'children' => array( 'what-we-do', 'plant-equipment', 'construction-process', 'certificates-licences' ),
			),
			array( 'slug' => 'news', 'children' => array() ),
			array( 'slug' => 'contact', 'children' => array() ),
		),
		'footer'  => array( 'about-us', 'capabilities', 'news', 'contact' ),
		'names'   => array( 'primary' => 'Menu chính (EN)', 'footer' => 'Menu chân trang (EN)' ),
	),
);

$locations = array();

foreach ( $structure as $lang => $config ) {
	// ----- Menu chính -----
	$menu_name = $config['names']['primary'];
	$menu      = wp_get_nav_menu_object( $menu_name );
	$menu_id   = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $menu_name );

	// Xoá mục cũ để chạy lại không bị nhân đôi.
	foreach ( wp_get_nav_menu_items( $menu_id ) ?: array() as $item ) {
		wp_delete_post( $item->ID, true );
	}

	foreach ( $config['primary'] as $entry ) {
		$page_id = tp_page_id( $entry['slug'], $lang );

		if ( 0 === $page_id ) {
			WP_CLI::warning( "Không thấy trang {$lang}/{$entry['slug']}" );
			continue;
		}

		$parent_item = wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-object-id' => $page_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);

		foreach ( $entry['children'] as $child_slug ) {
			$child_id = tp_page_id( $child_slug, $lang );

			if ( 0 === $child_id ) {
				WP_CLI::warning( "Không thấy trang con {$lang}/{$child_slug}" );
				continue;
			}

			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-object-id'   => $child_id,
					'menu-item-object'      => 'page',
					'menu-item-type'        => 'post_type',
					'menu-item-status'      => 'publish',
					'menu-item-parent-id'   => $parent_item,
				)
			);
		}
	}

	$locations[ $lang ]['primary'] = $menu_id;
	WP_CLI::log( "Menu chính {$lang}: #{$menu_id}" );

	// ----- Menu chân trang -----
	$fname   = $config['names']['footer'];
	$fmenu   = wp_get_nav_menu_object( $fname );
	$fmenu_id = $fmenu ? (int) $fmenu->term_id : (int) wp_create_nav_menu( $fname );

	foreach ( wp_get_nav_menu_items( $fmenu_id ) ?: array() as $item ) {
		wp_delete_post( $item->ID, true );
	}

	foreach ( $config['footer'] as $slug ) {
		$page_id = tp_page_id( $slug, $lang );

		if ( 0 === $page_id ) {
			continue;
		}

		wp_update_nav_menu_item(
			$fmenu_id,
			0,
			array(
				'menu-item-object-id' => $page_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}

	$locations[ $lang ]['footer'] = $fmenu_id;
	WP_CLI::log( "Menu footer {$lang}: #{$fmenu_id}" );
}

// Polylang gán menu theo ngôn ngữ qua option nav_menus của theme.
$theme       = get_option( 'stylesheet' );
$pll_options = get_option( 'polylang' );

$pll_options['nav_menus'][ $theme ] = array(
	'primary' => array( 'vi' => $locations['vi']['primary'], 'en' => $locations['en']['primary'] ),
	'footer'  => array( 'vi' => $locations['vi']['footer'], 'en' => $locations['en']['footer'] ),
);

update_option( 'polylang', $pll_options );

// Vị trí mặc định trỏ về menu tiếng Việt.
set_theme_mod(
	'nav_menu_locations',
	array(
		'primary' => $locations['vi']['primary'],
		'footer'  => $locations['vi']['footer'],
	)
);

WP_CLI::success( 'Đã tạo menu song ngữ và gán vị trí.' );
