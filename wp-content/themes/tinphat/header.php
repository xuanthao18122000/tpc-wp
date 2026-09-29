<?php
/**
 * Header của site.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'cc-root' ); ?>>
<?php wp_body_open(); ?>

<div id="page">
	<?php get_template_part( 'template-parts/header/site', 'header' ); ?>
	<main id="main" class="wrapper_content">
