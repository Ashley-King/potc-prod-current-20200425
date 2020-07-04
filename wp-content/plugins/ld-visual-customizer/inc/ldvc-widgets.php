<?php
add_action( 'widgets_init', 'lds_focus_mode_widget_areas' );
function lds_focus_mode_widget_areas() {
    register_sidebar( array(
        'name' => __( 'LearnDash Focus Mode: Right Sidebar', 'lds-skins' ),
        'id' => 'lds-focus-mode-right-sidebar',
        'description' => __( 'Widgets in this area will be shown to the right of the content in focus mode', 'lds-skins' ),
        'before_widget' => '<div class="lds-focus-content-widget">',
        'after_widget' => '</div>',
        'before_title' => '<div class="lds-focus-widget-title" role="heading" aria-level="3">',
        'after_title'  => '</div>'
    ) );
    register_sidebar( array(
        'name' => __( 'LearnDash Focus Mode: Below Menu', 'lds-skins' ),
        'id' => 'lds-focus-mode-menu-sidebar',
        'description' => __( 'Widgets in this area will be shown below the course menu on the left side', 'lds-skins' ),
        'before_widget' => '<div class="lds-focus-sidebar-widget">',
        'after_widget' => '</div>',
        'before_title' => '<span class="ld-focus-widget-heading" role="heading" aria-level="2">',
        'after_title'  => '</span>'
    ) );
}

add_action( 'learndash-focus-sidebar-after-nav-wrapper', 'lds_focus_mode_below_menu_widget_area' );
function lds_focus_mode_below_menu_widget_area() {

    if ( is_active_sidebar('lds-focus-mode-menu-sidebar') ) : ?>
        <div class="lds-focus-sidebar-widgets">
            <?php
            dynamic_sidebar('lds-focus-mode-menu-sidebar'); ?>
        </div>
    <?php endif;
}

add_action( 'learndash-focus-masthead-after', 'lds_focus_mode_sidebar_widget_area' );
function lds_focus_mode_sidebar_widget_area() {

    if ( is_active_sidebar('lds-focus-mode-right-sidebar') ) : ?>
        <div class="lds-focus-content-widgets">
            <?php
            dynamic_sidebar('lds-focus-mode-right-sidebar'); ?>
        </div>
    <?php endif;

}

add_filter( 'learndash_wrapper_class', 'lds_add_focus_widget_classes' );
function lds_add_focus_widget_classes( $classes ) {

    if( !is_active_sidebar('lds-focus-mode-right-sidebar') ) {
        return $classes;
    }

    return $classes .= ' lds-focus-mode-content-widgets';

}
