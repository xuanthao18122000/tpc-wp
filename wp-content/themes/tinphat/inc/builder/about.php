<?php
/**
 * Shortcode: giới thiệu ngắn trên trang chủ.
 *
 * Rút gọn nội dung trang Tổng quan + Tầm nhìn, kèm ảnh và nút
 * dẫn sang trang Giới thiệu đầy đủ.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khối giới thiệu công ty.
 */
class TinPhat_About extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_about';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Giới thiệu', 'tinphat' ),
			'category' => 'Tín Phát',
			'options'  => array(
				'title' => array( 'type' => 'textfield', 'heading' => __( 'Tiêu đề', 'tinphat' ), 'default' => '' ),
			),
		);
	}

	/**
	 * Render khối giới thiệu.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Không dùng.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		$atts = shortcode_atts(
			array(
				'title'   => '',
				'lead'    => '',
				'body'    => '',
				'image'   => 'tp-cap-fields.webp',
				'cta'     => '',
				'cta_url' => '',
			),
			is_array( $atts ) ? $atts : array(),
			$this->tag
		);

		if ( '' === $atts['title'] ) {
			return '';
		}

		ob_start();
		?>
		<section class="tp-home-about py-5">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6">
						<figure class="tp-home-about__media">
							<img src="<?php echo esc_url( tinphat_uploads_url( $atts['image'] ) ); ?>"
								alt="<?php echo esc_attr( $atts['title'] ); ?>"
								width="960" height="600" loading="lazy" decoding="async">
						</figure>
					</div>

					<div class="col-md-6">
						<div class="tp-home-about__body">
							<h2 class="tp-home-about__title"><?php echo esc_html( $atts['title'] ); ?></h2>

							<?php if ( '' !== $atts['lead'] ) : ?>
								<p class="tp-home-about__lead"><?php echo esc_html( $atts['lead'] ); ?></p>
							<?php endif; ?>

							<?php if ( '' !== $atts['body'] ) : ?>
								<p><?php echo esc_html( $atts['body'] ); ?></p>
							<?php endif; ?>

							<?php if ( '' !== $atts['cta'] && '' !== $atts['cta_url'] ) : ?>
								<a class="tp-btn" href="<?php echo esc_url( $atts['cta_url'] ); ?>">
									<?php echo esc_html( $atts['cta'] ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
		return (string) ob_get_clean();
	}
}

new TinPhat_About();
