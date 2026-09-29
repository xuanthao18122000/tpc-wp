<?php
/**
 * Permalink phẳng một cấp cho trang.
 *
 * WordPress mặc định lồng slug theo cây trang:
 *   /vi/gioi-thieu/tong-quan/
 *
 * Site này muốn URL ngắn, mỗi trang một cấp:
 *   /vi/tong-quan/
 *
 * Cấu trúc cây vẫn giữ nguyên trong database, nên tab điều hướng,
 * menu và breadcrumb hoạt động như cũ — chỉ URL là phẳng.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Bỏ phần đường dẫn của trang cha khỏi permalink.
 *
 * @param string  $link Permalink gốc.
 * @param int     $id   ID trang.
 * @return string
 */
function tinphat_flat_page_link( string $link, int $id ): string {
	$post = get_post( $id );

	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return $link;
	}

	// Trang chủ giữ nguyên.
	if ( (int) get_option( 'page_on_front' ) === $id ) {
		return $link;
	}

	if ( 0 === (int) $post->post_parent ) {
		return $link;
	}

	// Giữ nguyên gốc URL và tiền tố ngôn ngữ của chính trang này
	// (không dùng tinphat_home_url(): hàm đó trả về ngôn ngữ đang xem,
	// sẽ sai khi sinh link cho bản dịch).
	$parts = wp_parse_url( $link );

	if ( ! isset( $parts['path'] ) ) {
		return $link;
	}

	$segments = array_values( array_filter( explode( '/', $parts['path'] ) ) );

	if ( empty( $segments ) ) {
		return $link;
	}

	// Segment đầu là mã ngôn ngữ thì giữ lại.
	$prefix = '';

	if ( function_exists( 'pll_languages_list' ) ) {
		$languages = (array) pll_languages_list();

		if ( in_array( $segments[0], $languages, true ) ) {
			$prefix = $segments[0] . '/';
		}
	}

	$base = ( $parts['scheme'] ?? 'http' ) . '://' . ( $parts['host'] ?? '' );

	if ( isset( $parts['port'] ) ) {
		$base .= ':' . $parts['port'];
	}

	return $base . '/' . $prefix . $post->post_name . '/';
}
add_filter( 'page_link', 'tinphat_flat_page_link', 20, 2 );

/**
 * Cho WordPress hiểu URL phẳng khi có request tới.
 *
 * Không tìm thấy trang theo đường dẫn đầy đủ thì thử tìm theo
 * slug cuối cùng.
 *
 * @param WP $wp Đối tượng request.
 */
function tinphat_resolve_flat_page( WP $wp ): void {
	// URL một cấp: WordPress đoán là bài viết nên đặt `name`.
	// URL nhiều cấp: đặt `pagename`.
	$slug = '';

	if ( ! empty( $wp->query_vars['pagename'] ) ) {
		$pagename = (string) $wp->query_vars['pagename'];

		// Đường dẫn đầy đủ vẫn khớp thì giữ nguyên.
		if ( get_page_by_path( $pagename ) instanceof WP_Post ) {
			return;
		}

		$slug = basename( $pagename );
	} elseif ( ! empty( $wp->query_vars['name'] ) ) {
		$slug = (string) $wp->query_vars['name'];

		// `name` cũng là slug của bài viết. Nếu có bài thật trùng slug thì
		// để WordPress xử lý, không cướp request sang trang.
		if ( get_page_by_path( $slug, OBJECT, 'post' ) instanceof WP_Post ) {
			return;
		}
	}

	if ( '' === $slug ) {
		return;
	}

	$page = tinphat_find_page_by_slug( $slug );

	if ( ! $page instanceof WP_Post ) {
		return;
	}

	// Chuyển sang truy vấn trang theo đúng đường dẫn thật.
	unset( $wp->query_vars['name'] );
	$wp->query_vars['pagename'] = get_page_uri( $page->ID );
}
add_action( 'parse_request', 'tinphat_resolve_flat_page' );

/**
 * Tìm trang theo slug, ưu tiên đúng ngôn ngữ đang xem.
 *
 * @param string $slug Slug trang.
 * @return WP_Post|null
 */
function tinphat_find_page_by_slug( string $slug ): ?WP_Post {
	$pages = get_posts(
		array(
			'post_type'        => 'page',
			'name'             => $slug,
			'posts_per_page'   => -1,
			'post_status'      => 'publish',
			'suppress_filters' => false,
		)
	);

	if ( empty( $pages ) ) {
		return null;
	}

	if ( function_exists( 'pll_get_post_language' ) ) {
		$lang = tinphat_current_lang();

		foreach ( $pages as $page ) {
			if ( pll_get_post_language( $page->ID ) === $lang ) {
				return $page;
			}
		}
	}

	return $pages[0];
}

/**
 * Chuyển hướng 301 từ URL lồng cũ sang URL phẳng.
 *
 * Không làm việc này thì cùng một trang có hai URL cùng trả 200,
 * Google coi là nội dung trùng lặp.
 */
function tinphat_redirect_nested_to_flat(): void {
	if ( is_admin() || wp_doing_ajax() || ! is_page() ) {
		return;
	}

	// Xem trước, customizer, REST: giữ nguyên URL kèm tham số.
	// Redirect ở đây sẽ làm rụng preview_id/preview_nonce và người dùng
	// nhận 404 hoặc bị đẩy về bản đã xuất bản.
	if ( is_preview() || is_customize_preview() || is_embed() ) {
		return;
	}

	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}

	$post = get_queried_object();

	if ( ! $post instanceof WP_Post ) {
		return;
	}

	// Chỉ chuẩn hoá URL của trang đã xuất bản — nháp/chờ duyệt chưa có
	// permalink công khai để chuyển tới.
	if ( 'publish' !== get_post_status( $post ) ) {
		return;
	}

	$requested = isset( $_SERVER['REQUEST_URI'] )
		? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) )
		: '';

	if ( '' === $requested ) {
		return;
	}

	$canonical = (string) get_permalink( $post->ID );
	$target    = wp_parse_url( $canonical, PHP_URL_PATH );

	if ( ! is_string( $target ) ) {
		return;
	}

	$current = (string) wp_parse_url( $requested, PHP_URL_PATH );

	// Đã ở URL chuẩn thì thôi.
	if ( untrailingslashit( $current ) === untrailingslashit( $target ) ) {
		return;
	}

	// Giữ lại query string để không mất tham số theo dõi, phân trang…
	$query = (string) wp_parse_url( $requested, PHP_URL_QUERY );

	if ( '' !== $query ) {
		$canonical .= '?' . $query;
	}

	wp_safe_redirect( $canonical, 301 );
	exit;
}
add_action( 'template_redirect', 'tinphat_redirect_nested_to_flat', 5 );
