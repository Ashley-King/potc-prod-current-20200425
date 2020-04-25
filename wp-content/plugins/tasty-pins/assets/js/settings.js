(function( wp, $ ){

	var converter = {
		convertAction: 'tasty_pins_convert',
		data: {
			converting: false,
			count: 0,
			converted: 0,
			errorMessage: '',
			convertMessages: '',
		},
		template: 'tasty-pins-convert',
		wrapper: false,

		initialize: function( wrapper ) {
			this.wrapper = wrapper;
			this.postIds = JSON.parse( wrapper.attr('data-post-ids') );
			this.data.count = this.postIds.length;
			this.renderTemplate();
			this.bindEvents();
		},

		renderTemplate: function() {
			var template = wp.template( this.template );
			$(this.wrapper).html( template( this.data ) );
		},

		bindEvents: function() {
			$(this.wrapper).on('click', 'button.start-conversion', $.proxy( function(){
				this.data.converting = true;
				this.renderTemplate();
				this.triggerConvert();
			}, this ));
		},

		triggerConvert: function() {
			wp.ajax.send( this.convertAction, {
				data: {
					nonce: tastyPinsSettings.nonce,
					post_id : this.postIds.shift(),
				},
				type: 'GET'
			}).done( $.proxy( function( response ){
				this.data.converted++;
				if ( response.message ) {
					this.data.convertMessages += response.message + '<br />';
				}
				if ( this.postIds.length ) {
					this.renderTemplate();
					this.triggerConvert();
				} else {
					this.data.converting = false;
					this.data.count = 0;
					this.renderTemplate();
				}
			}, this) ).fail( $.proxy( function( response ){
				this.data.errorMessage = response.message;
				this.data.converting = false;
				this.renderTemplate();
			}, this) );
		},
	};

	$(document).ready(function(){
		var wrapper = $('.tasty-pins-convert-wrapper');
		if ( ! wrapper.length ) {
			return;
		}
		converter.initialize(wrapper);
	});

}(window.wp, jQuery));
