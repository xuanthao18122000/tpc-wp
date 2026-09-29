<?php
/**
 * Tín Phát Construction — child theme của Flatsome.
 *
 * @package TinPhat
 */

defined( 'ABSPATH' ) || exit;

define( 'TINPHAT_VERSION', '1.0.0' );
define( 'TINPHAT_DIR', get_stylesheet_directory() );
define( 'TINPHAT_URI', get_stylesheet_directory_uri() );

require_once TINPHAT_DIR . '/inc/setup.php';
require_once TINPHAT_DIR . '/inc/assets.php';
require_once TINPHAT_DIR . '/inc/helpers.php';
require_once TINPHAT_DIR . '/inc/icons.php';
require_once TINPHAT_DIR . '/inc/company.php';
require_once TINPHAT_DIR . '/inc/class-nav-walker.php';
require_once TINPHAT_DIR . '/inc/posttype/register.php';
require_once TINPHAT_DIR . '/inc/permalinks.php';
require_once TINPHAT_DIR . '/inc/seo.php';
require_once TINPHAT_DIR . '/inc/builder/register.php';
