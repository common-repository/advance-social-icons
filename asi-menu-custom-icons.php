<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class asi_custom_menu_fields {

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
		// add custom menu fields to menu
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'asi_add_custom_nav_fields' ) );

		//add_filter( 'wp_setup_nav_menu_item', array( $this, 'rc_scm_add_custom_fieldtxt' ) );
		// save menu custom fields
		add_action( 'wp_update_nav_menu_item', array( $this, 'asi_update_custom_nav_fields'), 10, 3 );
		// edit menu walker
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'asi_edit_custom_nav_walker'), 10, 2 );
	} // end constructor

	/* All functions will be placed here */
	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function asi_add_custom_nav_fields( $menu_item ) {		
		$menu_item->msisoicon = get_post_meta( $menu_item->ID, '_menu_item_socialicn', true );
	    $menu_item->subtitle = get_post_meta( $menu_item->ID, '_menu_item_subtitle', true );
	    $menu_item->iconsize = get_post_meta( $menu_item->ID, '_menu_item_icon_size', true );
	    $menu_item->customwid = get_post_meta( $menu_item->ID, '_menu_item_custom_width_size', true );
	    $menu_item->customhei = get_post_meta( $menu_item->ID, '_menu_item_custom_height_size', true );
	    return $menu_item;

	}

	/**
	 * Save menu custom fields
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function asi_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {

	    // Check if element is properly sent
		    
		if ( isset($_REQUEST['menu-item-socialicn'][$menu_item_db_id]) && is_array( $_REQUEST['menu-item-socialicn']) ) {
	        $socialicnvalue = sanitize_text_field($_REQUEST['menu-item-socialicn'][$menu_item_db_id]);
	        update_post_meta( $menu_item_db_id, '_menu_item_socialicn', $socialicnvalue );			
	    }
		/*custom subtitle*/
	    if ( isset($_REQUEST['menu-item-subtitle'][$menu_item_db_id]) && is_array( $_REQUEST['menu-item-subtitle']) ) {
	        $subtitle_value = sanitize_text_field($_REQUEST['menu-item-subtitle'][$menu_item_db_id]);
	        update_post_meta( $menu_item_db_id, '_menu_item_subtitle', $subtitle_value );
	    }
	    /*custom icon size*/
	    if ( isset($_REQUEST['menu-item-iconsize'][$menu_item_db_id]) && is_array( $_REQUEST['menu-item-iconsize']) ) {
	        $menuicon_value = sanitize_text_field($_REQUEST['menu-item-iconsize'][$menu_item_db_id]);
	        update_post_meta( $menu_item_db_id, '_menu_item_icon_size', $menuicon_value );
	    }
	    /*Custom icon width*/
	    if ( isset($_REQUEST['menu-item-custom-width-size'][$menu_item_db_id]) && is_array( $_REQUEST['menu-item-custom-width-size']) ) {
	        $custicon_width = sanitize_text_field($_REQUEST['menu-item-custom-width-size'][$menu_item_db_id]);
	        update_post_meta( $menu_item_db_id, '_menu_item_custom_width_size', $custicon_width );
	    }
	    /*Custom icon height*/
	    if ( isset($_REQUEST['menu-item-custom-height-size'][$menu_item_db_id]) && is_array( $_REQUEST['menu-item-custom-height-size']) ) {
	        $custm_icn_height = sanitize_text_field($_REQUEST['menu-item-custom-height-size'][$menu_item_db_id]);
	        update_post_meta( $menu_item_db_id, '_menu_item_custom_height_size', $custm_icn_height );
	    }

	}

	/**
	 * Define new Walker edit
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function asi_edit_custom_nav_walker($walker,$menu_id) {

	    return 'Walker_Nav_Menu_Edit_Custom_Social_Icons';

	}

}

// instantiate plugin's class
$GLOBALS['sweet_custom_menu'] = new asi_custom_menu_fields();

include_once( 'asi-custom-walker-menu.php' );
include_once( 'asi-custom-waker-frontend.php' );