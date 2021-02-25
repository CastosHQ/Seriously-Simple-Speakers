<?php

namespace SSSpeakers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * SSP Dependency Checker
 *
 * Checks if Seriously Simple Podcasting is enabled and validates against a minimum required version if specified
 */
class SSP_Dependencies {

	/**
	 * @var array
	 * @access  private
	 * @since    1.0.2
	 */
	private $active_plugins;

	/**
	 * The single instance of SSP_Speakers.
	 * @var $this
	 * @access  private
	 * @since    1.0.2
	 */
	private static $_instance = null;

	/**
	 * @access  protected
	 * @since    1.0.2
	 */
	protected function __construct(){
	}

	/**
	 * Main SSP_Speakers Instance
	 *
	 * Ensures only one instance is loaded or can be loaded.
	 *
	 * @return $this SSP_Speakers instance
	 * @since 1.0.3
	 * @static
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Ensures that Seriously Simple Podcasting plugin is enabled
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function ssp_active_check( $minimum_version = '' ) {
		return true;

		$active_plugins = $this->get_active_plugins();

		if( in_array( 'seriously-simple-podcasting/seriously-simple-podcasting.php', $active_plugins ) || array_key_exists( 'seriously-simple-podcasting/seriously-simple-podcasting.php', $active_plugins ) ) {
			if( $minimum_version ) {
				$ssp_version = get_option( 'ssp_version', '1.0' );
				if( version_compare( $ssp_version, $minimum_version, '>=' ) ) {
					return true;
				}
			} else {
				return true;
			}
		}

		return false;
	}

	/**
	 * @return array
	 * @since 1.0.3
	 */
	protected function get_active_plugins() {
		if ( empty( $this->active_plugins ) ) {
			$this->active_plugins = (array) get_option( 'active_plugins', array() );

			if ( is_multisite() ) {
				$this->active_plugins = array_merge( $this->active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
			}
		}

		return $this->active_plugins;
	}
}
