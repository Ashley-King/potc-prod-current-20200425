<?php

$focus_mode_width = get_option( 'lds_focus_content_width' );
if( $focus_mode_width && $focus_mode_width !== 'default' ): ?>
    .learndash-wrapper .ld-focus .ld-focus-main .ld-focus-content {
        max-width: <?php echo $focus_mode_width; ?>;
    }
<?php
endif;

$hide_elements = array(
    'welcome'   =>  array(
        'option'    =>  get_option('lds_focus_hide_welcome'),
        'selector'  =>  '.ld-user-welcome-text',
    ),
    'avatar'    =>  array(
        'option'    => get_option('lds_focus_hide_avatar'),
        'selector'  => '.ld-profile-avatar'
    ),
    'progress'  =>  array(
        'option'     =>  get_option('lds_focus_hide_top_progress_bar'),
        'selector'  =>  '.ld-focus-header .ld-progress-bar'
    ),
    'course_home'   =>  array(
        'option' =>  get_option('lds_focus_hide_course_home'),
        'selector'  =>  '.ld-course-navigation-heading .ld-icon-content'
    ),
    'content_footer_nav'  =>    array(
        'option' =>  get_option('lds_focus_hide_content_footer'),
        'selector' => '.ld-focus-content .ld-content-actions'
    )
);

foreach( $hide_elements as $element ) {

    if( isset($element['option']) && $element['option'] == 1 ) { ?>

        <?php echo $element['selector']; ?> {
            display: none;
        }

    <?php
    }
}
