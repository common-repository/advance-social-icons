<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}
class ASI_Backend {
	
	private static $instance = false;

	public function __construct() {
		if ( !self::$instance ) {
			$message = '<code>' . __CLASS__ . '</code> is a singleton.<br/> Please get an instantiate it with <code>' . __CLASS__ . '::get_instance();</code>';
			wp_die( $message );
		}       
	}
	
	public static function get_instance() {
		if ( !is_a( self::$instance, __CLASS__ ) ) {
			self::$instance = true;
			self::$instance = new self();
			self::$instance->init();
		}
		return self::$instance;
	}
	
	/**
	 * Initial setup. Called by get_instance.
	 */
	protected function init() {

		add_action( 'admin_enqueue_scripts', array( $this, 'wp_admin_enqueue_scripts' ) );

	}

	public function wp_admin_enqueue_scripts( $page ) {

		if ( 'nav-menus.php' == $page ) {
			$asi_frontend = ASI_Frontend::get_instance();
			
			$asi_frontend->asi_enqueue_scripts();

			wp_enqueue_script( 'menu-social-icons-admin', plugins_url( 'js/asi-social-icons-admin.js', ASI_PLUGIN_FL ), array( 'jquery' ), ASI_VER, true );
			wp_enqueue_style(  'menu-social-icons-admin', plugins_url( 'css/asi-social-icons-admin.css', ASI_PLUGIN_FL ), array(), ASI_VER );

			wp_localize_script( 'menu-social-icons-admin', 'MenuSocialIconsNetworks', $this->asi_scl_get_networks() );
			wp_enqueue_media();
			wp_enqueue_script( 'upload-custom-social-icons', plugins_url( 'js/asi-media-uploader.js', ASI_PLUGIN_FL ), array( 'jquery' ), ASI_VER, true );
		}

	}

	/**
	 * Get networks array to pass to javascript
	 * Set icon-sign values as icon values if icon-sign in use.
	 * Strip remaining icon-sign values
	 */
	public function asi_scl_get_networks() {
		$asi_frontend = ASI_Frontend::get_instance();
		
		$networks = $asi_frontend->networks;

		foreach ( $networks as &$network ) {
			if ( 'icon-sign' == $asi_frontend->type ) {
				$network['icon'] = $network['icon-sign'];
			}
			unset( $network['icon-sign'] );
		}

		return $networks;
	}


}