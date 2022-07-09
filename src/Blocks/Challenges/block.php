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

$show_title = isset( $attributes['showTitle'] ) && $attributes['showTitle'] ? true : false;
$show_id    = isset( $attributes['showId'] ) && $attributes['showId'] ? true : false;
$show_fname = isset( $attributes['showFname'] ) && $attributes['showFname'] ? true : false;
$show_lname = isset( $attributes['showLname'] ) && $attributes['showLname'] ? true : false;
$show_email = isset( $attributes['showEmail'] ) && $attributes['showEmail'] ? true : false;
$show_date  = isset( $attributes['showDate'] ) && $attributes['showDate'] ? true : false;

echo do_shortcode( '[miusage_challenges show_title="' . $show_title . '" show_id="' . $show_id . '" show_fname="' . $show_fname . '" show_lname="' . $show_lname . '" show_email="' . $show_email . '" show_date="' . $show_date . '"]' );
