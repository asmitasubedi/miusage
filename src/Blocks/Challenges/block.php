<?php
/**
 * Miusage Challenges Block Template
 * 
 * @package Miusage\Blocks\Challenges
 * 
 * @since 1.0.0
 * 
 * @param array $attributes
 * @param array $content
 * @param string $block
 */

if ( ! isset( $attributes ) ) {
	return;
}

$shortcode = do_shortcode( '[miusage_challenges]' );
echo $shortcode;
