<?php
/**
 * Custom shortcodes for more advanced output
 */


add_shortcode( 'lds_login', 'lds_login_shortcode' );
function lds_login_shortcode( $args ) {

	ob_start();

	echo '<div class="' . learndash_get_wrapper_class() . ' ldvc-login">' . learndash_get_template_part( 'modules/login-modal.php', array(), false ) . '</div>';

	return ob_get_clean();

}

add_shortcode( 'lds_course_list', 'lds_course_list_shortcode' );
function lds_course_list_shortcode( $atts ) {

	if( !isset($atts['style']) ) {
		$style = 'default';
	}

	$atts  = ( isset($atts) && !empty($atts) ? $atts : array() );
	$style = ( isset($atts['style']) && !empty($atts['style']) ? $atts['style'] : 'default' );

	$styles = apply_filters( 'lds_available_styles', array(
		'default',
		'expanded',
		'grid-banners'
	) );

	$legacy = array(
		'icon',
		'banner'
	);

	if( in_array( $style, $legacy ) ) {
		$style = 'grid-banners';
	}

	$cuser 	 = wp_get_current_user();
	$user_id = $cuser->ID;

	if( !in_array($style, $styles) ) {
		$style = 'default';
	}

	$atts['array'] = 'true';
	$atts['num'] = '-1';

	$courses = ld_course_list( $atts );

	$class = learndash_get_wrapper_class() . ' lds-course-list-' . $style . ' lds-course-list';

	if( isset($atts['cols']) ) {
		$class .= ' lds-course-list-cols-' . $atts['cols'];
	}

	ob_start(); ?>

		<div class="<?php echo esc_attr($class); ?>">
			<div class="ld-item-list ld-course-list">
				<?php
				foreach( $courses as $course ):
					include( lds_get_template_part( 'shortcodes/course-list/row.php' ) );
				endforeach; ?>
			</div>
		</div>

	<?php
	return ob_get_clean();

}
