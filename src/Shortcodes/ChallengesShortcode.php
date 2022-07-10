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
				'show_title' => true,
				'show_id'    => true,
				'show_fname' => true,
				'show_lname' => true,
				'show_email' => true,
				'show_date'  => true,
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

		$caption = isset( $data['title'] ) ? $data['title'] : false;
		$headers = isset( $data['data']['headers'] ) ? $data['data']['headers'] : false;
		$rows    = isset( $data['data']['rows'] ) ? $data['data']['rows'] : false;

		$toggles = array(
			'show_title' => filter_var( $attributes['show_title'], FILTER_VALIDATE_BOOLEAN ),
			'show_id'    => filter_var( $attributes['show_id'], FILTER_VALIDATE_BOOLEAN ),
			'show_fname' => filter_var( $attributes['show_fname'], FILTER_VALIDATE_BOOLEAN ),
			'show_lname' => filter_var( $attributes['show_lname'], FILTER_VALIDATE_BOOLEAN ),
			'show_email' => filter_var( $attributes['show_email'], FILTER_VALIDATE_BOOLEAN ),
			'show_date'  => filter_var( $attributes['show_date'], FILTER_VALIDATE_BOOLEAN ),
		);

		\ob_start();

		include MIUSAGE_ABSPATH . 'templates/shortcodes/challenges-table.php';

		return \ob_get_clean();

	}

}
