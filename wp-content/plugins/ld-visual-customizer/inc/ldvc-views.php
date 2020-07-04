<?php
add_action( 'learndash-quiz-row-title-after', 'ldvc_content_attributes' );
add_action( 'learndash-topic-row-title-after', 'ldvc_content_attributes' );
add_action( 'learndash-lesson-components-before', 'ldvc_content_attributes' );
function ldvc_content_attributes( $post_id = null ) {

    if( $post_id == null ) {
        $post_id = get_the_ID();
    }

    $meta = array(
        'content_type'  =>  get_post_meta( $post_id, '_lds_content_type', true ),
        'duration'      =>  get_post_meta( $post_id, '_lds_duration', true ),
        'icon'          =>  ldvc_get_content_icon( $post_id )
    );

    if( !empty( $meta['content_type'] ) || !empty( $meta['duration'] ) || !empty( $meta['icon'] ) ): ?>
        <span class="lds-enhanced-meta">
            <?php
            if( $meta['icon'] && !empty($meta['icon']) ) echo '<span class="lds-meta-item lds-content-icon"><span class="fa ' . esc_attr( $meta['icon'] ) . '"></span></span>';
            if( !empty( trim($meta['duration']) ) ) echo '<span class="lds-meta-item"><span class="fa fa-clock-o"></span> ' . esc_attr( $meta['duration'] ) . '</span>'; ?>
        </span>
    <?php
    endif;

}

add_action( 'lds_course_list_item_name_before', 'lds_course_list_thumbnail', 10, 2 );
function lds_course_list_thumbnail( $lesson_id = null , $style ) {

    $lesson_id = ( $lesson_id == null ? get_the_ID() : $lesson_id );

    if( $style == 'grid-banners' ) {
        include( lds_get_template_part( 'grid-banner/lesson/partials/thumbnail.php' ) );
    }

}

add_filter( 'learndash-lesson-row-attributes', 'ldvc_enable_lesson_items' );
function ldvc_enable_lesson_items( $status ) {

    return true;

}

add_action( 'learndash-quiz-row-title-after', 'ldvc_content_description' );
add_action( 'learndash-topic-row-title-after', 'ldvc_content_description' );
add_action( 'learndash-lesson-preview-after', 'ldvc_content_description' );
function ldvc_content_description( $post_id = null ) {

    if( $post_id == null ) {
        $post_id = get_the_ID();
    }

    $description = get_post_meta( $post_id, '_lds_short_description', true );

    if( $description && !empty( $description ) ): ?>
        <div class="lds-enhanced-short-description">
            <?php echo wp_kses_post($description); ?>
        </div>
    <?php endif;

}

add_filter( 'learndash_30_get_template_part', 'lds_custom_template_routes', 900, 4 );
function lds_custom_template_routes( $filepath, $slug, $args, $echo ) {

    $lds_template = get_option('lds_listing_style');

    $routes = apply_filters(' lds_custom_template_route_matches', array(
        'grid-banner' => array(
            'lesson/partials/row'    =>  'lesson/partials/row'
        )
    ), $filepath, $slug, $args, $echo );

    if( !$lds_template || !isset($routes[$lds_template]) || !isset($routes[$lds_template][$slug]) ) {
        return $filepath;
    }

    $new_filepath = apply_filters( 'lds_custom_templates_matched_filepath', LDS_PATH . 'inc/templates/' . $lds_template . '/' . $routes[$lds_template][$slug] . '.php', $filepath, $slug, $args );

    if( file_exists($new_filepath) ) {
        return $new_filepath;
    }

    return $filepath;

}

add_action( 'init', 'lds_template_helpers' );
function lds_template_helpers() {

    $lds_template = get_option('lds_listing_style');

    if( !$lds_template || empty($lds_template) || !file_exists( LDS_PATH . 'inc/templates/' . $lds_template . '/helpers.php' ) ) {
        return;
    }

    include( LDS_PATH . 'inc/templates/' . $lds_template . '/helpers.php' );

}

function lds_get_template_part( $filepath ) {

    return apply_filters( 'lds_get_template_part', LDS_PATH . 'inc/templates/' . $filepath, $filepath );

}


add_filter( 'ld_focus_mode_welcome_name', 'lds_focus_welcome_message' );
function lds_focus_welcome_message( $name ) {

     $style = get_option( 'lds_welcome_message_name', 'default' );

     if( !$style || empty($style) || $style == 'default' ) {
          return $name;
     }

     $cuser = wp_get_current_user();

     switch( $style ) {
          case('first'):
               $name = get_user_meta( $cuser->ID, 'first_name', true );
               break;
          case('full'):
               $name = get_user_meta( $cuser->ID, 'first_name', true ) . ' ' . get_user_meta( $cuser->ID, 'last_name', true );
               break;
          case('username'):
               $name = $cuser->user_login;
               break;
          case('none'):
               $name = '';
               break;
     }

     if( empty($name) && $style != 'none' ) {
          $name = 'snames';
     }

     return $name;

}

add_action( 'learndash-course-infobar-action-cell-after', 'lds_course_meta_icons' );
add_action( 'learndash-course-infobar-access-progress-after', 'lds_course_meta_icons' );
function lds_course_meta_icons( $post_type ) {


     if( $post_type != 'sfwd-courses' ) {
          return;
     }

     $post_id  = get_the_ID();
     $duration = get_post_meta( $post_id, '_lds_duration', true );
     $icon     = ldvc_get_content_icon( $post_id );

     if( $duration || $icon ): ?>
          <span class="lds-enhanced-meta">
               <?php
               if( $duration && !empty($duration) ): ?>
                   <span class="lds-course-duration">
                       <?php echo '<span class="lds-meta-item"><span class="fa fa-clock-o"></span> ' . esc_attr( $duration ) . '</span>'; ?>
                   </span>
               <?php
               endif;

               if( $icon && !empty($icon) ):
                    echo '<span class="lds-meta-item lds-content-icon"><span class="fa ' . esc_attr( $icon ) . '"></span></span>';
               endif; ?>
          </span>
     <?php endif;
}
