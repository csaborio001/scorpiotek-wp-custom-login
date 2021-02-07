<?php
/**
 * Loads the CSS and Javascript needed for the website, also hooks up the communication between
 * the PHP files and the Javascript files.
 *
 * @package scorpiotek-wp-custom-login
 */

namespace ScorpioTek\WPCustomLogin;

/**
 * Class responsible for loading the assets the plugin needs.
 */
class AssetLoader {
	/**
	 * Loads the assets the login plugin needs only if this is a login page.
	 */
	public function __construct() {
		if ( ! $this->is_login_page() ) {
			return;
		}
		$this->hook_plugin_assets();
	}

	/**
	 * Attaches the hook to the login action that will be in charge
	 * of loading the assets used by the login page.
	 *
	 * @return void
	 */
	public function hook_plugin_assets() {
		add_action( 'login_enqueue_scripts', array( $this, 'load_frontend_assets' ) );
		add_filter( 'login_header_text', array( $this, 'my_login_logo_url_title' ) );
		add_filter( 'login_headerurl', array( $this, 'my_login_logo_url' ) );
	}

	/**
	 * Called from the login_enqueue_scripts to load all plugin assets.
	 *
	 * @return void
	 */
	public function load_frontend_assets() {
		\wp_enqueue_script(
			'wp_custom_login_scripts',
			plugins_url('scorpiotek-wp-custom-login') . '/dist/scripts/login-mods.min.js',
			array( 'jquery' ),
			$this->get_plugin_version(),
			true
		);

		\wp_enqueue_style(
			'wp_custom_login_styles',
			plugins_url('scorpiotek-wp-custom-login') . '/dist/css/style.css',
			array(),
			$this->get_plugin_version(),
		);
	}
	/**
	 * Returns the plugin version if found, otherwise returns a random number as fallback.
	 *
	 * @return mixed - the plugin version if it can be found, a random number between 1 and 1000 otherwise.
	 */
	private function get_plugin_version() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}		
		$plugins = \get_plugins();
		if ( \is_array( $plugins ) && \array_key_exists( 'scorpiotek-wp-custom-login/scorpiotek-wp-custom-login.php', $plugins ) ) {
			if ( \array_key_exists( 'Version', $plugins['scorpiotek-wp-custom-login/scorpiotek-wp-custom-login.php'] ) ) {
				return $plugins['scorpiotek-wp-custom-login/scorpiotek-wp-custom-login.php']['Version'];
			} else {
				return wp_rand( 1, 1000 );
			}
		}
	}

	/**
	 * Figures out of the current page is a login page.
	 *
	 * @return boolean true if the current page is a login page, false otherwise.
	 */
	private function is_login_page() {
		return in_array(
			$GLOBALS['pagenow'],
			array(
				'wp-login.php',
				'wp-register.php',
			),
			true
		);
	}

	public function my_login_logo_url() {
		return home_url();
	}
	
	public function my_login_logo_url_title() {
		return 'Your Site Name and Info';
	}
}
