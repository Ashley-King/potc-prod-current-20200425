<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

class TCB_Login_Element extends TCB_Cloud_Template_Element_Abstract {

	/**
	 * Name of the element
	 *
	 * @return string
	 */
	public function name() {
		return __( 'Login Form', 'thrive-cb' );
	}

	/**
	 * Return icon class needed for display in menu
	 *
	 * @return string
	 */
	public function icon() {
		return 'login_elem';
	}

	/**
	 * Get element alternate
	 *
	 * @return string
	 */
	public function alternate() {
		return 'login';
	}

	/**
	 * Element identifier
	 *
	 * @return string
	 */
	public function identifier() {
		return '.thrv-login-element';
	}

	/**
	 * Whether or not this element is a placeholder
	 *
	 * @return bool
	 */
	public function is_placeholder() {
		return false;
	}

	/**
	 * Element category that will be displayed in the sidebar
	 *
	 * @return string
	 */
	public function category() {
		return $this->get_thrive_integrations_label();
	}

	/**
	 * Element HTML
	 *
	 * @return string
	 */
	public function html() {
		return tcb_template( 'elements/login.php', array(), true );
	}


	/**
	 * Temporary hide login element.
	 *
	 * @return bool
	 */
	public function hide() {
		return true;
	}

	/**
	 * Component and control config
	 *
	 * @return array
	 */
	public function own_components() {
		$login = array(
			'login'      => array(
				'config' => array(
					'AddRemoveLabels' => array(
						'config'     => array(
							'name'    => '',
							'label'   => __( 'Labels', 'thrive-cb' ),
							'default' => true,
						),
						'css_suffix' => ' .tcb-label',
						'css_prefix' => '',
						'extends'    => 'Switch',
					),
					'RememberMe'      => array(
						'config'     => array(
							'name'    => '',
							'label'   => __( 'Remember Me', 'thrive-cb' ),
							'default' => true,
						),
						'css_suffix' => ' .tcb-remember-me-item',
						'css_prefix' => '',
						'extends'    => 'Switch',
					),
					'PassResetUrl'    => array(
						'config'     => array(
							'name'    => '',
							'label'   => __( 'Password Reset Link', 'thrive-cb' ),
							'default' => true,
						),
						'css_suffix' => ' .tcb-lost-password-link',
						'css_prefix' => '',
						'extends'    => 'Switch',
					),
				),
			),
			'typography' => array(
				'hidden' => true,
			),
			'animation'  => array(
				'hidden' => true,
			),
		);

		return array_merge( $login, $this->group_component() );
	}

	/**
	 * Group Edit Properties
	 *
	 * @return array|bool
	 */
	public function has_group_editing() {

		return array(
			'exit_label'    => __( 'Exit Group Styling', 'thrive-cb' ),
			'select_values' => array(
				array(
					'value'    => 'all_form_items',
					'selector' => '.tve-login-form-item',
					'name'     => __( 'Grouped Form Items', 'thrive-cb' ),
					'singular' => __( '-- Form Item %s', 'thrive-cb' ),
				),
				array(
					'value'    => 'all_inputs',
					'selector' => '.tve-form-input',
					'name'     => __( 'Grouped Inputs', 'thrive-cb' ),
					'singular' => __( '-- Input %s', 'thrive-cb' ),
				),
				array(
					'value'    => 'all_labels',
					'selector' => '.tve-login-form-item label',
					'name'     => __( 'Grouped Labels', 'thrive-cb' ),
					'singular' => __( '-- Label %s', 'thrive-cb' ),
				),
				array(
					'value'    => 'all_submit_buttons',
					'selector' => '.tve-form-submit',
					'name'     => __( 'Submit Buttons', 'thrive-cb' ),
					'singular' => __( '-- Label %s', 'thrive-cb' ),
				),
				array(
					'value'    => 'all_back_buttons',
					'selector' => '.tcb-go-back',
					'name'     => __( 'Go Back Buttons', 'thrive-cb' ),
					'singular' => __( '-- Label %s', 'thrive-cb' ),
				),
				array(
					'value'    => 'all_back_icons',
					'selector' => '.tcb-go-back .thrv_icon',
					'name'     => __( 'Go Back Icon', 'thrive-cb' ),
					'singular' => __( '-- Label %s', 'thrive-cb' ),
				),
				array(
					'value'    => 'all_back_primary_text',
					'selector' => '.tcb-go-back .thrv-inline-text',
					'name'     => __( 'Go Back Text', 'thrive-cb' ),
					'singular' => __( '-- Label %s', 'thrive-cb' ),
				),
			),
		);
	}
}
