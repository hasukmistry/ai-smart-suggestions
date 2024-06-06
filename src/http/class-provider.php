<?php
/**
 * Provider class to select the HTTP provider.
 *
 * @package AISmartSuggestions\Http
 */

declare(strict_types=1);

namespace AISmartSuggestions\Http;

use AISmartSuggestions\Admin\Actions\Ai_Config_Form as Form;
use AISmartSuggestions\Core\Service;
use AISmartSuggestions\Http\Contracts\RequestInterface;

/**
 * Provider class
 *
 * @since 1.0
 */
final class Provider {
	/**
	 * Service instance.
	 *
	 * @since 1.0
	 *
	 * @var self
	 */
	private static $instance;

	/**
	 * The AI Provider Name
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	private string $ai_provider_name = 'groqcloud';

	/**
	 * The HTTP Request
	 *
	 * @since 1.0
	 *
	 * @var RequestInterface
	 */
	private RequestInterface $ai_provider;

	/**
	 * Get the provider instance.
	 *
	 * @since 1.0
	 *
	 * @return self
	 */
	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();

			// Set the AI Provider.
			self::$instance->set();
		}

		return self::$instance;
	}

	/**
	 * Get the current AI Provider from the container.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function set(): void {
		$ai_provider_name = get_option( Form::OPTION_AI_PROVIDER );

		if ( $ai_provider_name ) {
			$this->ai_provider_name = $ai_provider_name;
		}

		$this->ai_provider = Service::instance()->get_service( $this->ai_provider_name );
	}

	/**
	 * Get the current AI Provider name.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_name(): string {
		return $this->ai_provider_name;
	}

	/**
	 * Get the current AI Provider.
	 *
	 * @since 1.0
	 *
	 * @return RequestInterface
	 */
	public function get(): RequestInterface {
		return $this->ai_provider;
	}
}
