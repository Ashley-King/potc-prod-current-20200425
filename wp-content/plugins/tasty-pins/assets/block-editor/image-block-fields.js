const {
	isBlobURL,
} = wp.blob;

const {
	CheckboxControl,
	PanelBody,
	TextControl,
	TextareaControl,
} = wp.components;

const {
	createHigherOrderComponent,
} = wp.compose;

const {
	InspectorControls,
} = wp.editor;

const {
	Fragment,
} = wp.element;

const {
	__,
} = wp.i18n;

const {
	hooks,
	media,
} = wp;

const pastIdProps = {};

const registerFields = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( 'core/image' !== props.name ) {
			return (
				<BlockEdit { ...props } />
			);
		}

		const {
			attributes,
			setAttributes,
		} = props;

		let {
			pinterestText,
			pinterestTitle,
			pinterestRepinId,
		} = attributes;

		// When the last known 'id' prop was known and not an image ID,
		// see if there's some Pinterest Text
		// or Repin value to take from the Media Library.
		if ( typeof pastIdProps[ props.clientId ] !== 'undefined' &&
			! pastIdProps[ props.clientId ] &&
			attributes.id ) {
			const attachment = media.attachment( attributes.id );
			pinterestText = attachment.attributes.tp_pinterest_text;
			pinterestTitle = attachment.attributes.tp_pinterest_title;
			pinterestRepinId = attachment.attributes.tp_pinterest_repin_id;
			setAttributes( {
				pinterestText: attachment.attributes.tp_pinterest_text,
				pinterestTitle: attachment.attributes.tp_pinterest_title,
				pinterestRepinId: attachment.attributes.tp_pinterest_repin_id,
			} );
		}

		// Track last props state for the next cyle.
		pastIdProps[ props.clientId ] = attributes.id || false;

		// Accommodate both an image inserted from Media Library
		// and an image inserted from a URL.
		if ( ! attributes.id && ( ! attributes.url || isBlobURL( attributes.url ) ) ) {
			return (
				<BlockEdit { ...props } />
			);
		}

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ 'Tasty Pins' }>
						<TextControl
							defaultValue={ pinterestTitle }
							onChange={ ( value ) => setAttributes( { pinterestTitle: value } ) }
							label={ __( 'Pinterest Title', 'tasty-pins' ) }
						/>
						<TextareaControl
							defaultValue={ pinterestText }
							onChange={ ( value ) => setAttributes( { pinterestText: value } ) }
							label={ __( 'Pinterest Text', 'tasty-pins' ) }
							placeholder={ '' }
						/>
						<TextControl
							defaultValue={ pinterestRepinId }
							onChange={ ( value ) => setAttributes( { pinterestRepinId: value } ) }
							label={ __( 'Pinterest Repin ID', 'tasty-pins' ) }
						/>
						<CheckboxControl
							checked={ attributes.pinterestNoPin }
							onChange={ ( value ) => setAttributes( { pinterestNoPin: value } ) }
							label={ __( 'Disable Pinning', 'tasty-pins' ) }
						/>
					</PanelBody>
				</InspectorControls>
				<BlockEdit { ...props } />
			</Fragment>
		);
	};
} );

hooks.addFilter( 'editor.BlockEdit', 'wp-tasty/tasty-pins', registerFields );
