<?php
/**
 * Walker menu: sinh markup khớp CSS template (.menu-item-has-children, .sub-menu).
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

/**
 * Walker cho menu chính.
 */
class TinPhat_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Mở cấp con.
	 *
	 * @param string   $output Chuỗi HTML.
	 * @param int      $depth  Cấp hiện tại.
	 * @param stdClass $args   Tham số menu.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="sub-menu">';
	}

	/**
	 * Đóng cấp con.
	 *
	 * @param string   $output Chuỗi HTML.
	 * @param int      $depth  Cấp hiện tại.
	 * @param stdClass $args   Tham số menu.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	/**
	 * Mở một mục menu.
	 *
	 * @param string   $output            Chuỗi HTML.
	 * @param WP_Post  $data_object       Mục menu.
	 * @param int      $depth             Cấp hiện tại.
	 * @param stdClass $args              Tham số menu.
	 * @param int      $current_object_id ID đối tượng hiện tại.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$classes   = empty( $data_object->classes ) ? array() : (array) $data_object->classes;
		$classes[] = 'menu-item-' . $data_object->ID;

		$has_children = in_array( 'menu-item-has-children', $classes, true );

		if ( ! $has_children ) {
			$classes[] = 'menu-item';
		}

		$class_names = implode( ' ', array_map( 'sanitize_html_class', array_filter( array_unique( $classes ) ) ) );

		$output .= '<li class="' . esc_attr( $class_names ) . '">';

		$atts = array(
			'href'   => ! empty( $data_object->url ) ? $data_object->url : '',
			'title'  => ! empty( $data_object->attr_title ) ? $data_object->attr_title : '',
			'target' => ! empty( $data_object->target ) ? $data_object->target : '',
			'rel'    => ! empty( $data_object->xfn ) ? $data_object->xfn : '',
		);

		$attributes = '';

		foreach ( $atts as $name => $value ) {
			if ( '' === $value ) {
				continue;
			}

			$attributes .= sprintf(
				' %s="%s"',
				esc_attr( $name ),
				'href' === $name ? esc_url( $value ) : esc_attr( $value )
			);
		}

		$title  = apply_filters( 'the_title', $data_object->title, $data_object->ID );
		$caret  = ( $has_children && 0 === $depth ) ? tinphat_icon( 'angle-down', 'cc-caret' ) : '';

		$output .= '<a' . $attributes . '>' . esc_html( $title ) . $caret . '</a>';
	}

	/**
	 * Đóng một mục menu.
	 *
	 * @param string  $output      Chuỗi HTML.
	 * @param WP_Post $data_object Mục menu.
	 * @param int     $depth       Cấp hiện tại.
	 * @param array   $args        Tham số menu.
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}
