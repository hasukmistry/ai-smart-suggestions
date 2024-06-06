import { __ } from '@wordpress/i18n';
import iconRefresh from '@icons/refresh.js';

const IconButton = ( { onClick } ) => {
	return (
		<button
			title={ __( 'Refresh suggestions', 'ai-smart-suggestions' ) }
			className="ais-suggestions-modal__refresh"
			onClick={ onClick }
		>
			{ iconRefresh }
		</button>
	);
};

export default IconButton;
