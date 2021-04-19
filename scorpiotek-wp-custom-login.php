<?php
/**
 * Plugin Name: ScorpioTek WP Custom Login
 * Description: Contains the content types and infrastructure for running the Compeer Website.
 * Author: ScorpioTek
 *
 * @package compeer
 *
 * Version: 0.1.5
 *
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
$logon_redirect = new LoginRedirect(  __DIR__ . '/data/redirects.json' );


