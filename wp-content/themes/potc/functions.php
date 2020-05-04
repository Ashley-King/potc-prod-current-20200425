<?php

// Child theme (Do not remove!).
define( 'CHILD_THEME_NAME', 'Mai Lifestyle Pro' );
define( 'CHILD_THEME_URL', 'https://maitheme.com/' );
define( 'CHILD_THEME_VERSION', '1.3.0' );
define( 'MAI_THEME_SP', true );

// Support the Mai Theme Engine (Do not remove!).
add_theme_support( 'mai-theme-engine' );

/**
 * Mai Theme dependencies (Do not remove!).
 * This auto-installs Mai Theme Engine plugin,
 * which is required for the theme to function properly.
 *
 * composer require afragen/wp-dependency-installer
 */
include_once( __DIR__ . '/vendor/autoload.php' );
add_filter( 'pand_theme_loader', '__return_true' );
WP_Dependency_Installer::instance()->run( __DIR__ );

// Don't do anything else if the Mai Theme Engine plugin is not active.
if ( ! class_exists( 'Mai_Theme_Engine' ) ) {
	return;
}

// Include all php files in the /includes/ directory.
foreach ( glob( dirname( __FILE__ ) . '/includes/*.php' ) as $file ) { include $file; }


/**********************************
 * Add your customizations below! *
 **********************************/
//increase upload size
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

// Enqueue CSS files.
add_action( 'wp_enqueue_scripts', 'maitheme_enqueue_fonts' );
function maitheme_enqueue_fonts() {
	wp_enqueue_style( 'maitheme-google-fonts', '//fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,900|Roboto:100,300,400,500,700,900&display=swap', array(), CHILD_THEME_VERSION );
}

// Customize the site footer text.
add_filter( 'genesis_footer_creds_text', 'maitheme_site_footer_text' );
function maitheme_site_footer_text( $text ) {
	$url  = 'https://maitheme.com/';
	$name = 'Mai Theme';
	return sprintf( 'Copyright &copy; %s <a href="%s" title="%s">%s</a> &middot; All Rights Reserved &middot; Powered by <a rel="nofollow noopener" href="%s">%s</a>',
		date('Y'),
		get_bloginfo('url'),
		get_bloginfo('name'),
		get_bloginfo('name'),
		$url,
		$name
	);
}

//add body classes
add_filter( 'body_class', 'potc_body_class' );
function potc_body_class( $classes ) {
	
	if(is_page('about')){
		$classes[] = 'sub_page about_page';
	
	}	
	if(is_page('tbl')){
		$classes[] = 'sub_page tbl_page';
		
	}	
	if(is_page('contact')){
		$classes[] = 'sub_page contact_page';
	
	}	
	if(is_page('disclosure')){
		$classes[] = 'sub_page disclosure_page';
		
	}
	if(is_page('privacy-policy')){
		$classes[] = 'sub_page privacy_page';
		
	}	
	if ( is_page( 'thank-you' ) ){
		$classes[] = 'thank-you_page sub_page';	
	}
	if ( is_page( 'ashley-king' ) ){
		$classes[] = 'ashley_page sub_page';	
	}
	return $classes;

}


//custom js
function custom_scripts() {
	wp_register_script('custom_script', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'),'1.', true);
	wp_enqueue_script('custom_script');
	

}
	  
	add_action( 'wp_enqueue_scripts', 'custom_scripts' );  

//add home hero shortcode
function home_hero( $attr ) {  
    return get_template_part('template-parts/home-hero');
}
add_shortcode( 'insert-home-hero', 'home_hero' );

//add home quote shortcode
function home_quote( $attr ) {  
    return get_template_part('template-parts/home-quote');
}
add_shortcode( 'insert-home-quote', 'home_quote' );	

//add checklist optin shortcode
function checklist_optin( $attr ) { 
	 
	ob_start();
    get_template_part('template-parts/checklist-optin');
    return ob_get_clean(); 
}
add_shortcode( 'checklist-optin', 'checklist_optin' );

//add no-image optin shortcode
function no_image_optin( $attr ) { 
	 
	ob_start();
    get_template_part('template-parts/no-image-optin');
    return ob_get_clean(); 
}
add_shortcode( 'no-image-optin', 'no_image_optin' );


//add options page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Site Options',
		'menu_title'	=> 'Site Options',
		'menu_slug' 	=> 'site-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

// Run after Mai Theme.
add_action( 'genesis_before', function() {

	// Move featured image before the content.
remove_action( 'genesis_before_entry', 'mai_do_entry_featured_image');
add_action( 'genesis_before_entry_content', 'mai_do_entry_featured_image' );

//put shorcode in footer
function add_checklist(){
	echo do_shortcode('[checklist-optin]');
}
if(!is_front_page() && !is_page('thank-you')){
	add_action('genesis_before_footer', 'add_checklist');
}
	
});
