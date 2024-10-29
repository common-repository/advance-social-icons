=== Advanced Social icons ===
Contributors: galaxyweblinks
Plugin URI: https://wordpress.org/plugins/advance-social-icons
Author URI: https://www.galaxyweblinks.com
Tags: Advanced Social Icons, custom social icons, Social share, social media, Font Awesome social widget
Requires at least: 4.9 or higher
Tested up to: 6.6
Stable tag: 3.4
Requires PHP: 7.4
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Advanced social icons help you quickly add icons with links to your profile on different social media platforms.

== Description ==

Advanced social icons help you quickly add icons with links to your profiles on different social media platforms. The plugin uses icons from Font Awesome, which gives you the possibility to display various popular social icons via widgets. You can use custom icons to add links to anything you want.

No configuration is necessary, other than having links to your social media profiles in the built-in WordPress menus. Add links to any of these social sites under Appearance > Menus, then enable the plugin.

**Supported Sites**

`
bitbucket.org           dribbble.com         dropbox.com
facebook.com            flickr.com           foursquare.com
github.com              gittip.com           instagram.com
linkedin.com            mailto:(email)       pinterest.com
plus.google.com         renren.com           stackoverflow.com
trello.com              tumblr.com           twitter.com          
vk.com                  weibo.com            xing.com
youtube.com

* Requires asi_latest_social_icons be turned on. (See below.)
`

**Option: Icon Sizes**

To vary icon sizes, add this to your theme's **functions.php** file: (Default is 2x)

    add_filter( 'asi_social_icons_size', function(){return "normal"; } );
    add_filter( 'asi_social_icons_size', function(){return "large"; } );
    add_filter( 'asi_social_icons_size', function(){return "2x"; } );
    add_filter( 'asi_social_icons_size', function(){return "3x"; } );
    add_filter( 'asi_social_icons_size', function(){return "4x"; } );

**Option: Add More Icons**

Add icons from [FontAwesome](http://fortawesome.github.io/Font-Awesome/) for other URLs. For example, an RSS feed:

    add_filter( 'asi_networks_social_icons', 'asi_networks_social_icons');
    function asi_networks_social_icons( $networks ) {

        $extra_icons = array (
            '/feed' => array(                  // Enable this icon for any URL containing this text
                'name' => 'RSS',               // Default menu item label
                'class' => 'rss',              // Custom class
                'icon' => 'icon-rss',          // FontAwesome class
                'icon-sign' => 'icon-rss-sign' // May not be available. Check FontAwesome.
            ),
        );

        $extra_icons = array_merge( $networks, $extra_icons );
        return $extra_icons;
    }


== FEATURES AND OPTIONS ==

Supports FontAwesome icons.
Support custom icons
Drag and drop for icon sorting.
Option to easily change icon size.
More features coming on updates.


== Installation ==

1. Search for "Advance Social Icons" under `WordPress Admin > Plugins > Add New`
1. Activate the plugin.

== Screenshots ==

1. Add Social Icons in WordPress Menu Editor.
2. Choose custom icon and its size ( optional ).
3. Add social icon menu to widget.
4. Display icon.
5. Display icon with title.
6. "4x" icon size.

== Frequently Asked Questions == 

= Can you add X icon? =

Advance Social Icons is dependent on the [FontAwesome icon library](http://fortawesome.github.io/Font-Awesome). 
If an icon exists in FontAwesome, you can add a filter for it using the `asi_networks_social_icons` example shown in the plugin description.

If an icon does not exist in FontAwesome, you can add custom icon in your menu item and set custom size yourself.

= Does this plugin install all of FontAwesome? =

Yes. The plugin installs the complete FontAwesome package. You can use any of the icons in your HTML.

= Can we display the title with an icon? =

Yes, you can display the title with Font Awesome icons only. In the next version, we’ll update to have this work with custom icons.
To display icon title, add this to your theme’s functions.php file:

`add_filter( 'asi_social_icons_hide_text', '__return_false' );`

= How can we display custom icons? =

To display a custom icon, simply click the choose icon button in the menu item and adjust the size from the drop-down. You can manually define the size of the icon, too.

= How to display social icons? =

To display icons please follow these steps.
1] Create a menu under `Appearance > Menus`.
2] Choose any of social icon from `Social Icons` tab from the `Add menu items` column.
3] Once added the item to the menu, save it.
4] Go to `Appearance > Widgets`, You can drag the `navigation menu/custom menu` widget in your sidebars and change the settings from the widget form itself.
5] Call this sidebar to display social icons anywhere, in your site.


== Changelog ==

= 3.4 =
Stable Release.

= 3.3 =
Stable Release.

= 3.2 =
Stable Release.

= 3.1 =
Stable Release.

= 3.0 =
Second Stable Release.

= 2.0 =
* Fixed the deprecated create_function()
* Fixed the deprecated non static callable method issue
* Fixed bulk select checkbox issue

= 1.0 =

* Initial public release.

== Upgrade Notice ==

= 3.4 =
Stable Release.

= 3.3 =
Stable Release.

= 3.2 =
Stable Release.

= 3.1 =
Stable Release.

= 3.0 =
Second Stable Release.

= 2.0 =
Upgrade to fixes some undefined issues

= 1.0 =
First Stable Release.
