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
			'id'    => __( 'ID', 'woocommerce' ),
			'fname' => __( 'First Name', 'woocommerce' ),
			'lname' => __( 'Last Name', 'woocommerce' ),
			'email' => __( 'Email', 'woocommerce' ),
			'date'  => __( 'Date', 'woocommerce' ),
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
	 * Search box.
	 *
	 * @param  string $text     Button text.
	 * @param  string $input_id Input ID.
	 */
	public function search_box( $text, $input_id ) {

		if ( empty( $_REQUEST['s'] ) && ! $this->has_items() ) { // phpcs:ignore WordPress.Security.NonceVerification
			return;
		}

		$input_id = $input_id . '-search-input';
		$search   = isset( $_REQUEST['s'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification

		?>

		<p class="search-box">
			<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $text ); ?>:</label>
			<input type="search" id="<?php echo esc_attr( $input_id ); ?>" name="search" value="<?php echo esc_attr( $search ); ?>" />
			<?php submit_button( $text, '', '', false, array( 'id' => 'search-submit' ) ); ?>
		</p>

		<?php
	}

	/**
	 * Return search filter values or FALSE.
	 *
	 * @since 1.0.0
	 *
	 * @return bool|array
	 */
	public function get_filtered_search() {

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( empty( $_REQUEST['s'] ) ) {
			return false;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return sanitize_text_field( wp_unslash( $_REQUEST['s'] ) );
	}

	/**
	 * Whether the table has items to display or not.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function has_items() {

		return count( $this->items ) > 0;
	}

	/**
	 * No items found text.
	 */
	public function no_items() {

		esc_html_e( 'No challenges found.', 'woocommerce' );
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
