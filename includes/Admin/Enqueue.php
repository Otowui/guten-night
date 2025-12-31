<?php

namespace GutenNight\AdminDark\Admin;

use GutenNight\AdminDark\Support\Options;
use GutenNight\AdminDark\Support\Screen;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Enqueue {
	public static function register(): void {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin' ) );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_editor' ) );
	}

	public static function enqueue_admin(): void {
		if ( ! self::is_enabled_for_user() ) {
			return;
		}
		
		if ( ! Options::get( 'enable_admin' ) ) {
			return;
		}
		
		wp_enqueue_style(
			'gutennight-admin',
			GUTENNIGHT_URL . 'assets/dist/css/admin.css',
			array(),
			GUTENNIGHT_VERSION
		);
		
		wp_enqueue_script(
			'gutennight-admin',
			GUTENNIGHT_URL . 'assets/dist/js/admin.js',
			array(),
			GUTENNIGHT_VERSION,
			true
		);
		
		if ( Options::get( 'integrations_woocommerce' ) && Screen::is_woocommerce_active() && Screen::is_woocommerce_screen() ) {
			wp_enqueue_style(
				'gutennight-woocommerce',
				GUTENNIGHT_URL . 'assets/dist/css/integrations/woocommerce.css',
				array(),
				GUTENNIGHT_VERSION
			);
		}
		
		if ( Options::get( 'integrations_jetpack' ) && Screen::is_jetpack_active() && Screen::is_jetpack_screen() ) {
			wp_enqueue_style(
				'gutennight-jetpack',
				GUTENNIGHT_URL . 'assets/dist/css/integrations/jetpack.css',
				array(),
				GUTENNIGHT_VERSION
			);
		}
	}

	public static function enqueue_editor(): void {
		if ( ! self::is_enabled_for_user() ) {
			return;
		}
		
		if ( ! Options::get( 'enable_block_editor' ) ) {
			return;
		}
		
		wp_enqueue_style(
			'gutennight-editor',
			GUTENNIGHT_URL . 'assets/dist/css/editor.css',
			array(),
			GUTENNIGHT_VERSION
		);
	}
	
	private static function is_enabled_for_user(): bool {
		return UserPreferences::is_enabled_for_user( get_current_user_id() );
	}
}