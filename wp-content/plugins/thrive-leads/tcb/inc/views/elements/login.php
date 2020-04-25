<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-visual-editor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

$logout_link = tcb_get_dynamic_link( 'Logout', 'Site' );
$logout_url  = isset( $logout_link['url'] ) ? $logout_link['url'] : '#';
$logout_id   = isset( $logout_link['id'] ) ? $logout_link['id'] : '';
?>

<div class="thrv_wrapper thrv-login-element">
	<div class="tcb-login-form-wrapper tve_empty_dropzone tve_no_drag tve-active-state" data-state="login">
		<div class="thrv_wrapper tcb-login-form tcb-no-clone tcb-no-delete tcb-no-save tve_no_drag">
			<form action="" method="post" novalidate class="tve-form">
				<div class="tve-login-item-wrapper">
					<div class="tve-login-form-item tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save">
						<div class="thrv-form-input-wrapper tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save" data-type="email">
							<label class="tcb-label tcb-editable-label tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save"><?php echo __( 'Username or Email Address', 'thrive-cb' ); ?></label>

							<div class="tve-form-input tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save">
								<input placeholder="<?php esc_attr_e( 'Username or Email Address', 'thrive-cb' ); ?>" data-placeholder="<?php esc_attr_e( 'Username or Email Address', 'thrive-cb' ); ?>" type="text" name="username">
							</div>
						</div>
					</div>
					<div class="tve-login-form-item tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save">
						<div class="thrv-form-input-wrapper tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save" data-type="password">
							<label class="tcb-label tcb-editable-label tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save"><?php echo __( 'Password', 'thrive-cb' ); ?></label>

							<div class="tve-form-input tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save">
								<input type="password" placeholder="<?php esc_attr_e( 'Type your password', 'thrive-cb' ); ?>" data-placeholder="<?php esc_attr_e( 'Type your password', 'thrive-cb' ); ?>" name="password">
							</div>
						</div>
					</div>
					<div class="tve-login-form-item tcb-remember-me-item tcb-no-delete tcb-no-clone tcb-no-save">
						<div class="thrv-form-input-wrapper tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save" data-type="checkbox">
							<input type="checkbox" name="remember_me">
							<label class="tcb-editable-label tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save tcb-remberme-label">
								<?php echo __( 'Remember me', 'thrive-cb' ); ?>
							</label>
						</div>
					</div>
				</div>

				<div class="tve-form-submit tcb-no-save">
					<button class="tve_btn_txt" type="submit"><?php echo __( 'Log In', 'thrive-cb' ); ?></button>
				</div>

				<div class="thrv_wrapper thrv_text_element tcb-lost-password-link tcb-no-clone tcb-no-delete tve_no_drag tcb-no-title tcb-no-save">
					<p>
						<a href="javascript:void(0);" class="tcb-switch-state" data-switch_state="forgot_password">
							<?php esc_attr_e( 'I have forgotten my password.', 'thrive-cb' ); ?>
						</a>
					</p>
				</div>
			</form>
		</div>
	</div>

	<div class="tcb-login-form-wrapper tve_empty_dropzone tcb-permanently-hidden tve_no_drag" data-state="forgot_password">
		<div class="thrv_wrapper thrv_text_element" data-tag="h2">
			<h2>Password Reset</h2>
		</div>
		<div class="thrv_wrapper thrv_text_element">
			<p><?php echo __( 'Please enter your email address. You will receive a link to create a new password via email', 'thrive-cb' ); ?></p>
		</div>
		<div class="thrv_wrapper tcb-login-form tcb-no-clone tcb-no-delete tcb-no-save tve_no_drag">
			<form action="" method="post" class="tve-form" novalidate>
				<div class="tve-cf-item-wrapper">
					<div class="tve-login-form-item tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save">
						<div class="thrv-form-input-wrapper" data-type="text">
							<label class="tcb-label tcb-editable-label tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save"><?php echo __( 'Username or Email Address', 'thrive-cb' ); ?></label>

							<div class="tve-form-input tcb-no-clone tcb-no-delete tve_no_drag tcb-no-save">
								<input placeholder="<?php esc_attr_e( 'Username or Email Address', 'thrive-cb' ); ?>" data-placeholder="<?php esc_attr_e( 'Username or Email Address', 'thrive-cb' ); ?>" type="text" name="login">
							</div>
						</div>
					</div>
				</div>
				<div class="tve-form-submit tcb-no-save">
					<button class="tve_btn_txt" type="submit"><?php echo __( 'Get New Password', 'thrive-cb' ); ?></button>
				</div>
			</form>
		</div>
		<div class="thrv_wrapper thrv-divider" data-style="tve_sep-1" data-thickness="1" data-color="rgb(213,217,223)">
			<hr class="tve_sep tve_sep-1">
		</div>
		<div class="thrv_wrapper thrv-button tcb-no-delete tcb-no-clone tve_no_drag tcb-no-save tcb-go-back tcb-with-icon tcb-no-scroll" draggable="true">
			<a href="javascript:void(0);" class="tcb-button-link tcb-no-delete tcb-no-clone tcb-no-save tve_no_drag tcb-switch-state" data-switch_state="login" draggable="false">
				<span class="tcb-button-icon tcb-no-delete tcb-no-clone tve_no_drag tcb-no-save">
					<div class="thrv_wrapper thrv_icon tcb-no-delete tcb-no-clone tve_no_drag tcb-no-save tcb-no-scroll">
						<svg class="tcb-icon" viewBox="0 0 448 512" data-id="icon-long-arrow-left-light" data-name="">
							<path d="M136.97 380.485l7.071-7.07c4.686-4.686 4.686-12.284 0-16.971L60.113 273H436c6.627 0 12-5.373 12-12v-10c0-6.627-5.373-12-12-12H60.113l83.928-83.444c4.686-4.686 4.686-12.284 0-16.971l-7.071-7.07c-4.686-4.686-12.284-4.686-16.97 0l-116.485 116c-4.686 4.686-4.686 12.284 0 16.971l116.485 116c4.686 4.686 12.284 4.686 16.97-.001z"></path>
						</svg>
					</div>
				</span>
				<span class="tcb-button-texts tcb-no-delete tcb-no-clone tve_no_drag tcb-no-save">
					<span class="thrv-inline-text"><?php esc_attr_e( 'Back to Log in', 'thrive-cb' ); ?></span>
				</span>
			</a>
		</div>
	</div>

	<div class="tcb-login-form-wrapper tve_empty_dropzone tcb-permanently-hidden tve_no_drag" data-state="reset_confirmation">
		<div class="thrv_wrapper thrv_text_element" data-tag="h2">
			<h2><?php echo __( 'Password Reset', 'thrive-cb' ); ?></h2>
		</div>
		<div class="thrv_wrapper thrv_text_element">
			<p><?php echo __( 'The instructions to reset your password are sent to the email address you provided.', 'thrive-cb' ); ?></p>
			<p><?php echo __( 'If you did not receive the email, please check your spam folder as well.', 'thrive-cb' ); ?></p>
		</div>
		<div class="thrv_wrapper thrv-divider" data-style="tve_sep-1" data-thickness="1" data-color="rgb(213,217,223)">
			<hr class="tve_sep tve_sep-1">
		</div>
		<div class="thrv_wrapper thrv-button tcb-no-delete tcb-no-clone tve_no_drag tcb-no-save tcb-go-back tcb-with-icon tcb-no-scroll" draggable="true">
			<a href="javascript:void(0);" class="tcb-button-link tcb-no-delete tcb-no-clone tcb-no-save tve_no_drag tcb-switch-state" data-switch_state="login" draggable="false">
				<span class="tcb-button-icon tcb-no-delete tcb-no-clone tve_no_drag tcb-no-save">
					<div class="thrv_wrapper thrv_icon tcb-no-delete tcb-no-clone tve_no_drag tcb-no-save tcb-no-scroll">
						<svg class="tcb-icon" viewBox="0 0 448 512" data-id="icon-long-arrow-left-light" data-name="">
							<path d="M136.97 380.485l7.071-7.07c4.686-4.686 4.686-12.284 0-16.971L60.113 273H436c6.627 0 12-5.373 12-12v-10c0-6.627-5.373-12-12-12H60.113l83.928-83.444c4.686-4.686 4.686-12.284 0-16.971l-7.071-7.07c-4.686-4.686-12.284-4.686-16.97 0l-116.485 116c-4.686 4.686-4.686 12.284 0 16.971l116.485 116c4.686 4.686 12.284 4.686 16.97-.001z"></path>
						</svg>
					</div>
				</span>
				<span class="tcb-button-texts tcb-no-delete tcb-no-clone tve_no_drag tcb-no-save">
					<span class="thrv-inline-text"><?php esc_attr_e( 'Back to Log in', 'thrive-cb' ); ?></span>
				</span>
			</a>
		</div>
	</div>

	<div class="tcb-login-form-wrapper tve_empty_dropzone tcb-permanently-hidden tve_no_drag" data-state="logged_in">
		<div class="thrv_wrapper thrv_text_element" data-tag="h2">
			<h2><?php echo __( 'You are already logged in', 'thrive-cb' ); ?></h2>
		</div>

		<div class="thrv_wrapper thrv-button tcb-no-clone tve_no_drag tcb-no-save tcb-no-scroll">
			<a href="<?php echo $logout_url; ?>>" class="tcb-button-link tve-dynamic-link" data-dynamic-link="thrive_global_shortcode_url" data-shortcode-id="<?php echo $logout_id; ?>">
				<span class="tcb-button-texts tcb-no-clone tve_no_drag tcb-no-save">
					<span class="tcb-button-text thrv-inline-text tcb-no-clone tve_no_drag tcb-no-save"> <?php esc_attr_e( 'Log Out', 'thrive-cb' ); ?> </span>
				</span>
			</a>
		</div>
	</div>
	<input type="hidden" name="config" value="YTozOntzOjEzOiJzdWJtaXRfYWN0aW9uIjtzOjExOiJzaG93TWVzc2FnZSI7czoxMjoicmVkaXJlY3RfdXJsIjtzOjA6IiI7czoxNToic3VjY2Vzc19tZXNzYWdlIjtzOjc6IlN1Y2Nlc3MiO30=">
</div>
