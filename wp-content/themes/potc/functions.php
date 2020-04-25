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
	wp_enqueue_style( 'maitheme-google-fonts', '//fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,900|Roboto:300,400,700,900&display=swap', array(), CHILD_THEME_VERSION );
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
	return $classes;

}


//custom js
function custom_scripts() {
	wp_register_script('custom_script', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'),'1.', true);
	wp_enqueue_script('custom_script');
	wp_register_script('eo_script', get_stylesheet_directory_uri() . '/js/eo-submit.js', array('jquery'),'1.', true);
	wp_enqueue_script('eo_script');
	//sweet alert 2 
	wp_register_script('sweet-alert', 'https://cdn.jsdelivr.net/npm/sweetalert2@9', array('jquery'),'1.0', true);
	wp_enqueue_script('sweet-alert');
	// wp_register_script('sweet-alert-polyfill', 'https://cdn.jsdelivr.net/npm/promise-polyfill', array('jquery'),'1.0', true);
	wp_enqueue_script('sweet-alert-polyfill');
}
	  
	add_action( 'wp_enqueue_scripts', 'custom_scripts' );  

	// generic email octopus form shortcode
	function eo_shortcode(){
		
		return '<div class="email-octopus-form-wrapper"><form id="email-octopus-form" class="email-octopus-form" method="post">
		<div class="email-octopus-form-row">
		<input class="field_1" name="field_1" type="text" placeholder="Enter Your First Name" /></div>
		<div class="email-octopus-form-row">
		<input class="field_0" name="field_0" type="email" placeholder="Enter Your Email" />
		<input name="user[fax_number]" type=checkbox value="1" style="display: none;" 
		tabindex="-1" autocomplete="false"/>
		</div>
		<div class="email-octopus-form-row-subscribe">
		<button type="submit">Sign Me Up!</button>
		
		</div>
		</form></div>';
	}
	add_shortcode('eo-form', 'eo_shortcode');

	// orange email octopus form shortcode
	//use in three-fourths column
	function styled_eo_shortcode($atts){
		$a = shortcode_atts( array(
			'title' => 'Keep Progressing',
			'text'  =>  '<span class="white-space">Get the best out-of-the-box ideas for</span><span class="white-space"> pediatric therapy, business &amp; life.</span>',
			'subtext' => 'Give it a try.<span class="white-space"> Easily unsubscribe anytime.</span>',
			'classes' => 'bg-orange'
		), $atts );
		
		return '<div class="styled__eo-form '.$a['classes'].'"><h3>'. $a['title'].'</h3>
		<p class="margin-zero">'.$a['text'].'</p>
		<p class="margin-zero">'.$a['subtext'].'</p><div class="email-octopus-form-wrapper "><form id="email-octopus-form" class="email-octopus-form" method="post">
		<div class="email-octopus-form-row">
		<input class="field_1" name="field_1" type="text" placeholder="Enter Your First Name" /></div>
		<div class="email-octopus-form-row">
		<input class="field_0" name="field_0" type="email" placeholder="Enter Your Email" />
		<input name="user[fax_number]" type=checkbox value="1" style="display: none;" 
		tabindex="-1" autocomplete="false"/>
		</div>
		<div class="email-octopus-form-row-subscribe">
		<button type="submit">Sign Me Up!</button>
		</div>
		</form></div></div>';
	}
	add_shortcode('styled-eo-form', 'styled_eo_shortcode');

	