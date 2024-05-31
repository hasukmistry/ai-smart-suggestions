<?php
/**
 * Class to handle ai config form.
 *
 * @package AISmartSuggestions\Admin\Actions
 */

declare(strict_types=1);

namespace AISmartSuggestions\Admin\Actions;

use AISmartSuggestions\Core\Actions\Base;
use AISmartSuggestions\Core\Secret;
use AISmartSuggestions\Core\Encryption;

/**
 * Class Ai_Config_Form
 *
 * @package AISmartSuggestions\Admin\Actions
 */
class Ai_Config_Form extends Base {
	/**
	 * Save action
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public const SAVE_ACTION = 'ai_config_page_save';

	/**
	 * Save nonce
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public const SAVE_NONCE = 'ai_config_page_save_nonce';

	/**
	 * Notice action
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public const NOTICE_ACTION = 'ai_config_page_notice_action';

	/**
	 * Option for AI Provider
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public const OPTION_AI_PROVIDER = 'ai_ss_ai_provider';

	/**
	 * Option for AI Model
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public const OPTION_AI_MODEL = 'ai_ss_ai_model';

	/**
	 * Option for API Key
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public const OPTION_AI_API_KEY = 'ai_ss_api_key';

	/**
	 * Invoke the class.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function __invoke(): void {
		add_action(
			sprintf( 'admin_post_%s', self::SAVE_ACTION ),
			array( $this, 'handle_form' )
		);

		add_action(
			sprintf( 'admin_post_nopriv_%s', self::SAVE_ACTION ),
			array( $this, 'handle_form' )
		);
	}

	/**
	 * Handle the form action.
	 *
	 * @since 1.0
	 *
	 * @return void
	 *
	 * @throws \Exception If the form fields are invalid.
	 */
	public function handle_form(): void {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), self::SAVE_NONCE ) ) {
			// Set transient for 10 seconds to indicate nonce failure.
			set_transient(
				self::NOTICE_ACTION,
				array(
					'message' => 'Nonce verification failed!',
					'type'    => 'error',
				),
				10
			);

			$this->safe_redirect( wp_get_referer() );
		}

		try {
			$ai_provider = ! empty( $_POST['ai-provider'] ) ? sanitize_text_field( wp_unslash( $_POST['ai-provider'] ) ) : '';

			if ( ! in_array( $ai_provider, $this->get_ai_providers(), true ) ) {
				throw new \Exception( 'Invalid AI Provider, please choose a valid option.' );
			}

			// Save the AI provider.
			update_option( self::OPTION_AI_PROVIDER, $ai_provider );

			$ai_model = ! empty( $_POST['ai-model'] ) ? sanitize_text_field( wp_unslash( $_POST['ai-model'] ) ) : '';

			if ( ! in_array( $ai_model, $this->get_groqcloud_models(), true ) ) {
				throw new \Exception( 'Invalid AI Model, please choose a valid option.' );
			}

			// Save the AI model.
			update_option( self::OPTION_AI_MODEL, $ai_model );

			$api_key = ! empty( $_POST['ai-api-key'] ) ? sanitize_text_field( wp_unslash( $_POST['ai-api-key'] ) ) : '';

			if ( empty( $api_key ) ) {
				throw new \Exception( 'Invalid API Key, please enter a valid API Key.' );
			}

			if ( ! Secret::get_secret() ) {
				throw new \Exception( 'Encryption key not found, please deactivate/activate the plugin.' );
			}

			// Save the API key.
			update_option( self::OPTION_AI_API_KEY, Encryption::encrypt( $api_key ) );

			set_transient(
				self::NOTICE_ACTION,
				array(
					'message' => 'Configuration updated successfully!',
					'type'    => 'success',
				),
				10
			);
		} catch ( \Throwable $e ) {
			set_transient(
				self::NOTICE_ACTION,
				array(
					'message' => esc_html( $e->getMessage() ),
					'type'    => 'error',
				),
				10
			);
		}

		$this->safe_redirect( wp_get_referer() );
	}

	/**
	 * Get the list of available AI providers.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	private function get_ai_providers(): array {
		return array(
			'groqcloud',
		);
	}

	/**
	 * Get the list of available Groqcloud models.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	private function get_groqcloud_models(): array {
		return array(
			'mixtral-8x7b-32768',
			'llama3-8b-8192',
			'llama3-70b-8192',
			'gemma-7b-it',
		);
	}
}
