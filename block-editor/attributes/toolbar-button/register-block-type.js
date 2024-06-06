import enabledToolbarButton from './block-settings.js';

/**
 * Declare our custom attribute
 *
 * @param {Object} settings The block settings.
 * @param {string} name     The block name.
 */
const setToolbarButtonAttribute = ( settings, name ) => {
	// Do nothing if it's another block than our defined ones.
	if ( ! enabledToolbarButton.includes( name ) ) {
		return settings;
	}

	return Object.assign( {}, settings, {
		attributes: Object.assign( {}, settings.attributes, {
			isSuggestionsModalOpen: { type: 'boolean', default: false },
		} ),
	} );
};

wp.hooks.addFilter(
	'blocks.registerBlockType',
	'ai-smart-suggestions/set-toolbar-button-attribute',
	setToolbarButtonAttribute
);
