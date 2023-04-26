<?php
/*
 * Plugin Name: Seriously Simple Speakers
 * Version: 1.0.2
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

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'is_ssp_active' ) ) {
	require_once( 'ssp-includes/ssp-functions.php' );
}

if( is_ssp_active( '1.14' ) ) {

	// Load plugin class files
	require_once( 'includes/class-ssp-speakers.php' );

	SSP_Speakers();
}
