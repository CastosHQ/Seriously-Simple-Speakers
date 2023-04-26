<?php

/**
 * Functions used by Seriously Simple Speakers plugin.
 */

use SSSpeakers\SSP_Speakers;
use SSSpeakers\SSP_Dependencies;

/**
 * SSP Detection
 */
if ( ! function_exists( 'is_ssp_active' ) ) {
	function is_ssp_active( $minimum_version = '' ) {
		require_once __DIR__ . '/class-ssp-dependencies.php';

		return SSP_Dependencies::ssp_active_check( $minimum_version );
	}
}

/**
 * Creates and returns SSP_Speakers instance.
 * */
if ( ! function_exists( 'ssp_speakers' ) ) {
	/**
	 * Returns the main instance of SSP_Speakers to prevent the need to use globals.
	 *
	 * @param string $file
	 * @param string $version
	 *
	 * @return SSP_Speakers SSP_Speakers
	 * @since  1.0.0
	 */
	function ssp_speakers( $file, $version ) {
		require_once __DIR__ . '/class-ssp-speakers.php';

		return SSP_Speakers::instance( $file, $version );
	}
}
