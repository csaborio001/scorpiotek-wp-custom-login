<?php
/**
 * Specifies the styles and scripts that will be loaded by the plugin.
 *
 * @package scorpiotek-wp-custom-login
 */
function custom_login_stylesheet() {

	if ( is_login_page() ) {
		wp_enqueue_style(
			'custom-login',
			plugins_url() . '/scorpiotek-wp-custom-login/assets/css/login-styles.css',
			array(),
			'0.1'
		);

		wp_enqueue_script(
			'custom-login-script',
			plugins_url() . '/scorpiotek-wp-custom-login/assets/js/login-mods.js',
			array( 'jquery' ),
			'0.1',
			false
		);
	}
}
add_action( 'login_enqueue_scripts', 'custom_login_stylesheet' );

function my_login_logo_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
	return 'Your Site Name and Info';
}
add_filter( 'login_header_text', 'my_login_logo_url_title' );


/**
 * is_login_page
 * 
 * https://stackoverflow.com/questions/5266945/wordpress-how-detect-if-current-page-is-the-login-page
 *
 * @return void
 */
function is_login_page() {
	return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}
