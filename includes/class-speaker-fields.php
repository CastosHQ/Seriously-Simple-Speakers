<?php

namespace SSSpeakers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 1.0.3
 * */
class Speaker_Fields {

	/**
	 * The single instance of SSP_Speakers.
	 * @var $this
	 * @access  private
	 * @since   1.0.2
	 */
	private static $_instance = null;

	/**
	 * @access  protected
	 * @since   1.0.2
	 */
	protected function __construct() {
		return $this;
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
	 * @since 1.0.3
	 */
	public function init() {
		if ( ! is_admin() ) {
			return;
		}
		add_action( SSP_Speakers::TAXONOMY . '_edit_form_fields', array( $this, 'add_term_fields' ) );
		add_action( 'created_' . SSP_Speakers::TAXONOMY, array( $this, 'save_term_fields' ) );
		add_action( 'edited_' . SSP_Speakers::TAXONOMY, array( $this, 'save_term_fields' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_wp_media_files' ) );
	}

	/**
	 * @since 1.0.3
	 */
	public function load_wp_media_files() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_media();
	}

	/**
	 * @since 1.0.3
	 */
	public function add_term_fields( $term ) {
		$email    = get_term_meta( $term->term_id, 'ssp_speaker_email', true );
		$headshot = get_term_meta( $term->term_id, 'ssp_speaker_headshot', true );

		echo Renderer::render( 'term-fields', compact( 'email', 'headshot' ) );
	}

	/**
	 * @since 1.0.3
	 */
	function save_term_fields( $term_id ) {
		update_term_meta(
			$term_id,
			'ssp_speaker_email',
			sanitize_text_field( filter_input( INPUT_POST, 'ssp_speaker_email', FILTER_VALIDATE_EMAIL ) )
		);

		update_term_meta(
			$term_id,
			'ssp_speaker_headshot',
			sanitize_text_field( filter_input( INPUT_POST, 'ssp_speaker_headshot', FILTER_VALIDATE_URL ) )
		);
	}
}
