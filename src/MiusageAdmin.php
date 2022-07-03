<?php
/**
 * Admin Class
 *
 * @package Miusage
 */

namespace Miusage;

defined( 'ABSPATH' ) || exit;

/**
 * Admin Miusage Class
 *
 * @class Miusage
 */
class MiusageAdmin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Hook into actions and filters.
	 */
	private function init() {
		// Initialize hooks.
		$this->init_hooks();

		// Allow 3rd party to remove hooks.
		do_action( 'miusage_admin_unhook', $this );
	}

	/**
	 * Initialize hooks.
	 */
	private function init_hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {

	}

}
