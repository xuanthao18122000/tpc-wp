<?php
/**
 * Nút chia sẻ bài viết.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_url   = rawurlencode( (string) get_permalink() );
$tp_title = rawurlencode( (string) get_the_title() );
?>
<div class="tp-share">
	<span class="tp-share__label"><?php esc_html_e( 'Chia sẻ', 'tinphat' ); ?></span>

	<a class="tp-share__btn" target="_blank" rel="noopener noreferrer"
		href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr( $tp_url ); ?>"
		aria-label="<?php esc_attr_e( 'Chia sẻ lên Facebook', 'tinphat' ); ?>">
		<?php tinphat_the_icon( 'facebook' ); ?>
	</a>

	<a class="tp-share__btn" target="_blank" rel="noopener noreferrer"
		href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr( $tp_url ); ?>"
		aria-label="<?php esc_attr_e( 'Chia sẻ lên LinkedIn', 'tinphat' ); ?>">
		<?php tinphat_the_icon( 'linkedin' ); ?>
	</a>
</div>
