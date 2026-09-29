<?php
/**
 * Trang 404.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="container tp-page__body tp-404">
	<h1 class="tp-404__code">404</h1>
	<p class="tp-404__text"><?php esc_html_e( 'Không tìm thấy trang bạn yêu cầu.', 'tinphat' ); ?></p>
	<a class="tp-404__home" href="<?php echo esc_url( tinphat_home_url() ); ?>">
		<?php esc_html_e( 'Về trang chủ', 'tinphat' ); ?>
	</a>
</div>
<?php
get_footer();
