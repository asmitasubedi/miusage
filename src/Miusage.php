<?php
/**
 * Main Miusage Class
 *
 * @package Miusage
 */

namespace Miusage;

use Miusage\RestApi\RestApi;
use Miusage\Cli\Cli;
use Miusage\Shortcodes\Shortcodes;
use Miusage\Blocks\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Main Miusage Class
 *
 * @class Miusage
 */
final class Miusage {
	/**
	 * Miusage version.
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * The single instance of the class.
	 *
	 * @var Miusage
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Miusage Instance.
	 *
	 * Ensures only one instance of Miusage is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Miusage - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->define_constants();
		$this->init_hooks();
		$this->includes();

		if ( ! $this->meets_requirements() ) {
			return;
		}

		$this->admin = new MiusageAdmin();

		if ( $this->is_request( 'frontend' ) ) {
			// Public instances.
			$this->public = new MiusagePublic();
		}
	}

	/**
	 * Define Miusage Constants.
	 *
	 * @since 1.0.0
	 */
	private function define_constants() {
		$this->define( 'MIUSAGE_PLUGIN_NAME', 'miusage' );
		$this->define( 'MIUSAGE_VERSION', $this->version );
		$this->define( 'MIUSAGE_ABSPATH', dirname( MIUSAGE_PLUGIN_FILE ) . '/' );
		$this->define( 'MIUSAGE_PLUGIN_URL', $this->plugin_url() );
		$this->define( 'MIUSAGE_PLUGIN_BASENAME', plugin_basename( MIUSAGE_PLUGIN_FILE ) );
		$this->define( 'MIUSAGE_PLUGIN_PATH', plugin_dir_path( MIUSAGE_PLUGIN_FILE ) );
		$this->define( 'MIUSAGE_TEMPLATE_DEBUG_MODE', false );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @since 1.0.0
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 1.0.0
	 */
	private function init_hooks() {
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'admin_notices', array( $this, 'maybe_disable_plugin' ) );
	}

	/**
	 * Include required files.
	 *
	 * @since 1.0.0
	 */
	private function includes() {
		if ( $this->meets_requirements() ) {
			RestApi::init();
			Cli::init();
			Shortcodes::register_shortcodes();
			new Blocks();
		}
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'miusage', false, dirname( MIUSAGE_PLUGIN_BASENAME ) . '/languages/' );
	}

	/**
	 * Get the plugin URL.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', MIUSAGE_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( MIUSAGE_PLUGIN_FILE ) );
	}

	/**
	 * Get Ajax URL.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}

	/**
	 * Get the template path.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public function template_path() {
		return apply_filters( 'miusage_template_path', '/miusage/' );
	}

	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Output error message and disable plugin if requirements are not met.
	 *
	 * This fires on admin_notices.
	 *
	 * @since 1.0.0
	 */
	public function maybe_disable_plugin() {

		if ( ! $this->meets_requirements() ) {
			// Deactivate the plugin.
			deactivate_plugins( MIUSAGE_PLUGIN_BASENAME );
		}
	}

	/**
	 * Check if all plugin requirements are met.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if requirements are met, otherwise false.
	 */
	private function meets_requirements() {
		return true;
	}
}
