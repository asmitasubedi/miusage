<?php
/**
 * Miusage Helpers.
 *
 * @since 1.0.0
 * @package Miusage\Helpers
 */

namespace Miusage\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Miusage Helpers class.
 *
 * @since 1.0.0
 */
class Helpers {

	/**
	 * Build cache key for a given URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $url The URL for which to build a cache key.
	 * @return string The cache key.
	 */
	public static function build_cache_key( $url ) {

		return 'miusage_url_response_' . md5( $url );
	}

	/**
	 * Retrieve a value from the cache at a given key.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key The cache key.
	 * @return mixed The value from the cache.
	 */
	public static function get_cache( $key ) {

		return get_transient( $key );
	}

	/**
	 * Cache a given data set at a given cache key.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key  The cache key under which to store the value.
	 * @param string $data The data to be stored at the given cache key.
	 * @return bool True when transient set. False if not set.
	 */
	public static function set_cache( $key, $data = '' ) {

		$ttl = HOUR_IN_SECONDS;

		$cache_expiration = apply_filters( 'miusage_cache_expiration', $ttl );

		return set_transient( $key, $data, $cache_expiration );
	}

	/**
	 * Resets the cache key for a given URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $url The URL for which to reset the cache key.
	 * @return bool True when transient is deleted. False if not deleted.
	 */
	public static function reset_cache( $url ) {

		$cache_key = self::build_cache_key( $url );

		return delete_transient( $cache_key );
	}

	/**
	 * Retrieve the challenges using the Rest Request.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed The response from the URL.
	 */
	public static function retrieve_challenges() {

		$request = new \WP_REST_Request( 'GET', '/miusage/v1/challenges' );
		$request->set_header( 'Content-Type', 'application/json' );
		$request->set_header( 'Accept', 'application/json' );

		$response = rest_do_request( $request );

		if ( $response->is_error() ) {

			$error = $response->as_error();
			return $error;
		}

		$data = $response->get_data();

		return $data;
	}

	/**
	 * Get the full date format as per WP options.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function datetime_format() {

		return sprintf( /* translators: %1$s - date, \a\t - specially escaped "at", %2$s - time. */
			esc_html__( '%1$s \a\t %2$s', 'wp-mail-smtp' ),
			get_option( 'date_format' ),
			get_option( 'time_format' )
		);
	}

	/**
	 * Check if the admin page is miusage page
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public static function is_miusage_page() {

		return ( isset( $_GET['page'] ) && 'miusage' === $_GET['page'] );
	}

	/**
	 * Check if the content has miusage shortcode
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public static function has_miusage_shortcode() {

		return has_shortcode( get_the_content(), 'miusage_challenges' );
	}

}
