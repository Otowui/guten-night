<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if ( ! defined( 'GUTENNIGHT_DELETE_DATA' ) || true !== GUTENNIGHT_DELETE_DATA ) {
	return;
}

$option_name = 'gutennight_settings';
$meta_key    = 'gutennight_enabled';

if ( is_multisite() ) {
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$plugin_file       = plugin_basename( dirname( __FILE__ ) . '/guten-night.php' );
	$is_network_active = function_exists( 'is_plugin_active_for_network' )
		? is_plugin_active_for_network( $plugin_file )
		: false;

	if ( $is_network_active ) {
		$site_ids = get_sites(
			array(
				'fields' => 'ids',
			)
		);

		foreach ( $site_ids as $site_id ) {
			switch_to_blog( (int) $site_id );
			delete_option( $option_name );
			restore_current_blog();
		}
	} else {
		delete_option( $option_name );
	}
} else {
	delete_option( $option_name );
}

delete_metadata( 'user', 0, $meta_key, '', true );