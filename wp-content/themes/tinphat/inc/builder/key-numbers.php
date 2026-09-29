<?php
/**
 * Shortcode: dải số liệu có hiệu ứng đếm.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Khối "Số liệu nổi bật".
 */
class TinPhat_Key_Numbers extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_key_numbers';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Số liệu', 'tinphat' ),
			'category' => 'Tín Phát',
			'type'     => 'container',
			'allow'    => array( 'tinphat_key_number_item' ),
			'options'  => array(
				'heading'    => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề', 'tinphat' ),
					'default' => '',
				),
				'subheading' => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề phụ', 'tinphat' ),
					'default' => '',
				),
			),
		);
	}

	/**
	 * Render khối bao ngoài.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Các item bên trong.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		$atts = shortcode_atts(
			array(
				'heading'    => '',
				'subheading' => '',
			),
			is_array( $atts ) ? $atts : array(),
			$this->tag
		);

		ob_start();
		?>
		<section class="tp-key-numbers" data-tp-count>
			<div class="container">
				<?php if ( '' !== $atts['heading'] ) : ?>
					<h2 class="tp-key-numbers__heading"><?php echo esc_html( $atts['heading'] ); ?></h2>
				<?php endif; ?>

				<?php if ( '' !== $atts['subheading'] ) : ?>
					<p class="tp-key-numbers__sub"><?php echo esc_html( $atts['subheading'] ); ?></p>
				<?php endif; ?>

				<div class="tp-key-numbers__grid">
					<?php echo do_shortcode( (string) $content ); ?>
				</div>
			</div>
		</section>
		<?php
		return (string) ob_get_clean();
	}
}

/**
 * Một ô số liệu.
 */
class TinPhat_Key_Number_Item extends TinPhat_Shortcode {

	/**
	 * Tag shortcode.
	 *
	 * @var string
	 */
	protected string $tag = 'tinphat_key_number_item';

	/**
	 * Cấu hình UX Builder.
	 *
	 * @return array<string,mixed>
	 */
	protected function builder_config(): array {
		return array(
			'name'     => __( 'Tín Phát — Ô số liệu', 'tinphat' ),
			'category' => 'Tín Phát',
			'require'  => array( 'tinphat_key_numbers' ),
			'options'  => array(
				'label' => array(
					'type'    => 'textfield',
					'heading' => __( 'Nhãn', 'tinphat' ),
					'default' => '',
				),
				'value' => array(
					'type'    => 'textfield',
					'heading' => __( 'Giá trị (chỉ số)', 'tinphat' ),
					'default' => '0',
				),
				'unit'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Đơn vị', 'tinphat' ),
					'default' => '',
				),
			),
		);
	}

	/**
	 * Render một ô.
	 *
	 * @param array<string,mixed>|string $atts    Thuộc tính.
	 * @param string|null                $content Không dùng.
	 * @return string
	 */
	public function render( $atts = array(), $content = null ): string {
		$atts = shortcode_atts(
			array(
				'label' => '',
				'value' => '0',
				'unit'  => '',
			),
			is_array( $atts ) ? $atts : array(),
			$this->tag
		);

		$target = (int) preg_replace( '/\D/', '', (string) $atts['value'] );

		ob_start();
		?>
		<div class="tp-key-number">
			<div class="tp-key-number__label"><?php echo esc_html( $atts['label'] ); ?></div>
			<div class="tp-key-number__value">
				<span data-tp-count-to="<?php echo esc_attr( (string) $target ); ?>">0</span>
				<?php if ( '' !== $atts['unit'] ) : ?>
					<span class="tp-key-number__unit"><?php echo esc_html( $atts['unit'] ); ?></span>
				<?php endif; ?>
			</div>
		</div>
		<?php
		return (string) ob_get_clean();
	}
}

new TinPhat_Key_Numbers();
new TinPhat_Key_Number_Item();
