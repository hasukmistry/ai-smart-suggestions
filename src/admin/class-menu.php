<?php
/**
 * Menu class to add menu items to the admin menu.
 *
 * @package AISmartSuggestions\Admin
 */

declare(strict_types=1);

namespace AISmartSuggestions\Admin;

/**
 * Class Menu
 *
 * @package AISmartSuggestions\Admin
 */
class Menu {
	/**
	 * Invoke the class.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function __invoke(): void {
		add_action( 'admin_menu', array( $this, 'add' ), 99 );
	}

	/**
	 * Add the menu item to WordPress
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function add(): void {
		add_options_page(
			__( 'Configure AI Smart Suggestions', 'ai-smart-suggestions' ),
			__( 'Smart Suggestions', 'ai-smart-suggestions' ),
			'manage_options',
			'ai-smart-suggestions',
			array( $this, 'ai_config_page' ),
		);
	}

	/**
	 * Add the page to the admin menu.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function ai_config_page(): void {
	}
}
