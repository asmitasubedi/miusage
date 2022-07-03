<?php
/**
 * Public Class
 *
 * @package Miusage
 */

namespace Miusage;

defined( 'ABSPATH' ) || exit;

/**
 * Handle public functions
 */
class MiusagePublic {
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Initialization
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @return void
	 */
	private function init() {
		$this->init_hooks();

		// Allow 3rd party to remove hooks.
		do_action( 'miusage_public_unhook', $this );
	}

	/**
	 * Initialize hooks
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Enqueue styles
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {

	}

}
