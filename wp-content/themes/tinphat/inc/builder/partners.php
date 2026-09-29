<?php
/**
 * Shortcode: dải logo đối tác.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khối "Khách hàng và đối tác".
 */
class TinPhat_Partners extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_partners';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Đối tác', 'tinphat' ),
			'category' => 'Tín Phát',
			'options'  => array(
				'title' => array( 'type' => 'textfield', 'heading' => __( 'Tiêu đề', 'tinphat' ), 'default' => '' ),
			),
		);
	}

	/**
	 * Render dải logo.
	 *
	 * Lấy từ CPT doi-tac; nếu chưa có bài nào thì dùng bộ logo mẫu
	 * trong assets để giữ bố cục.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Không dùng.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		$atts = shortcode_atts(
			array( 'title' => '' ),
			is_array( $atts ) ? $atts : array(),
			$this->tag
		);

		$logos = array();

		$query = new WP_Query(
			array(
				'post_type'           => 'doi-tac',
				'post_status'         => 'publish',
				'posts_per_page'      => 30,
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			)
		);

		while ( $query->have_posts() ) {
			$query->the_post();

			if ( has_post_thumbnail() ) {
				$logos[] = array(
					'src' => (string) get_the_post_thumbnail_url( null, 'medium' ),
					'alt' => (string) get_the_title(),
				);
			}
		}

		wp_reset_postdata();

		// MOCKUP: chưa có CPT đối tác thì dùng logo mẫu từ template.
		if ( empty( $logos ) ) {
			foreach ( tinphat_sample_partner_logos() as $src ) {
				$logos[] = array( 'src' => $src, 'alt' => '' );
			}
		}

		if ( empty( $logos ) ) {
			return '';
		}

		ob_start();
		?>
		<div class="partner_section mt-5 py-5">
			<div class="container">
				<div class="title_partner" data-aos="fade-up">
					<div class="row align-items-center">
						<div class="col-auto">
							<h3 class="fs-40 mb-0 fw-bold"><?php echo esc_html( $atts['title'] ); ?></h3>
						</div>
						<div class="col"><div class="line_img"></div></div>
					</div>
				</div>

				<div class="swiper tp-partners__slider mt-4" data-aos="fade-up">
					<div class="swiper-wrapper">
						<?php foreach ( $logos as $logo ) : ?>
							<div class="swiper-slide tp-partner">
								<img src="<?php echo esc_url( $logo['src'] ); ?>"
									alt="<?php echo esc_attr( $logo['alt'] ); ?>"
									loading="lazy" decoding="async">
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
		return (string) ob_get_clean();
	}
}

new TinPhat_Partners();
