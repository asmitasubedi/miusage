<?php
/**
 * Blocks class.
 *
 * @since 1.0.0
 * @package Miusage\Blocks
 */

namespace Miusage\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Blocks class.
 *
 * @class Blocks
 */
class Blocks {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Initialization
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @return void
	 */
	private function init() {
		$this->init_hooks();
	}

	/**
	 * Init Hooks.
	 *
	 * @since 1.0.0
	 */
	private function init_hooks() {
		add_filter( 'block_categories_all', array( $this, 'block_categories' ), 10, 2 );
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_blocks' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'set_script_translations' ) );
	}

	/**
	 * Add block categories.
	 *
	 * @param array $categories
	 * @param array $post
	 * @return array
	 */
	public function block_categories( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'miusage',
					'title' => __( 'Miusage', 'miusage' ),
				),
			)
		);
	}

	/**
	 * Register blocks.
	 *
	 * @since 1.0.0
	 */
	public function register_blocks() {
		foreach ( self::get_blocks() as $block => $function ) {
			register_block_type(
				__DIR__ . "/{$block}",
				array(
					'render_callback' => function( $attributes, $content ) use ( $block ) {
						return $this->render_block( $attributes, $content, $block );
					},
					'editor_script'   => 'miusage-blocks-js',
					'editor_style'    => 'miusage-blocks-css',
				)
			);
		}
	}

	/**
	 * Get blocks list.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected static function get_blocks() {
		$namespace = '\\Miusage\\Blocks';

		/**
		 * Filters blocks classes.
		 *
		 * @since 1.0.0
		 *
		 * @param string[] $classes The block classes.
		 */
		return apply_filters(
			'miusage_blocks',
			array(
				'Challenges' => "{$namespace}\\Challenges",
			)
		);
	}

	/**
	 * Enqueue blocks.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_blocks() {
		$block_deps = include_once plugin_dir_path( MIUSAGE_PLUGIN_FILE ) . '/assets/build/blocks.asset.php';
		wp_register_script(
			'miusage-blocks-js',
			plugin_dir_url( MIUSAGE_PLUGIN_FILE ) . 'assets/build/blocks.js',
			$block_deps['dependencies'],
			$block_deps['version'],
			true
		);

		wp_localize_script(
			'miusage-blocks-js',
			'miusage',
			array(
				'siteURL' => esc_url( home_url( '/' ) ),
			)
		);

		wp_enqueue_style( 'miusage-blocks-css', plugin_dir_url( MIUSAGE_PLUGIN_FILE ) . 'assets/blocks/challenges/style.css', array(), MIUSAGE_VERSION );
	}

	/**
	 * Set script translations.
	 *
	 * @since 1.0.0
	 */
	public function set_script_translations() {
		wp_set_script_translations( 'miusage-blocks-js', 'miusage', plugin_dir_path( MIUSAGE_PLUGIN_FILE ) . 'languages' );
	}

	/**
	 * Render block.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attributes Block attributes.
	 * @param string $content Block content.
	 * @param string $block Block name.
	 * 
	 * @return string Block HTML.
	 */
	public function render_block( $attributes, $content, $block) {

		ob_start();
		include __DIR__ . "/{$block}/block.php";
		$block_render = ob_get_clean();

		return $block_render;
	}
}
