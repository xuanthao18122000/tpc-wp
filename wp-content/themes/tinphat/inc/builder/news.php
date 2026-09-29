<?php
/**
 * Shortcode: danh sách tin mới nhất ở trang chủ.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khối "Tin mới nhất".
 */
class TinPhat_Home_News extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_news';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Tin tức', 'tinphat' ),
			'category' => 'Tín Phát',
			'options'  => array(
				'title' => array( 'type' => 'textfield', 'heading' => __( 'Tiêu đề', 'tinphat' ), 'default' => '' ),
				'limit' => array( 'type' => 'slider', 'heading' => __( 'Số bài', 'tinphat' ), 'default' => 8, 'min' => 3, 'max' => 12 ),
			),
		);
	}

	/**
	 * Render danh sách tin.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Không dùng.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		$atts = shortcode_atts(
			array( 'title' => '', 'limit' => 8 ),
			is_array( $atts ) ? $atts : array(),
			$this->tag
		);

		$query = new WP_Query(
			array(
				'post_type'              => 'post',
				'post_status'            => 'publish',
				'posts_per_page'         => max( 1, min( 12, (int) $atts['limit'] ) ),
				'no_found_rows'          => true,
				'ignore_sticky_posts'    => true,
			)
		);

		if ( ! $query->have_posts() ) {
			return '';
		}

		$archive_id = (int) get_option( 'page_for_posts' );
		$archive    = $archive_id > 0 ? (string) get_permalink( $archive_id ) : '';

		ob_start();
		?>
		<div class="latest_news_section pt-md-5 pt-2">
			<div class="container">
				<div class="title_section" data-aos="fade-up">
					<div class="row align-items-center justify-content-between">
						<div class="col-md-6 col-auto">
							<h3 class="fs-40 mb-0 fw-bold"><span><?php echo esc_html( $atts['title'] ); ?></span></h3>
						</div>
					</div>
				</div>

				<div class="post_cff mt-4" data-aos="fade-up">
					<div class="row">
						<?php
						while ( $query->have_posts() ) :
							$query->the_post();
							$tp_cats = get_the_category();
							?>
							<div class="col-md-12">
								<div class="post_item mb-4">
									<div class="row gx-2 gx-md-3">
										<div class="col-md-2 col-6">
											<figure>
												<a href="<?php the_permalink(); ?>"
													aria-label="<?php echo esc_attr( (string) get_the_title() ); ?>">
													<?php if ( has_post_thumbnail() ) : ?>
														<?php the_post_thumbnail( 'medium', array( 'class' => 'img-fluid wp-post-image', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
													<?php else : ?>
														<span class="tp-thumb-placeholder"></span>
													<?php endif; ?>
												</a>
											</figure>
										</div>
										<div class="col-md-10 col-6">
											<div class="post_info">
												<h4 class="fs-16 fw-bold">
													<a href="<?php the_permalink(); ?>" class="cl-blue"><?php the_title(); ?></a>
												</h4>
												<div class="d-none d-md-block">
													<div class="post_cate fw-bold fs-13">
														<?php
														if ( ! empty( $tp_cats ) ) {
															echo esc_html( $tp_cats[0]->name ) . ' | ';
														}
														echo esc_html( (string) get_the_date() );
														?>
													</div>
													<?php echo esc_html( wp_trim_words( (string) get_the_excerpt(), 34 ) ); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						endwhile;
						?>
					</div>
				</div>

				<?php if ( '' !== $archive ) : ?>
					<div class="news_more">
						<a href="<?php echo esc_url( $archive ); ?>"><?php esc_html_e( 'Xem tất cả', 'tinphat' ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
		wp_reset_postdata();

		return (string) ob_get_clean();
	}
}

new TinPhat_Home_News();
