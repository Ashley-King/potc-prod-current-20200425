const {
	isEmpty,
} = lodash;

const {
	RawHTML,
	renderToString,
} = wp.element;

const { hooks } = wp;

const saveAttributes = ( element, blockType, attributes ) => {
	if ( 'core/image' !== blockType.name ) {
		return element;
	}

	const {
		pinterestText,
		pinterestTitle,
		pinterestRepinId,
		pinterestNoPin,
	} = attributes;

	const imageProps = [];
	if ( ! isEmpty( pinterestText ) ) {
		imageProps.push( {
			attribute: 'data-pin-description',
			value: pinterestText,
		} );
	}

	if ( ! isEmpty( pinterestTitle ) ) {
		imageProps.push( {
			attribute: 'data-pin-title',
			value: pinterestTitle,
		} );
	}

	if ( ! isEmpty( pinterestRepinId ) ) {
		imageProps.push( {
			attribute: 'data-pin-id',
			value: pinterestRepinId,
		} );
	}

	if ( pinterestNoPin ) {
		imageProps.push( {
			attribute: 'data-pin-nopin',
			value: '1',
		} );
	}
	// Don't need to modify when all attributes are empty.
	if ( isEmpty( imageProps ) ) {
		return element;
	}
	let elementAsString = renderToString( element );
	imageProps.forEach( ( { attribute, value } ) => {
		// Don't allow some values to prevent breaking out of the attribute.
		value = value
			.replace( /&/g, '&amp;' )
			.replace( /</g, '' )
			.replace( />/g, '' )
			.replace( /\"/g, '' );
		elementAsString = elementAsString.replace( '<img ', `<img ${ attribute }="${ value }" ` );
	} );

	return (
		<RawHTML>{ elementAsString }</RawHTML>
	);
};

hooks.addFilter( 'blocks.getSaveElement', 'wp-tasty/tasty-pins', saveAttributes );

