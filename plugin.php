<?php
/*
Plugin Name: Advance Social Icons
Description: Advance Social Icons(ASI) is a very nifty responsive social links plugin that helps you put icons from font awesome library or custom icons wherever you need. You can add icons in your Wordpress posts, pages, or custom post types via custom menu call or widget. 
Version: 3.4
Author: Galaxy Weblinks
Author URI: https://www.galaxyweblinks.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define( 'ASI_PLUGIN_FL', __FILE__ );
define( 'ASI_VER', '1.0' );

add_action( 'init', 'asi_menu_init' );

function asi_menu_init() {

	// PHP Version Check
	$php_is_outdated = version_compare( PHP_VERSION, '5.2', '<' );

	// Only exit and warn if on admin page
	$okay_to_exit = is_admin() && ( !defined('DOING_AJAX') || !DOING_AJAX );
	
	if ( $php_is_outdated ) {
    if ( $okay_to_exit ) {
      require_once ABSPATH . '/wp-admin/includes/plugin.php';
      deactivate_plugins( __FILE__ );
      wp_die( sprintf( __( 'Advance Social Icons requires PHP 5.2 or higher, as does WordPress 3.2 and higher. The plugin has now disabled itself. For information on upgrading, %ssee this article%s.', 'menu-social-icons'), '<a href="http://codex.wordpress.org/Switching_to_PHP5" target="_blank">', '</a>') );
    } else {
      return;
    }
	}

	require_once dirname ( __FILE__ ) . '/classes/asi-frontend.php';
	require_once dirname ( __FILE__ ) . '/classes/asi-backend.php';

	if ( class_exists( 'BWP_MINIFY' ) ) {
		require_once dirname ( __FILE__ ) . '/classes/asi-bwp-compatibility.php';
	}
	
	// Frontend actions
	// WP E-Commerce blocks other template_redirect actions by exiting at priority 10.
	add_action( 'template_redirect', 'ASI_Frontend::get_instance', 5 );

	// Admin actions
	add_action( 'admin_init', 'ASI_Backend::get_instance' );

}
include_once( 'asi-menu-custom-icons.php' );
include_once( 'asi-custom-menu-link.php' );