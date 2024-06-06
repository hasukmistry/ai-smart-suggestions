<?php
/**
 * Smart Suggestions REST API
 *
 * @package AISmartSuggestions\RestApi
 */

declare(strict_types=1);

namespace AISmartSuggestions\RestApi;

use AISmartSuggestions\Http\Contracts\RequestInterface;
use AISmartSuggestions\Http\Provider;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * Smart Suggestions REST API
 *
 * @since 1.0
 */
class Smart_Suggestions extends Base {
	/**
	 * Method to register the routes
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function register_routes(): void {
		register_rest_route(
			self::ROUTE_NAMESPACE,
			'/suggestions',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'suggestions' ),
				'args'                => array(
					'content' => array(
						'required' => true,
						'type'     => 'string',
					),
				),
				'permission_callback' => array( $this, 'verify_nonce' ),
			)
		);
	}

	/**
	 * Handle the request
	 *
	 * @since 1.0
	 *
	 * @param WP_REST_Request $request The request object.
	 *
	 * @return WP_REST_Response
	 */
	public function suggestions( WP_REST_Request $request ): WP_REST_Response {
		// Get the raw body content.
		$body = $request->get_body();

		try {
			// Decode the JSON string to a PHP array.
			$data = json_decode( $body, true );

			// Check for JSON decode errors.
			if ( json_last_error() !== JSON_ERROR_NONE ) {
				return new WP_REST_Response(
					array(
						'error' => array(
							'message' => 'Failed to decode JSON: ' . json_last_error_msg(),
							'type'    => 'invalid_request_error',
						),
					),
					400
				);
			}

			$block_name = sanitize_text_field( wp_unslash( $data['name'] ) );
			$content    = sanitize_text_field( wp_unslash( $data['content'] ) );

			// Ensure the value is one of the expected options.
			$valid_block_names = array( 'core/heading', 'core/paragraph' );

			if ( ! in_array( $block_name, $valid_block_names, true ) ) {
				return new WP_REST_Response( 'Unknown block name requested.', 400 );
			}

			/**
			 * Get the current AI Provider
			 *
			 * @since 1.0
			 *
			 * @var RequestInterface $provider
			 */
			$provider = Provider::instance()
				->get();

			$result = $provider
				->set_headers()
				->set_body( $block_name, $content )
				->request();

			// Handle errors and send the response.
			if ( is_wp_error( $result ) ) {
				return new WP_REST_Response( $result, 400 );
			}

			return new WP_REST_Response( $result, 200 );
		} catch ( \Throwable $e ) {
			return new WP_REST_Response( $e->getMessage(), 400 );
		}
	}
}
