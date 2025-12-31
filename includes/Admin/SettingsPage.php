<?php

namespace GutenNight\AdminDark\Admin;

use GutenNight\AdminDark\Support\Options;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class SettingsPage {
	private const OPTION_GROUP = 'gutennight';
	private const OPTION_NAME  = 'gutennight_settings';
	private const PAGE_SLUG    = 'gutennight';
	
	private const FIELDS = array(
		'enabled_by_default'       => 'Enable dark mode by default for new users',
		'allow_user_toggle'        => 'Allow users to toggle dark mode for themselves',
		'enable_admin'             => 'Enable dark mode in wp-admin',
		'enable_block_editor'      => 'Enable dark mode in block editor',
		'integrations_woocommerce' => 'Enable WooCommerce integration styles',
		'integrations_jetpack'     => 'Enable Jetpack integration styles',
	);
	
	public static function register(): void {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	public static function add_menu(): void {
		add_options_page(
			__( 'GutenNight', 'guten-night' ),
			__( 'GutenNight', 'guten-night' ),
			'manage_options',
			self::PAGE_SLUG,
			array( __CLASS__, 'render_page' )
		);
	}
	
	public static function register_settings(): void {
		register_setting(
			self::OPTION_GROUP,
			self::OPTION_NAME,
			array(
				'sanitize_callback' => array( __CLASS__, 'sanitize_settings' ),
			)
		);
	
		add_settings_section(
			'gutennight_main',
			__( 'General Settings', 'guten-night' ),
			'__return_false',
			self::PAGE_SLUG
		);
	
		foreach ( self::FIELDS as $key => $label ) {
			add_settings_field(
				$key,
				esc_html__( $label, 'guten-night' ),
				array( __CLASS__, 'render_checkbox_field' ),
				self::PAGE_SLUG,
				'gutennight_main',
				array(
					'key'   => $key,
					'label' => $label,
				)
			);
		}
	}

	public static function render_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'guten-night' ) );
		}
		
		echo '<div class="wrap">';
		echo '<h1>' . esc_html__( 'GutenNight', 'guten-night' ) . '</h1>';
		echo '<form method="post" action="options.php">';
		settings_fields( self::OPTION_GROUP );
		do_settings_sections( self::PAGE_SLUG );
		submit_button();
		echo '</form>';
		echo '</div>';
	}
	
	public static function render_checkbox_field( array $args ): void {
		$key     = $args['key'] ?? '';
		$options = Options::get_all();
		$value   = $options[ $key ] ?? false;
		$id      = 'gutennight_' . $key;
		$name    = self::OPTION_NAME . '[' . $key . ']';
		$label   = $args['label'] ?? '';
	
		echo '<label for="' . esc_attr( $id ) . '">';
		echo '<input type="checkbox" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="1" ' . checked( $value, true, false ) . ' />';
		echo ' ' . esc_html__( $label, 'guten-night' );
		echo '</label>';
	}
	
	public static function sanitize_settings( $values ): array {
		$sanitized = array();
	
		if ( ! is_array( $values ) ) {
			$values = array();
		}
	
		foreach ( self::FIELDS as $key => $label ) {
			$sanitized[ $key ] = ! empty( $values[ $key ] );
		}
	
		return $sanitized;
	}
}