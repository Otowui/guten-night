<?php

namespace GutenNight\AdminDark\Support;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Options {
	private const OPTION_NAME = 'gutennight_settings';

	private const DEFAULTS = array(
		'enabled_by_default'      => false,
		'allow_user_toggle'       => true,
		'enable_block_editor'     => true,
		'enable_admin'            => true,
		'integrations_woocommerce' => true,
		'integrations_jetpack'    => true,
	);

	public static function get_all(): array {
		$stored = get_option( self::OPTION_NAME, array() );

		if ( ! is_array( $stored ) ) {
			$stored = array();
		}

		$sanitized = self::sanitize_settings( $stored );

		return array_merge( self::DEFAULTS, $sanitized );
	}

	public static function get( string $key ) {
		if ( ! array_key_exists( $key, self::DEFAULTS ) ) {
			return null;
		}

		$all = self::get_all();

		return $all[ $key ];
	}

	public static function update( array $new_values ): array {
		$sanitized = self::sanitize_settings( $new_values );
		$updated   = array_merge( self::get_all(), $sanitized );

		update_option( self::OPTION_NAME, $updated );

		return $updated;
	}

	private static function sanitize_settings( array $values ): array {
		$sanitized = array();

		foreach ( self::DEFAULTS as $key => $default ) {
			if ( ! array_key_exists( $key, $values ) ) {
				continue;
			}

			$sanitized[ $key ] = self::sanitize_bool( $values[ $key ] );
		}

		return $sanitized;
	}

	private static function sanitize_bool( $value ): bool {
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