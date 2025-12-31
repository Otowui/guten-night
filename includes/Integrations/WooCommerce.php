<?php

namespace GutenNight\AdminDark\Integrations;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class WooCommerce implements IntegrationInterface {
	public function is_active(): bool {
		if ( class_exists( 'WooCommerce' ) || defined( 'WC_VERSION' ) ) {
			return true;
		}

		return $this->is_plugin_active( 'woocommerce/woocommerce.php' );
	}

	public function should_load_for_screen( $screen ): bool {
		if ( ! $screen instanceof \WP_Screen ) {
			return false;
		}

		$id        = isset( $screen->id ) ? strtolower( (string) $screen->id ) : '';
		$base      = isset( $screen->base ) ? strtolower( (string) $screen->base ) : '';
		$post_type = isset( $screen->post_type ) ? strtolower( (string) $screen->post_type ) : '';

		$matches = array(
			'woocommerce',
			'product',
			'shop_order',
			'wc-',
		);

		foreach ( array( $id, $base, $post_type ) as $value ) {
			if ( '' === $value ) {
				continue;
			}

			foreach ( $matches as $match ) {
				if ( false !== strpos( $value, $match ) ) {
					return true;
				}
			}
		}

		return false;
	}

	public function get_style_handle(): string {
		return 'gutennight-woocommerce';
	}

	public function get_style_src(): string {
		return GUTENNIGHT_URL . 'assets/dist/css/integrations/woocommerce.css';
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