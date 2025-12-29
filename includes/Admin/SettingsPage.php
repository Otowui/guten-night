<?php

namespace GutenNight\AdminDark\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class SettingsPage {
	public static function register(): void {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu' ) );
	}

	public static function add_menu(): void {
		add_options_page(
			__( 'GutenNight', 'guten-night' ),
			__( 'GutenNight', 'guten-night' ),
			'manage_options',
			'guten-night',
			array( __CLASS__, 'render_page' )
		);
	}

	public static function render_page(): void {
		echo '<div class="wrap">';
		echo '<h1>' . esc_html__( 'GutenNight', 'guten-night' ) . '</h1>';
		echo '<p>' . esc_html__( 'Settings coming next.', 'guten-night' ) . '</p>';
		echo '</div>';
	}
}