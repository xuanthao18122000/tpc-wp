<?php
/**
 * Thanh header: top line, logo, menu, tìm kiếm, drawer mobile.
 *
 * Markup bám theo CSS của template (#header_site, .top_line, .head_menu).
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_lang    = tinphat_current_lang();
$tp_phone   = tinphat_option( 'phone' );
$tp_socials = tinphat_socials();
?>
<header id="header_site" class="sticky-top scrollUp">

	<div class="top_line py-1">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-4">
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

						<?php if ( '' !== $tp_phone ) : ?>
							<li>
								<a class="fw-bold" href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $tp_phone ) ); ?>">
									<?php echo esc_html( $tp_phone ); ?>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>

				<div class="col-md-6 col-8">
					<div class="d-flex justify-content-end align-items-center">
						<a class="brochure-btn loading" href="<?php echo esc_url( tinphat_brochure_url() ); ?>"
							target="_blank" rel="noreferrer noopener">
							<ul>
								<li><?php esc_html_e( 'e-Brochure', 'tinphat' ); ?></li>
								<li><?php esc_html_e( 'Loading...', 'tinphat' ); ?></li>
								<li><?php esc_html_e( 'Open File', 'tinphat' ); ?></li>
							</ul>
							<div>
								<svg viewBox="0 0 24 24" aria-hidden="true">
									<path d="M 4,12 C 4,12 12,20 12,20 C 12,20 20,12 20,12" />
								</svg>
							</div>
						</a>
						<?php tinphat_language_switcher(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="head_menu py-3 py-md-0">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-2 col-6">
					<a class="logo_site" href="<?php echo esc_url( tinphat_home_url() ); ?>">
						<img class="img-fluid"
							src="<?php echo esc_url( tinphat_logo( 'header' ) ); ?>"
							alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					</a>
				</div>

				<div class="col-md-10 col-6">
					<div class="d-flex d-md-none justify-content-end">
						<a href="#" class="hamburger_btn" aria-label="<?php esc_attr_e( 'Mở menu', 'tinphat' ); ?>">
							<span class="hamburger-icon"><span></span><span></span><span></span><span></span><span></span><span></span></span>
						</a>
					</div>

					<div class="d-md-flex d-none justify-content-end align-items-center">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => false,
								'menu_class'     => 'menu_site',
								'depth'          => 2,
								'fallback_cb'    => false,
								'walker'         => new TinPhat_Nav_Walker(),
							)
						);
						?>

						<div class="search_btn ms-5">
							<a href="#" aria-label="<?php esc_attr_e( 'Tìm kiếm', 'tinphat' ); ?>">
								<img class="img-fluid" src="<?php echo esc_url( tinphat_uploads_url( 'icon-search.svg' ) ); ?>" alt="" draggable="false">
							</a>
							<form class="search_form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<div class="row gx-0">
									<div class="col">
										<label class="screen-reader-text" for="tp-s"><?php esc_html_e( 'Tìm kiếm', 'tinphat' ); ?></label>
										<input id="tp-s" type="search" name="s" class="form-control"
											placeholder="<?php esc_attr_e( 'Từ khóa...', 'tinphat' ); ?>"
											value="<?php echo esc_attr( get_search_query() ); ?>">
										<?php if ( function_exists( 'pll_current_language' ) ) : ?>
											<input type="hidden" name="lang" value="<?php echo esc_attr( $tp_lang ); ?>">
										<?php endif; ?>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>

<div class="overlay_menu"></div>
<div id="menu_mobile">
	<?php tinphat_language_switcher(); ?>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'menu_site',
			'depth'          => 2,
			'fallback_cb'    => false,
			'walker'         => new TinPhat_Nav_Walker(),
		)
	);
	?>
</div>
