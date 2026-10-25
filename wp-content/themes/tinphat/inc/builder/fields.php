<?php
/**
 * Shortcode: 4 lĩnh vực hoạt động trên trang chủ.
 *
 * Nội dung lấy từ hồ sơ năng lực (trang 10-11 PDF).
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khối lĩnh vực hoạt động.
 */
class TinPhat_Fields extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_fields';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Lĩnh vực', 'tinphat' ),
			'category' => 'Tín Phát',
			'options'  => array(
				'title' => array( 'type' => 'textfield', 'heading' => __( 'Tiêu đề', 'tinphat' ), 'default' => '' ),
			),
		);
	}

	/**
	 * Render 4 lĩnh vực.
	 *
	 * Mỗi lĩnh vực truyền qua thuộc tính f1..f4 dạng
	 * "ảnh|tiêu đề|mô tả" để shortcode gọn, không cần CPT riêng.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Không dùng.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		$atts = shortcode_atts(
			array(
				'title'   => '',
				'cta'     => '',
				'cta_url' => '',
				'f1'      => '',
				'f2'      => '',
				'f3'      => '',
				'f4'      => '',
			),
			is_array( $atts ) ? $atts : array(),
			$this->tag
		);

		$items = array();

		foreach ( array( 'f1', 'f2', 'f3', 'f4' ) as $key ) {
			if ( '' === $atts[ $key ] ) {
				continue;
			}

			$parts = array_map( 'trim', explode( '|', (string) $atts[ $key ] ) );

			if ( count( $parts ) < 3 ) {
				continue;
			}

			$items[] = array(
				'image' => $parts[0],
				'title' => $parts[1],
				'desc'  => $parts[2],
			);
		}

		if ( empty( $items ) ) {
			return '';
		}

		ob_start();
		?>
		<section class="tp-home-fields py-5">
			<div class="container">
				<div class="title_section" data-aos="fade-up">
					<div class="row align-items-center">
						<div class="col-md-6">
							<h2 class="fs-40 mb-0 fw-bold"><span><?php echo esc_html( $atts['title'] ); ?></span></h2>
						</div>
					</div>
				</div>

				<div class="row mt-4">
					<?php foreach ( $items as $i => $item ) : ?>
						<div class="col-md-3 col-6">
							<article class="tp-home-field" data-aos="fade-up" data-aos-delay="<?php echo (int) ( $i * 80 ); ?>">
								<figure class="tp-home-field__media">
									<img src="<?php echo esc_url( tinphat_uploads_url( $item['image'] ) ); ?>"
										alt="<?php echo esc_attr( $item['title'] ); ?>"
										width="720" height="450" loading="lazy" decoding="async">
									<span class="tp-home-field__num"><?php printf( '%02d', (int) $i + 1 ); ?></span>
								</figure>

								<div class="tp-home-field__body">
									<h3><?php echo esc_html( $item['title'] ); ?></h3>
									<p><?php echo esc_html( $item['desc'] ); ?></p>
								</div>
							</article>
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ( '' !== $atts['cta'] && '' !== $atts['cta_url'] ) : ?>
					<p class="tp-home-fields__cta">
						<a class="read_more" href="<?php echo esc_url( $atts['cta_url'] ); ?>">
							<?php echo esc_html( $atts['cta'] ); ?>
						</a>
					</p>
				<?php endif; ?>
			</div>
		</section>
		<?php
		return (string) ob_get_clean();
	}
}

new TinPhat_Fields();
