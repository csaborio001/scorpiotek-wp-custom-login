<?php
/**
 * Specifies the styles and scripts that will be loaded by the plugin.
 *
 * @package scorpiotek-wp-custom-login
 */
function custom_login_stylesheet() {
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
add_action( 'login_enqueue_scripts', 'custom_login_stylesheet' );
