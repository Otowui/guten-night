<?php

namespace GutenNight\AdminDark\Support;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Requirements {
	private const MIN_WP_VERSION  = '6.0';
	private const MIN_PHP_VERSION = '7.4';

	public static function meets(): bool {
		global $wp_version;

		$wp_version  = (string) $wp_version;
		$php_version = PHP_VERSION;

		if ( version_compare( $wp_version, self::MIN_WP_VERSION, '<' ) ) {
			return false;
		}

		if ( version_compare( $php_version, self::MIN_PHP_VERSION, '<' ) ) {
			return false;
		}

		return true;
	}

	public static function register_notice(): void {
		add_action( 'admin_notices', array( __CLASS__, 'render_notice' ) );
		add_action( 'network_admin_notices', array( __CLASS__, 'render_notice' ) );
	}

	public static function render_notice(): void {
		global $wp_version;

		$message = sprintf(
			/* translators: 1: Minimum WordPress version, 2: Minimum PHP version, 3: Current WordPress version, 4: Current PHP version. */
			__( 'GutenNight requires WordPress %1$s+ and PHP %2$s+. Your site is running WordPress %3$s and PHP %4$s.', 'guten-night' ),
			self::MIN_WP_VERSION,
			self::MIN_PHP_VERSION,
			(string) $wp_version,
			PHP_VERSION
		);

		echo '<div class="notice notice-error"><p>' . esc_html( $message ) . '</p></div>';
	}
}