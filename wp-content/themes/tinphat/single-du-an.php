<?php
/**
 * Chi tiết một dự án.
 *
 * Dùng chung bố cục với trang chi tiết tin tức: banner → menu chuyên mục
 * → 2 cột (nội dung 8/12 + sidebar 4/12) → nút chia sẻ.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$tp_client   = (string) tinphat_field( 'client' );
	$tp_location = (string) tinphat_field( 'location' );
	$tp_scope    = (string) tinphat_field( 'scope' );
	$tp_value    = (string) get_post_meta( get_the_ID(), 'contract_value', true );
	$tp_grade    = (string) get_post_meta( get_the_ID(), 'grade', true );
	$tp_signed   = (string) get_post_meta( get_the_ID(), 'signed_date', true );
	$tp_done     = (string) get_post_meta( get_the_ID(), 'completion_date', true );
	$tp_archive  = (string) get_post_type_archive_link( 'du-an' );

	// post_type_archive_title() chỉ trả về giá trị trên trang archive,
	// ở trang chi tiết phải lấy nhãn từ chính object CPT.
	$tp_pt       = get_post_type_object( 'du-an' );
	$tp_pt_label = $tp_pt instanceof WP_Post_Type ? (string) $tp_pt->labels->name : __( 'Dự án', 'tinphat' );

	$tp_gallery = (array) get_post_meta( get_the_ID(), 'gallery', true );
	$tp_gallery = array_filter( array_map( 'intval', $tp_gallery ) );
	?>
	<article <?php post_class( 'tp-project-single' ); ?>>
		<div class="page_cover">
			<div class="bg_cover">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'full', array( 'class' => 'img-fluid', 'draggable' => 'false' ) );
				} else {
					printf(
						'<img class="img-fluid" src="%s" alt="" draggable="false">',
						esc_url( tinphat_uploads_url( 'tp-cover-capability.webp' ) )
					);
				}
				?>
			</div>

			<div class="meta_info">
				<h1 class="fs-40 fw-bold"><?php the_title(); ?></h1>

				<div class="breadcrumb_site">
					<span>
						<span><a href="<?php echo esc_url( tinphat_home_url() ); ?>"><?php esc_html_e( 'Trang chủ', 'tinphat' ); ?></a></span>
						<?php echo ' » '; ?>
						<span><a href="<?php echo esc_url( $tp_archive ); ?>"><?php echo esc_html( $tp_pt_label ); ?></a></span>
						<?php echo ' » '; ?>
						<span class="breadcrumb_last" aria-current="page"><?php the_title(); ?></span>
					</span>
				</div>
			</div>
		</div>

		<div class="news__page py-5">
			<div class="container">
				<div class="menu_news">
					<div class="row align-items-center">
						<div class="col-md-6">
							<h2 class="fs-40 fw-bold text-uppercase"><?php echo esc_html( $tp_pt_label ); ?></h2>
						</div>

						<div class="col-md-6">
							<ul>
								<li class="active">
									<a href="<?php echo esc_url( $tp_archive ); ?>">
										<?php esc_html_e( 'Tất cả dự án', 'tinphat' ); ?>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-8">
						<div class="tp-single__main">
							<h2 class="tp-single__title"><?php the_title(); ?></h2>

							<div class="tp-single__meta">
								<?php if ( '' !== $tp_location ) : ?>
									<span><?php echo esc_html( $tp_location ); ?></span>
								<?php endif; ?>

								<?php if ( '' !== $tp_grade ) : ?>
									<span class="tp-single__cat"><?php echo esc_html( $tp_grade ); ?></span>
								<?php endif; ?>
							</div>

							<?php if ( has_post_thumbnail() ) : ?>
								<figure class="tp-single__figure">
									<?php the_post_thumbnail( 'large', array( 'decoding' => 'async' ) ); ?>
								</figure>
							<?php endif; ?>

							<div class="tp-single__content">
								<?php if ( '' !== $tp_scope ) : ?>
									<p class="tp-lead-desc"><?php echo esc_html( $tp_scope ); ?></p>
								<?php endif; ?>

								<?php
								// Nội dung chi tiết nếu đã nhập trong admin.
								the_content();
								?>
							</div>

							<?php if ( ! empty( $tp_gallery ) ) : ?>
								<h3 class="tp-project-gallery__title">
									<?php esc_html_e( 'Hình ảnh thi công', 'tinphat' ); ?>
								</h3>

								<div class="tp-project-gallery">
									<?php foreach ( $tp_gallery as $tp_id ) : ?>
										<figure class="tp-project-gallery__item">
											<?php
											echo wp_get_attachment_image(
												$tp_id,
												'medium_large',
												false,
												array( 'loading' => 'lazy', 'decoding' => 'async' )
											);
											?>
										</figure>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<?php get_template_part( 'template-parts/news/share' ); ?>
						</div>
					</div>

					<div class="col-md-4">
						<aside class="tp-project-detail__aside">
							<h2 class="tp-project-detail__title"><?php esc_html_e( 'Tổng quan', 'tinphat' ); ?></h2>

							<dl class="tp-project-detail__facts">
								<?php if ( '' !== $tp_client ) : ?>
									<dt><?php esc_html_e( 'Chủ đầu tư', 'tinphat' ); ?></dt>
									<dd><?php echo esc_html( $tp_client ); ?></dd>
								<?php endif; ?>

								<?php if ( '' !== $tp_location ) : ?>
									<dt><?php esc_html_e( 'Địa điểm', 'tinphat' ); ?></dt>
									<dd><?php echo esc_html( $tp_location ); ?></dd>
								<?php endif; ?>

								<?php if ( '' !== $tp_scope ) : ?>
									<dt><?php esc_html_e( 'Gói thầu', 'tinphat' ); ?></dt>
									<dd><?php echo esc_html( $tp_scope ); ?></dd>
								<?php endif; ?>

								<?php if ( '' !== $tp_grade ) : ?>
									<dt><?php esc_html_e( 'Quy mô', 'tinphat' ); ?></dt>
									<dd><?php echo esc_html( $tp_grade ); ?></dd>
								<?php endif; ?>

								<?php if ( '' !== $tp_value ) : ?>
									<dt><?php esc_html_e( 'Giá trị hợp đồng', 'tinphat' ); ?></dt>
									<dd class="tp-project-detail__value"><?php echo esc_html( $tp_value ); ?></dd>
								<?php endif; ?>

								<?php if ( '' !== $tp_signed ) : ?>
									<dt><?php esc_html_e( 'Ký hợp đồng', 'tinphat' ); ?></dt>
									<dd><?php echo esc_html( $tp_signed ); ?></dd>
								<?php endif; ?>

								<?php if ( '' !== $tp_done ) : ?>
									<dt><?php esc_html_e( 'Hoàn thành', 'tinphat' ); ?></dt>
									<dd><?php echo esc_html( $tp_done ); ?></dd>
								<?php endif; ?>
							</dl>

							<a class="tp-btn" href="<?php echo esc_url( tinphat_contact_url() ); ?>">
								<?php esc_html_e( 'Liên hệ tư vấn', 'tinphat' ); ?>
							</a>
						</aside>

						<?php get_template_part( 'template-parts/project/sidebar' ); ?>
					</div>
				</div>

				<?php get_template_part( 'template-parts/project/related' ); ?>

				<p class="tp-project-detail__back">
					<a href="<?php echo esc_url( $tp_archive ); ?>">&laquo; <?php esc_html_e( 'Xem tất cả dự án', 'tinphat' ); ?></a>
				</p>
			</div>
		</div>
	</article>
	<?php
endwhile;

get_footer();
