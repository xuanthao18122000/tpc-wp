<?php
/**
 * Sidebar trang tin: danh sách tin mới nhất.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_latest = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 5,
		'post__not_in'        => array( get_the_ID() ),
		'no_found_rows'       => true,
		'ignore_sticky_posts' => true,
	)
);

if ( ! $tp_latest->have_posts() ) {
	return;
}

$tp_archive = (int) get_option( 'page_for_posts' );
?>
<aside class="tp-news-sidebar">
	<h2 class="tp-news-sidebar__title"><?php esc_html_e( 'Tin mới nhất', 'tinphat' ); ?></h2>

	<ul class="tp-news-sidebar__list">
		<?php
		while ( $tp_latest->have_posts() ) :
			$tp_latest->the_post();
			?>
			<li class="tp-news-sidebar__item">
				<a href="<?php the_permalink(); ?>">
					<figure class="tp-news-sidebar__media">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'medium', array( 'loading' => 'lazy', 'decoding' => 'async' ) );
						} else {
							echo '<span class="tp-thumb-placeholder" aria-hidden="true"></span>';
						}
						?>
					</figure>

					<div class="tp-news-sidebar__body">
						<h3><?php the_title(); ?></h3>
						<time datetime="<?php echo esc_attr( (string) get_the_date( 'c' ) ); ?>">
							<?php echo esc_html( (string) get_the_date( 'd/m/Y' ) ); ?>
						</time>
					</div>
				</a>
			</li>
			<?php
		endwhile;

		wp_reset_postdata();
		?>
	</ul>

	<?php if ( $tp_archive > 0 ) : ?>
		<a class="tp-news-sidebar__all" href="<?php echo esc_url( (string) get_permalink( $tp_archive ) ); ?>">
			<?php esc_html_e( 'Xem tất cả tin tức', 'tinphat' ); ?> &raquo;
		</a>
	<?php endif; ?>
</aside>
