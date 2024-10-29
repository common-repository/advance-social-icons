<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}
class ASI_Frontend {

	/**
	 * Should we hide the original menu text, or put the icon before it?
	 * Override with asi_social_icons_hide_text filter
	 * 
	 * @var bool
	 */
	var $hide_text = true;

	/**
	 * Contains 3.2.1 FontAwesome icons only. See $networks_latest for additional 4.0 icons.
	 * @var array links social site URLs with CSS classes for icons
	 */
	var $networks = array(
		'bitbucket.org'      => array( 'name' => 'Bitbucket',      'class' => 'bitbucket',     'icon' => 'icon-bitbucket',     'icon-sign' => 'icon-bitbucket-sign'   ),
		'dribbble.com'       => array( 'name' => 'Dribbble',       'class' => 'dribbble',      'icon' => 'icon-dribbble',      'icon-sign' => 'icon-dribbble'         ),
		'dropbox.com'        => array( 'name' => 'Dropbox',        'class' => 'dropbox',       'icon' => 'icon-dropbox',       'icon-sign' => 'icon-dropbox'          ),
		'facebook.com'       => array( 'name' => 'Facebook',       'class' => 'facebook',      'icon' => 'icon-facebook',      'icon-sign' => 'icon-facebook-sign'    ),
		'flickr.com'         => array( 'name' => 'Flickr',         'class' => 'flickr',        'icon' => 'icon-flickr',        'icon-sign' => 'icon-flickr'           ),
		'foursquare.com'     => array( 'name' => 'Foursquare',     'class' => 'foursquare',    'icon' => 'icon-foursquare',    'icon-sign' => 'icon-foursquare'       ),
		'github.com'         => array( 'name' => 'Github',         'class' => 'github',        'icon' => 'icon-github',        'icon-sign' => 'icon-github-sign'      ),
		'gittip.com'         => array( 'name' => 'GitTip',         'class' => 'gittip',        'icon' => 'icon-gittip',        'icon-sign' => 'icon-gittip'           ),
		'instagr.am'         => array( 'name' => 'Instagram',      'class' => 'instagram',     'icon' => 'icon-instagram',     'icon-sign' => 'icon-instagram'        ),
		'instagram.com'      => array( 'name' => 'Instagram',      'class' => 'instagram',     'icon' => 'icon-instagram',     'icon-sign' => 'icon-instagram'        ),
		'linkedin.com'       => array( 'name' => 'LinkedIn',       'class' => 'linkedin',      'icon' => 'icon-linkedin',      'icon-sign' => 'icon-linkedin-sign'    ),
		'mailto:'            => array( 'name' => 'Email',          'class' => 'envelope',      'icon' => 'icon-envelope',      'icon-sign' => 'icon-envelope-alt'     ),
		'pinterest.com'      => array( 'name' => 'Pinterest',      'class' => 'pinterest',     'icon' => 'icon-pinterest',     'icon-sign' => 'icon-pinterest-sign'   ),
		'plus.google.com'    => array( 'name' => 'Google+',        'class' => 'google-plus',   'icon' => 'icon-google-plus',   'icon-sign' => 'icon-google-plus-sign' ),
		'renren.com'         => array( 'name' => 'RenRen',         'class' => 'renren',        'icon' => 'icon-renren',        'icon-sign' => 'icon-renren'           ),
		'stackoverflow.com'  => array( 'name' => 'Stack Exchange', 'class' => 'stackexchange', 'icon' => 'icon-stackexchange', 'icon-sign' => 'icon-stackexchange'    ),
		'trello.com'         => array( 'name' => 'Trello',         'class' => 'trello',        'icon' => 'icon-trello',        'icon-sign' => 'icon-trello'           ),
		'tumblr.com'         => array( 'name' => 'Tumblr',         'class' => 'tumblr',        'icon' => 'icon-tumblr',        'icon-sign' => 'icon-tumblr'           ),
		'twitter.com'        => array( 'name' => 'Twitter',        'class' => 'twitter',       'icon' => 'icon-twitter',       'icon-sign' => 'icon-twitter-sign'     ),
		'vk.com'             => array( 'name' => 'VK',             'class' => 'vk',            'icon' => 'icon-vk',            'icon-sign' => 'icon-vk'               ),
		'weibo.com'          => array( 'name' => 'Weibo',          'class' => 'weibo',         'icon' => 'icon-weibo',         'icon-sign' => 'icon-weibo'            ),
		'xing.com'           => array( 'name' => 'Xing',           'class' => 'xing',          'icon' => 'icon-xing',          'icon-sign' => 'icon-xing'             ),
		'youtu.be'           => array( 'name' => 'YouTube',        'class' => 'youtube',       'icon' => 'icon-youtube',       'icon-sign' => 'icon-youtube-sign'     ),
		'youtube.com'        => array( 'name' => 'YouTube',        'class' => 'youtube',       'icon' => 'icon-youtube',       'icon-sign' => 'icon-youtube-sign'     ),
	);

	/**
	 * Contains 4.0+ FontAwesome icons only.
	 * @var array links social site URLs with CSS classes for icons
	 */
	var $networks_latest = array(
		'slideshare.net'     => array( 'name' => 'SlideShare',     'class' => 'slideshare',     'icon' => 'fa fa-slideshare',     'icon-sign' => 'fa fa-slideshare'     ),
		'stackoverflow.com'  => array( 'name' => 'Stack Overflow', 'class' => 'stack-overflow', 'icon' => 'fa fa-stack-overflow', 'icon-sign' => 'fa fa-stack-overflow' ),
		'stackexchange.com'  => array( 'name' => 'Stack Exchange', 'class' => 'stack-exchange', 'icon' => 'fa fa-stack-exchange', 'icon-sign' => 'fa fa-stack-exchange' ),
		'vimeo.com'          => array( 'name' => 'Vimeo',          'class' => 'vimeo',          'icon' => 'fa fa-vimeo-square',   'icon-sign' => 'fa fa-vimeo-square'   ),
		'mailto:'            => array( 'name' => 'Email',          'class' => 'envelope',       'icon' => 'fa fa-envelope',       'icon-sign' => 'fa fa-envelope-o'     ),
	);

	/**
	 * Class to apply to the <li> of all social menu items
	 */
	var $li_class = 'social-icon';

	/**
	 * FontAwesome 4.0+ -- Size options available for icon output
	 * These are sizes that render as "pixel perfect" according to FontAwesome.
	 */
	var $icon_sizes = array(
		'normal' => '',
		'large'  => 'fa-lg',
		'2x'     => 'fa-2x',
		'3x'     => 'fa-3x',
		'4x'     => 'fa-4x',
		'5x'     => 'fa-5x',
	);

	/**
	 * FontAwesome 3.2.1 -- Size options available for icon output
	 * These are sizes that render as "pixel perfect" according to FontAwesome.
	 */
	var $legacy_icon_sizes = array(
		'normal' => '',
		'large'  => 'icon-large',
		'2x'     => 'icon-2x',
		'3x'     => 'icon-3x',
		'4x'     => 'icon-4x',
	);

	/**
	 * Size of the icons to display.
	 * Override with asi_social_icons_size filter
	 * 
	 * @var string normal|large|2x|3x|4x
	 */
	var $size = '2x';

	/**
	 * Display normal icons, or icons cut out of a box (sign) shape?
	 * Override with asi_social_icons_type filter
	 *
	 * @var string icon|icon-sign
	 */
	var $type = 'icon';

	/**
	 * @var bool If true, use FontAwesome 4.0+, which drops IE7, but adds Vimeo
	 */
	var $use_latest = false;

	/**
	 * @var asi_Menu_Social_Icons Instance of the class.
	 */
	private static $instance = false;

	/**
	 * Don't use this. Use ::get_instance() instead.
	 */
	public function __construct() {
		if ( !self::$instance ) {
			$message = '<code>' . __CLASS__ . '</code> is a singleton.<br/> Please get an instantiate it with <code>' . __CLASS__ . '::get_instance();</code>';
			wp_die( $message );
		}

		add_filter( 'wp_get_nav_menu_items', array($this,'asi_exclude_children_items'), null, 3 ); 
	}

	function asi_exclude_children_items( $items, $menu, $args ) {
		foreach ( $items as $key => $item ) {
	        if ( $item->menu_item_parent != 0 && $item->msisoicon =='socialico') unset( $items[$key] );
	    }
	    return $items;
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
		
		// Option to update to FontAwesome 4.0+ format (drops IE7 support)
		$this->use_latest = apply_filters( 'asi_latest_social_icons', $this->use_latest );

		if ( $this->use_latest ) {
			add_filter( 'asi_networks_social_icons', array( $this, 'asi_update_network_classes' ), 1000 );
		}

		$this->size         = apply_filters( 'asi_social_icons_size',         $this->size );
		$this->type         = apply_filters( 'asi_social_icons_type',         $this->type );
		$this->hide_text    = apply_filters( 'asi_social_icons_hide_text',    $this->hide_text );
		$this->networks     = apply_filters( 'asi_networks_social_icons',     $this->networks );

		add_action( 'wp_enqueue_scripts', array( $this, 'asi_enqueue_scripts' ) );
		add_action( 'wp_print_scripts', array( $this, 'asi_print_scripts' ) );

		add_filter( 'wp_nav_menu_objects', array( $this, 'asi_wp_nav_menu_obj' ), 5, 2 );

		// Shortcode for testing all fontawesome icons: [fontawesometest]
		add_shortcode( 'fontawesometest', array( $this, 'asi_shortcode_fontawesome' ) );
		add_action( 'fontawesometest', array( $this, 'asi_fontawesome_test' ) );

	}

	/**
	 * Load FontAwesome from NetDNA's Content Deliver Network (faster, likely to be cached)
	 * @see http://www.bootstrapcdn.com/#tab_fontawesome
	 */
	public function asi_enqueue_scripts() {		
		wp_enqueue_style( 'frontviewstyle', plugins_url( 'css/asi-frontend.css', ASI_PLUGIN_FL), array(), ASI_VER );

		if ( $this->use_latest ) {

			// FontAwesome latest. Drops IE7 support.
			wp_enqueue_style( 'fontawesome', '//netdna.bootstrapcdn.com/font-awesome/latest/css/font-awesome.css', array(), ASI_VER, 'all' );

		}else {

			// FontAwesome 3.2.1 -- support IE7, but lacks Vimeo
			global $wp_styles;
			wp_enqueue_style( 'fontawesome', '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css', array(), ASI_VER, 'all' );
			wp_enqueue_style( 'fontawesome-ie', '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css', array( 'fontawesome' ), ASI_VER );

			// Internet Explorer conditional comment
			$wp_styles->add_data( 'fontawesome-ie', 'conditional', 'IE 7' );

		}

	}

	/**
	 * Hide text visually, but keep available for screen readers.
	 * Just a few lines of stylesheet, so loading inline rather than adding another HTTP request.
	 */
	public function asi_print_scripts() {
		?>
		<style>
			/* Accessible for screen readers but hidden from view */
			.fa-hidden { position:absolute; left:-10000px; top:auto; width:1px; height:1px; overflow:hidden; }
			.rtl .fa-hidden { left:10000px; }
			.fa-showtext { margin-right: 5px; }
		</style>
		<?php
	}

	/**
	 * Get icon HTML with appropriate classes depending on size and icon type
	 */
	public function asi_fontaws_gt_icons( $network ) {

		// Switch between legacy or current icon size classes
		$icon_sizes = ( $this->use_latest ) ?  $this->icon_sizes : $this->legacy_icon_sizes;

		$size = $icon_sizes[ $this->size ];
		$icon = $network[ $this->type ];
		$show_text = $this->hide_text ? '' : 'fa-showtext';

		$html = "<i class='$size $icon $show_text'></i>";

		return apply_filters( 'asi_social_icons_icon_html', $html, $size, $icon, $show_text );

	}

	/**
	 * Find social links in top-level menu items, add icon HTML
	 */
	public function asi_wp_nav_menu_obj( $sorted_menu_items, $args ){
		
		foreach( $sorted_menu_items as $key => $item ) { 
				
			
			/*if (($item->type_label == 'Page' || $item->type_label == 'Post') && ('socialico' !== $item->msisoicon)) {
	            unset($sorted_menu_items[$key]);
	        }*/
			

			if('socialico' == $item->msisoicon){
				foreach( $this->networks as $url => $network ) {
					if ( false !== strpos( $item->url, $url ) ) {
						$item->classes[] = $this->li_class;
						$item->classes[] = $network['class'];

						if ( $this->hide_text ) {
							$html = "<span class='fa-hidden'>{$item->title}</span>";
							$item->title = apply_filters( 'asi_social_icons_title_html', $html, $item->title );
						}
						

						if($item->subtitle){ //check custom icon
							if($item->iconsize == 'other'){
								if(!empty($item->customwid)){
									$icowidth = $item->customwid;
								}
								else{
									$icowidth = 40;
								}
								if(!empty($item->customhei)){
									$icoheight = $item->customhei.'px';
								}
								else{
									$icoheight = 'auto';
								}
							}
							else{
								$icowidth = $item->iconsize;
								$icoheight = $item->iconsize.'px';
							}

							$html = "<img style='width:".$icowidth."px; height:".$icoheight.";' class='suttl previw-social' src='".$item->subtitle."'>";
							$item->title = apply_filters( 'asi_social_icons_title_html', $html, $item->subtitle );
						}
						else{
							$item->title = $this->asi_fontaws_gt_icons( $network ) . $item->title ;
						}
						
					}
					else if(!empty($item->subtitle)){

						//$item->classes[] = 'social-icon';
							if($item->iconsize == 'other'){
								if(!empty($item->customwid)){
									$icowidth = $item->customwid;
								}
								else{
									$icowidth = 40;
								}
								if(!empty($item->customhei)){
									$icoheight = $item->customhei.'px';
								}
								else{
									$icoheight = 'auto';
								}
							}
							else{
								$icowidth = $item->iconsize;
								$icoheight = $item->iconsize.'px';
							}

							$html = "<img style='width:".$icowidth."px; height:".$icoheight.";' class='suttl previw-social' src='".$item->subtitle."'>";
							$item->title = apply_filters( 'asi_social_icons_title_html', $html, $item->subtitle );						
					}
				}
			}
		}


		return $sorted_menu_items;
		
	}

	/**
	 * Change size classes from 3.2.1 format to 4.0+ format.
	 * 
	 * @param  array $networks See $this->$networks
	 * @return array $networks Filtered to change "icon-" to "fa fa-"
	 */
	public function asi_update_network_classes( $networks ) {
		
		foreach ( $networks as $url => &$values ) {
			$values['icon']      = str_replace( 'icon-', 'fa fa-', $values['icon'] );
			$values['icon-sign'] = str_replace( 'icon-', 'fa fa-', $values['icon-sign'] );
			$values['icon-sign'] = str_replace( '-sign', '-square', $values['icon-sign'] );
		}

		$networks = array_merge( $networks, $this->networks_latest );

		return $networks;
	}

	/**
	 * Output of all FontAwesome icons 
	 */
	public function asi_fontawesome_test( $args ) {
		include dirname( __FILE__ ) . '/asi-font-awesome.html';
	}

	/**
	 * Shortcode to test output of all FontAwesome icons
	 */
	public function asi_shortcode_fontawesome( $args ) {
		ob_start();
		$this->asi_fontawesome_test();
		return ob_get_clean();
	}
}