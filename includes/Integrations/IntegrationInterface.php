<?php

namespace GutenNight\AdminDark\Integrations;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

interface IntegrationInterface {
	public function is_active(): bool;

	public function should_load_for_screen( $screen ): bool;

	public function get_style_handle(): string;

	public function get_style_src(): string;
}