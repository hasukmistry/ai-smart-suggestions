<?php
/**
 * Base class to utilize the REST API.
 *
 * @package AISmartSuggestions\RestApi
 */

declare(strict_types=1);

namespace AISmartSuggestions\RestApi;

use WP_REST_Request;

/**
 * Base class
 *
 * @since 1.0
 */
abstract class Base {
	/**
	 * The route namespace
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public const ROUTE_NAMESPACE = 'ai-ss/v1';

	/**
	 * The nonce
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public const NONCE = 'wp_rest';

	/**
	 * Invoke the class
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function __invoke(): void {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Abstract method to register the routes
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	abstract public function register_routes(): void;

	/**
	 * Verifies the nonce
	 *
	 * @since 1.0
	 *
	 * @param WP_REST_Request $request The request object.
	 *
	 * @return bool|\WP_Error
	 */
	public function verify_nonce( WP_REST_Request $request ): bool|\WP_Error {
		$nonce = $request->get_header( 'X-WP-Nonce' );

		if ( ! wp_verify_nonce( $nonce, self::NONCE ) ) {
			return new \WP_Error(
				'invalid_nonce',
				'Missing or Invalid X-WP-Nonce given',
				array( 'status' => 403 )
			);
		}

		return true;
	}
}
