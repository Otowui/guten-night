<?php

namespace GutenNight\AdminDark\Admin;

use GutenNight\AdminDark\Integrations\Jetpack;
use GutenNight\AdminDark\Integrations\WooCommerce;
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
		
		self::enqueue_integrations();
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
	
	private static function enqueue_integrations(): void {
		$screen = Screen::get_current_screen();
	
		$integrations = array(
			'integrations_woocommerce' => new WooCommerce(),
			'integrations_jetpack'     => new Jetpack(),
		);
	
		foreach ( $integrations as $option_key => $integration ) {
			if ( ! Options::get( $option_key ) ) {
				continue;
			}
	
			if ( ! $integration->is_active() ) {
				continue;
			}
	
			if ( ! $integration->should_load_for_screen( $screen ) ) {
				continue;
			}
	
			wp_enqueue_style(
				$integration->get_style_handle(),
				$integration->get_style_src(),
				array(),
				GUTENNIGHT_VERSION
			);
		}
	}
	
	private static function is_enabled_for_user(): bool {
		return UserPreferences::is_enabled_for_user( get_current_user_id() );
	}
}