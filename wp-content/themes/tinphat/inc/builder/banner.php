<?php
/**
 * Shortcode: banner trang chủ.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khối banner slider.
 */
class TinPhat_Banner extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_banner';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Banner', 'tinphat' ),
			'category' => 'Tín Phát',
			'type'     => 'container',
			'allow'    => array( 'tinphat_banner_item' ),
			'options'  => array(),
		);
	}

	/**
	 * Render slider.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Các slide.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		ob_start();
		?>
		<div id="banner_site" class="newslide">
			<div class="swiper tp-banner__slider">
				<div class="swiper-wrapper">
					<?php echo do_shortcode( (string) $content ); ?>
				</div>
				<div class="swiper-button-prev" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Slide trước', 'tinphat' ); ?>"></div>
				<div class="swiper-button-next" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Slide sau', 'tinphat' ); ?>"></div>
			</div>
		</div>
		<?php
		return (string) ob_get_clean();
	}
}

/**
 * Một slide banner.
 */
class TinPhat_Banner_Item extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_banner_item';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Slide banner', 'tinphat' ),
			'category' => 'Tín Phát',
			'require'  => array( 'tinphat_banner' ),
			'options'  => array(
				'image' => array(
					'type'    => 'image',
					'heading' => __( 'Hình nền', 'tinphat' ),
				),
				'title' => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề', 'tinphat' ),
					'default' => '',
				),
				'link'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Liên kết', 'tinphat' ),
					'default' => '',
				),
			),
		);
	}

	/**
	 * Render một slide.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Không dùng.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		$atts = shortcode_atts(
			array(
				'image' => '',
				'title' => '',
				'link'  => '',
				'eager' => '',
			),
			is_array( $atts ) ? $atts : array(),
			$this->tag
		);

		$atts['eager'] = ( '1' === (string) $atts['eager'] || 'true' === (string) $atts['eager'] );

		$src = '';

		if ( is_numeric( $atts['image'] ) ) {
			$src = tinphat_image_url( (int) $atts['image'], 'full' );
		} elseif ( '' !== $atts['image'] ) {
			$src = (string) $atts['image'];
		}

		if ( '' === $src ) {
			return '';
		}

		ob_start();
		?>
		<div class="swiper-slide item">
			<?php if ( '' !== $atts['link'] ) : ?>
				<a href="<?php echo esc_url( $atts['link'] ); ?>">
			<?php endif; ?>

			<img src="<?php echo esc_url( $src ); ?>"
				alt="<?php echo esc_attr( $atts['title'] ); ?>"
				<?php // Khớp kích thước thật của file banner (xem scripts/make-banners.php). ?>
				width="2560" height="1440"
				<?php // Slide đầu là ứng viên LCP: tải ngay, không lazy. ?>
				<?php if ( $atts['eager'] ) : ?>
					fetchpriority="high" decoding="async"
				<?php else : ?>
					loading="lazy" decoding="async"
				<?php endif; ?>>

			<?php if ( '' !== $atts['title'] ) : ?>
				<div class="meta_info">
					<div class="container">
						<div class="meta_inner">
							<div class="description"><?php echo esc_html( $atts['title'] ); ?></div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( '' !== $atts['link'] ) : ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
		return (string) ob_get_clean();
	}
}

new TinPhat_Banner();
new TinPhat_Banner_Item();
