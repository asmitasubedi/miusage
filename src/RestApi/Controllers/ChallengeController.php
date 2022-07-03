<?php
/**
 * Challenge Rest API controller.
 *
 * @class ChallengeController
 * @package Miusage/RestApi
 * @since 1.0.0
 */

namespace Miusage\RestApi\Controllers;

use Miusage\Helpers\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Challenge Rest API controller class.
 *
 * @class ChallengeController
 */
class ChallengeController extends \WP_REST_Controller {

	/**
	 * Endpoint namespace.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $namespace = 'miusage/v1';

	/**
	 * Route base.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $rest_base = 'challenges';

	/**
	 * Object type.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $object_type = 'challenge';

	/**
	 * If object is hierarchical.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	protected $hierarchical = true;

	/**
	 * Miusage endpoint.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $miusage_endpoint = 'https://miusage.com/v1/challenge/1/';

	/**
	 * Register routes.
	 *
	 * @since 1.0.0
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);

	}

	/**
	 * Get items permissions check.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_REST_Request $request
	 * @return bool
	 */
	public function get_items_permissions_check( $request ) {
		// authentication of the AJAX endpoint is not required.
		return true;
	}

	/**
	 * Get items.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_REST_Request $request Request object.
	 * @return WP_REST_Response
	 */
	public function get_items( $request ) {
		$url = $this->miusage_endpoint;
		$url = untrailingslashit( $url );

		if ( empty( $url ) ) {
			return new \WP_Error( 'rest_invalid_url', __( 'Invalid URL' ), array( 'status' => 404 ) );
		}

		$cache_key = Helpers::build_cache_key( $url );

		// Attempt to retrieve cached response.
		$cached_response = Helpers::get_cache( $cache_key );

		if ( ! empty( $cached_response ) ) {
			$remote_url_response = $cached_response;
		} else {
			$remote_url_response = $this->fetch_items( $url );

			// Exit if we don't have a valid body or it's empty.
			if ( is_wp_error( $remote_url_response ) || empty( $remote_url_response ) ) {
				return $remote_url_response;
			}

			// Cache the valid response.
			Helpers::set_cache( $cache_key, $remote_url_response );
		}

		$response = rest_ensure_response( $remote_url_response );

		return $response;
	}

	/**
	 * Fetch items.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function fetch_items( $url ) {

		$user_agent = 'WP-Miusage/' . get_bloginfo( 'version' ) . ' (+' . get_bloginfo( 'url' ) . ')';

		$args = array(
			'limit_response_size' => 150 * KB_IN_BYTES,
			'user-agent'          => $user_agent,
		);

		$args = apply_filters( 'miusage_request_args', $args, $url );

		$response = wp_safe_remote_get( $url, $args );

		if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return new \WP_Error(
				'no_response',
				__( 'URL not found. Response returned a non-200 status code for this URL.' ),
				array( 'status' => 404 )
			);
		}

		$remote_body = wp_remote_retrieve_body( $response );
		$remote_body = json_decode( $remote_body, true );

		if ( empty( $remote_body ) ) {
			return new \WP_Error(
				'no_content',
				__( 'Unable to retrieve body from response at this URL.' ),
				array( 'status' => 404 )
			);
		}

		return $remote_body;
	}

}
