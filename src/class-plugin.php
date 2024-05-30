<?php
/**
 * Plugin class to load plugin.
 *
 * @package AISmartSuggestions
 */

declare(strict_types=1);

namespace AISmartSuggestions;

/**
 * Plugin class
 *
 * @since 1.0
 */
class Plugin {
	/**
	 * Plugin instance.
	 *
	 * @since 1.0
	 *
	 * @var self
	 */
	private static $instance;

	/**
	 * Get the plugin instance.
	 *
	 * @since 1.0
	 *
	 * @return self
	 */
	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize the plugin.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function init(): void {
		if ( wp_installing() ) {
			return;
		}
	}
}
