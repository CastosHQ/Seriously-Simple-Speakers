<?php

namespace SSSpeakers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings
 *
 * Adds Speakers Tab to the Settings
 * @since 1.0.3
 */
class Settings {

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
	protected function __construct() {
		return $this;
	}

	/**
	 * @access  protected
	 * @since    1.0.2
	 */
	public function init() {
		add_filter( 'ssp_settings_fields', array( $this, 'add_settings_tab' ) );
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

	public function add_settings_tab( $settings ) {
		$settings['speakers'] = array(
			'title'       => __( 'Speakers', 'seriously-simple-podcasting' ),
			'description' => __( 'Speakers settings.', 'seriously-simple-podcasting' ),
			'fields'      => array(
				array(
					'id'          => 'speakers_display',
					'label'       => __( 'Speaker display', 'seriously-simple-podcasting' ),
					'description' => __( ' Use this to set what Speaker information you would like to display below the player.', 'seriously-simple-podcasting' ),
					'type'        => 'radio',
					'options'     => array(
						'name'       => __( 'Show Speaker name only', 'seriously-simple-podcasting' ),
						'name_image' => __( 'Show Speaker name and image', 'seriously-simple-podcasting' ),
						'image'      => __( 'Show Speaker image only', 'seriously-simple-podcasting' ),
					),
					'default'     => 'above',
				),
			),
		);

		return $settings;
	}
}
