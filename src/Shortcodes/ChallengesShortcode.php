<?php
/**
 * Challenges Shortcode Class.
 *
 * @since 1.0.0
 * @package Miusage\Shortcodes
 */

namespace Miusage\Shortcodes;

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode class.
 */
class ChallengesShortcode {

	public static function challenges_callback( $attributes, $content = null ) {
		$attributes = shortcode_atts(
			array(
				'title'       => '',
				'description' => '',
				'image'       => '',
				'link'        => '',
				'link_text'   => '',
			),
			$attributes,
			'miusage_challenges'
		);

		return 'hii';

		// $template_path = self::get_template_path();

		// /**
		// * Render the template.
		// */
		// return self::get_rendered_html(
		// array_merge(
		// $attributes,
		// $this->get_template_args()
		// ),
		// $template_path
		// );
	}

}
