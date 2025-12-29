<?php

namespace GutenNight\AdminDark\Admin;

use GutenNight\AdminDark\Support\Options;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class BodyClass {
	public static function register(): void {
		add_filter( 'admin_body_class', array( __CLASS__, 'add_body_class' ) );
		add_action( 'admin_footer', array( __CLASS__, 'output_body_data_attribute' ) );
	}

	public static function add_body_class( string $classes ): string {
		if ( ! self::is_enabled() ) {
			return $classes;
		}
		
		return $classes . ' gutennight-enabled';
	}
	
	public static function output_body_data_attribute(): void {
		if ( ! self::is_enabled() ) {
			return;
		}
	
		echo '<script>document.body.setAttribute("data-gutennight-enabled","true");</script>';
	}
	
	private static function is_enabled(): bool {
		if ( ! Options::get( 'enable_admin' ) ) {
			return false;
		}
	
		return UserPreferences::is_enabled_for_user( get_current_user_id() );
	}
}