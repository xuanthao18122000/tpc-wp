<?php
/**
 * Ô ngày tháng của bài viết (dùng chung cho mọi kiểu thẻ tin).
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="date_post">
	<div class="date fs-24 fw-bold"><?php echo esc_html( (string) get_the_date( 'd' ) ); ?></div>
	<div class="month fs-13"><?php echo esc_html( tinphat_month_label() ); ?></div>
</div>
