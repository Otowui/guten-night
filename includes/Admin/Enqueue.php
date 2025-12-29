<?php

namespace GutenNight\AdminDark\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Enqueue {
	public static function register(): void {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin' ) );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_editor' ) );
	}

	public static function enqueue_admin(): void {
		wp_enqueue_style(
			'gutennight-admin',
			GUTENNIGHT_URL . 'assets/css/admin.css',
			array(),
			GUTENNIGHT_VERSION
		);
	}

	public static function enqueue_editor(): void {
		wp_enqueue_style(
			'gutennight-editor',
			GUTENNIGHT_URL . 'assets/css/editor.css',
			array(),
			GUTENNIGHT_VERSION
		);
	}
}