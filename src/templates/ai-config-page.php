<?php
/**
 * The template for displaying the form.
 *
 * @package AISmartSuggestions\Templates
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use AISmartSuggestions\Admin\Actions\Ai_Config_Form as Form;
use AISmartSuggestions\Core\Decryption;

$notice      = get_transient( Form::NOTICE_ACTION );
$ai_provider = get_option( Form::OPTION_AI_PROVIDER );
$ai_api_key  = get_option( Form::OPTION_AI_API_KEY ) ? Decryption::decrypt( get_option( Form::OPTION_AI_API_KEY ) ) : '';
?>
<div class="wrap">

	<h1><?php esc_html_e( 'Configure AI Smart Suggestions', 'ai-smart-suggestions' ); ?></h1>

	<!-- Start: Notice -->
	<?php if ( ! empty( $notice ) ) : ?>
		<?php
			// Delete transient to prevent displaying the notice multiple times.
			delete_transient( Form::NOTICE_ACTION );
		?>
		<div class="notice notice-<?php echo esc_attr( $notice['type'] ); ?>">
			<p><?php echo esc_html( $notice['message'] ); ?></p>
		</div>
	<?php endif; ?>
	<!-- End: Notice -->

	<form class="ai-config-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">

		<input type="hidden" name="action" value="<?php echo esc_attr( Form::SAVE_ACTION ); ?>" />
		<input type="hidden" name="_wpnonce" id="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( Form::SAVE_NONCE ) ); ?>" />

		<p>
			<?php esc_html_e( 'Configure your AI Provider and Model. This approach streamlines the process of using various AI models to recommend different suggestions for your content.', 'ai-smart-suggestions' ); ?>
		</p>

		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th>
						<label for="ai-provider"><?php esc_html_e( 'AI Provider', 'ai-smart-suggestions' ); ?></label>
					</th>
					<td>
						<select name="ai-provider" id="ai-provider" class="regular-text">
							<option value=""><?php esc_html_e( 'Select an AI Provider', 'ai-smart-suggestions' ); ?></option>
							<option <?php echo 'groqcloud' === $ai_provider ? 'selected' : ''; ?> value="groqcloud"><?php esc_html_e( 'GroqCloud', 'ai-smart-suggestions' ); ?></option>
						</select>
					</th>
				</tr>
				<tr>
					<th>
						<label for="ai-model"><?php esc_html_e( 'AI Model', 'ai-smart-suggestions' ); ?></label>
					</th>
					<td>
						<select disabled name="ai-model" id="ai-model" class="regular-text">
						</select>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ai-api-key"><?php esc_html_e( 'API Key', 'ai-smart-suggestions' ); ?></label>
					</th>
					<td>
						<input disabled type="text" name="ai-api-key" id="ai-api-key" class="regular-text" value="<?php echo esc_attr( $ai_api_key ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input type="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'ai-smart-suggestions' ); ?>" />
		</p>

	</form>

</div>
