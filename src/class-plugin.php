<?php
/**
 * Plugin class to load plugin.
 *
 * @package AISmartSuggestions
 */

declare(strict_types=1);

namespace AISmartSuggestions;

use AISmartSuggestions\Core\Service;

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

		// Spin up the service config and container.
		add_action( 'wp_loaded', array( $this, 'load' ) );
	}

	/**
	 * Load the plugin.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function load(): void {
		$config_dir  = AI_SS_PLUGIN_PATH . 'src/config';
		$config_file = 'services.yaml';

		// Bail early if the config file has not been created yet.
		if ( ! file_exists( $config_dir . '/' . $config_file ) ) {
			return;
		}

		// Set config service.
		Service::instance()
			->set_config(
				$config_dir,
				$config_file
			)
			->set_services();
	}
}
