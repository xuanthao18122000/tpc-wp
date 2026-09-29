<?php
/**
 * Shortcode: carousel dự án, lấy dữ liệu từ CPT du-an.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khối "Dự án".
 */
class TinPhat_Projects extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_projects';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Dự án', 'tinphat' ),
			'category' => 'Tín Phát',
			'options'  => array(
				'title'    => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề', 'tinphat' ),
					'default' => '',
				),
				'limit'    => array(
					'type'    => 'slider',
					'heading' => __( 'Số dự án hiển thị', 'tinphat' ),
					'default' => 9,
					'min'     => 3,
					'max'     => 24,
				),
				'category' => array(
					'type'     => 'select',
					'heading'  => __( 'Lọc theo loại', 'tinphat' ),
					'default'  => '',
					'config'   => array(
						'placeholder' => __( 'Tất cả', 'tinphat' ),
						'termSelect'  => array( 'post_type' => 'du-an', 'taxonomies' => 'loai-du-an' ),
					),
				),
			),
		);
	}

	/**
	 * Render carousel.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Không dùng.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		$atts = shortcode_atts(
			array(
				'title'    => '',
				'limit'    => 9,
				'category' => '',
			),
			is_array( $atts ) ? $atts : array(),
			$this->tag
		);

		$args = array(
			'post_type'              => 'du-an',
			'post_status'            => 'publish',
			'posts_per_page'         => max( 1, min( 24, (int) $atts['limit'] ) ),
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'ignore_sticky_posts'    => true,
		);

		if ( '' !== $atts['category'] ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'loai-du-an',
					'field'    => 'slug',
					'terms'    => sanitize_title( (string) $atts['category'] ),
				),
			);
		}

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return '';
		}

		ob_start();
		?>
		<section class="tp-projects">
			<?php if ( '' !== $atts['title'] ) : ?>
				<h2 class="tp-projects__title"><?php echo esc_html( $atts['title'] ); ?></h2>
			<?php endif; ?>

			<div class="swiper tp-projects__slider">
				<div class="swiper-wrapper">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						get_template_part( 'template-parts/project', 'card' );
					endwhile;
					?>
				</div>
				<div class="swiper-button-prev" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Slide trước', 'tinphat' ); ?>"></div>
				<div class="swiper-button-next" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Slide sau', 'tinphat' ); ?>"></div>
			</div>
		</section>
		<?php
		wp_reset_postdata();

		return (string) ob_get_clean();
	}
}

new TinPhat_Projects();
