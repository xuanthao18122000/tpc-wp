<?php
/**
 * Ảnh bìa + breadcrumb cho trang con.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_cover = has_post_thumbnail()
	? (string) get_the_post_thumbnail_url( null, 'full' )
	: tinphat_uploads_url( 'banner-01.webp' ); // MOCKUP: thay bằng ảnh bìa riêng của Tín Phát.

$tp_parent = wp_get_post_parent_id( get_the_ID() );
?>
<div class="page_cover">
	<div class="bg_cover">
		<img class="img-fluid" src="<?php echo esc_url( $tp_cover ); ?>" alt="" draggable="false">
	</div>

	<div class="meta_info">
		<h1 class="fs-40 fw-bold"><?php the_title(); ?></h1>

		<div class="breadcrumb_site">
			<span>
				<span>
					<a href="<?php echo esc_url( tinphat_home_url() ); ?>">
						<?php esc_html_e( 'Trang chủ', 'tinphat' ); ?>
					</a>
				</span>
				<?php echo ' » '; ?>

				<?php if ( $tp_parent > 0 ) : ?>
					<span>
						<a href="<?php echo esc_url( (string) get_permalink( $tp_parent ) ); ?>">
							<?php echo esc_html( (string) get_the_title( $tp_parent ) ); ?>
						</a>
					</span>
					<?php echo ' » '; ?>
				<?php endif; ?>

				<span class="breadcrumb_last" aria-current="page"><?php the_title(); ?></span>
			</span>
		</div>
	</div>
</div>
