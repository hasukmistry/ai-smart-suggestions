<?php
/**
 * Prompt class to set/get the prompt for the OpenAI API.
 *
 * @package AISmartSuggestions\OpenAI
 */

declare(strict_types=1);

namespace AISmartSuggestions\OpenAI;

/**
 * Prompt class
 *
 * @since 1.0
 */
final class Prompt {
	/**
	 * The AI prompt
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	private string $prompt = '';

	/**
	 * Set the AI Prompt
	 *
	 * @since 1.0
	 *
	 * @param string $block_name The block name.
	 * @param string $content    The content to be used in the prompt.
	 *
	 * @return self
	 */
	public function set_prompt( string $block_name, string $content ): self {
		$request = 'paragraph';

		if ( 'core/heading' === $block_name ) {
			$request = 'heading';
		}

		$this->prompt = sprintf( 'I am creating a blog post. Help me make my %s more engaging and give me 5 different suggestions for it. The %s is: \'%s\'', $request, $request, $content );

		return $this;
	}

	/**
	 * Get the AI Prompt
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_prompt(): string {
		return $this->prompt;
	}
}
