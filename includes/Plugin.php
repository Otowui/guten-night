<?php

namespace GutenNight\AdminDark;

use GutenNight\AdminDark\Admin\BodyClass;
use GutenNight\AdminDark\Admin\Enqueue;
use GutenNight\AdminDark\Admin\SettingsPage;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Plugin {
	public static function init(): void {
		BodyClass::register();
		Enqueue::register();
		SettingsPage::register();
	}
}