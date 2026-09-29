<?php
/**
 * Fallback template — WordPress bắt buộc theme phải có file này.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="container tp-page__body">
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

		<?php
		the_posts_pagination(
			array(
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;',
			)
		);
		?>
	<?php else : ?>
		<p><?php esc_html_e( 'Không tìm thấy nội dung.', 'tinphat' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
