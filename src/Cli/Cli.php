<?php
/**
 * Handles cli command initialization.
 *
 * @since 1.0.0
 * @package Miusage\Cli
 */

namespace Miusage\Cli;

defined( 'ABSPATH' ) || exit;

/**
 * Cli class.
 */
class Cli {

	/**
	 * Namespace.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $namespace = 'Miusage\\Cli';

	/**
	 * If WP Cli is active?
	 */
	public static function is_wp_cli() {
		return defined( 'WP_CLI' ) && WP_CLI;
	}

	/**
	 * Hook into WP CLI.
	 */
	public static function init() {
		add_action( 'cli_init', array( __CLASS__, 'register' ) );
	}

	/**
	 * Register CLI commands.
	 *
	 * @since 1.0.0
	 *
	 * @throws \Exception When this is not run within WP CLI.
	 */
	public static function register() {

		if ( ! self::is_wp_cli() ) {
			/* translators: %s php class name */
			throw new \Exception( sprintf( __( 'The %s class can only be run within WP CLI.', 'action-scheduler' ), __CLASS__ ) );
		}

		/**
		 * Filters CLI commands.
		 *
		 * @since 1.0.0
		 *
		 * @param array $commands Command to command handler class index.
		 */
		$commands = apply_filters(
			'miusage_cli_commands',
			array(
				'challenges' => self::$namespace . '\\Challenges',
			)
		);

		foreach ( $commands as $command => $class ) {
			\WP_CLI::add_command( "miusage {$command}", $class );
		}
	}
}
