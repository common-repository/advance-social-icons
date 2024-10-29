<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class ASI_Custom_Social_Type_Link{

     //Everything will go here
     public function asi_load_fun(){
          //Hook function to add the metabox to the Menu page
          add_action( 'admin_init', array(__CLASS__,'asi_social_add_meta_box'));

          // Javascript for the meta box
          add_action( 'admin_enqueue_scripts', array(__CLASS__,'asi_metabox_script') );

          //Ajax callback to create menu item and add it to menu
          add_action('wp_ajax_msi-social-share-links-action', array( __CLASS__, 'asi_ajax_call_back_fun'));

          //Assign menu item the appropriate url
          add_filter( 'wp_setup_nav_menu_item',  array(__CLASS__,'asi_setup_social_item') );

          //Make post type archive link 'current'
          //add_filter( 'wp_nav_menu_objects', array(__CLASS__,'asi_current_item_social'));
     }

     public static function asi_social_add_meta_box() {
          add_meta_box( 'post-type-archives', __('Social icons','my-post-type-archive-links'),array(__CLASS__,'asi_custom_metabox'),'nav-menus' ,'side','low');
     }

     public static function asi_custom_metabox() {
          global $nav_menu_selected_id;
      ?>
          <div class="asi-social-icons-custom" id="asi-social-icons-custom">
            <p id="menu-item-url-wrap" class="wp-clearfix">
                <label class="howto" for="custom-menu-item-url"><?php _e( 'URL' ); ?></label>
                <input id="msi-custom-menu-item-url" name="menu-item[-1][menu-item-url]" type="text" class="menu-item-url" value="http://" readonly="readonly" />
            </p>
            <p id="menu-item-name-wrap" class="wp-clearfix">
                <label class="howto" for="custom-menu-item-name"><?php _e( 'Link Text' ); ?></label>
                <input id="msi-custom-menu-item-name" name="menu-item[-1][menu-item-title]" type="text" class="menu-item-title" readonly="readonly"/>
            </p>
           
            <!-- 'Add to Menu' button -->
            <p class="button-controls" >
                 <span class="add-to-menu" >
                      <input type="submit" id="submit-post-type-archives" <?php disabled( $nav_menu_selected_id, 0 ); ?> value="<?php esc_attr_e('Add to Menu'); ?>" name="add-post-type-menu-item"  class="button-secondary submit-add-to-menu" />
                 </span>
            </p>
          </div>
     <?php
     }

     public static function asi_metabox_script($hook) {
          if( 'nav-menus.php' != $hook )
               return;

          //On Appearance>Menu page, enqueue script: 
          wp_enqueue_script( 'my-post-type-archive-links_metabox', plugins_url('/js/asi-menumetabox.js', __FILE__),array('jquery'));

          //Add nonce variable
          wp_localize_script('my-post-type-archive-links_metabox','Mysocialiconlinks', array('nonce'=>wp_create_nonce('msi-social-share-links-action')));
     }

   public static function asi_ajax_call_back_fun(){

          if ( ! current_user_can( 'edit_theme_options' ) )
               die('-1');

          check_ajax_referer('msi-social-share-links-action','socialicon_nonce');

          require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
          if(empty($_POST['post_types']))
               exit;
                 $menu_item_data= array(
                  'menu-item-title' => sanitize_text_field($_POST['post_types'][1]),
                  'menu-item-type' => 'custom',
                  'menu-item-object' => filter_var_array($_POST['post_types']),
                  'menu-item-url' => filter_var($_POST['post_types'][0], FILTER_SANITIZE_URL),
              );

                //Collect the items' IDs. 
                $item_ids = wp_update_nav_menu_item(0, 0, $menu_item_data );
        
               $menu_obj = get_post( $item_ids );
                               

               if ( ! empty( $menu_obj->ID ) ) {
                    $menu_obj = wp_setup_nav_menu_item( $menu_obj );
                   
                    $menu_obj->label = $menu_obj->post_title; 
                    $menu_obj->socialico ='socialicon';
                    $menu_items[] = $menu_obj;
               }

          //This gets the HTML to returns it to the menu
          if ( ! empty( $menu_items ) ) {
               $args = array(
                    'after' => '',
                    'before' => '',
                    'link_after' => '',
                    'link_before' => '',
                    'walker' => new Walker_Nav_Menu_Edit_Custom_Social_Icons,
                    'iconimage' => 'yes',
               );
               echo walk_nav_menu_tree( $menu_items, 0, (object) $args );
          }

          //Finally don't forget to exit
          exit;
     }


     public static function asi_setup_social_item($menu_item){
       
        $post_type = $menu_item->object;
        return $menu_item;
     }

     public function asi_current_item_social($items){

          foreach ($items as $item){
               if('custom' != $item->type)
                    continue;

        $post_type = $item->object;
        if(!is_post_type_archive($post_type)&& !is_singular($post_type))
                    continue;

        //Make item current
        $item->current = true;
        $item->classes[] = 'current-menu-item';

        //Get menu item's ancestors:
        $_anc_id = (int) $item->db_id;
        $active_ancestor_item_ids=array();

        while(( $_anc_id = get_post_meta( $_anc_id, '_menu_item_menu_item_parent', true ) ) &&
                ! in_array( $_anc_id, $active_ancestor_item_ids )  )
        {
                $active_ancestor_item_ids[] = $_anc_id;
        }

        //Loop through ancestors and give them 'ancestor' or 'parent' class
        foreach ($items as $key=>$parent_item){
                    $classes = (array) $parent_item->classes;

                    //If menu item is the parent
                    if ($parent_item->db_id == $item->menu_item_parent ) {
                         $classes[] = 'current-menu-parent';
                         $items[$key]->current_item_parent = true;
                    }

                    //If menu item is an ancestor
                    if ( in_array(  intval( $parent_item->db_id ), $active_ancestor_item_ids ) ) {
                         $classes[] = 'current-menu-ancestor';
                         $items[$key]->current_item_ancestor = true;
                    }

                    $items[$key]->classes = array_unique( $classes );
        }

          }
     return $items;
     }



}
(new ASI_Custom_Social_Type_Link())->asi_load_fun();
?>