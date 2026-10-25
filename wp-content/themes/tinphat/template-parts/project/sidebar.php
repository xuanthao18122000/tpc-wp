<?php
/**
 * Sidebar trang dự án: danh sách dự án khác.
 *
 * Dùng chung markup với sidebar tin tức để hai trang đồng bộ.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

$tp_others = new WP_Query(
	array(
		'post_type'           => 'du-an',
		'post_status'         => 'publish',
		'posts_per_page'      => 5,
		'post__not_in'        => array( get_the_ID() ),
		'orderby'             => 'rand',
		'no_found_rows'       => true,
		'ignore_sticky_posts' => true,
	)
);

if ( ! $tp_others->have_posts() ) {
	return;
}

$tp_archive = (string) get_post_type_archive_link( 'du-an' );
?>
<aside class="tp-news-sidebar tp-news-sidebar--project">
	<h2 class="tp-news-sidebar__title"><?php esc_html_e( 'Dự án khác', 'tinphat' ); ?></h2>

	<ul class="tp-news-sidebar__list">
		<?php
		while ( $tp_others->have_posts() ) :
			$tp_others->the_post();
			$tp_loc = (string) tinphat_field( 'location' );
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

						<?php if ( '' !== $tp_loc ) : ?>
							<span class="tp-news-sidebar__loc"><?php echo esc_html( $tp_loc ); ?></span>
						<?php endif; ?>
					</div>
				</a>
			</li>
			<?php
		endwhile;

		wp_reset_postdata();
		?>
	</ul>

	<?php if ( '' !== $tp_archive ) : ?>
		<a class="tp-news-sidebar__all" href="<?php echo esc_url( $tp_archive ); ?>">
			<?php esc_html_e( 'Xem tất cả dự án', 'tinphat' ); ?> &raquo;
		</a>
	<?php endif; ?>
</aside>
