import superagent from 'superagent';

// eslint-disable-next-line no-undef
const apiConfig = aiSmartSuggestions;

const request = superagent.agent();

request.set( 'Accept', 'application/json' );
request.set( 'Content-Type', 'application/json' );
request.set( 'X-WP-Nonce', apiConfig.nonce );

// request interceptor
request.use( ( req ) => {
	req.url = `${ apiConfig.restApiUrl }${ req.url }`;
	return req;
} );

export default request;
