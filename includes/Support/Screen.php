<?php

namespace GutenNight\AdminDark\Support;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Screen {
	public static function get_current_screen(): ?\WP_Screen {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return null;
		}

		$screen = get_current_screen();

		if ( $screen instanceof \WP_Screen ) {
			return $screen;
		}

		return null;
	}

	public static function is_woocommerce_active(): bool {
		if ( class_exists( 'WooCommerce' ) || defined( 'WC_VERSION' ) ) {
			return true;
		}

		return self::is_plugin_active( 'woocommerce/woocommerce.php' );
	}

	public static function is_jetpack_active(): bool {
		if ( class_exists( 'Jetpack' ) || defined( 'JETPACK__VERSION' ) ) {
			return true;
		}

		return self::is_plugin_active( 'jetpack/jetpack.php' );
	}

	public static function is_woocommerce_screen(): bool {
		$screen = self::get_current_screen();

		if ( ! $screen ) {
			return false;
		}

		$id        = isset( $screen->id ) ? (string) $screen->id : '';
		$base      = isset( $screen->base ) ? (string) $screen->base : '';
		$post_type = isset( $screen->post_type ) ? (string) $screen->post_type : '';

		$woocommerce_ids = array(
			'woocommerce',
			'woocommerce_page_wc-settings',
			'woocommerce_page_wc-status',
			'woocommerce_page_wc-addons',
			'woocommerce_page_wc-reports',
			'woocommerce_page_wc-admin',
			'product',
			'edit-product',
			'shop_order',
			'edit-shop_order',
			'shop_coupon',
			'edit-shop_coupon',
		);

		$woocommerce_post_types = array(
			'product',
			'shop_order',
			'shop_coupon',
		);

		if ( in_array( $id, $woocommerce_ids, true ) ) {
			return true;
		}

		if ( in_array( $post_type, $woocommerce_post_types, true ) ) {
			return true;
		}

		if ( false !== strpos( $id, 'woocommerce' ) || false !== strpos( $base, 'woocommerce' ) ) {
			return true;
		}

		return false;
	}

	public static function is_jetpack_screen(): bool {
		$screen = self::get_current_screen();

		if ( ! $screen ) {
			return false;
		}

		$id   = isset( $screen->id ) ? (string) $screen->id : '';
		$base = isset( $screen->base ) ? (string) $screen->base : '';

		$jetpack_ids = array(
			'jetpack',
			'jetpack_page_jetpack',
			'jetpack_page_stats',
			'jetpack_page_settings',
			'jetpack_page_dashboard',
			'jetpack_page_backup',
			'jetpack_page_scan',
			'jetpack_page_search',
			'jetpack_page_vaultpress',
		);

		if ( in_array( $id, $jetpack_ids, true ) ) {
			return true;
		}

		if ( false !== strpos( $id, 'jetpack' ) || false !== strpos( $base, 'jetpack' ) ) {
			return true;
		}

		return false;
	}

	private static function is_plugin_active( string $plugin ): bool {
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