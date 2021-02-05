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
		if ( $this->is_login_page() ) {
			$this->redirect_info_array = $this->load_settings_file( $settings_file );
			$this->setup_redirection_hook();
		}
	}

	public function setup_redirection_hook() {
		\add_filter( 'login_redirect', array( $this, 'redirect_on_login' ), 10, 3 );
	}
	/**
	 * Called by the login_redirect hook, redirects users on login baseed on what is
	 * specified in the /data/redirects.json file.
	 *
	 * @param string  $url the url to redirect the user.
	 * @param string  $request the url where the original request was made.
	 * @param WP_User $user the WP_User who is logging in.
	 * @return string the URL where the user will be redireted to.
	 */
	public function redirect_on_login( $url, $request, $user ) {
		if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
			/** The roles that have been specified in the config file. */
			$redirected_roles = array_keys( $this->redirect_info_array );
			/** The roles of the current user as an array. */
			$user_roles = $user->roles;
			/** This will return the roles that have been specified in the config file
			 * that the user belongs to.
			 */
			$identified_roles = array_intersect( $redirected_roles, $user_roles );
			/** The role the user belongs to has not been specified in file. */
			if ( empty( $identified_roles ) ) {
				$url = home_url();
			}
			/** Iterate thru the role list and return the first match. */
			foreach( $identified_roles as $role) {
				$url = $this->redirect_info_array[$role];
				break;
			}
		}
		return $url;
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
}
