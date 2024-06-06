import get from 'lodash/get';

const extractParagraphs = ( inputText ) => {
	const lines = inputText.split( '\n' );
	const paragraphs = lines.map( ( line ) => {
		const match = line.match( /^\d+\.\s*(.*)/m );
		return match ? match[ 1 ] : '';
	} );

	return paragraphs.filter( ( paragraph ) => paragraph !== '' );
};

const removeQuotes = ( inputText ) => {
	return inputText.replace( /^["']|["']$/g, '' );
};

const getErrorFromResponse = ( response ) => {
	if ( window.aiSmartSuggestions.ai_provider === 'groqcloud' ) {
		return getErrorFromGroqResponse( response );
	}

	return '';
};

const getErrorFromGroqResponse = ( response ) => {
	return get( response, 'body.error.message' );
};

const getContentFromResponse = ( response ) => {
	if ( window.aiSmartSuggestions.ai_provider === 'groqcloud' ) {
		return getContentFromGroqResponse( response );
	}

	return '';
};

const getContentFromGroqResponse = ( response ) => {
	return get( response, 'body.choices[0].message.content', [] );
};

export {
	extractParagraphs,
	removeQuotes,
	getErrorFromResponse,
	getContentFromResponse,
};
