<?php
/**
 * Initialize REST API.
 *
 * @since 1.0.0
 * @package  Miusage\RestApi
 */

namespace Miusage\RestApi;

defined( 'ABSPATH' ) || exit;

/**
 * REST API Class.
 *
 * @since 1.0.0
 */
class RestApi {

	/**
	 * REST API namespaces and endpoints.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected static $controllers = array();

	/**
	 * Hook into WordPress ready to init the REST API as needed.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_rest_routes' ) );
	}

	/**
	 * Register REST API routes.
	 *
	 * @since 1.0.0
	 */
	public static function register_rest_routes() {
		foreach ( self::get_rest_namespaces() as $namespace => $controllers ) {
			foreach ( $controllers as $controller_name => $controller_class ) {
				self::$controllers[ $namespace ][ $controller_name ] = new $controller_class();
				self::$controllers[ $namespace ][ $controller_name ]->register_routes();
			}
		}
	}

	/**
	 * Get API namespaces - new namespaces should be registered here.
	 *
	 * @since 1.0.0
	 *
	 * @return array List of Namespaces and Main controller classes.
	 */
	protected static function get_rest_namespaces() {
		/**
		 * Filters rest API controller classes.
		 *
		 * @since 1.0.0
		 *
		 * @param array $controllers API namespace to API controllers index array.
		 */
		return apply_filters(
			'miusage_rest_api_get_rest_namespaces',
			array(
				'miusage/v1' => self::get_v1_controllers(),
			)
		);
	}

	/**
	 * List of controllers in the miusage/v1 namespace.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @return array
	 */
	protected static function get_v1_controllers() {
		$namespace = '\\Miusage\\RestApi\\Controllers';

		return array(
			'challenges' => "{$namespace}\\ChallengeController",
		);
	}

}
