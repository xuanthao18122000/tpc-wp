<?php
/**
 * Kết quả tìm kiếm.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="container tp-page__body">
	<h1 class="tp-search__title">
		<?php
		printf(
			/* translators: %s: từ khoá tìm kiếm */
			esc_html__( 'Kết quả cho: %s', 'tinphat' ),
			'<span>' . esc_html( get_search_query() ) . '</span>'
		);
		?>
	</h1>

	<?php if ( have_posts() ) : ?>
		<div class="tp-archive">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'tp-archive__item' ); ?>>
					<h2 class="tp-archive__title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<div class="tp-archive__excerpt"><?php the_excerpt(); ?></div>
				</article>
				<?php
			endwhile;
			?>
		</div>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Không có kết quả nào phù hợp.', 'tinphat' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
