<?php
$wp_customize->add_section( 'lds_visual_customizer_focus_mode', array(
    'title'     => __( 'Focus Mode', 'lds_skins' ),
    'priority'  => 35,
    'panel'     => 'lds_visual_customizer'
) );

$focus_settings = apply_filters( 'lds_visual_customizer_focus_settings', array(
    'lds_focus_content_width' => array(
        'default'             => '',
        'type'                => 'option',
        'transport'           => 'refresh',
        'capability'          => 'edit_theme_options',
    ),
    'lds_welcome_message_name' => array(
        'default'             => '',
        'type'                => 'option',
        'transport'           => 'refresh',
        'capability'          => 'edit_theme_options',
    ),
    'lds_focus_hide_welcome'  => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_focus_hide_avatar'  => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_focus_hide_top_progress_bar'  => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_focus_hide_course_home'  => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_focus_hide_content_footer'  => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
) );

$focus_setting_fields = apply_filters( 'ldvc_focus_mode_ranges', array(
    'lds_focus_content_width' => array(
        'label'      => __( 'Focus mode content max-width', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_focus_mode',
        'settings'   => 'lds_focus_content_width',
        'type'       => 'select',
        'choices'   =>  array(
            'default'   =>	__( 'Default (960px)', 'lds_skins' ),
            '768px'	    =>	__( 'Narrow (768px)', 'lds_skins' ),
            '1180px'    =>  __( 'Medium (1180px)', 'lds_skins' ),
            '1600px'	=>	__( 'Wide (1600px)', 'lds_skins' ),
            'inherit'	=>	__( 'Full Width', 'lds_skins' ),
        ),
    ),
    'lds_welcome_message_name' => array(
       'label'      => __( 'Welcome message name', 'lds_skins' ),
       'section'    => 'lds_visual_customizer_focus_mode',
       'settings'   => 'lds_welcome_message_name',
       'type'       => 'select',
       'choices'   =>  array(
            'default'   =>	__( 'Default (display name)', 'lds_skins' ),
            'first'	    =>	__( 'First name', 'lds_skins' ),
            'full'      =>    __( 'Full name', 'lds_skins' ),
            'username'  =>	__( 'Username', 'lds_skins' ),
            'none'      =>	__( 'No name', 'lds_skins' ),
       ),
    ),
    'lds_focus_hide_welcome' => array(
        'label'      => __( 'Hide user welcome message', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_focus_mode',
        'settings'   => 'lds_focus_hide_welcome',
        'type'       => 'checkbox',
    ),
    'lds_focus_hide_avatar' => array(
        'label'      => __( 'Hide user avatar and secondary menu', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_focus_mode',
        'settings'   => 'lds_focus_hide_avatar',
        'type'       => 'checkbox',
    ),
    'lds_focus_hide_top_progress_bar' => array(
        'label'      => __( 'Hide progress bar in header', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_focus_mode',
        'settings'   => 'lds_focus_hide_top_progress_bar',
        'type'       => 'checkbox',
    ),
    'lds_focus_hide_course_home' => array(
        'label'      => __( 'Hide course home icon', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_focus_mode',
        'settings'   => 'lds_focus_hide_course_home',
        'type'       => 'checkbox',
    ),
    'lds_focus_hide_content_footer' => array(
        'label'      => __( 'Hide footer previous / next links', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_focus_mode',
        'settings'   => 'lds_focus_hide_content_footer',
        'type'       => 'checkbox',
    ),
) );

foreach( $focus_settings as $slug => $options ) {
    $wp_customize->add_setting( $slug, $options );
}


foreach( $focus_setting_fields as $slug => $options ) {

    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        $slug,
        $options
    ) );

}
