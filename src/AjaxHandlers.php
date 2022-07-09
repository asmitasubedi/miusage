<?php
/**
 * Ajax Handlers Class
 *
 * @package Miusage
 * @since 1.0.0
 */

namespace Miusage;

use Miusage\Helpers\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Ajax Handlers Class
 *
 * @class Miusage\AjaxHandlers
 */
class AjaxHandlers {

	/**
	 * Initialize.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function init() {
		self::init_handlers();
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0.0
	 */
	private static function init_handlers() {
		add_action( 'wp_ajax_miusage_refresh_challenges', array( __CLASS__, 'refresh_challenges' ) );
	}

	/**
	 * Refresh challenge data.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function refresh_challenges() {

		if ( ! isset( $_REQUEST['miusage_refresh_challenges_nonce'] ) || ! wp_verify_nonce( $_REQUEST['miusage_refresh_challenges_nonce'], 'miusage_refresh_challenges' ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Invalid nonce.', 'miusage' ),
				)
			);
		}

		// verify user is logged in.
		if ( ! is_user_logged_in() ) {
			wp_send_json_error(
				array(
					'message' => __( 'You must be logged in to refresh challenges.', 'miusage' ),
				)
			);
		}

		// verify user has permission to refresh challenges.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'You do not have permission to refresh challenges.', 'miusage' ),
				)
			);
		}

		$url     = 'https://miusage.com/v1/challenge/1/';
		$url     = untrailingslashit( $url );
		$refresh = Helpers::reset_cache( $url );

		if ( $refresh ) {

			wp_send_json_success(
				array(
					'message' => __( 'Challenges refreshed successfully.', 'miusage' ),
				)
			);

		} else {

			wp_send_json_error(
				array(
					'message' => __( 'Challenges could not be refreshed.', 'miusage' ),
				)
			);

		}

		wp_die();
	}
}

