<?php
/**
 * Đăng ký Custom Post Type và taxonomy.
 *
 * Khai báo bằng mảng cấu hình rồi đăng ký trong một vòng lặp,
 * tránh lặp lại register_post_type() cho từng loại.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Định nghĩa các CPT của site.
 *
 * @return array<string,array<string,mixed>>
 */
function tinphat_post_types(): array {
	return array(
		'du-an'      => array(
			'singular'  => __( 'Dự án', 'tinphat' ),
			'plural'    => __( 'Dự án', 'tinphat' ),
			'menu_icon' => 'dashicons-building',
			'slug'      => 'du-an',
			'supports'  => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'taxonomy'  => array(
				'key'      => 'loai-du-an',
				'singular' => __( 'Loại dự án', 'tinphat' ),
				'slug'     => 'loai-du-an',
			),
		),
		'van-hoa'    => array(
			'singular'  => __( 'Văn hóa', 'tinphat' ),
			'plural'    => __( 'Văn hóa', 'tinphat' ),
			'menu_icon' => 'dashicons-groups',
			'slug'      => 'van-hoa',
			'supports'  => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		),
		'video'      => array(
			'singular'  => __( 'Video', 'tinphat' ),
			'plural'    => __( 'Video', 'tinphat' ),
			'menu_icon' => 'dashicons-video-alt3',
			'slug'      => 'video',
			'supports'  => array( 'title', 'thumbnail' ),
		),
		'tuyen-dung' => array(
			'singular'  => __( 'Tuyển dụng', 'tinphat' ),
			'plural'    => __( 'Tuyển dụng', 'tinphat' ),
			'menu_icon' => 'dashicons-id-alt',
			'slug'      => 'tuyen-dung',
			'supports'  => array( 'title', 'editor' ),
		),
		'doi-tac'    => array(
			'singular'     => __( 'Đối tác', 'tinphat' ),
			'plural'       => __( 'Đối tác', 'tinphat' ),
			'menu_icon'    => 'dashicons-networking',
			'slug'         => 'doi-tac',
			'supports'     => array( 'title', 'thumbnail' ),
			'public'       => false,
			'show_in_menu' => true,
			'taxonomy'     => array(
				'key'      => 'nhom-doi-tac',
				'singular' => __( 'Nhóm đối tác', 'tinphat' ),
				'slug'     => 'nhom-doi-tac',
			),
		),
	);
}

/**
 * Đăng ký toàn bộ CPT và taxonomy đi kèm.
 */
function tinphat_register_post_types(): void {
	foreach ( tinphat_post_types() as $key => $config ) {
		$public = $config['public'] ?? true;

		register_post_type(
			$key,
			array(
				'labels'       => tinphat_build_labels( $config['singular'], $config['plural'] ),
				'public'       => $public,
				'show_ui'      => true,
				'show_in_menu' => $config['show_in_menu'] ?? $public,
				'show_in_rest' => true,
				'has_archive'  => $public,
				'menu_icon'    => $config['menu_icon'],
				'supports'     => $config['supports'],
				'rewrite'      => $public ? array( 'slug' => $config['slug'], 'with_front' => false ) : false,
			)
		);

		if ( ! isset( $config['taxonomy'] ) ) {
			continue;
		}

		$tax = $config['taxonomy'];

		register_taxonomy(
			$tax['key'],
			$key,
			array(
				'labels'            => tinphat_build_labels( $tax['singular'], $tax['singular'] ),
				'public'            => $public,
				'hierarchical'      => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'rewrite'           => $public ? array( 'slug' => $tax['slug'], 'with_front' => false ) : false,
			)
		);
	}
}
add_action( 'init', 'tinphat_register_post_types' );

/**
 * Sinh mảng label từ tên số ít / số nhiều.
 *
 * @param string $singular Tên số ít.
 * @param string $plural   Tên số nhiều.
 * @return array<string,string>
 */
function tinphat_build_labels( string $singular, string $plural ): array {
	return array(
		'name'               => $plural,
		'singular_name'      => $singular,
		'menu_name'          => $plural,
		/* translators: %s: tên loại nội dung */
		'add_new_item'       => sprintf( __( 'Thêm %s mới', 'tinphat' ), $singular ),
		/* translators: %s: tên loại nội dung */
		'edit_item'          => sprintf( __( 'Sửa %s', 'tinphat' ), $singular ),
		/* translators: %s: tên loại nội dung */
		'search_items'       => sprintf( __( 'Tìm %s', 'tinphat' ), $singular ),
		/* translators: %s: tên loại nội dung */
		'not_found'          => sprintf( __( 'Không có %s nào', 'tinphat' ), $singular ),
		/* translators: %s: tên loại nội dung */
		'all_items'          => sprintf( __( 'Tất cả %s', 'tinphat' ), $plural ),
	);
}
