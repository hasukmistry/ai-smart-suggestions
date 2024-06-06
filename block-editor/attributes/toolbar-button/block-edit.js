import enabledToolbarButton from './block-settings.js';
import { createHigherOrderComponent } from '@wordpress/compose';
import ToolbarButtonWithModal from '@components/ToolbarButtonWithModal.js';
import { Fragment } from '@wordpress/element';

/**
 * Add Custom Button to Paragraph Toolbar
 */
const withToolbarButton = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		// If current block is not allowed
		if ( ! enabledToolbarButton.includes( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		return (
			<Fragment>
				<ToolbarButtonWithModal { ...props } />
				<BlockEdit { ...props } />
			</Fragment>
		);
	};
}, 'withToolbarButton' );

wp.hooks.addFilter(
	'editor.BlockEdit',
	'ai-smart-suggestions/with-toolbar-button',
	withToolbarButton
);
