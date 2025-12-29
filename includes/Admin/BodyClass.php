<?php

namespace GutenNight\AdminDark\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class BodyClass {
	public static function register(): void {
		add_filter( 'admin_body_class', array( __CLASS__, 'add_body_class' ) );
	}

	public static function add_body_class( string $classes ): string {
		return $classes . ' gutennight-enabled';
	}
}