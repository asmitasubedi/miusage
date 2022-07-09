<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Miusage
 *
 * @since 1.0.0
 */

namespace Miusage;

use Miusage\Helpers\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Manages Scripts and Styles.
 *
 * @class Miusage\ScriptStyle
 */
class ScriptStyle {

	/**
	 * Initialization.
	 *
	 * @since 1.0.0
	 */
	public static function init() {

		self::init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0.0
	 */
	private static function init_hooks() {

		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue admin scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_admin_scripts() {

		if ( Helpers::is_miusage_page() ) {
			wp_enqueue_script( 'miusage-admin-script', plugin_dir_url( MIUSAGE_PLUGIN_FILE ) . 'assets/js/admin.js', array( 'jquery' ), MIUSAGE_VERSION, true );
		}
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_scripts() {

		if ( Helpers::has_miusage_shortcode() ) {
			wp_enqueue_style( 'miusage-public', plugin_dir_url( MIUSAGE_PLUGIN_FILE ) . 'assets/css/challenges-table.css', array(), MIUSAGE_VERSION );
		}
	}


}
