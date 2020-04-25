<?php
/**
 * Plugin Name:     Tasty Pins
 * Plugin URI:      https://www.wptasty.com/tasty-pins
 * Description:     Optimize your blog’s images for Pinterest, SEO, and screenreaders.
 * Author:          WP Tasty
 * Author URI:      https://www.wptasty.com
 * Text Domain:     tasty-pins
 * Domain Path:     /languages
 * Version:         1.0.2
 *
 * @package         Tasty_Pins
 */

define( 'TASTY_PINS_PLUGIN_VERSION', '1.0.2' );
define( 'TASTY_PINS_PLUGIN_FILE', __FILE__ );

/**
 * Register plugin integration points
 */
add_action( 'admin_init', array( 'Tasty_Pins\Admin', 'action_admin_init' ) );
add_action( 'http_request_args', array( 'Tasty_Pins\Admin', 'filter_http_request_args' ), 10, 2 );
add_action( 'admin_head', array( 'Tasty_Pins\Admin', 'action_admin_head' ) );
add_action( 'admin_menu', array( 'Tasty_Pins\Admin', 'action_admin_menu' ) );
add_action( 'admin_notices', array( 'Tasty_Pins\Admin', 'action_admin_notices_license_key' ) );
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( 'Tasty_Pins\Admin', 'filter_plugin_action_links' ) );
add_action( 'add_option_tasty_pins_license_key', array( 'Tasty_Pins\Admin', 'action_update_option_register_license' ) );
add_action( 'update_option_tasty_pins_license_key', array( 'Tasty_Pins\Admin', 'action_update_option_register_license' ) );
add_action( 'update_option_tasty_pins_license_key', array( 'Tasty_Pins\Admin', 'action_update_option_clear_transient' ) );
add_action( 'wp_ajax_tasty_pins_remove_license_key', array( 'Tasty_Pins\Admin', 'handle_wp_ajax_remove_license_key' ) );
add_action( 'wp_ajax_tasty_pins_convert', array( 'Tasty_Pins\Admin', 'handle_wp_ajax_convert' ) );
add_filter( 'edit_form_after_title', array( 'Tasty_Pins\Admin', 'action_edit_form_after_title' ), 11 );
add_action( 'add_meta_boxes', array( 'Tasty_Pins\Admin', 'action_add_meta_boxes' ) );
add_action( 'save_post', array( 'Tasty_Pins\Admin', 'action_save_post' ) );
add_filter( 'attachment_fields_to_save', array( 'Tasty_Pins\Admin', 'filter_attachment_fields_to_save' ), 10, 2 );
add_filter( 'wp_prepare_attachment_for_js', array( 'Tasty_Pins\Admin', 'filter_wp_prepare_attachment_for_js' ), 10, 2 );
add_action( 'admin_enqueue_scripts', array( 'Tasty_Pins\Assets', 'action_admin_enqueue_scripts' ) );
add_action( 'enqueue_block_editor_assets', array( 'Tasty_Pins\Blocks', 'action_enqueue_block_editor_assets' ) );
add_filter( 'wp_ajax_save-attachment', array( 'Tasty_Pins\Admin', 'handle_wp_ajax_save_attachment' ), 1 );
add_filter( 'image_send_to_editor', array( 'Tasty_Pins\Admin', 'filter_image_send_to_editor' ) );
add_filter( 'wp_get_attachment_image_attributes', array( 'Tasty_Pins\Frontend', 'filter_wp_get_attachment_image_attributes' ), 10, 2 );
add_filter( 'post_thumbnail_html', array( 'Tasty_Pins\Frontend', 'filter_post_thumbnail_html' ), 10, 2 );
add_filter( 'wp_kses_allowed_html', array( 'Tasty_Pins\Admin', 'filter_wp_kses_allowed_html' ), 10, 2 );
add_action( 'wp_head', array( 'Tasty_Pins\Frontend', 'action_wp_head_print_pinit_js' ) );
add_filter( 'the_content', array( 'Tasty_Pins\Frontend', 'filter_the_content_early' ), 1 );
add_filter( 'the_content', array( 'Tasty_Pins\Frontend', 'filter_the_content' ) );

/**
 * Register the class autoloader
 */
spl_autoload_register(
	function( $class ) {
		$class = ltrim( $class, '\\' );
		if ( 0 !== stripos( $class, 'Tasty_Pins\\' ) ) {
			return;
		}

		$parts = explode( '\\', $class );
		array_shift( $parts ); // Don't need "Tasty_Pins".
		$last    = array_pop( $parts ); // File should be 'class-[...].php'.
		$last    = 'class-' . $last . '.php';
		$parts[] = $last;
		$file    = dirname( __FILE__ ) . '/inc/' . str_replace( '_', '-', strtolower( implode( '/', $parts ) ) );
		if ( file_exists( $file ) ) {
			require $file;
		}

	}
);

/**
 * Register the plugin activation hook
 */
register_activation_hook( __FILE__, array( 'Tasty_Pins\Admin', 'plugin_activation' ) );
