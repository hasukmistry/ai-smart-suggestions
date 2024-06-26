import { __ } from '@wordpress/i18n';
import get from 'lodash/get';
import { BlockControls } from '@wordpress/block-editor';
import { useState } from '@wordpress/element';
import {
	Modal,
	Spinner,
	ToolbarGroup,
	ToolbarButton,
} from '@wordpress/components';
import iconAi from '@icons/ai.js';
import RefreshButton from './RefreshButton';
import { getSuggestions } from '@services/suggestions';
import {
	extractParagraphs,
	removeQuotes,
	getErrorFromResponse,
	getContentFromResponse,
} from '@utils/json';

/**
 * ToolbarButtonWithModal
 *
 * @param {Object}   props
 * @param {string}   props.attributes.content
 * @param {boolean}  props.attributes.isSuggestionsModalOpen
 * @param {Function} props.setAttributes
 * @param {string}   props.name
 */
const ToolbarButtonWithModal = ( props ) => {
	const { attributes, setAttributes } = props;

	const { content, isSuggestionsModalOpen } = attributes;

	const [ loading, setLoading ] = useState( false );
	const [ refreshing, setRefreshing ] = useState( false );
	const [ apiData, setApiData ] = useState( null );
	const [ errorMessage, setErrorMessage ] = useState( '' );

	/**
	 * May be request suggestions
	 */
	const mayBeRequestSuggestions = async () => {
		try {
			const response = await getSuggestions( props.name, content );

			if ( get( response, 'body.error' ) ) {
				throw new Error( getErrorFromResponse( response ) );
			}

			const suggestions = extractParagraphs(
				getContentFromResponse( response )
			);

			setApiData( suggestions );
		} catch ( error ) {
			setErrorMessage( error.message );
		}
	};

	/**
	 * Open modal
	 */
	const openModal = async () => {
		setLoading( true );
		setErrorMessage( '' );

		await mayBeRequestSuggestions();

		setLoading( false );
		setAttributes( { isSuggestionsModalOpen: true } );
	};

	/**
	 * May be refresh suggestions
	 */
	const mayBeRefreshSuggestions = async () => {
		setRefreshing( true );
		setErrorMessage( '' );

		await mayBeRequestSuggestions();

		setRefreshing( false );
	};

	/**
	 * Close modal
	 */
	const closeModal = () => setAttributes( { isSuggestionsModalOpen: false } );

	/**
	 * Handle paragraph click
	 *
	 * @param {string} paragraph
	 */
	const handleParagraphClick = ( paragraph ) => {
		setAttributes( { content: paragraph } );
		closeModal();
	};

	return (
		<>
			{ isSuggestionsModalOpen && ! loading && (
				<Modal
					title={
						<>
							<span>
								{ __(
									'Smart Suggestions',
									'ai-smart-suggestions'
								) }
							</span>
							{ refreshing ? (
								<Spinner />
							) : (
								<RefreshButton
									onClick={ () => mayBeRefreshSuggestions() }
								/>
							) }
						</>
					}
					onRequestClose={ closeModal }
					isOpen={ isSuggestionsModalOpen }
					className="ais-suggestions-modal"
				>
					{ errorMessage && (
						<div
							className="ais-suggestions-modal__error"
							role="alert"
						>
							{ errorMessage }
						</div>
					) }

					{ apiData && apiData.length > 0 && (
						<p className="ais-suggestions-modal__disclaimer">
							{ __(
								'Please be aware that the suggestions provided are generated by AI and may not always be perfectly accurate. Carefully review each suggestion to ensure it fits your needs. Your judgment is essential in making the best decisions. Thank you for your understanding!',
								'ai-smart-suggestions'
							) }
						</p>
					) }

					{ apiData && apiData.length > 0 ? (
						apiData.map( ( paragraph, index ) => (
							<div
								key={ index }
								onKeyDown={ ( e ) => {
									if ( refreshing ) {
										return; // Prevent interaction if refreshing
									}

									if (
										e.key === 'Enter' ||
										e.key === 'Space'
									) {
										handleParagraphClick( paragraph );
									}
								} }
								onClick={ () => {
									if ( refreshing ) {
										return; // Prevent interaction if refreshing
									}

									handleParagraphClick( paragraph );
								} }
								role="button"
								tabIndex={ 0 }
								className={ `ais-suggestions-modal__suggestion ${
									refreshing ? 'disabled' : ''
								}` }
							>
								{ removeQuotes( paragraph ) }
							</div>
						) )
					) : (
						<p className="ais-suggestions-modal__no-data">
							{ __(
								'No data available',
								'ai-smart-suggestions'
							) }
						</p>
					) }
				</Modal>
			) }
			<BlockControls group="block">
				<ToolbarGroup>
					<ToolbarButton
						icon={ loading ? <Spinner /> : iconAi }
						label={ __(
							'Smart Suggestions',
							'ai-smart-suggestions'
						) }
						isActive={ isSuggestionsModalOpen }
						onClick={ openModal }
						disabled={ loading }
					/>
				</ToolbarGroup>
			</BlockControls>
		</>
	);
};

export default ToolbarButtonWithModal;
