(function($){
	$(document).ready(function(){

		/**
		 * Update attachment details template to include Pinterest Text field.
		 */
		var imageDetailsTmpl = $("#tmpl-image-details"),
			attachmentDetailsTmpl = $("#tmpl-attachment-details"),
			twoColTmpl = $('#tmpl-attachment-details-two-column'),
			attachmentDisplaySettingsTmpl = $('#tmpl-attachment-display-settings'),
			mediaEditText = $('#tp-pinterest-text-wrap')
			mediaEditTitle = $('#tp-pinterest-title-wrap'),
			mediaEditId = $('#tp-pinterest-repin-id-wrap'),
			pinterestTextHtml = '';

		var isCustomizeOrWidgets = false;
		if ( typeof window.pagenow !== 'undefined'
			&& ( 'customize' === window.pagenow
			|| 'widgets' === window.pagenow	) ) {
			isCustomizeOrWidgets = true;
		}

		// Details template when editing an inline image
		if ( imageDetailsTmpl.length > 0 && ! isCustomizeOrWidgets ) {
			var imageDetailsHtml = imageDetailsTmpl.html();
			pinterestTextHtml = '<label class="setting tp-pinterest-title"><span>Pinterest Title</span><input type="text" data-setting="tp_pinterest_title" value="{{ data.model.tp_pinterest_title }}"></label>';
			pinterestTextHtml += '<label class="setting tp-pinterest-text"><span>Pinterest Text</span><textarea data-setting="tp_pinterest_text">{{ data.model.tp_pinterest_text }}</textarea></label>';
			pinterestTextHtml += '<label class="setting tp-pinterest-repin-id"><span>Pinterest Repin ID</span><input type="text" data-setting="tp_pinterest_repin_id" value="{{ data.model.tp_pinterest_repin_id }}"></label>';
			pinterestTextHtml += '<label class="setting tp-pinterest-nopin"><span style="margin-top: 4px;">Disable Pinning</span><input style="vertical-align:bottom;" type="checkbox" <# if ( data.model.tp_pinterest_nopin ) { #>checked="checked"<# } #> data-setting="tp_pinterest_nopin" /></label>';
			// WordPress 5.3+
			if ( -1 !== imageDetailsHtml.indexOf('<span class="setting alt-text') ) {
				imageDetailsHtml = imageDetailsHtml.replace(/(<span class="setting alt-text(.+)?">)/, pinterestTextHtml + '$1');
			} else {
				imageDetailsHtml = imageDetailsHtml.replace(/(<label class="setting alt-text(.+)?">)/, pinterestTextHtml + '$1');
			}
			imageDetailsTmpl.text( imageDetailsHtml );
		}

		// Details template when editing attachments
		if ( attachmentDetailsTmpl.length > 0 ) {
			var attachmentDetailsHtml = attachmentDetailsTmpl.html();
			pinterestTextHtml = '<# if ( \'image\' === data.type ) { #>';
			pinterestTextHtml += '<label class="setting" data-setting="tp_pinterest_title"><span class="name">Pinterest Title</span><input type="text" {{ maybeReadOnly }} value="{{ data.tp_pinterest_title }}"></label>';
			pinterestTextHtml += '<label class="setting" data-setting="tp_pinterest_text"><span class="name" style="margin-right:2%;">Pinterest Text</span><textarea {{ maybeReadOnly }}>{{ data.tp_pinterest_text }}</textarea></label>';
			pinterestTextHtml += '<label class="setting" data-setting="tp_pinterest_repin_id"><span class="name">Pinterest Repin ID</span><input type="text" {{ maybeReadOnly }} value="{{ data.tp_pinterest_repin_id }}"></label>';
			pinterestTextHtml += '<# } #>';
			// WordPress 5.3+
			if ( -1 !== attachmentDetailsHtml.indexOf('<span class="setting has-description" data-setting="alt">') ) {
				attachmentDetailsHtml = attachmentDetailsHtml.replace(/(<span class="setting has-description" data-setting="alt">)/, pinterestTextHtml + '$1');
			} else {
				attachmentDetailsHtml = attachmentDetailsHtml.replace(/(<label class="setting" data-setting="alt">)/, pinterestTextHtml + '$1');
			}
			attachmentDetailsTmpl.text( attachmentDetailsHtml );
		}

		// Two-column template in the media library
		if ( twoColTmpl.length > 0 ) {
			var twoColHtml = twoColTmpl.html();
			pinterestTextHtml = '<# if ( \'image\' === data.type ) { #>';
			pinterestTextHtml += '<label class="setting" data-setting="tp_pinterest_title"><span class="name">Pinterest Title</span><input type="text" {{ maybeReadOnly }} value="{{ data.tp_pinterest_title }}"></label>';
			pinterestTextHtml += '<label class="setting" data-setting="tp_pinterest_text"><span class="name" style="margin-right:2%;">Pinterest Text</span><textarea {{ maybeReadOnly }}>{{ data.tp_pinterest_text }}</textarea></label>';
			pinterestTextHtml += '<label class="setting" data-setting="tp_pinterest_repin_id"><span class="name">Pinterest Repin ID</span><input type="text" {{ maybeReadOnly }} value="{{ data.tp_pinterest_repin_id }}"></label>';
			pinterestTextHtml += '<# } #>';
			// WordPress 5.3+
			if ( -1 !== twoColHtml.indexOf('<span class="setting has-description" data-setting="alt">') ) {
				twoColHtml = twoColHtml.replace(/(<span class="setting has-description" data-setting="alt">)/, pinterestTextHtml + '$1');
			} else {
				twoColHtml = twoColHtml.replace(/(<label class="setting" data-setting="alt">)/, pinterestTextHtml + '$1');
			}
			twoColTmpl.text( twoColHtml );
		}

		// Settings when inserting an attachment
		if ( attachmentDisplaySettingsTmpl.length > 0 && ! isCustomizeOrWidgets ) {
			var attachmentDisplaySettingsHtml = attachmentDisplaySettingsTmpl.html();
			attachmentDisplaySettingsHtml += '<# if ( \'image\' === data.type ) { #>';
			attachmentDisplaySettingsHtml += '<label class="setting"><span>Disable Pinning</span><input type="checkbox" name="tp_pinterest_nopin" data-setting="tp_pinterest_nopin" /></label>';
			attachmentDisplaySettingsHtml += '<# } #>';
			attachmentDisplaySettingsTmpl.text( attachmentDisplaySettingsHtml );
		}

		// Static PHP template to edit the image
		if ( mediaEditText.length > 0 ) {
			// WordPress 5.2 vs. WordPress 5.1.
			var appendEl = $('.wp_attachment_details #alt-text-description').length ? $('.wp_attachment_details #alt-text-description') : $('.wp_attachment_details p:nth-child(1)');
			// Append after caption, but before Alt Text
			appendEl.after( mediaEditId );
			mediaEditId.removeClass('hide-if-js');
			appendEl.after( mediaEditText );
			mediaEditText.removeClass('hide-if-js');
			appendEl.after( mediaEditTitle );
			mediaEditTitle.removeClass('hide-if-js');
		}

		/**
		 * Listen to when the Image Details modal is opened and closed
		 */
		if ( typeof wp !== 'undefined'
			&& typeof wp.media !== 'undefined'
			&& typeof wp.media.events !== 'undefined' ) {
			wp.media.events.on('editor:image-edit',function(event){
				event.metadata.tp_pinterest_text = event.editor.$(event.image).attr('data-pin-description');
				event.metadata.tp_pinterest_title = event.editor.$(event.image).attr('data-pin-title');
				event.metadata.tp_pinterest_repin_id = event.editor.$(event.image).attr('data-pin-id');
				event.metadata.tp_pinterest_nopin = event.editor.$(event.image).attr('data-pin-nopin') ? true : false;
			});
			wp.media.events.on('editor:image-update',function(event){
				event.editor.$(event.image).attr('data-pin-description', event.metadata.tp_pinterest_text);
				event.editor.$(event.image).attr('data-pin-title', event.metadata.tp_pinterest_title);
				event.editor.$(event.image).attr('data-pin-id', event.metadata.tp_pinterest_repin_id);
				if ( event.metadata.tp_pinterest_nopin ) {
					event.editor.$(event.image).attr('data-pin-nopin', 'true');
				} else {
					event.editor.$(event.image).removeAttr('data-pin-nopin');
				}
			});
		}

		/**
		 * Handle selection of the Pinterest hidden image
		 */
		$(document).ready(function(){

			if ( typeof wp !== 'undefined'
				&& typeof wp.media !== 'undefined'
				&& typeof wp.media.editor !== 'undefined' ) {
				/**
				 * Overload wp.media.editor.send.attachment() to include the 'Disable Pinning' data
				 */

				/**
				 * Called when sending an attachment to the editor
				 *   from the medial modal.
				 *
				 * @param {Object} props Attachment details (align, link, size, etc).
				 * @param {Object} attachment The attachment object, media version of Post.
				 * @returns {Promise}
				 */
				wp.media.editor.send.attachment = function( props, attachment ) {
					var caption = attachment.caption,
						options, html;

					// If captions are disabled, clear the caption.
					if ( ! wp.media.view.settings.captions ) {
						delete attachment.caption;
					}

					props = wp.media.string.props( props, attachment );

					options = {
						id:           attachment.id,
						post_content: attachment.description,
						post_excerpt: caption
					};

					if ( props.linkUrl ) {
						options.url = props.linkUrl;
					}

					var attachObj = wp.media.attachment( attachment.id );
					if ( typeof attachObj.attributes.tp_pinterest_text !== 'undefined' ) {
						props.tp_pinterest_text = attachObj.attributes.tp_pinterest_text;
					}
					if ( typeof attachObj.attributes.tp_pinterest_title !== 'undefined' ) {
						props.tp_pinterest_title = attachObj.attributes.tp_pinterest_title;
					}
					if ( typeof attachObj.attributes.tp_pinterest_repin_id !== 'undefined' ) {
						props.tp_pinterest_repin_id = attachObj.attributes.tp_pinterest_repin_id;
					}

					if ( 'image' === attachment.type ) {
						html = wp.media.string.image( props );

						_.each({
							align: 'align',
							size:  'image-size',
							alt:   'image_alt'
						}, function( option, prop ) {
							if ( props[ prop ] )
								options[ option ] = props[ prop ];
						});
					} else if ( 'video' === attachment.type ) {
						html = wp.media.string.video( props, attachment );
					} else if ( 'audio' === attachment.type ) {
						html = wp.media.string.audio( props, attachment );
					} else {
						html = wp.media.string.link( props );
						options.post_title = props.title;
					}

					return wp.media.post( 'send-attachment-to-editor', {
						nonce:      wp.media.view.settings.nonce.sendToEditor,
						attachment: options,
						props:      props,
						html:       html,
						post_id:    wp.media.view.settings.post.id
					});
				};

			}
			var frame;
			var selectImage = function( el ){
				var hiddenEl = el.find('input');

				var frame = wp.media({
					title: $('.tasty-pins-select-hidden-image').data('media-title'),
					multiple: hiddenEl.length ? false : true,
					library: {
						type: 'image',
					},
				});

				if ( hiddenEl.length ) {
					frame.on('open',function(){
						var attachIds = hiddenEl.val().split(','),
							selection = frame.state().get('selection'),
							attachments = [];
						$.each( attachIds, function(i, attachId){
							var attachment = wp.media.attachment(attachId);
							attachment.fetch();
							attachments.push( attachment );
						});
						selection.add( attachments );
					});
				}

				frame.on('close',function(){
					var selection = frame.state().get('selection');
					if ( ! selection ) {
						return;
					}
					var src;
					if ( hiddenEl.length ) {
						var attachIds = [],
							imageSizes;
						selection.each(function(attachment){
							attachIds.push( attachment['id'] );
							imageSizes = attachment.attributes.sizes;
						});
						hiddenEl.val(attachIds.join(','));
						if ( 'object' === typeof imageSizes ) {
							src = imageSizes.full.url;
							if ( 'object' === typeof imageSizes.thumbnail ) {
								src = imageSizes.thumbnail.url;
							}
							var img = $('<img />');
							img.attr( 'src', src );
							img.attr('data-pin-nopin','1' );
							el.find('.tasty-pins-hidden-image-preview').html( img );
						}
					} else {
						selection.each(function(attachment){
							var template = wp.template('tasty-pins-hidden-image-preview');
							var src = attachment.attributes.sizes.full.url;
							if ( 'object' === typeof attachment.attributes.sizes.thumbnail ) {
								src = attachment.attributes.sizes.thumbnail.url;
							}
							$('.tasty-pins-hidden-image-with-placeholder').after(template( {
								id: attachment['id'],
								src: src,
							}));
						});
					}
				});

				frame.open();
			}
			$('.tasty-pins-hidden-images').on('click','.tasty-pins-remove-hidden-image', function(e){
				e.preventDefault();
				$(this).closest('.tasty-pins-hidden-image').remove();
			});
			$('.tasty-pins-hidden-images').on('click', '.tasty-pins-hidden-image-preview', function(e){
				e.preventDefault();
				selectImage( $(this).closest('.tasty-pins-hidden-image') );
			});
			$('.tasty-pins-select-hidden-image').on('click',function(e){
				e.preventDefault();
				selectImage( $(this).closest('.tasty-pins-hidden-image') );
			});
		})

	});
}(jQuery))
