/**
 * Ai config page script.
 *
 * @package AISmartSuggestions\Templates\Assets\Js
 */

jQuery( document ).ready(
	function ( $ ) {
		const getOption = ( value, text, isSelected, isRecommended = false ) => {
			return '<option value="' + value + '"' + ( isSelected ? ' selected' : '' ) + '>' + text + ( isRecommended ? ' (' + aissConfigs.translations.recommended + ')' : '' ) + '</option>';
		};

		const aiModelOptions = ( selectedProvider ) => {

			let options = '';

			if ( selectedProvider === 'groqcloud' ) {
				options  = '<optgroup label="Mistral">';
				options += getOption( 'mixtral-8x7b-32768', 'Mixtral 8x7b', 'mixtral-8x7b-32768' === aissConfigs.ai_model, true );
				options += '</optgroup>';

				options += '<optgroup label="Meta">';
				options += getOption( 'llama3-8b-8192', 'LLaMA3 8b', 'llama3-8b-8192' === aissConfigs.ai_model );
				options += getOption( 'llama3-70b-8192', 'LLaMA3 70b', 'llama3-70b-8192' === aissConfigs.ai_model );
				options += '</optgroup>';

				options += '<optgroup label="Google">';
				options += getOption( 'gemma-7b-it', 'Gemma 7b', 'gemma-7b-it' === aissConfigs.ai_model );
				options += '</optgroup>';
			}

			return options;

		}

		const updateAiModelsDropdown = ( selectedOption ) => {
			$( '#ai-model' ).html( aiModelOptions( selectedOption ) );
			$( '#ai-model' ).prop( 'disabled', false );

			$( '#ai-api-key' ).attr( 'placeholder', aissConfigs.translations.api_key_placeholder );
			$( '#ai-api-key' ).prop( 'disabled', false );
		};

		$( '#ai-provider' ).change(
			function () {
				updateAiModelsDropdown( $( this ).val() );

				if ( ! $( this ).val() ) {
					$( '#ai-model' ).prop( 'disabled', true );
					$( '#ai-api-key' ).val( '' );
					$( '#ai-api-key' ).prop( 'disabled', true );
				}
			}
		);

		if ( aissConfigs.ai_provider ) {
			updateAiModelsDropdown( aissConfigs.ai_provider );
		}
	}
);