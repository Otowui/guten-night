=== GutenNight ===
Contributors: gutennight
Tags: admin, dark mode
Requires at least: 6.0
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A dark mode for the WordPress admin area.

== Description ==
GutenNight adds a dark theme to the WordPress admin interface.

== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/guten-night` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.

== Uninstall ==
By default, uninstalling GutenNight leaves your settings and user preferences intact.
To delete all GutenNight data on uninstall, add the following to `wp-config.php` before removing the plugin:

`define( 'GUTENNIGHT_DELETE_DATA', true );`

When this constant is enabled, GutenNight deletes the `gutennight_settings` option and removes the
`gutennight_enabled` user meta key for all users.

On multisite networks, the uninstall routine attempts to remove settings from each site when the plugin
is network-activated. This cleanup is best-effort; if you need a full network cleanup, ensure the constant
is enabled and uninstall the plugin from each site.

== Changelog ==
= 0.1.0 =
* Initial release.