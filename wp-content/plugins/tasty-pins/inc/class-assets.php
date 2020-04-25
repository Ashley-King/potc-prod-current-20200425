<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Tasty_Pins
 */

namespace Tasty_Pins;

/**
 * Enqueue scripts and styles.
 */
class Assets {

	/**
	 * Enqueue scripts and styles in the admin.
	 */
	public static function action_admin_enqueue_scripts() {
		$fmtime = filemtime( dirname( __DIR__ ) . '/assets/js/admin.js' );
		wp_enqueue_script( 'tasty-pins-admin', plugins_url( 'assets/js/admin.js', __DIR__ ), array( 'jquery' ), $fmtime );
		$fmtime = filemtime( dirname( __DIR__ ) . '/assets/css/admin.css' );
		wp_enqueue_style( 'tasty-pins-admin-css', plugins_url( 'assets/css/admin.css', __DIR__ ), null, $fmtime );

		$screen = get_current_screen();

		if ( $screen && 'options-media' === $screen->id ) {
			$time = filemtime( dirname( dirname( __FILE__ ) ) . '/assets/js/settings.js' );
			wp_enqueue_script( 'tasty-pins-settings', plugins_url( 'assets/js/settings.js?r=' . (int) $time, dirname( __FILE__ ) ), array( 'jquery', 'wp-util' ) );
			wp_localize_script(
				'tasty-pins-settings',
				'tastyPinsSettings',
				array(
					'nonce' => wp_create_nonce( Admin::NONCE_KEY ),
				)
			);
		}
	}


}
