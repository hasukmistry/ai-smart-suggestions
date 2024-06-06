<?php
/**
 * Groq class to make HTTP requests to the OpenAI API.
 *
 * @package AISmartSuggestions\Http
 */

declare(strict_types=1);

namespace AISmartSuggestions\Http;

use AISmartSuggestions\Http\Contracts\RequestInterface;
use AISmartSuggestions\Admin\Actions\Ai_Config_Form as Form;
use AISmartSuggestions\Core\Decryption;
use AISmartSuggestions\OpenAI\Prompt;

/**
 * Groq class
 *
 * @since 1.0
 */
final class Groq implements RequestInterface {
	/**
	 * The API URL
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	private const API_URL = 'https://api.groq.com/openai/v1/chat/completions';

	/**
	 * Request headers
	 *
	 * @since 1.0
	 *
	 * @var array
	 */
	private array $headers = array();

	/**
	 * Request JSON body
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	private string $body = '';

	/**
	 * Groq Constructor
	 *
	 * @since 1.0
	 *
	 * @param Prompt $prompt_manager The prompt manager.
	 */
	public function __construct( private Prompt $prompt_manager ) {
	}

	/**
	 * Make the request to the API
	 *
	 * @since 1.0
	 *
	 * @return array|\WP_Error
	 *
	 * @throws \Exception If there is an error in the request.
	 */
	public function request(): array|\WP_Error {
		$args = array(
			'headers' => $this->get_headers(),
			'body'    => $this->get_body(),
			'method'  => 'POST',
		);

		try {
			$response = wp_remote_post( self::API_URL, $args );

			if ( is_wp_error( $response ) ) {
				throw new \Exception( $response->get_error_message() );
			}

			$response_body = wp_remote_retrieve_body( $response );

			return json_decode( $response_body, true );
		} catch ( \Throwable $e ) {
			return new \WP_Error(
				'ai_smart_suggestions_groq_error',
				$e->getMessage(),
				$e
			);
		}
	}

	/**
	 * Set the headers
	 *
	 * @since 1.0
	 *
	 * @return self
	 */
	public function set_headers(): self {
		$this->headers = array(
			'Content-Type'  => 'application/json',
			'Authorization' => 'Bearer ' . $this->get_api_key(),
		);

		return $this;
	}

	/**
	 * Set the body
	 *
	 * @since 1.0
	 *
	 * @param string $block_name The block name.
	 * @param string $content    The content to be used in the prompt.
	 *
	 * @return self
	 */
	public function set_body( string $block_name, string $content ): self {
		$this->prompt_manager->set_prompt( $block_name, $content );

		$this->body = wp_json_encode(
			array(
				'model'    => get_option( Form::OPTION_AI_MODEL ),
				'messages' => array(
					array(
						'role'    => 'user',
						'content' => rawurlencode( $this->prompt_manager->get_prompt() ),
					),
				),
			)
		);

		return $this;
	}

	/**
	 * Get the API key
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	private function get_api_key(): string {
		return Decryption::decrypt( get_option( Form::OPTION_AI_API_KEY ) );
	}

	/**
	 * Get the headers
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	private function get_headers(): array {
		return $this->headers;
	}

	/**
	 * Get the body
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	private function get_body(): string {
		return $this->body;
	}
}
