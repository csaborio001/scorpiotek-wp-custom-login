<?php
/**
 * Reads the configuration file from data/redirects.json to specify where
 * a role must be redirected upon login.
 *
 * @package scorpiotek-wp-custom-login
 */

namespace ScorpioTek\WPCustomLogin;

/**
 * Class responsible for loading the assets the plugin needs.
 */
class LoginRedirect {

	private $redirect_info_array;

	public function __construct( $settings_file ) {
		$this->redirect_info_array = $this->load_settings_file( $settings_file );
		$this->setup_redirection_hook();
	}

	public function setup_redirection_hook() {
		add_filter( 'login_redirect', array( $this, 'redirect_on_login', 10, 3 ) );
	}
	
	public function redirect_on_login( $redirect_to, $requested_redirect_to, $user ) {
			/** Get the user roles. */

			/** Do any of the roles match those in the configuration file? */

			/** If so, redirect to the first match in the array. */

			/** Otherwise just reedirect them to the home page. */
	}

	private function load_settings_file( $settings_file ) {
		if( is_null( $settings_file ) ) {
			return -1;
		}
		/** Try and load the local data file if there is no JSON info when creating. */
		$json_data = file_get_contents( $settings_file );
		if ( false === $json_data ) {
			if ( WP_DEBUG ) {
				error_log ( __( 'ERROR In ScopriioTek Custom Login: Could not load the json file', 'scorpiotek' ) );
			}
			return -1;
		}
		$json_decoded_data = json_decode( $json_data, true );
		
		if ( $json_decoded_data === false || $json_decoded_data === null) {
			error_log ( __( 'ERROR ScopriioTek Custom Login: Could not load the contents of the json file, most likely incorrect json', 'scorpiotek' ) );
			return false;
		}
		return $json_decoded_data;
	}
}
