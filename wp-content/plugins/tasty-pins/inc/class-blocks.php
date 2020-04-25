<?php
/**
 * Manage Gutenberg Block interactions.
 *
 * @package Tasty_Pins
 */

namespace Tasty_Pins;

/**
 * Manage Gutenberg Block interactions.
 */
class Blocks {

	/**
	 * Enqueue scripts and styles in the Gutenberg editor.
	 */
	public static function action_enqueue_block_editor_assets() {

		wp_enqueue_media();
		$fmtime = filemtime( dirname( __DIR__ ) . '/assets/dist/block-editor.build.js' );
		wp_enqueue_script(
			'tasty-pins-block-editor',
			plugins_url( 'assets/dist/block-editor.build.js', __DIR__ ),
			array(
				'wp-components',
				'wp-compose',
				'wp-editor',
				'wp-element',
				'wp-i18n',
				'media-editor',
			),
			$fmtime
		);
		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'tasty-pins-block-editor', 'tasty-pins' );
		}
	}

}
