<?php
/**
 * Plugin Name: ScorpioTek WP Custom Login
 * Description: Contains the content types and infrastructure for running the Compeer Website.
 * Author: ScorpioTek
 *
 * @package compeer
 *
 * Version: 0.1.4
 *
 * Text Domain: scorpiotek
 **/

/** Loads the stylesheet which takes care of the logo, colors, etc. */

/** Exit if file is called directly. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require 'vendor/autoload.php';

use ScorpioTek\WPCustomLogin\AssetLoader;

/** Load all plugin assets. */

$asset_loader = new AssetLoader();


