<?php
/**
 * Converts Social Warfare data over to Tasty Pins.
 *
 * @package Tasty_Pins
 */

namespace Tasty_Pins\Converters;

use Tasty_Pins\Admin;
use WP_Error;

/**
 * Converts Social Warfare data over to Tasty Pins.
 */
class Social_Warfare {

	/**
	 * Meta key used to indicate when Social Warfare has already been migrated.
	 *
	 * @var string
	 */
	const CONVERSION_COMPLETE_KEY = 'tasty_pins_converted_social_warfare';

	/**
	 * Meta key used by Social Warfare to store Pinterest text.
	 *
	 * @var string
	 */
	const PINTEREST_TEXT_KEY = 'swp_pinterest_description';

	/**
	 * Meta key used by Social Warfare to store Pinterest image URL.
	 *
	 * @var string
	 */
	const PINTEREST_IMAGE_URL_KEY = 'swp_pinterest_image_url';

	/**
	 * Meta key used by Social Warfare to store Pinterest image ID.
	 *
	 * @var string
	 */
	const PINTEREST_IMAGE_ID_KEY = 'swp_pinterest_image';

	/**
	 * Get the post ids that have unmigrated Social Warfare data.
	 *
	 * @return array
	 */
	public static function get_unmigrated_post_ids() {
		global $wpdb;

		$swp_post_ids = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT(post_id) FROM {$wpdb->postmeta} WHERE meta_key = %s OR meta_key = %s OR meta_key = %s", self::PINTEREST_TEXT_KEY, self::PINTEREST_IMAGE_URL_KEY, self::PINTEREST_IMAGE_ID_KEY ) );
		if ( empty( $swp_post_ids ) ) {
			return array();
		}
		$converted_post_ids = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT(post_id) FROM {$wpdb->postmeta} WHERE meta_key = %s", self::CONVERSION_COMPLETE_KEY ) );
		$unconverted_ids    = array_diff( $swp_post_ids, $converted_post_ids );

		return array_values( $unconverted_ids );
	}

	/**
	 * Converts Social Warfare data to Tasty Pins for a post.
	 *
	 * @param integer $post_id Post ID to convert.
	 * @return true|WP_Error
	 */
	public static function convert_post( $post_id ) {
		global $wpdb;

		if ( ! $post_id || ! get_post( $post_id ) ) {
			// translators: The ID for the post.
			return new WP_Error( 'tp_missing_post', sprintf( __( 'No post found for post id %d', 'tasty-pins' ), $post_id ) );
		}

		// If the post doesn't have Pinterest Text, use SW Pinterest Text.
		$sw_text = get_post_meta( $post_id, self::PINTEREST_TEXT_KEY, true );
		if ( $sw_text && ! get_post_meta( $post_id, Admin::DEFAULT_TEXT_KEY, true ) ) {
			update_post_meta( $post_id, Admin::DEFAULT_TEXT_KEY, $sw_text );
		}

		// If there's an image ID, use it in the migration.
		$sw_image = get_post_meta( $post_id, self::PINTEREST_IMAGE_ID_KEY, true );
		if ( $sw_image ) {
			$hidden_images   = get_post_meta( $post_id, Admin::HIDDEN_IMAGE_KEY, true );
			$hidden_images   = array_filter( array_map( 'intval', explode( ',', $hidden_images ) ) );
			$hidden_images[] = $sw_image;
			update_post_meta( $post_id, Admin::HIDDEN_IMAGE_KEY, implode( ',', $hidden_images ) );
		} else {
			// If there's an image URL, attempt to fetch the original from the database.
			$sw_image = get_post_meta( $post_id, self::PINTEREST_IMAGE_URL_KEY, true );
			if ( $sw_image ) {
				$attach_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid=%s", $sw_image ) );
				if ( $attach_id ) {
					$hidden_images   = get_post_meta( $post_id, Admin::HIDDEN_IMAGE_KEY, true );
					$hidden_images   = array_filter( array_map( 'intval', explode( ',', $hidden_images ) ) );
					$hidden_images[] = $attach_id;
					update_post_meta( $post_id, Admin::HIDDEN_IMAGE_KEY, implode( ',', $hidden_images ) );
				} else {
					// Translators: post id, edit post link.
					return new WP_Error( 'tp_missing_attachment', sprintf( __( 'The image in post %1$d could not be found. Convert manually by <a href="%2$s">editing the post</a>.', 'tasty-pins' ), $post_id, get_edit_post_link( $post_id, 'raw' ) ) );
				}
			}
		}

		// Set a marker to prevent future conversions.
		update_post_meta( $post_id, self::CONVERSION_COMPLETE_KEY, 1 );

		return true;
	}

}
