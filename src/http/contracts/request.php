<?php
/**
 * Request interface.
 *
 * @package AISmartSuggestions\Http\Contracts
 */

declare(strict_types=1);

namespace AISmartSuggestions\Http\Contracts;

interface RequestInterface {
	/**
	 * Make the request to the API.
	 *
	 * @since 1.0
	 *
	 * @return array|\WP_Error
	 */
	public function request(): array|\WP_Error;

	/**
	 * Set the headers.
	 *
	 * @since 1.0
	 *
	 * @return self
	 */
	public function set_headers(): self;

	/**
	 * Set the body.
	 *
	 * @since 1.0
	 *
	 * @param string $block_name The block name.
	 * @param string $content    The content to be used in the prompt.
	 *
	 * @return self
	 */
	public function set_body( string $block_name, string $content ): self;
}
