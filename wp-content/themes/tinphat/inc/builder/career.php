<?php
/**
 * Shortcode: khối tuyển dụng dạng accordion.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khối "Tuyển dụng".
 */
class TinPhat_Career extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_career';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Tuyển dụng', 'tinphat' ),
			'category' => 'Tín Phát',
			'options'  => array(
				'title' => array( 'type' => 'textfield', 'heading' => __( 'Tiêu đề', 'tinphat' ), 'default' => '' ),
				'intro' => array( 'type' => 'textarea', 'heading' => __( 'Giới thiệu', 'tinphat' ), 'default' => '' ),
				'cta'   => array( 'type' => 'textfield', 'heading' => __( 'Nút', 'tinphat' ), 'default' => '' ),
				'link'  => array( 'type' => 'textfield', 'heading' => __( 'Liên kết nút', 'tinphat' ), 'default' => '#' ),
				'limit' => array( 'type' => 'slider', 'heading' => __( 'Số tin', 'tinphat' ), 'default' => 3, 'min' => 1, 'max' => 8 ),
			),
		);
	}

	/**
	 * Render accordion tuyển dụng.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Không dùng.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		$atts = shortcode_atts(
			array( 'title' => '', 'intro' => '', 'cta' => '', 'link' => '#', 'limit' => 3 ),
			is_array( $atts ) ? $atts : array(),
			$this->tag
		);

		$query = new WP_Query(
			array(
				'post_type'           => 'tuyen-dung',
				'post_status'         => 'publish',
				'posts_per_page'      => max( 1, min( 8, (int) $atts['limit'] ) ),
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			)
		);

		ob_start();
		?>
		<div class="career_section pt-3 mb-5">
			<div class="container">
				<div class="row gx-0">
					<div class="col-md-6">
						<div class="content_career" data-aos="fade-left">
							<h3 class="fs-60 fw-bold"><?php echo esc_html( $atts['title'] ); ?></h3>
							<div class="content_inner">
								<div class="border-left"><?php echo esc_html( $atts['intro'] ); ?></div>
								<?php if ( '' !== $atts['cta'] ) : ?>
									<a href="<?php echo esc_url( $atts['link'] ); ?>"><?php echo esc_html( $atts['cta'] ); ?></a>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="accordion" data-tp-accordion data-aos="fade-right">
							<?php
							$i = 0;
							while ( $query->have_posts() ) :
								$query->the_post();
								$open = 0 === $i;
								?>
								<div class="accordion-item">
									<h2 class="accordion-header">
										<button type="button"
											class="accordion-button<?php echo $open ? '' : ' collapsed'; ?>"
											aria-expanded="<?php echo $open ? 'true' : 'false'; ?>">
											<span><?php the_title(); ?></span>
										</button>
									</h2>
									<div class="accordion-collapse collapse<?php echo $open ? ' show' : ''; ?>">
										<div class="accordion-body"><?php echo esc_html( wp_strip_all_tags( (string) get_the_content() ) ); ?></div>
									</div>
								</div>
								<?php
								++$i;
							endwhile;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		wp_reset_postdata();

		return (string) ob_get_clean();
	}
}

new TinPhat_Career();
