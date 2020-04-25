<?php
/**
 * Enhancements to the WordPress frontend.
 *
 * @package Tasty_Pins
 */

namespace Tasty_Pins;

/**
 * Enhancements to the WordPress frontend.
 */
class Frontend {

	/**
	 * Post meta key used to store the default text.
	 *
	 * @var string
	 */
	const DEFAULT_TEXT_KEY = 'tp_pinterest_default_text';

	/**
	 * Post meta key used to store the default title.
	 *
	 * @var string
	 */
	const DEFAULT_TITLE_KEY = 'tp_pinterest_default_title';

	/**
	 * Image attribute used to store Pinterest Text.
	 *
	 * @var string
	 */
	const TEXT_ATTRIBUTE = 'data-pin-description';

	/**
	 * Post meta key used to store Pinterest Text.
	 *
	 * @var string
	 */
	const TEXT_KEY = 'tp_pinterest_text';

	/**
	 * Image attribute used to store Pinterest Title.
	 *
	 * @var string
	 */
	const TITLE_ATTRIBUTE = 'data-pin-title';

	/**
	 * Post meta key used to store Pinterest Title.
	 *
	 * @var string
	 */
	const TITLE_KEY = 'tp_pinterest_title';

	/**
	 * Image attribute used to disable pinning.
	 *
	 * @var string
	 */
	const NOPIN_ATTRIBUTE = 'data-pin-nopin';

	/**
	 * Image attribute used to disable pinning.
	 *
	 * @var string
	 */
	const NOPIN_ATTRIBUTE_WITH_VALUE = 'data-pin-nopin="true"';

	/**
	 * Post meta key used to store Pinterest Repin ID.
	 *
	 * @var string
	 */
	const REPIN_ID_KEY = 'tp_pinterest_repin_id';

	/**
	 * Image attribute used to store Pinterest Repin ID.
	 *
	 * @var string
	 */
	const REPIN_ID_ATTRIBUTE = 'data-pin-id';

	/**
	 * Post meta key used to store "Force pinning" option.
	 *
	 * @var string
	 */
	const FORCE_PINNING_KEY = 'tp_pinterest_force_pinning';

	/**
	 * Post meta key used to store Pinterest hidden image.
	 *
	 * @var string
	 */
	const HIDDEN_IMAGE_KEY = 'tp_pinterest_hidden_image';

	/**
	 * Image attribute used to store Pinterest URL.
	 *
	 * @var string
	 */
	const URL_ATTRIBUTE = 'data-pin-url';

	/**
	 * Add Pinterest Text data attribute when present
	 *
	 * @param array   $attr       Attributes for the image markup.
	 * @param WP_Post $attachment Image attachment post.
	 * @return array
	 */
	public static function filter_wp_get_attachment_image_attributes( $attr, $attachment ) {
		$pinterest_text = get_post_meta( $attachment->ID, self::TEXT_KEY, true );
		if ( $pinterest_text ) {
			$attr[ self::TEXT_ATTRIBUTE ] = $pinterest_text;
		}
		$pinterest_title = get_post_meta( $attachment->ID, self::TITLE_KEY, true );
		if ( $pinterest_title ) {
			$attr[ self::TITLE_ATTRIBUTE ] = $pinterest_title;
		}
		$pinterest_repin_id = get_post_meta( $attachment->ID, self::REPIN_ID_KEY, true );
		if ( $pinterest_repin_id ) {
			$attr[ self::REPIN_ID_ATTRIBUTE ] = $pinterest_repin_id;
		}
		return $attr;
	}

	/**
	 * Add Pinterest default text or force-pinned image text when necessary.
	 *
	 * @param string  $html    Existing post thumbnail HTML.
	 * @param integer $post_id Post ID.
	 * @return string
	 */
	public static function filter_post_thumbnail_html( $html, $post_id ) {

		if ( false === stripos( $html, '<img' ) ) {
			return $html;
		}

		$default_title = get_post_meta( $post_id, self::DEFAULT_TITLE_KEY, true );
		if ( $default_title && false === stripos( $html, self::TITLE_ATTRIBUTE ) ) {
			$html = str_replace( '<img ', '<img ' . self::TITLE_ATTRIBUTE . '="' . esc_attr( $default_title ) . '" ', $html );
		}

		$default_text = get_post_meta( $post_id, self::DEFAULT_TEXT_KEY, true );
		if ( $default_text && false === stripos( $html, self::TEXT_ATTRIBUTE ) ) {
			$html = str_replace( '<img ', '<img ' . self::TEXT_ATTRIBUTE . '="' . esc_attr( $default_text ) . '" ', $html );
		}

		$html = self::process_content_force_pinned_image( $html, $post_id );

		$post_type_object = get_post_type_object( get_post_type( $post_id ) );
		if ( $post_type_object->publicly_queryable && false === stripos( $html, self::URL_ATTRIBUTE ) ) {
			$html = str_replace( '<img ', '<img ' . self::URL_ATTRIBUTE . '="' . esc_url( get_permalink( $post_id ) ) . '" ', $html );
		}

		return $html;
	}

	/**
	 * Force pinning of first hidden image when checkbox is selected.
	 *
	 * @param string $content Post content.
	 * @return string
	 */
	public static function filter_the_content_early( $content ) {
		if ( ! is_singular() ) {
			return $content;
		}

		$content = self::process_content_default_title( $content, get_the_ID() );
		$content = self::process_content_default_text( $content, get_the_ID() );
		$content = self::process_content_force_pinned_image( $content, get_the_ID() );

		return $content;
	}

	/**
	 * Add Pinterest hidden image to post content when present.
	 *
	 * @param string $content Post content.
	 * @return string
	 */
	public static function filter_the_content( $content ) {
		if ( ! is_singular() ) {
			return $content;
		}
		$content = self::get_hidden_image_html( get_the_ID() ) . $content;
		return $content;
	}

	/**
	 * Add pinit.js to the head.
	 */
	public static function action_wp_head_print_pinit_js() {
		echo "<script type='text/javascript' async defer src='//assets.pinterest.com/js/pinit.js' data-pin-hover='true'></script>\n";
	}

	/**
	 * Get the HTML for hidden images to be included in a post.
	 *
	 * @param integer $post_id Post ID to fetch hidden images of.
	 * @return string
	 */
	public static function get_hidden_image_html( $post_id ) {
		$content             = '';
		$default_description = get_post_meta( $post_id, self::DEFAULT_TEXT_KEY, true );
		$default_title       = get_post_meta( $post_id, self::DEFAULT_TITLE_KEY, true );
		if ( ! $default_title ) {
			$default_title = apply_filters( 'the_title', get_post_field( 'post_title', $post_id, 'raw' ), $post_id );
		}
		foreach ( self::get_hidden_image_ids( $post_id ) as $hidden_image ) {
			/**
			 * Permit modification of the hidden image thumbnail size.
			 *
			 * @param string  $thumb_size   Thumbnail size.
			 * @param integer $hidden_image Hidden image ID.
			 */
			$thumb_size = apply_filters( 'tasty_pins_hidden_image_thumbnail_size', 'thumbnail', $hidden_image );
			$thumb_src  = wp_get_attachment_image_src( $hidden_image, $thumb_size );
			$src        = wp_get_attachment_image_src( $hidden_image, 'full' );
			if ( ! empty( $src[0] ) ) {
				$src_attr    = ! empty( $thumb_src[0] ) ? $thumb_src[0] : $src[0];
				$extra_attrs = '';
				foreach ( array(
					self::TEXT_ATTRIBUTE     => self::TEXT_KEY,
					self::TITLE_ATTRIBUTE    => self::TITLE_KEY,
					self::REPIN_ID_ATTRIBUTE => self::REPIN_ID_KEY,
				) as $pin_attr => $meta_key ) {
					$meta_value = get_post_meta( $hidden_image, $meta_key, true );
					if ( '' === $meta_value && self::TEXT_KEY === $meta_key ) {
						$meta_value = $default_description;
					}
					if ( '' === $meta_value && self::TITLE_KEY === $meta_key ) {
						$meta_value = $default_title;
					}
					if ( '' !== $meta_value ) {
						$extra_attrs .= $pin_attr . '="' . esc_attr( $meta_value ) . '" ';
					}
				}
				if ( $extra_attrs ) {
					$extra_attrs = ' ' . $extra_attrs;
				}
				$image_content = '<div class="tasty-pins-hidden-image-container" style="display:none;"><img' . ( $extra_attrs ? $extra_attrs : ' ' ) . 'class="tasty-pins-hidden-image" src="' . esc_url( $src_attr ) . '" data-pin-media="' . esc_url( $src[0] ) . '"></div>';
				/**
				 * Permit motification of the hidden image HTML.
				 *
				 * @param string  $image_content Image content HTML string.
				 * @param integer $hidden_image  Hidden image ID.
				 */
				$image_content = apply_filters( 'tasty_pins_hidden_image_html', $image_content, $hidden_image );
				$content       = $image_content . PHP_EOL . $content;
			}
		}
		return $content;
	}

	/**
	 * Get the hidden image IDs for a given post.
	 *
	 * @param integer $post_id Post ID to fetch hidden images of.
	 * @return array
	 */
	public static function get_hidden_image_ids( $post_id ) {
		$hidden_images = get_post_meta( $post_id, self::HIDDEN_IMAGE_KEY, true );
		$hidden_images = array_map( 'intval', explode( ',', $hidden_images ) );
		return array_unique( $hidden_images );
	}

	/**
	 * Processes a string of content to apply the default text if necessary.
	 *
	 * @param string  $content Existing content.
	 * @param integer $post_id Containing post ID.
	 * @return string
	 */
	private static function process_content_default_text( $content, $post_id ) {
		// When 'DEFAULT_TEXT_KEY' is set, it should apply to all images
		// that don't already have a Pinterest description.
		$default_description = get_post_meta( $post_id, self::DEFAULT_TEXT_KEY, true );
		if ( ! $default_description ) {
			return $content;
		}
		return preg_replace_callback(
			'#<img[^>]+>#',
			function( $match ) use ( $default_description ) {
				$img = $match[0];
				if ( false !== stripos( $img, 'data-pin-description' ) ) {
					return $img;
				}
				$img = str_replace( '<img ', '<img data-pin-description="' . esc_attr( $default_description ) . '" ', $img );
				return $img;
			},
			$content
		);
	}

	/**
	 * Processes a string of content to apply the default title if necessary.
	 *
	 * @param string  $content Existing content.
	 * @param integer $post_id Containing post ID.
	 * @return string
	 */
	private static function process_content_default_title( $content, $post_id ) {
		// When 'DEFAULT_TITLE_KEY' is set, it should apply to all images
		// that don't already have a Pinterest title.
		$default_title = get_post_meta( $post_id, self::DEFAULT_TITLE_KEY, true );
		if ( ! $default_title ) {
			$default_title = apply_filters( 'the_title', get_post_field( 'post_title', $post_id, 'raw' ), $post_id );
		}
		return preg_replace_callback(
			'#<img[^>]+>#',
			function( $match ) use ( $default_title ) {
				$img = $match[0];
				if ( false !== stripos( $img, 'data-pin-title' ) ) {
					return $img;
				}
				$img = str_replace( '<img ', '<img data-pin-title="' . esc_attr( $default_title ) . '" ', $img );
				return $img;
			},
			$content
		);
	}

	/**
	 * Processes a string of content to apply the force-pinned image if necessary.
	 *
	 * @param string  $content Existing content.
	 * @param integer $post_id Containing post ID.
	 * @return string
	 */
	private static function process_content_force_pinned_image( $content, $post_id ) {
		if ( ! get_post_meta( $post_id, self::FORCE_PINNING_KEY, true ) ) {
			return $content;
		}
		$hidden_images = self::get_hidden_image_ids( $post_id );
		if ( empty( $hidden_images ) ) {
			return $content;
		}
		$first_hidden = array_shift( $hidden_images );
		$src          = wp_get_attachment_image_src( $first_hidden, 'full' );
		$description  = get_post_meta( $first_hidden, self::TEXT_KEY, true );
		if ( ! $description ) {
			$description = get_post_meta( $post_id, self::DEFAULT_TEXT_KEY, true );
		}
		$title = get_post_meta( $first_hidden, self::TITLE_KEY, true );
		if ( ! $title ) {
			$title = get_post_meta( $post_id, self::DEFAULT_TITLE_KEY, true );
		}
		$repin_id = get_post_meta( $first_hidden, self::REPIN_ID_KEY, true );
		if ( ! empty( $src ) ) {
			$content = preg_replace_callback(
				'#<img[^>]+>#',
				function( $match ) use ( $src, $description, $title, $repin_id ) {
					$img = $match[0];
					// Strip existing instances of 'data-pin-*'.
					$img = preg_replace( '#(data-pin-media|data-pin-description|data-pin-title|data-pin-id)="[^"]+"\s?#', '', $img );
					$img = str_replace( '<img ', '<img data-pin-media="' . esc_url( $src[0] ) . '" data-pin-description="' . esc_attr( $description ) . '" data-pin-title="' . esc_attr( $title ) . '" data-pin-id="' . esc_attr( $repin_id ) . '" ', $img );
					return $img;
				},
				$content
			);
		}
		return $content;
	}

}
