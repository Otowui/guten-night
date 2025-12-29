<?php

namespace GutenNight\AdminDark;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Autoloader {
	private const PREFIX = 'GutenNight\\AdminDark\\';

	public static function register(): void {
		spl_autoload_register( array( __CLASS__, 'autoload' ) );
	}

	private static function autoload( string $class ): void {
		if ( strpos( $class, self::PREFIX ) !== 0 ) {
			return;
		}

		$relative_class = substr( $class, strlen( self::PREFIX ) );
		$relative_path  = str_replace( '\\', '/', $relative_class ) . '.php';
		$path           = GUTENNIGHT_PATH . 'includes/' . $relative_path;

		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}
}