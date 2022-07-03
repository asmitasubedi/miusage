<?php
/**
 * Miusage Cache Helpers.
 *
 * @since 1.0.0
 * @package Miusage\Helpers
 */

namespace Miusage\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Miusage Caches implementation.
 *
 * @since 1.0.0
 */
class Cache {

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
}
