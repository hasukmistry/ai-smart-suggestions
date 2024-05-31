<?php
/**
 * Class to decrypt data.
 *
 * @package AISmartSuggestions\Core
 */

declare(strict_types=1);

namespace AISmartSuggestions\Core;

/**
 * Decryption class
 *
 * @since 1.0
 */
final class Decryption {
	/**
	 * Decrypt the data.
	 *
	 * @since 1.0
	 *
	 * @param string $data Data to be decrypted.
	 *
	 * @return string
	 */
	public static function decrypt( string $data ): string {
		if ( ! Secret::get_secret() ) {
			return $data;
		}

		$secret    = Secret::get_secret();
		$iv_length = openssl_cipher_iv_length( 'AES-256-CBC' );

		// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode
		$encrypted_data = base64_decode( $data );
		$iv             = substr( $encrypted_data, 0, $iv_length );
		$encrypted_data = substr( $encrypted_data, $iv_length );

		return openssl_decrypt( $encrypted_data, 'AES-256-CBC', $secret, 0, $iv );
	}
}
