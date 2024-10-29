<?php
/**
 * Better WordPress Minify fails to recognize URLs starting with "//"
 * Force BWP to ignore NetDNA-hosted fontawesome scripts.
 * 
 * @see http://wordpress.org/plugins/bwp-minify/
 */
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}
function asi_menu_bwp_dont_minify_fontawesome($excluded) {
	$excluded = array('fontawesome', 'fontawesome-ie');
	return $excluded;
}
add_filter('bwp_minify_style_ignore', 'asi_menu_bwp_dont_minify_fontawesome');