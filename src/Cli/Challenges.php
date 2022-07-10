<?php
/**
 * CLI Challenges.
 *
 * @since 1.0.0
 * @package Miusage\Cli
 */

namespace Miusage\Cli;

use Miusage\Helpers\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Challenges cli class.
 */
class Challenges extends \WP_CLI_Command {

	/**
	 * Refreshes the miusage transient, overrides the limit the next time it is called.
	 *
	 * ## OPTIONS
	 *
	 * ## EXAMPLES
	 *
	 *     wp miusage challenges refresh
	 *
	 * @when after_wp_load
	 */
	public function refresh( $args, $assoc_args ) {
		
		$url = 'https://miusage.com/v1/challenge/1/';
		$url = untrailingslashit( $url );

		$refresh = Helpers::reset_cache( $url );

		if ( $refresh ) {
			\WP_CLI::success( 'Challenges refreshed.' );
		} else {
			\WP_CLI::error( 'Challenges not refreshed.' );
		}
	}
}
