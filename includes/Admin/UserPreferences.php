<?php

namespace GutenNight\AdminDark\Admin;

use GutenNight\AdminDark\Support\Options;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class UserPreferences {
	private const META_KEY = 'gutennight_enabled';

	public static function register(): void {
		add_action( 'user_register', array( __CLASS__, 'handle_user_register' ) );
		add_action( 'show_user_profile', array( __CLASS__, 'render_profile_field' ) );
		add_action( 'edit_user_profile', array( __CLASS__, 'render_profile_field' ) );
		add_action( 'personal_options_update', array( __CLASS__, 'save_profile_field' ) );
		add_action( 'edit_user_profile_update', array( __CLASS__, 'save_profile_field' ) );
	}

	public static function is_enabled_for_user( $user_id ): bool {
		$user_id = (int) $user_id;

		if ( $user_id <= 0 ) {
			return self::normalize_bool( Options::get( 'enabled_by_default' ) );
		}

		if ( ! metadata_exists( 'user', $user_id, self::META_KEY ) ) {
			return self::normalize_bool( Options::get( 'enabled_by_default' ) );
		}

		$value = get_user_meta( $user_id, self::META_KEY, true );

		return self::normalize_bool( $value );
	}

	public static function set_enabled_for_user( $user_id, bool $enabled ): void {
		$user_id = (int) $user_id;

		if ( $user_id <= 0 ) {
			return;
		}

		update_user_meta( $user_id, self::META_KEY, $enabled ? 1 : 0 );
	}

	public static function handle_user_register( $user_id ): void {
		if ( Options::get( 'enabled_by_default' ) ) {
			self::set_enabled_for_user( $user_id, true );
		}
	}

	public static function render_profile_field( $user ): void {
		if ( ! Options::get( 'allow_user_toggle' ) ) {
			return;
		}

		$enabled = self::is_enabled_for_user( $user->ID );

		echo '<h2>' . esc_html__( 'GutenNight', 'guten-night' ) . '</h2>';
		echo '<table class="form-table" role="presentation">';
		echo '<tr>';
		echo '<th><label for="' . esc_attr( self::META_KEY ) . '">' . esc_html__( 'Enable GutenNight dark mode', 'guten-night' ) . '</label></th>';
		echo '<td>';
		echo '<input type="checkbox" name="' . esc_attr( self::META_KEY ) . '" id="' . esc_attr( self::META_KEY ) . '" value="1" ' . checked( $enabled, true, false ) . ' />';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
	}

	public static function save_profile_field( $user_id ): void {
		if ( ! Options::get( 'allow_user_toggle' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return;
		}

		$enabled = ! empty( $_POST[ self::META_KEY ] );

		self::set_enabled_for_user( $user_id, $enabled );
	}

	private static function normalize_bool( $value ): bool {
		if ( is_bool( $value ) ) {
			return $value;
		}

		if ( is_string( $value ) ) {
			$normalized = strtolower( trim( $value ) );

			if ( in_array( $normalized, array( '1', 'true', 'yes', 'on' ), true ) ) {
				return true;
			}

			if ( in_array( $normalized, array( '0', 'false', 'no', 'off', '' ), true ) ) {
				return false;
			}
		}

		return (bool) $value;
	}
}