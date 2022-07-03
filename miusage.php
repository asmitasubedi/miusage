<?php
/**
 * Plugin Name:     Miusage
 * Plugin URI:      https://awesomemotive.com/
 * Description:     A miusage API based plugin.
 * Author:          Asmita Subedi
 * Author URI:      https://asmitasubedi.com.np/
 * Text Domain:     miusage
 * Domain Path:     /languages
 * Version:         1.0.0
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package         Miusage
 */

use Miusage\Miusage;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Include the autoloader.
require_once __DIR__ . '/vendor/autoload.php';

if ( ! defined( 'MIUSAGE_PLUGIN_FILE' ) ) {
	define( 'MIUSAGE_PLUGIN_FILE', __FILE__ );
}

/**
 * Return the main instance of Miusage.
 *
 * @since 1.0.0
 * @return Miusage
 */
function miusage() {
	return Miusage::instance();
}

// Global for backwards compatibility.
$GLOBALS['WP_Miusage'] = miusage();
