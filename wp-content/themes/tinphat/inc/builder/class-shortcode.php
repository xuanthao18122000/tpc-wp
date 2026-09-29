<?php
/**
 * Lớp cơ sở cho shortcode của theme.
 *
 * Shortcode đăng ký bằng add_shortcode() chuẩn WordPress nên chạy độc lập.
 * Phần UX Builder chỉ kích hoạt nếu có Flatsome — hiện không dùng,
 * giữ lại để không mất công viết lại nếu sau này đổi ý.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Đăng ký shortcode vừa cho WordPress vừa cho UX Builder.
 */
abstract class TinPhat_Shortcode {

	/**
	 * Tag của shortcode.
	 *
	 * @var string
	 */
	protected string $tag = '';

	/**
	 * Gắn hook.
	 */
	public function __construct() {
		if ( '' === $this->tag ) {
			return;
		}

		add_shortcode( $this->tag, array( $this, 'render' ) );
		add_action( 'ux_builder_setup', array( $this, 'register_builder' ) );
	}

	/**
	 * Khai báo cho UX Builder (chỉ chạy khi cài Flatsome).
	 */
	public function register_builder(): void {
		if ( ! function_exists( 'add_ux_builder_shortcode' ) ) {
			return;
		}

		add_ux_builder_shortcode( $this->tag, $this->builder_config() );
	}

	/**
	 * Cấu hình hiển thị trong UX Builder.
	 *
	 * Không dùng khi chạy độc lập, nhưng vẫn khai báo để tài liệu hoá
	 * các tham số mà shortcode nhận.
	 *
	 * @return array<string,mixed>
	 */
	abstract protected function builder_config(): array;

	/**
	 * Render HTML.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Nội dung bên trong.
	 * @return string
	 */
	abstract public function render( $atts = array(), $content = null ): string;
}
