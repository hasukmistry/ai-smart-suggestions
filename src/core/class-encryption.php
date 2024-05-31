<?php
/**
 * Class to encrypt data.
 *
 * @package AISmartSuggestions\Core
 */

declare(strict_types=1);

namespace AISmartSuggestions\Core;

/**
 * Encryption class
 *
 * @since 1.0
 */
final class Encryption {
	/**
	 * Encrypt the data.
	 *
	 * @since 1.0
	 *
	 * @param string $data Data to be encrypted.
	 *
	 * @return string
	 */
	public static function encrypt( string $data ): string {
		if ( ! Secret::get_secret() ) {
			return $data;
		}

		$secret         = Secret::get_secret();
		$iv_length      = openssl_cipher_iv_length( 'AES-256-CBC' );
		$iv             = openssl_random_pseudo_bytes( $iv_length );
		$encrypted_data = openssl_encrypt( $data, 'AES-256-CBC', $secret, 0, $iv );

		// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
		return base64_encode( $iv . $encrypted_data );
	}
}
