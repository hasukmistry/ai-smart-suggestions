<?php
/**
 * Class to display ai config page.
 *
 * @package AISmartSuggestions\Admin
 */

declare(strict_types=1);

namespace AISmartSuggestions\Admin;

use AISmartSuggestions\Admin\Actions\Ai_Config_Form as Form;
use AISmartSuggestions\Core\Decryption;

/**
 * Class Ai_Config_Page
 *
 * @package AISmartSuggestions\Admin
 */
class Ai_Config_Page {
	/**
	 * Template name
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public const TEMPLATE_NAME = 'src/templates/ai-config-page.php';

	/**
	 * Invoke the class.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function __invoke(): void {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0
	 *
	 * @param string $hook Hook name.
	 *
	 * @return void
	 */
	public function enqueue_scripts( $hook ): void {
		if ( 'settings_page_ai-smart-suggestions' !== $hook ) {
			return;
		}

		wp_register_script(
			'ai-config-page',
			AI_SS_PLUGIN_URL . 'src/templates/assets/js/ai-config-page.js',
			array( 'jquery' ),
			'1.0',
			true
		);

		// Localize the script with the translations.
		wp_localize_script(
			'ai-config-page',
			'aissConfigs',
			array(
				'translations' => array(
					'recommended'         => __( 'Recommended', 'ai-smart-suggestions' ),
					'api_key_placeholder' => __( 'Enter your API Key', 'ai-smart-suggestions' ),
				),
				'ai_provider'  => get_option( Form::OPTION_AI_PROVIDER ),
				'ai_model'     => get_option( Form::OPTION_AI_MODEL ),
				'ai_api_key'   => get_option( Form::OPTION_AI_API_KEY ) ? Decryption::decrypt( get_option( Form::OPTION_AI_API_KEY ) ) : '',
			)
		);

		wp_enqueue_script( 'ai-config-page' );
	}

	/**
	 * Render the page
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public static function render(): void {
		include_once AI_SS_PLUGIN_PATH . self::TEMPLATE_NAME;
	}
}
