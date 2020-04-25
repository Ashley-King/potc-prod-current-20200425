<?php
/**
 * Enhancements to the WordPress backend.
 *
 * @package Tasty_Pins
 */

namespace Tasty_Pins;

use Tasty_Pins\Converters\Social_Warfare;

/**
 * Enhancements to the WordPress backend.
 */
class Admin {
	/**
	 * Plugin About page slug.
	 *
	 * @var string
	 */
	const ABOUT_SLUG = 'tasty-pins-about';

	/**
	 * Capability required to manage settings.
	 *
	 * @var string
	 */
	const CAPABILITY = 'edit_others_posts';

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
	 * Post meta key used to store Pinterest Text.
	 *
	 * @var string
	 */
	const TEXT_KEY = 'tp_pinterest_text';

	/**
	 * Post meta key used to store Pinterest Title.
	 *
	 * @var string
	 */
	const TITLE_KEY = 'tp_pinterest_title';

	/**
	 * Post meta key used to store Pinterest Repin ID.
	 *
	 * @var string
	 */
	const REPIN_ID_KEY = 'tp_pinterest_repin_id';

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
	 * Name of the plugin author.
	 *
	 * @var string
	 */
	const ITEM_AUTHOR = 'Tasty Pins';

	/**
	 * Name of the product.
	 *
	 * @var string
	 */
	const ITEM_NAME = 'Tasty Pins';

	/**
	 * Key used for the license check cache.
	 *
	 * @var string
	 */
	const LICENSE_CHECK_CACHE_KEY = 'tasty-pins-license-check';

	/**
	 * Option used to store the license key.
	 *
	 * @var string
	 */
	const LICENSE_KEY_OPTION = 'tasty_pins_license_key';

	/**
	 * Key used for the settings nonce.
	 *
	 * @var string
	 */
	const NONCE_KEY = 'tasty-pins-settings';

	/**
	 * Option name for plugin activation state.
	 *
	 * @var string
	 */
	const PLUGIN_ACTIVATION_OPTION = 'tasty_pins_do_activation_redirect';

	/**
	 * URL for the EDD store.
	 *
	 * @var
	 */
	const STORE_URL = 'https://www.wptasty.com';

	/**
	 * Initialize the upgrader
	 */
	public static function action_admin_init() {
		new Updater(
			self::STORE_URL,
			TASTY_PINS_PLUGIN_FILE,
			array(
				'version'   => TASTY_PINS_PLUGIN_VERSION,
				'license'   => get_option( self::LICENSE_KEY_OPTION ),
				'item_name' => self::ITEM_NAME,
				'author'    => self::ITEM_AUTHOR,
			)
		);

		if ( get_option( self::PLUGIN_ACTIVATION_OPTION, false ) ) {
			delete_option( self::PLUGIN_ACTIVATION_OPTION );
			if ( ! isset( $_GET['activate-multi'] ) ) {
				wp_safe_redirect( menu_page_url( self::ABOUT_SLUG, false ) );
				exit;
			}
		}
	}

	/**
	 * Actions to perform when activating the plugin.
	 */
	public static function plugin_activation() {
		update_option( self::PLUGIN_ACTIVATION_OPTION, true );
	}

	/**
	 * Includes PHP and plugin versions in the user agent for update checks.
	 *
	 * @param array  $r   An array of HTTP request arguments.
	 * @param string $url The request URL.
	 * @return array
	 */
	public static function filter_http_request_args( $r, $url ) {
		if ( self::STORE_URL !== $url
			|| 'POST' !== $r['method']
			|| empty( $r['body'] )
			|| ! is_array( $r['body'] )
			|| empty( $r['body']['item_name'] )
			|| self::ITEM_NAME !== $r['body']['item_name'] ) {
			return $r;
		}

		$r['user-agent'] = rtrim( $r['user-agent'], ';' )
			. '; PHP/' . PHP_VERSION . '; '
			. self::ITEM_NAME . '/' . TASTY_PINS_PLUGIN_VERSION;
		return $r;
	}

	/**
	 * Register admin menu UX.
	 */
	public static function action_admin_menu() {
		register_setting( 'tasty-pins-settings', self::LICENSE_KEY_OPTION );
		add_settings_section( 'tasty-pins-converters', __( 'Convert Pinterest Images from Social Warfare to Tasty Pins', 'tasty-pins' ), array( __CLASS__, 'render_converters_section' ), 'media' );
		add_dashboard_page( __( 'About Tasty Pins', 'tasty-pins' ), __( 'About Tasty Pins', 'tasty-pins' ), self::CAPABILITY, self::ABOUT_SLUG, array( __CLASS__, 'handle_about_page' ) );

	}

	/**
	 * Remove the plugin about page from the menu because it'll only be shown after plugin activation.
	 */
	public static function action_admin_head() {
		remove_submenu_page( 'index.php', self::ABOUT_SLUG );
	}

	/**
	 * Display an admin notice when the license key is incorrect.
	 */
	public static function action_admin_notices_license_key() {

		$screen = get_current_screen();
		if ( $screen && 'post' === $screen->base ) {
			return;
		}

		if ( ! get_option( self::LICENSE_KEY_OPTION ) ) :
			?>
	<div class="updated" style="display:block !important;">
		<form method="post" action="options.php">
			<p>
				<strong><?php esc_html_e( 'Tasty Pins is almost ready', 'tasty-pins' ); ?></strong>, <label style="vertical-align: baseline;" for="<?php echo esc_attr( self::LICENSE_KEY_OPTION ); ?>"><?php esc_html_e( 'enter your license key to continue', 'tasty-pins' ); ?></label>
				<input type="text" style="margin-left: 5px; margin-right: 5px; " class="code regular-text" id="<?php echo esc_attr( self::LICENSE_KEY_OPTION ); ?>" name="<?php echo esc_attr( self::LICENSE_KEY_OPTION ); ?>" />
				<input type="submit" value="<?php _e( 'Save license key', 'tasty-pins' ); ?>" class="button-primary" />
			</p>
			<p>
				<strong><?php esc_html_e( "Don't have a Tasty Pins license yet?", 'tasty-pins' ); ?></strong> <a href="https://www.wptasty.com/" target="_blank"><?php esc_html_e( 'Get one in just a few minutes time', 'tasty-pins' ); ?></a>, <?php esc_html_e( "and report back once you've gotten your license key", 'tasty-pins' ); ?>
			</p>
			<?php
			settings_fields( 'tasty-pins-settings' );
			do_settings_sections( 'tasty-pins-settings' );
			?>
		</form>

	</div>
			<?php
		endif;

		$license_check = false;
		if ( get_option( self::LICENSE_KEY_OPTION ) ) {
			$license_check = get_transient( self::LICENSE_CHECK_CACHE_KEY );
			if ( false === $license_check ) {
				$api_params = array(
					'edd_action' => 'check_license',
					'license'    => get_option( self::LICENSE_KEY_OPTION ),
					'item_id'    => false,
					'item_name'  => self::ITEM_NAME,
					'author'     => self::ITEM_AUTHOR,
					'url'        => home_url(),
				);

				$license_check = wp_remote_post(
					self::STORE_URL,
					array(
						'timeout' => 15,
						'body'    => $api_params,
					)
				);

				if ( ! is_wp_error( $license_check ) ) {
					$license_check = json_decode( wp_remote_retrieve_body( $license_check ) );
				}
				set_transient( self::LICENSE_CHECK_CACHE_KEY, $license_check, 60 * HOUR_IN_SECONDS );
			}
		}

		if ( ! empty( $license_check ) && 'valid' !== $license_check->license ) :
			?>
	<div class="error" style="display:block !important;">
		<form method="post" action="options.php">
			<p>
				<strong><?php esc_html_e( 'To enable updates and support for Tasty Pins', 'tasty-pins' ); ?></strong>, <label style="vertical-align: baseline;" for="<?php echo esc_attr( self::LICENSE_KEY_OPTION ); ?>"><?php esc_html_e( 'enter a valid license key', 'tasty-pins' ); ?></label>
				<input type="text" style="margin-left: 5px; margin-right: 5px; " class="code regular-text" id="<?php echo esc_attr( self::LICENSE_KEY_OPTION ); ?>" name="<?php echo esc_attr( self::LICENSE_KEY_OPTION ); ?>" value="<?php echo esc_attr( get_option( self::LICENSE_KEY_OPTION ) ); ?>" />
				<input type="submit" value="<?php _e( 'Save license key', 'tasty-pins' ); ?>" class="button-primary" />
			</p>
			<p>
				<strong><?php esc_html_e( "Think you've reached this message in error?", 'tasty-pins' ); ?></strong> <a href="http://support.wptasty.com" target="_blank"><?php esc_html_e( 'Submit a support ticket', 'tasty-pins' ); ?></a>, <?php esc_html_e( "and we'll do our best to help out.", 'tasty-pins' ); ?>
			</p>
			<div style="display:none;"><pre><?php echo json_encode( $license_check ); ?></pre></div>
			<?php
			settings_fields( 'tasty-pins-settings' );
			do_settings_sections( 'tasty-pins-settings' );
			?>
		</form>

	</div>
			<?php
		endif;

	}

	/**
	 * Activate the license when the option is updated
	 */
	public static function action_update_option_register_license() {
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => get_option( self::LICENSE_KEY_OPTION ),
			'item_name'  => self::ITEM_NAME, // the name of our product in EDD.
			'url'        => home_url(),
		);
		wp_remote_post(
			self::STORE_URL,
			array(
				'timeout' => 15,
				'body'    => $api_params,
			)
		);
	}

	/**
	 * Clear license key cache when the option is updated.
	 */
	public static function action_update_option_clear_transient() {
		delete_transient( self::LICENSE_CHECK_CACHE_KEY );
		$cache_key = md5( 'edd_plugin_' . sanitize_key( plugin_basename( TASTY_PINS_PLUGIN_FILE ) ) . '_version_info' );
		delete_site_transient( $cache_key );
		$cache_key = 'edd_api_request_' . substr( md5( serialize( basename( TASTY_PINS_PLUGIN_FILE, '.php' ) ) ), 0, 15 );
		delete_site_transient( $cache_key );
		delete_site_transient( 'update_plugins' );
	}

	/**
	 * Include the 'Remove license' link in plugin actions
	 *
	 * @param array $links Existing plugin actions.
	 * @return array
	 */
	public static function filter_plugin_action_links( $links ) {
		if ( get_option( self::LICENSE_KEY_OPTION ) ) {
			$links['remove_key'] = '<a href="' . add_query_arg(
				array(
					'action' => 'tasty_pins_remove_license_key',
					'nonce'  => wp_create_nonce( 'tasty_pins_remove_license_key' ),
				),
				admin_url( 'admin-ajax.php' )
			) . '">' . esc_html__( 'Remove license', 'tasty-pins' ) . '</a>';
		}
		return $links;
	}

	/**
	 * Handle AJAX request to remove the license key.
	 */
	public static function handle_wp_ajax_remove_license_key() {

		if ( ! current_user_can( 'manage_options' ) || ! wp_verify_nonce( $_GET['nonce'], 'tasty_pins_remove_license_key' ) ) {
			wp_safe_redirect( admin_url( 'plugins.php' ) );
			exit;
		}

		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => get_option( self::LICENSE_KEY_OPTION ),
			'item_name'  => self::ITEM_NAME,
			'url'        => home_url(),
		);
		$response   = wp_remote_post(
			self::STORE_URL,
			array(
				'timeout' => 15,
				'body'    => $api_params,
			)
		);
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.', 'tasty-pins' );
			}
			wp_die( $message );
		}

		self::action_update_option_clear_transient();
		delete_option( self::LICENSE_KEY_OPTION );
		wp_safe_redirect( admin_url( 'plugins.php' ) );
		exit;
	}

	/**
	 * Handles an AJAX request to convert Social Warfare Pinterest images.
	 */
	public static function handle_wp_ajax_convert() {
		if ( ! wp_verify_nonce( $_GET['nonce'], self::NONCE_KEY )
			|| empty( $_GET['post_id'] ) ) {
			wp_send_json_error(
				array(
					'message' => __( "Sorry, you don't have permission to do this.", 'tasty-pins' ),
				)
			);
		}
		$ret      = Social_Warfare::convert_post( (int) $_GET['post_id'] );
		$response = array(
			'message' => is_wp_error( $ret ) ? $ret->get_error_message() : '',
		);
		wp_send_json_success( $response );
	}

	/**
	 * Renders the Media section used for the Social Warfare converter.
	 */
	public static function render_converters_section() {
		$unmigrated_ids = Social_Warfare::get_unmigrated_post_ids();
		$standard_text  = __( "Social Warfare Pinterest Images were detected. If you'd like, use the button below to convert these over to Tasty Pins.\n\nThis will migrate Pinterest descriptions and hidden images to use Tasty Pins functionality. Existing Social Warfare data will not be altered.", 'tasty-pins' );
		if ( $unmigrated_ids ) {
			?>
<div class="tasty-pins-convert-wrapper" data-post-ids="<?php echo esc_attr( wp_json_encode( $unmigrated_ids ) ); ?>">
			<?php echo wpautop( esc_html( $standard_text ) ); ?>
	<button class="button start-conversion" disabled><?php esc_html_e( 'Convert Pinterest images', 'tasty-pins' ); ?></button>
</div>
<script type="text/html" id="tmpl-tasty-pins-convert">
	<# if ( data.converting ) { #>
		<p><?php esc_html_e( 'Converting Social Warfare Pinterest images. Leave this window open until the conversion is complete.', 'tasty-pins' ); ?></p>
		<progress value="{{ data.converted }}" max="{{ data.count }}">
	<# } else { #>
		<# if ( data.count ) { #>
			<?php echo wpautop( ' {{data.count }} ' . esc_html( $standard_text ) ); ?>
			<button class="button start-conversion"><?php esc_html_e( 'Convert Pinterest images', 'tasty-pins' ); ?></button>
		<# } else { #>
			<p><?php esc_html_e( 'Social Warfare Pinterest image conversion complete. Feel free to navigate to a different page.', 'tasty-pins' ); ?></p>
		<# } #>
	<# } #>
	<# if ( data.errorMessage ) { #>
		<p>{{ data.errorMessage }}</p>
	<# } #>
	<# if ( data.convertMessages ) { #>
		<p>{{{ data.convertMessages }}}</p>
	<# } #>
</script>
			<?php
		} else {
			echo '<p>' . __( 'No conversion needed; either no Social Warfare Pinterest images were found, or they have already been converted.', 'tasty-pins' ) . '</p>';
		}
	}

	/**
	 * Add Pinterest Text HTML to the DOM.
	 *
	 * @param WP_Post $post   Attachment object.
	 */
	public static function action_edit_form_after_title( $post ) {
		if ( 'attachment' !== $post->post_type
			|| 'image' !== substr( $post->post_mime_type, 0, 5 ) ) {
			return;
		}
		$text_value = get_post_meta( $post->ID, self::TEXT_KEY, true );
		$text_name  = 'attachments[' . $post->ID . '][' . self::TEXT_KEY . ']';

		$title_value = get_post_meta( $post->ID, self::TITLE_KEY, true );
		$title_name  = 'attachments[' . $post->ID . '][' . self::TITLE_KEY . ']';

		$id_value = get_post_meta( $post->ID, self::REPIN_ID_KEY, true );
		$id_name  = 'attachments[' . $post->ID . '][' . self::REPIN_ID_KEY . ']';
		?>
		<p id="tp-pinterest-text-wrap" class="hide-if-js">
			<label for="<?php echo esc_attr( $text_name ); ?>"><strong>Pinterest Text</strong></label><br>
			<textarea style="height:4em;" name="<?php echo esc_attr( $text_name ); ?>" class="widefat"><?php echo esc_textarea( $text_value ); ?></textarea>
		</p>
		<p id="tp-pinterest-title-wrap" class="hide-if-js">
			<label for="<?php echo esc_attr( $title_name ); ?>"><strong>Pinterest Title</strong></label><br>
			<input type="text" name="<?php echo esc_attr( $title_name ); ?>" value="<?php echo esc_attr( $title_value ); ?>" class="widefat">
		</p>
		<p id="tp-pinterest-repin-id-wrap" class="hide-if-js">
			<label for="<?php echo esc_attr( $id_name ); ?>"><strong>Pinterest Repin ID</strong></label><br>
			<input type="text" name="<?php echo esc_attr( $id_name ); ?>" value="<?php echo esc_attr( $id_value ); ?>" class="widefat">
		</p>
		<?php
	}

	/**
	 * Add a meta box to manage the hidden Pinterest image
	 *
	 * @param string $post_type Post type being loaded.
	 */
	public static function action_add_meta_boxes( $post_type ) {
		if ( 'attachment' === $post_type
			|| ! post_type_supports( $post_type, 'editor' ) ) {
			return;
		}
		add_meta_box( 'tasty-pins', esc_html__( 'Tasty Pins', 'tasty-pins' ), array( __CLASS__, 'render_meta_box' ), $post_type );
	}

	/**
	 * Render the Tasty Pins meta box
	 *
	 * @param WP_Post $post Current post object.
	 */
	public static function render_meta_box( $post ) {
		$force_pinning = (bool) get_post_meta( $post->ID, self::FORCE_PINNING_KEY, true );
		$default_text  = get_post_meta( $post->ID, self::DEFAULT_TEXT_KEY, true );
		$default_title = get_post_meta( $post->ID, self::DEFAULT_TITLE_KEY, true );
		$hidden_images = get_post_meta( $post->ID, self::HIDDEN_IMAGE_KEY, true );
		$hidden_images = array_map( 'intval', explode( ',', $hidden_images ) );
		?>
		<section>
			<h3><?php esc_html_e( 'Pinterest hidden images', 'tasty-pins' ); ?></h3>
			<div class="tasty-pins-force-pinning">
				<label>
					<input type="checkbox" <?php checked( true, $force_pinning ); ?> name="<?php echo esc_attr( self::FORCE_PINNING_KEY ); ?>">
					<?php esc_html_e( 'Force pinning of first hidden image', 'tasty-pins' ); ?>
				</label>
			</div>
			<div class="tasty-pins-hidden-images">
			<div class="tasty-pins-hidden-image tasty-pins-hidden-image-with-placeholder">
				<div class="tasty-pins-hidden-image-preview">
					<div class="tasty-pins-hidden-image-preview-placeholder"></div>
				</div>
				<span class="tasty-pins-select-hidden-image button" data-input-name="<?php echo esc_attr( self::HIDDEN_IMAGE_KEY ); ?>" data-media-title="<?php esc_attr_e( 'Pinterest Hidden Images', 'tasty-pins' ); ?>"><?php esc_html_e( 'Select Images', 'tasty-pins' ); ?></span>
			</div>
			<?php
			foreach ( $hidden_images as $hidden_image ) {
				$hidden_image_src = wp_get_attachment_image_src( $hidden_image, 'thumbnail' );
				$hidden_image_src = ! empty( $hidden_image_src[0] ) ? $hidden_image_src[0] : false;
				if ( empty( $hidden_image_src ) ) {
					continue;
				}
				self::render_single_image_template( $hidden_image_src, $hidden_image );
			}
			?>
			</div>
		</section>
		<div style="clear:both;"></div>
		<section class="tasty-pins-default-title">
			<h3 for="<?php echo esc_attr( self::DEFAULT_TITLE_KEY ); ?>">
				<?php esc_html_e( 'Default Pinterest Title', 'tasty-pins' ); ?>
			</h3>
			<p><?php esc_html_e( 'Default Pinterest Title will be applied to any images in the content that do not have a Pinterest Title set. If no Default Pinterest Title is provided, the post title will be used. If a hidden image is forced, the hidden image\'s Pinterest Title will be used instead.', 'tasty-pins' ); ?> <a href="<?php echo esc_url( 'https://www.wptasty.com/default-title' ); ?>"><?php esc_html_e( 'Learn more.', 'tasty-pins' ); ?></a></p>
			<input name="<?php echo esc_attr( self::DEFAULT_TITLE_KEY ); ?>" style="display:inline-block;margin-top: 0.5rem;" value="<?php echo esc_attr( $default_title ); ?>" />
		</section>
		<section class="tasty-pins-default-text">
			<h3 for="<?php echo esc_attr( self::DEFAULT_TEXT_KEY ); ?>">
				<?php esc_html_e( 'Default Pinterest Text', 'tasty-pins' ); ?>
			</h3>
			<p><?php esc_html_e( 'Default Pinterest Text will be applied to any images in the content that do not have a Pinterest Text set. If a hidden image is forced, the hidden image\'s Pinterest Text will be used instead.', 'tasty-pins' ); ?> <a href="<?php echo esc_url( 'https://www.wptasty.com/default-text' ); ?>"><?php esc_html_e( 'Learn more.', 'tasty-pins' ); ?></a></p>
			<textarea name="<?php echo esc_attr( self::DEFAULT_TEXT_KEY ); ?>" rows="4" style="margin-top: 0.5rem;"><?php echo esc_textarea( $default_text ); ?></textarea>
		</section>
		<script type="text/html" id="tmpl-tasty-pins-hidden-image-preview">
			<?php self::render_single_image_template( '{{data.src}}', '{{data.id}}' ); ?>
		</script>
		<style>
		label[for="tasty_pins_hidden_image"],
		.tasty-pins-force-pinning,
		.tasty-pins-hidden-images,
		.tasty-pins-default-text {
			margin-top: 1em;
			margin-bottom: 1em;
		}
		.tasty-pins-hidden-image {
			position: relative;
			width: 150px;
			height: 150px;
			border: 1px solid #ddd;
			float: left;
		}
		.tasty-pins-hidden-image .tasty-pins-hidden-image-preview:hover,
		.tasty-pins-hidden-image .tasty-pins-remove-hidden-image:hover {
			cursor: pointer;
		}
		.tasty-pins-hidden-image .tasty-pins-hidden-image-preview img {
			max-width: 100%;
		}
		.tasty-pins-hidden-image .tasty-pins-remove-hidden-image {
			position: absolute;
			top: 5px;
			right: 5px;
			padding-left: 0;
			padding-right: 0;
			height: 22px;
			z-index: 1;
		}
		.tasty-pins-hidden-image .tasty-pins-hidden-image-preview-placeholder {
			width: 150px;
			height: 150px;
		}
		.tasty-pins-hidden-image .tasty-pins-select-hidden-image {
			display: none;
			position: absolute;
			top: 50%;
			left: 50%;
			margin-top: -14px;
			margin-left: -54px;
		}
		.tasty-pins-hidden-image.tasty-pins-hidden-image-with-placeholder .tasty-pins-select-hidden-image {
			display: block;
		}
		.tasty-pins-hidden-image.tasty-pins-hidden-image-with-placeholder .tasty-pins-remove-hidden-image {
			display: none;
		}
		.tasty-pins-default-title p,
		.tasty-pins-default-text p {
			max-width: 500px;
		}
		.tasty-pins-default-title input,
		.tasty-pins-default-text textarea {
			width: 100%;
			max-width: 500px;
		}
		</style>
		<?php
		wp_enqueue_media();
		wp_nonce_field( 'tasty-pins-nonce', 'tasty-pins-nonce' );
	}

	/**
	 * Render the display of a single preview image.
	 *
	 * @param string  $src          Source for the hidden image.
	 * @param integer $hidden_image ID for the hidden image.
	 */
	private static function render_single_image_template( $src, $hidden_image ) {
		$id = md5( mt_rand() );
		?>
		<div class="tasty-pins-hidden-image">
			<div class="tasty-pins-hidden-image-preview">
				<img src="<?php echo esc_attr( $src ); ?>" data-pin-nopin="1" />
			</div>
			<span class="tasty-pins-remove-hidden-image button" data-input-id="<?php echo esc_attr( $id ); ?>"><span class="dashicons dashicons-no-alt"></span></span>
			<input type="hidden" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( self::HIDDEN_IMAGE_KEY ); ?>[]" value="<?php echo esc_attr( $hidden_image ); ?>" />
		</div>
		<?php
	}

	/**
	 * Save the meta box when the post is saved
	 *
	 * @param integer $post_id ID for the post.
	 */
	public static function action_save_post( $post_id ) {

		if ( ! isset( $_POST['tasty-pins-nonce'] )
			|| ! wp_verify_nonce( $_POST['tasty-pins-nonce'], 'tasty-pins-nonce' ) ) {
			return;
		}
		$force_pinning = ! empty( $_POST[ self::FORCE_PINNING_KEY ] ) ? 1 : 0;
		update_post_meta( $post_id, self::FORCE_PINNING_KEY, $force_pinning );

		$hidden_images = ! empty( $_POST[ self::HIDDEN_IMAGE_KEY ] ) ? implode( ',', array_map( 'intval', $_POST[ self::HIDDEN_IMAGE_KEY ] ) ) : '';
		update_post_meta( $post_id, self::HIDDEN_IMAGE_KEY, $hidden_images );

		$default_text = ! empty( $_POST[ self::DEFAULT_TEXT_KEY ] ) ? sanitize_text_field( $_POST[ self::DEFAULT_TEXT_KEY ] ) : '';
		update_post_meta( $post_id, self::DEFAULT_TEXT_KEY, $default_text );

		$default_title = ! empty( $_POST[ self::DEFAULT_TITLE_KEY ] ) ? sanitize_text_field( $_POST[ self::DEFAULT_TITLE_KEY ] ) : '';
		update_post_meta( $post_id, self::DEFAULT_TITLE_KEY, $default_title );
	}

	/**
	 * Save custom fields used in the attachment editor.
	 *
	 * @param array $data       Attachment fields to save.
	 * @param array $attachment Data specific about the attachment.
	 * @return array
	 */
	public static function filter_attachment_fields_to_save( $data, $attachment ) {
		foreach ( array(
			self::TEXT_KEY,
			self::TITLE_KEY,
			self::REPIN_ID_KEY,
		) as $field ) {
			if ( ! isset( $attachment[ $field ] ) ) {
				continue;
			}
			update_post_meta( $data['ID'], $field, sanitize_text_field( $attachment[ $field ] ) );
		}
		return $data;
	}

	/**
	 * Filter the attachment data prepared for JavaScript.
	 *
	 * @param array  $response   Array of prepared attachment data.
	 * @param object $attachment Attachment object.
	 * @return array
	 */
	public static function filter_wp_prepare_attachment_for_js( $response, $attachment ) {
		foreach ( array(
			self::TEXT_KEY,
			self::TITLE_KEY,
			self::REPIN_ID_KEY,
		) as $field ) {
			$response[ $field ] = get_post_meta( $attachment->ID, $field, true );
		}
		return $response;
	}

	/**
	 * Save Pinterest Text when an attachment is saved.
	 */
	public static function handle_wp_ajax_save_attachment() {
		if ( ! isset( $_POST['id'] ) ) {
			return;
		}
		if ( ! check_ajax_referer( 'update-post_' . $_POST['id'], 'nonce' ) ) {
			return;
		}

		foreach ( array(
			self::TEXT_KEY,
			self::TITLE_KEY,
			self::REPIN_ID_KEY,
		) as $field ) {
			if ( ! isset( $_POST['changes'][ $field ] ) ) {
				continue;
			}
			update_post_meta( (int) $_POST['id'], $field, sanitize_text_field( $_POST['changes'][ $field ] ) );
		}
	}

	/**
	 * Append Pinterest Text to markup sent to editor
	 *
	 * @param string $html The image HTML markup to send.
	 * @return string
	 */
	public static function filter_image_send_to_editor( $html ) {
		if ( ! empty( $_POST['props']['tp_pinterest_text'] ) ) {
			$html = str_replace( '<img ', '<img data-pin-description="' . esc_attr( wp_unslash( $_POST['props']['tp_pinterest_text'] ) ) . '" ', $html );
		}
		if ( ! empty( $_POST['props']['tp_pinterest_title'] ) ) {
			$html = str_replace( '<img ', '<img data-pin-title="' . esc_attr( wp_unslash( $_POST['props']['tp_pinterest_title'] ) ) . '" ', $html );
		}
		if ( ! empty( $_POST['props']['tp_pinterest_repin_id'] ) ) {
			$html = str_replace( '<img ', '<img data-pin-id="' . esc_attr( wp_unslash( $_POST['props']['tp_pinterest_repin_id'] ) ) . '" ', $html );
		}
		if ( ! empty( $_POST['props']['tp_pinterest_nopin'] ) ) {
			$html = str_replace( '<img ', '<img data-pin-nopin="true" ', $html );
		}
		return $html;
	}

	/**
	 * Filter allowed tags to include our data attributes.
	 *
	 * @param array  $tags    Allowed tags.
	 * @param string $context Context for the call.
	 * @return array
	 */
	public static function filter_wp_kses_allowed_html( $tags, $context ) {
		if ( 'post' !== $context ) {
			return $tags;
		}
		$tags['img']['data-pin-description'] = true;
		$tags['img']['data-pin-title']       = true;
		$tags['img']['data-pin-id']          = true;
		$tags['img']['data-pin-nopin']       = true;
		return $tags;
	}

	/**
	 * Get a rendered template.
	 *
	 * @param string $template Template to render.
	 * @param array  $vars     Variables to pass to the template.
	 * @return string
	 */
	public static function get_template_part( $template, $vars = array() ) {
		$full_path = dirname( dirname( __FILE__ ) ) . '/templates/' . $template . '.php';
		// Provided template may already be a full path.
		if ( ! file_exists( $full_path ) ) {
			$full_path = $template;
		}
		if ( ! file_exists( $full_path ) ) {
			return '';
		}

		ob_start();
		// @codingStandardsIgnoreStart
		if ( ! empty( $vars ) ) {
			extract( $vars );
		}
		// @codingStandardsIgnoreEnd
		include $full_path;
		return ob_get_clean();
	}

	/**
	 * Render the About page.
	 */
	public static function handle_about_page() {
		echo self::get_template_part( 'about' );
	}

}
