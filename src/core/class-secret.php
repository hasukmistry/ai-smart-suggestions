<?php
/**
 * Class to generate a secret key for encryption/decryption of data.
 *
 * @package AISmartSuggestions\Core
 */

declare(strict_types=1);

namespace AISmartSuggestions\Core;

/**
 * Secret class
 *
 * @since 1.0
 */
final class Secret {
	/**
	 * Option for secret key.
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public const OPTION_SECRET = 'AI_SS_SECRET';

	/**
	 * Activate the plugin.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public static function activate(): void {
		if ( ! self::get_secret() ) {
			$secret = self::get_generated_key();
			update_option( self::OPTION_SECRET, $secret );
		}
	}

	/**
	 * Get the secret key.
	 *
	 * @since 1.0
	 *
	 * @return string|bool
	 */
	public static function get_secret(): string|bool {
		return get_option( self::OPTION_SECRET );
	}

	/**
	 * Generate a secret key.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	private static function get_generated_key(): string {
		return bin2hex( random_bytes( 32 ) );
	}
}
