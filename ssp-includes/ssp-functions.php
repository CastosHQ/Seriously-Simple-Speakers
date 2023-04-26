<?php

/**
 * Functions used by plugins
 */

use SSSpeakers\SSP_Speakers;
use SSSpeakers\SSP_Dependencies;

if ( ! class_exists( 'SSSpeakers\SSP_Dependencies' ) ) {
	require_once 'class-ssp-dependencies.php';
}

/**
 * SSP Detection
 */
if ( ! function_exists( 'is_ssp_active' ) ) {
	function is_ssp_active( $minimum_version = '' ) {
		return SSP_Dependencies::ssp_active_check( $minimum_version );
	}
}

/**
 * Returns the main instance of SSP_Speakers to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object SSP_Speakers
 */
function SSP_Speakers () {
	$instance = SSP_Speakers::instance( __FILE__, '1.0.1' );
	return $instance;
}
