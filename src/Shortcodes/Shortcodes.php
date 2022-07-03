<?php
/**
 * Shortcodes initializer.
 *
 * @since 1.0.0
 * @class Shortcodes
 * @package Miusage\Shortcodes
 */

namespace Miusage\Shortcodes;

defined( 'ABSPATH' ) || exit;

/**
 * Shortcodes initializer.
 */
class Shortcodes {

	/**
	 * Register shortcodes.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function register_shortcodes() {
		foreach ( self::get_shortcodes() as $shortcode => $function ) {
			add_shortcode( apply_filters( "miusage_{$shortcode}_tag", $shortcode ), $function );
		}
	}

	/**
	 * Get shortcodes list.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected static function get_shortcodes() {
		$namespace = '\\Miusage\\Shortcodes';

		/**
		 * Filters shortcode classes.
		 *
		 * @since 1.0.0
		 *
		 * @param string[] $classes The shortcode classes.
		 */
		return apply_filters(
			'miusage_shortcodes',
			array(
				'miusage_challenges' => "{$namespace}\\ChallengesShortcode" . '::challenges_callback',
			)
		);
	}
}
