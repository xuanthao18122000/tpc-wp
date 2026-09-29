<?php
/**
 * Thẻ hiển thị một dự án.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_client   = (string) tinphat_field( 'client' );
$tp_location = (string) tinphat_field( 'location' );
$tp_scope    = (string) tinphat_field( 'scope' );
?>
<article class="swiper-slide tp-project">
	<a class="tp-project__link" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="tp-project__media">
				<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'class' => 'tp-project__img' ) ); ?>
			</div>
		<?php endif; ?>

		<h3 class="tp-project__name"><?php the_title(); ?></h3>

		<dl class="tp-project__meta">
			<?php if ( '' !== $tp_client ) : ?>
				<dt><?php esc_html_e( 'Khách hàng', 'tinphat' ); ?></dt>
				<dd><?php echo esc_html( $tp_client ); ?></dd>
			<?php endif; ?>

			<?php if ( '' !== $tp_location ) : ?>
				<dt><?php esc_html_e( 'Vị trí', 'tinphat' ); ?></dt>
				<dd><?php echo esc_html( $tp_location ); ?></dd>
			<?php endif; ?>

			<?php if ( '' !== $tp_scope ) : ?>
				<dt><?php esc_html_e( 'Phạm vi công việc', 'tinphat' ); ?></dt>
				<dd><?php echo esc_html( $tp_scope ); ?></dd>
			<?php endif; ?>
		</dl>
	</a>
</article>
