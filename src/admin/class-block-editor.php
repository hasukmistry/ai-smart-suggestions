<?php
/**
 * Class to enqueue scripts for block editor.
 *
 * @package AISmartSuggestions\Admin
 */

declare(strict_types=1);

namespace AISmartSuggestions\Admin;

use AISmartSuggestions\Admin\Actions\Ai_Config_Form as Form;
use AISmartSuggestions\RestApi\Base;

/**
 * Class Block_Editor
 *
 * @package AISmartSuggestions\Admin
 */
class Block_Editor {
	/**
	 * Invoke the class.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function __invoke(): void {
		// Bail early if the current user does not have enough permissions.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		// Bail early if the option is not set.
		if ( ! get_option( Form::OPTION_AI_PROVIDER ) ) {
			return;
		}

		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		// Bail early if the dist files are not present.
		if ( ! file_exists( AI_SS_PLUGIN_PATH . 'dist/main.js' ) ) {
			return;
		}

		wp_register_script(
			'ai-smart-suggestions-block-editor',
			AI_SS_PLUGIN_URL . 'dist/main.js',
			array( 'wp-blocks', 'wp-dom', 'wp-dom-ready', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data' ),
			filemtime( AI_SS_PLUGIN_PATH . 'dist/main.js' ),
			true
		);

		wp_localize_script(
			'ai-smart-suggestions-block-editor',
			'aiSmartSuggestions',
			array(
				'ai_provider' => get_option( Form::OPTION_AI_PROVIDER ),
				'ai_model'    => get_option( Form::OPTION_AI_MODEL ),
				'restApiUrl'  => esc_url_raw( rest_url( Base::ROUTE_NAMESPACE ) ),
				'nonce'       => wp_create_nonce( Base::NONCE ),
			),
		);

		wp_enqueue_script( 'ai-smart-suggestions-block-editor' );

		wp_enqueue_style(
			'ai-smart-suggestions-block-editor-styles',
			AI_SS_PLUGIN_URL . 'dist/style-main.css',
			array(),
			filemtime( AI_SS_PLUGIN_PATH . 'dist/style-main.css' ),
			'all'
		);
	}
}
