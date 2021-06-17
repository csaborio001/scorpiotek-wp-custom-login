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

	private $redirect_settings;

	public function __construct( $redirect_settings ) {
		if ( $this->is_login_page() ) {
			$this->redirect_settings = $redirect_settings;
			$this->setup_redirection_hook();
		}
	}

	/**
	 * Sets up the callback function that will be called when anyone logs into the website.
	 */
	public function setup_redirection_hook(): void {
		\add_filter( 'login_redirect', array( $this, 'redirect_on_login' ), 10, 3 );
	}
	/**
	 * Called by the login_redirect hook, redirects users depending on the configuration
	 * that was passed to this class.
	 *
	 * @param string  $url the url to redirect the user.
	 * @param string  $request the url where the original request was made.
	 * @param \WP_User $user the WP_User who is logging in.
	 * @return string the URL where the user will be redireted to.
	 */
	public function redirect_on_login( $url, $request, $user ) {
		/** It is possible to be called when no one has hit the submit button on login form. */
		if ( ! $user instanceof \WP_User ) {
			return $url;
		}

		if ( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
			/** The roles of the current user as an array. */
			$current_user_roles = $user->roles;
			foreach ( $this->redirect_settings as $redirect_info ) {
				/** If there is a match, create the redirection URL. */
				if ( \in_array( $redirect_info['role'], $current_user_roles ) ) {
					if ( 'home' === $redirect_info['redirect_base'] ) {
						$url = \home_url( $redirect_info['redirect_url'] );
					} elseif ( 'admin' === $redirect_info['redirect_base'] ) {
						$url = \admin_url( $redirect_info['redirect_url'] );
					}
					return $url;
				}
			}
		}
		return $url;
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
