<?php
/**
 * Chân trang: logo, liên hệ, sitemap, mạng xã hội, copyright.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_phone   = tinphat_option( 'phone' );
$tp_socials = tinphat_socials();
?>
<footer id="footer_site">
	<div class="container">
		<div class="pt-5 pb-3">
			<div class="row">
				<div class="col-md-3">
					<div class="logo_box mb-3">
						<a class="logo_ft" href="<?php echo esc_url( tinphat_home_url() ); ?>">
							<img class="img-fluid"
								src="<?php echo esc_url( tinphat_logo( 'footer' ) ); ?>"
								alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" draggable="false">
						</a>
						<img src="<?php echo esc_url( tinphat_uploads_url( 'footer-map-bg.webp' ) ); ?>" alt="" draggable="false">
					</div>
				</div>

				<div class="col-md-9">
					<div class="row">
						<div class="col-md-5 col-8 order-md-0">
							<div class="pe-md-3">
								<h3 class="fs-16 text-uppercase fw-bold mb-3"><?php esc_html_e( 'Liên Hệ', 'tinphat' ); ?></h3>
								<ul>
									<li>
										<img src="<?php echo esc_url( tinphat_uploads_url( 'icon-marker.svg' ) ); ?>" alt="" draggable="false">
										<?php echo esc_html( tinphat_option( 'address' ) ); ?>
									</li>
									<li>
										<img src="<?php echo esc_url( tinphat_uploads_url( 'icon-phone.svg' ) ); ?>" alt="" draggable="false">
										<?php echo esc_html( $tp_phone ); ?>
									</li>
									<li>
										<img src="<?php echo esc_url( tinphat_uploads_url( 'icon-email.svg' ) ); ?>" alt="" draggable="false">
										<?php echo esc_html( tinphat_option( 'email' ) ); ?>
									</li>
								</ul>

								<h3 class="fs-16 text-uppercase fw-bold mb-3"><?php esc_html_e( 'Giờ Làm Việc', 'tinphat' ); ?></h3>
								<ul>
									<li>
										<img src="<?php echo esc_url( tinphat_uploads_url( 'icon-marker.svg' ) ); ?>" alt="" draggable="false">
										<?php echo esc_html( tinphat_option( 'hours' ) ); ?>
									</li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-4 order-md-1">
							<h3 class="fs-16 text-uppercase fw-bold mb-3"><?php esc_html_e( 'SITEMAP', 'tinphat' ); ?></h3>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'footer',
									'container'      => false,
									'menu_id'        => 'menu-menu-footer',
									'depth'          => 1,
									'fallback_cb'    => false,
								)
							);
							?>
						</div>

						<div class="col-md-4 order-md-2">
							<h3 class="fs-16 text-uppercase fw-bold mb-3"><?php esc_html_e( 'Theo dõi', 'tinphat' ); ?></h3>
							<ul class="social">
								<?php foreach ( $tp_socials as $tp_social ) : ?>
									<li>
										<a href="<?php echo esc_url( $tp_social['url'] ); ?>"
											target="_blank" rel="noreferrer noopener"
											aria-label="<?php echo esc_attr( $tp_social['name'] ); ?>">
											<?php tinphat_the_icon( $tp_social['icon'] ); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>

							<?php if ( '' !== $tp_phone ) : ?>
								<div class="mt-3">
									<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $tp_phone ) ); ?>">
										<?php esc_html_e( 'Hotline', 'tinphat' ); ?>: <?php echo esc_html( $tp_phone ); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="copyright pt-3 pb-3">
			<div class="row">
				<div class="col-md-6">
					<?php
					printf(
						/* translators: %1$s: năm, %2$s: tên công ty */
						esc_html__( '© %1$s %2$s. All Rights Reserved.', 'tinphat' ),
						esc_html( gmdate( 'Y' ) ),
						esc_html( tinphat_option( 'company_name' ) )
					);
					?>
				</div>
				<div class="col-md-6 text-md-end">
					<a href="#"><?php esc_html_e( 'Điều Khoản Dịch Vụ', 'tinphat' ); ?></a>
					<?php echo ' | '; ?>
					<a href="#"><?php esc_html_e( 'Chính Sách Bảo Mật', 'tinphat' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</footer>
