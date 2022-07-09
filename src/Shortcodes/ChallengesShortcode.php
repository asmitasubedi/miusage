<?php
/**
 * Challenges Shortcode Class.
 *
 * @since 1.0.0
 * @package Miusage\Shortcodes
 */

namespace Miusage\Shortcodes;

use Miusage\Helpers\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode class.
 *
 * @class Miusage\Shortcodes\ChallengesShortcode
 */
class ChallengesShortcode {

	/**
	 * Callback function for challenges shortcode.
	 *
	 * @since 1.0.0
	 */
	public static function challenges_callback( $attributes, $content = null ) {

		$attributes = shortcode_atts(
			array(
				'id'    => true,
				'fname' => true,
				'lname' => true,
				'email' => true,
				'date'  => true,
			),
			$attributes,
			'miusage_challenges'
		);

		// If REST_REQUEST is defined (by WordPress) and is a TRUE, then it's a REST API request.
		$is_rest_route = ( defined( 'REST_REQUEST' ) && REST_REQUEST );
		if (
			( is_admin() && ! $is_rest_route ) || // admin and AJAX (via admin-ajax.php) requests.
			( ! is_admin() && $is_rest_route )    // REST requests only.
		) {
			return '';
		}

		$data = Helpers::retrieve_challenges();

		if ( is_wp_error( $data ) ) {
			return $data->get_error_message();
		}

		if ( empty( $data ) ) {
			return __( 'No challenges found.', 'miusage' );
		}

		\ob_start();

		include_once MIUSAGE_ABSPATH . 'templates/shortcodes/challenges-table.php';

		return \ob_get_clean();

	}

}
