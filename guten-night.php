<?php
/**
 * Plugin Name: GutenNight
 * Description: Adds a dark mode to the WordPress admin area.
 * Version: 0.1.0
 * Author: GutenNight
 * Text Domain: guten-night
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

define( 'GUTENNIGHT_VERSION', '0.1.0' );
define( 'GUTENNIGHT_PATH', plugin_dir_path( __FILE__ ) );
define( 'GUTENNIGHT_URL', plugin_dir_url( __FILE__ ) );
define( 'GUTENNIGHT_BASENAME', plugin_basename( __FILE__ ) );

require_once GUTENNIGHT_PATH . 'includes/Autoloader.php';

GutenNight\AdminDark\Autoloader::register();

GutenNight\AdminDark\Plugin::init();