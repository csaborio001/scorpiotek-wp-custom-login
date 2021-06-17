<?php
/**
 * Plugin Name: ScorpioTek WP Custom Login
 * Description: Contains the content types and infrastructure for running the Compeer Website.
 * Author: ScorpioTek
 *
 * @package compeer
 *
 * Version: 0.1.6
 **/

/** Loads the stylesheet which takes care of the logo, colors, etc. */

/** Exit if file is called directly. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require 'vendor/autoload.php';

use ScorpioTek\WPCustomLogin\AssetLoader;
use ScorpioTek\WPCustomLogin\LoginRedirect;

/** Load all plugin assets. */

$asset_loader   = new AssetLoader();
$logon_redirect = new LoginRedirect(
	array(
		array(
			'role'          => 'administrator',
			'redirect_base' => 'admin',
			'redirect_url'  => '',
		),
		array(
			'role'          => 'esaanz_member',
			'redirect_base' => 'home',
			'redirect_url'  => 'account/?action=subscriptions',
		),
	)
);


