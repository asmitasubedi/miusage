<?php
/**
 * Admin Menu Class
 *
 * @since 1.0.0
 * @package Miusage\Admin
 */

namespace Miusage\Admin;

use Miusage\Admin\ChallengesTable;

defined( 'ABSPATH' ) || exit;

/**
 * Admin Menu Class
 *
 * @class Miusage\AdminMenu
 */
class AdminMenu {

	/**
	 * Initialize.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function init() {
		self::init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0.0
	 */
	private static function init_hooks() {
		add_action( 'admin_menu', array( __CLASS__, 'init_menus' ) );
	}

	/**
	 * Initialize admin menus.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function init_menus() {
		add_menu_page(
			esc_html__( 'Miusage', 'miusage' ),
			'Miusage',
			'manage_options',
			'miusage',
			array( __CLASS__, 'display_main_page' ),
			'dashicons-rest-api'
		);
	}

	/**
	 * Render menu Page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function display_main_page() {
		$table = new ChallengesTable();
		$table->prepare_items();

		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Miusage Challenges', 'miusage' ); ?></h1>
			<?php
				$table->display();
			?>
		</div>

		<div class="miusage-refresh-challenges">
			<form name="miusage-refresh-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
				<input type="hidden" name="action" value="miusage_refresh_challenges" />
				<?php wp_nonce_field( 'miusage_refresh_challenges', 'miusage_refresh_challenges_nonce' ); ?>
				<input type="submit" class="button button-primary" value="<?php esc_html_e( 'Refresh Challenges', 'miusage' ); ?>" />
			</form>
			<div class="miusage-refresh-challenges-response"></div>
		</div>
		<?php
	}

}
