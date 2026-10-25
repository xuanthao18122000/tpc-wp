<?php
/**
 * Shortcode: dải khẩu hiệu nền ảnh.
 *
 * Nội dung lấy từ hồ sơ năng lực: "An toàn & Chất lượng là mục tiêu
 * hàng đầu" (trang 02–03) và "Đơn vị Tổng thầu thi công xây dựng hàng
 * đầu Việt Nam" (trang 04–05).
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khối khẩu hiệu toàn chiều rộng.
 */
class TinPhat_Motto extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_motto';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Khẩu hiệu', 'tinphat' ),
			'category' => 'Tín Phát',
			'options'  => array(
				'title' => array( 'type' => 'textfield', 'heading' => __( 'Khẩu hiệu', 'tinphat' ), 'default' => '' ),
				'sub'   => array( 'type' => 'textfield', 'heading' => __( 'Dòng phụ', 'tinphat' ), 'default' => '' ),
				'image' => array( 'type' => 'textfield', 'heading' => __( 'Ảnh nền', 'tinphat' ), 'default' => '' ),
			),
		);
	}

	/**
	 * Render dải khẩu hiệu.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Không dùng.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		$atts = shortcode_atts(
			array(
				'title' => '',
				'sub'   => '',
				'image' => 'tp-motto-bg.webp',
			),
			is_array( $atts ) ? $atts : array(),
			$this->tag
		);

		if ( '' === $atts['title'] ) {
			return '';
		}

		ob_start();
		?>
		<section class="tp-motto-band">
			<img class="tp-motto-band__bg"
				src="<?php echo esc_url( tinphat_uploads_url( $atts['image'] ) ); ?>"
				alt="" width="1920" height="560" loading="lazy" decoding="async">

			<div class="container tp-motto-band__inner">
				<p class="tp-motto-band__title"><?php echo esc_html( $atts['title'] ); ?></p>

				<?php if ( '' !== $atts['sub'] ) : ?>
					<p class="tp-motto-band__sub"><?php echo esc_html( $atts['sub'] ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php
		return (string) ob_get_clean();
	}
}

new TinPhat_Motto();
