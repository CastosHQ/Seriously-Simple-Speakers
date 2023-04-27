<?php

namespace SSSpeakers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SSP_Speakers {

	/**
	 * The single instance of SSP_Speakers.
	 * @var    object
	 * @access  private
	 * @since    1.0.0
	 */
	private static $_instance = null;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_version;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_token;

	/**
	 * The main plugin file.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $file;

	/**
	 * The main plugin directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $dir;

	/**
	 * The taxonomy slug.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $tax;

	/**
	 * The singular name for taxonomy terms.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $single;

	/**
	 * The plural name for taxonomy terms.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plural;

	/**
	 * Constructor function.
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	public function __construct( $file = '', $version = '1.0.0' ) {
		$this->_version = $version;
		$this->_token   = 'ssp_speakers';

		// Load plugin environment variables
		$this->file = $file;
		$this->dir  = dirname( $this->file );

		// Register functinos to run on plugin activation
		register_activation_hook( $this->file, array( $this, 'install' ) );

		// Register taxonomy ( use 12 to make sure it is fired after podcast CPT is registered on 11 )
		add_action( 'init', array( $this, 'register_taxonomy' ), 12 );

		// Add speakers to episode meta
		add_filter( 'ssp_episode_meta_details', array( $this, 'display_speakers' ), 10, 3 );

		// Handle localisation
		add_action( 'plugins_loaded', array( $this, 'load_localization' ) );
	}

	public function display_speakers( $meta = array(), $episode_id = 0, $context = '' ) {

		if ( ! $episode_id ) {
			return $meta;
		}

		$speakers = wp_get_post_terms( $episode_id, 'speaker' );

		// Saving speaker count in a variable as is it used a few times
		$count = count( $speakers );

		if ( is_wp_error( $speakers ) || ( is_array( $speakers ) && 0 == $count ) ) {
			return $meta;
		}

		// Get label for speaker display
		if ( 1 == $count ) {
			$label = $this->single;
		} else {
			$label = $this->plural;
		}

		// Allow dynamic filtering of label
		$label = apply_filters( 'ssp_speakers_display_label', $label, $episode_id, $count );

		$speakers_html = '';

		// Generate HTML for speaker display
		foreach ( $speakers as $speaker ) {

			if ( ! $speakers_html ) {
				$speakers_html .= $label . ': ';
			} else {
				$speakers_html .= ', ';
			}

			$speakers_html .= '<a href="' . get_term_link( $speaker->term_id ) . '">' . $speaker->name . '</a>';

		}

		$speakers_html = apply_filters( 'ssp_speakers_display', $speakers_html, $episode_id );

		// Add speaker display to episode meta
		if ( $speakers_html ) {
			$meta['speakers'] = $speakers_html;
		}

		return $meta;
	}

	public function register_taxonomy() {

		$this->tax    = $this->get_tax_name();
		$this->single = apply_filters( 'ssp_speakers_single_label', __( 'Speaker', 'seriously-simple-speakers' ) );
		$this->plural = apply_filters( 'ssp_speakers_plural_label', __( 'Speakers', 'seriously-simple-speakers' ) );

		// Create taxonomy labels
		$labels = array(
			'name'                       => $this->plural,
			'singular_name'              => $this->single,
			'menu_name'                  => $this->plural,
			'all_items'                  => sprintf( __( 'All %s', 'seriously-simple-speakers' ), $this->plural ),
			'edit_item'                  => sprintf( __( 'Edit %s', 'seriously-simple-speakers' ), $this->single ),
			'view_item'                  => sprintf( __( 'View %s', 'seriously-simple-speakers' ), $this->single ),
			'update_item'                => sprintf( __( 'Update %s', 'seriously-simple-speakers' ), $this->single ),
			'add_new_item'               => sprintf( __( 'Add New %s', 'seriously-simple-speakers' ), $this->single ),
			'new_item_name'              => sprintf( __( 'New %s Name', 'seriously-simple-speakers' ), $this->single ),
			'parent_item'                => sprintf( __( 'Parent %s', 'seriously-simple-speakers' ), $this->single ),
			'parent_item_colon'          => sprintf( __( 'Parent %s:', 'seriously-simple-speakers' ), $this->single ),
			'search_items'               => sprintf( __( 'Search %s', 'seriously-simple-speakers' ), $this->plural ),
			'popular_items'              => sprintf( __( 'Popular %s', 'seriously-simple-speakers' ), $this->plural ),
			'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', 'seriously-simple-speakers' ), $this->plural ),
			'add_or_remove_items'        => sprintf( __( 'Add or remove %s', 'seriously-simple-speakers' ), $this->plural ),
			'choose_from_most_used'      => sprintf( __( 'Choose from the most used %s', 'seriously-simple-speakers' ), $this->plural ),
			'not_found'                  => sprintf( __( 'No %s found', 'seriously-simple-speakers' ), $this->plural ),
			'items_list_navigation'      => sprintf( __( '%s list navigation', 'seriously-simple-speakers' ), $this->plural ),
			'items_list'                 => sprintf( __( '%s list', 'seriously-simple-speakers' ), $this->plural ),
		);

		// Build taxonomy arguments
		$args = array(
			'hierarchical'          => true,
			'label'                 => $this->plural,
			'labels'                => apply_filters( 'ssp_speakers_taxonomy_labels', $labels ),
			'meta_box_cb'           => null,
			'public'                => true,
			'query_var'             => $this->tax,
			'rewrite'               => array(
				'slug' => apply_filters( 'ssp_speakers_taxonomy_slug', $this->tax )
			),
			'show_admin_column'     => true,
			'show_in_nav_menus'     => true,
			'show_in_rest'          => true,
			'show_tagcloud'         => true,
			'show_ui'               => true,
			'sort'                  => '',
			'update_count_callback' => '',
		);

		// Allow filtering of taxonomy arguments
		$args = apply_filters( 'ssp_register_taxonomy_args', $args, $this->tax );

		// Get all selected podcast post types
		$podcast_post_types = ssp_post_types( true );

		// Register taxonomy for all podcast post types
		register_taxonomy( $this->tax, $podcast_post_types, $args );
	}

	/**
	 * @return string
	 */
	public function get_tax_name() {
		return apply_filters( 'ssp_speakers_tax', 'speaker' );
	}

	public function get_speakers( $episode_id = 0 ) {

		$speakers = array();

		if ( ! $episode_id ) {
			global $post;
			$episode_id = $post->ID;
		}

		if ( ! $episode_id ) {
			return $speakers;
		}

		$speaker_terms = wp_get_post_terms( $episode_id, $this->get_tax_name() );

		if ( is_wp_error( $speakers ) || ( is_array( $speaker_terms ) && 0 == count( $speaker_terms ) ) ) {
			return $speakers;
		}

		foreach ( $speaker_terms as $speaker ) {
			$speakers[] = array(
				'id'   => $speaker->term_id,
				'name' => $speaker->name,
				'url'  => get_term_link( $speaker->term_id ),
			);
		}

		return $speakers;
	}

	/**
	 * Load plugin localisation
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	public function load_localization() {
		load_plugin_textdomain( 'seriously-simple-speakers', false, basename( $this->dir ) . '/languages/' );
	}

	/**
	 * Main SSP_Speakers Instance
	 *
	 * Ensures only one instance of SSP_Speakers is loaded or can be loaded.
	 *
	 * @return self SSP_Speakers instance
	 * @see SSP_Speakers()
	 * @since 1.0.0
	 * @static
	 */
	public static function instance( $file = '', $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}

		return self::$_instance;
	}


	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	public function install() {
		$this->_log_version_number();

		// Regsiter taxonomy and flush rewrite rules on plugin activation
		$this->register_taxonomy();
		flush_rewrite_rules( true );
	}

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	private function _log_version_number() {
		update_option( $this->_token . '_version', $this->_version );
	}

}
