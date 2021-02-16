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

namespace SSSpeakers;

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'SSS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SSS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once __DIR__ . '/autoloader.php';

if( SSP_Dependencies::instance()->ssp_active_check( '1.14' ) ) {
	SSP_Speakers::instance( __FILE__, '1.0.2' )->init();
}
