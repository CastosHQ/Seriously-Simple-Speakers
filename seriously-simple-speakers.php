<?php
/*
 * Plugin Name: Seriously Simple Speakers
 * Version: 1.1.0
 * Plugin URI: https://wordpress.org/plugins/seriously-simple-speakers
 * Description: Add speakers to your Seriously Simple Podcasting episodes.
 * Author: Castos
 * Author URI: https://www.castos.com/
 * Requires at least: 4.4
 * Tested up to: 5.5
 *
 * Text Domain: seriously-simple-speakers
 * Domain Path: /languages
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SSP_SPKRS_VERSION', '1.1.0' );

require_once( 'php/ssp-functions.php' );

if ( is_ssp_active( '1.14' ) ) {
	ssp_speakers( __FILE__, SSP_SPKRS_VERSION );
}
