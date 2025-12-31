<?php

namespace GutenNight\AdminDark;

use GutenNight\AdminDark\Admin\BodyClass;
use GutenNight\AdminDark\Admin\Enqueue;
use GutenNight\AdminDark\Admin\SettingsPage;
use GutenNight\AdminDark\Admin\UserPreferences;
use GutenNight\AdminDark\Support\Requirements;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Plugin {
	private static ?Plugin $instance = null;
	private bool $hooks_registered   = false;
	
	public static function init(): void {
		if ( null === self::$instance ) {
				self::$instance = new self();
		}
	
		self::$instance->register_hooks();
	}
		
	private function __construct() {
	}
		
	private function register_hooks(): void {
		if ( $this->hooks_registered ) {
			return;
		}
		if ( ! Requirements::meets() ) {
			Requirements::register_notice();
			$this->hooks_registered = true;
			return;
		}
		
		BodyClass::register();
		Enqueue::register();
		SettingsPage::register();
		UserPreferences::register();
			
		$this->hooks_registered = true;
	}
}