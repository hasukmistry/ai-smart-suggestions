<?php
/**
 * Config interface.
 *
 * @package AISmartSuggestions\Core\Contracts
 */

declare(strict_types=1);

namespace AISmartSuggestions\Core\Contracts;

use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

interface ConfigInterface {
	/**
	 * Load a config file.
	 *
	 * @since 1.0
	 *
	 * @param string $file The config file to load.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException If the file is not found.
	 */
	public function load( string $file ): void;
}
