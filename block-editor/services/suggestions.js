import request from '@services/request';
import superagent from 'superagent';

/**
 * Get suggestions from the API
 *
 * @param {string} blockName The block name
 * @param {string} content   The content to get suggestions for
 *
 * @return {Promise<superagent.Response>} The suggestions
 */
export function getSuggestions( blockName, content ) {
	return request.post( '/suggestions' ).send( {
		name: blockName,
		content,
	} );
}
