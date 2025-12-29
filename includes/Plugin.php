<?php

namespace GutenNight\AdminDark;

use GutenNight\AdminDark\Admin\BodyClass;
use GutenNight\AdminDark\Admin\Enqueue;
use GutenNight\AdminDark\Admin\SettingsPage;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Plugin {
	private static ?Plugin $instance = null;
	
	public static function init(): void {
		if ( null === self::$instance ) {
				self::$instance = new self();
		}
	
		self::$instance->register_hooks();
	}
		
	private function __construct() {
	}
		
	private function register_hooks(): void {
		BodyClass::register();
		Enqueue::register();
		SettingsPage::register();
	}
}