<?php

namespace GutenNight\AdminDark\Integrations;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Jetpack implements IntegrationInterface {
	public function is_active(): bool {
		if ( class_exists( 'Jetpack' ) || defined( 'JETPACK__VERSION' ) ) {
			return true;
		}

		return $this->is_plugin_active( 'jetpack/jetpack.php' );
	}

	public function should_load_for_screen( $screen ): bool {
		if ( ! $screen instanceof \WP_Screen ) {
			return false;
		}

		$id   = isset( $screen->id ) ? strtolower( (string) $screen->id ) : '';
		$base = isset( $screen->base ) ? strtolower( (string) $screen->base ) : '';

		foreach ( array( $id, $base ) as $value ) {
			if ( '' === $value ) {
				continue;
			}

			if ( false !== strpos( $value, 'jetpack' ) ) {
				return true;
			}
		}

		return false;
	}

	public function get_style_handle(): string {
		return 'gutennight-jetpack';
	}

	public function get_style_src(): string {
		return GUTENNIGHT_URL . 'assets/dist/css/integrations/jetpack.css';
	}

	private function is_plugin_active( string $plugin ): bool {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			$plugin_file = ABSPATH . 'wp-admin/includes/plugin.php';

			if ( file_exists( $plugin_file ) ) {
				require_once $plugin_file;
			}
		}

		if ( function_exists( 'is_plugin_active' ) ) {
			return is_plugin_active( $plugin );
		}

		return false;
	}
}