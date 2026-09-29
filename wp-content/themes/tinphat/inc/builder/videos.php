<?php
/**
 * Shortcode: khối video.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khối "Videos".
 */
class TinPhat_Videos extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_videos';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Video', 'tinphat' ),
			'category' => 'Tín Phát',
			'options'  => array(
				'title' => array( 'type' => 'textfield', 'heading' => __( 'Tiêu đề', 'tinphat' ), 'default' => '' ),
				'limit' => array( 'type' => 'slider', 'heading' => __( 'Số video', 'tinphat' ), 'default' => 3, 'min' => 1, 'max' => 9 ),
			),
		);
	}

	/**
	 * Render lưới video.
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
				'post_type'           => 'video',
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
		<div class="video_section pt-4">
			<div class="container">
				<div class="title_section mb-4" data-aos="fade-up">
					<div class="row align-items-center">
						<div class="col-md-6 col">
							<h3 class="fs-40 mb-0 fw-bold"><span><?php echo esc_html( $atts['title'] ); ?></span></h3>
						</div>
					</div>
				</div>
			</div>

			<div class="video_slider">
				<div class="container">
					<div class="row">
						<?php
						while ( $query->have_posts() ) :
							$query->the_post();
							$tp_link = (string) tinphat_field( 'video_url' );

							if ( '' === $tp_link ) {
								$tp_link = '#';
							}
							?>
							<div class="col-md-4">
								<div class="item" data-aos="fade-up">
									<a href="<?php echo esc_url( $tp_link ); ?>"
										aria-label="<?php echo esc_attr( (string) get_the_title() ); ?>"
										<?php echo '#' !== $tp_link ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'medium_large', array( 'class' => 'img-fluid', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
										<?php else : ?>
											<span class="tp-thumb-placeholder"></span>
										<?php endif; ?>
										<span class="play_btn"><?php tinphat_the_icon( 'play' ); ?></span>
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
		<?php
		wp_reset_postdata();

		return (string) ob_get_clean();
	}
}

new TinPhat_Videos();
