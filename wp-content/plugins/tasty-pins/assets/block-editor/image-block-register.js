const { merge } = lodash;

const { hooks } = wp;

const pinAttributes = {
	pinterestText: {
		type: 'string',
		source: 'attribute',
		selector: 'img',
		attribute: 'data-pin-description',
		default: '',
	},
	pinterestTitle: {
		type: 'string',
		source: 'attribute',
		selector: 'img',
		attribute: 'data-pin-title',
		default: '',
	},
	pinterestRepinId: {
		type: 'string',
		source: 'attribute',
		selector: 'img',
		attribute: 'data-pin-id',
		default: '',
	},
	pinterestNoPin: {
		type: 'boolean',
		source: 'attribute',
		selector: 'img',
		attribute: 'data-pin-nopin',
		default: '',
	},
};

const modifyRegistration = ( settings, name ) => {
	if ( 'core/image' !== name ) {
		return settings;
	}

	// Register our attributes to the Image Block.
	settings.attributes = Object.assign( settings.attributes, pinAttributes );

	const imageAttributes = [
		'src',
		'alt',
		'data-pin-description',
		'data-pin-title',
		'data-pin-id',
		'data-pin-nopin',
	];

	// Extend raw <img> HTML transformation.
	settings.transforms.from[ 0 ] = merge( settings.transforms.from[ 0 ], {
		schema: {
			figure: {
				children: {
					a: {
						children: {
							img: {
								attributes: imageAttributes,
							},
						},
					},
					img: {
						attributes: imageAttributes,
					},
				},
			},
		},
	} );

	// Extend [caption] shortcode transformation
	settings.transforms.from[ 2 ].attributes = Object.assign( settings.transforms.from[ 2 ].attributes, pinAttributes );

	return settings;
};

hooks.addFilter( 'blocks.registerBlockType', 'wp-tasty/tasty-pins', modifyRegistration );
