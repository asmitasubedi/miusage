<?php
/**
 * Admin Table Class
 *
 * @since 1.0.0
 * @package Miusage\Admin
 */

namespace Miusage\Admin;

use Miusage\Helpers\Helpers;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_List_Table', false ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Class for displaying Miusage Challenges in a WordPress-like Admin Table.
 */
class ChallengesTable extends \WP_List_Table {

	/**
	 * Initialize the challenges table list.
	 */
	public function __construct() {

		parent::__construct(
			array(
				'singular' => 'challenge',
				'plural'   => 'challenges',
				'ajax'     => false,
			)
		);
	}

	/**
	 * Get list columns.
	 *
	 * @return array
	 */
	public function get_columns() {

		return array(
			'id'    => __( 'ID', 'miusage' ),
			'fname' => __( 'First Name', 'miusage' ),
			'lname' => __( 'Last Name', 'miusage' ),
			'email' => __( 'Email', 'miusage' ),
			'date'  => __( 'Date', 'miusage' ),
		);
	}

	/**
	 * Display Challenges ID.
	 *
	 * @param  array $item
	 * @return string
	 */
	public function column_id( $item ) {

		return esc_attr( $item['id'] );
	}

	/**
	 * Display Challenges First Name.
	 *
	 * @param  array $item
	 * @return string
	 */
	public function column_fname( $item ) {

		return esc_html( $item['fname'] );
	}

	/**
	 * Display Challenges Last Name.
	 *
	 * @param  array $item
	 * @return string
	 */
	public function column_lname( $item ) {

		return esc_html( $item['lname'] );
	}

	/**
	 * Display Challenges Email.
	 *
	 * @param  array $item
	 * @return string
	 */
	public function column_email( $item ) {

		return esc_html( $item['email'] );
	}

	/**
	 * Display Challenges Date.
	 *
	 * @param  array $item
	 * @return string
	 */
	public function column_date( $item ) {

		return esc_html(
			date_i18n(
				Helpers::datetime_format(),
				$item['date']
			)
		);
	}

	/**
	 * Prepare table list items.
	 */
	public function prepare_items() {

		$this->items = $this->get_challenges();

	}

	/**
	 * Retrieve challenges.
	 *
	 * @return array
	 */
	private function get_challenges() {

		$data = Helpers::retrieve_challenges();

		if ( is_wp_error( $data ) || empty( $data ) ) {
			return array();
		}

		$challenges = isset( $data['data']['rows'] ) ? $data['data']['rows'] : array();

		return $challenges;
	}

	/**
	 * No items found text.
	 */
	public function no_items() {

		esc_html_e( 'No challenges found.', 'miusage' );
	}

	/**
	 * Displays the table.
	 *
	 * @since 1.0.0
	 */
	public function display() {

		$this->_column_headers = array( $this->get_columns(), array(), array() );

		parent::display();
	}

}
