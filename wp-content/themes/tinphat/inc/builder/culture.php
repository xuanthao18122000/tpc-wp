<?php
/**
 * Shortcode: khối văn hóa công ty.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khối "Văn hóa".
 */
class TinPhat_Culture extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_culture';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Văn hóa', 'tinphat' ),
			'category' => 'Tín Phát',
			'options'  => array(
				'title' => array( 'type' => 'textfield', 'heading' => __( 'Tiêu đề', 'tinphat' ), 'default' => '' ),
				'limit' => array( 'type' => 'slider', 'heading' => __( 'Số bài', 'tinphat' ), 'default' => 3, 'min' => 1, 'max' => 9 ),
			),
		);
	}

	/**
	 * Render lưới văn hóa.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Không dùng.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		$atts = shortcode_atts(
			array( 'title' => '', 'limit' => 3 ),
			is_array( $atts ) ? $atts : array(),
			$this->tag
		);

		$query = new WP_Query(
			array(
				'post_type'           => 'van-hoa',
				'post_status'         => 'publish',
				'posts_per_page'      => max( 1, min( 9, (int) $atts['limit'] ) ),
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			)
		);

		if ( ! $query->have_posts() ) {
			return '';
		}

		ob_start();
		?>
		<div class="cultural_section">
			<div class="container">
				<div class="title_section" data-aos="fade-up">
					<div class="row align-items-center">
						<div class="col-md-6 col">
							<h3 class="fs-40 mb-0 fw-bold"><span><?php echo esc_html( $atts['title'] ); ?></span></h3>
						</div>
					</div>
				</div>

				<div class="video_slider mt-4">
					<div class="container">
						<div class="row">
							<?php
							while ( $query->have_posts() ) :
								$query->the_post();
								?>
								<div class="col-md-4">
									<div class="item" data-aos="fade-up">
										<a href="<?php the_permalink(); ?>"
											aria-label="<?php echo esc_attr( (string) get_the_title() ); ?>">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'medium_large', array( 'class' => 'img-fluid wp-post-image', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
											<?php else : ?>
												<span class="tp-thumb-placeholder"></span>
											<?php endif; ?>
										</a>
										<div class="title_video"><?php the_title(); ?></div>
									</div>
								</div>
								<?php
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

new TinPhat_Culture();
