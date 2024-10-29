<?php
/**
 *  /!\ This is a copy of Walker_Nav_Menu_Edit class in core
 * 
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class Walker_Nav_Menu_Edit_Custom_Social_Icons extends Walker_Nav_Menu  {
	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function start_lvl(&$output, $depth = 0, $args = array()) {	
	}
	
	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function end_lvl(&$output, $depth = 0, $args = array()) {
	}
	
	/*function end_el(&$output, $category, $depth = 0, $args = array()){
	}*/
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
	    global $_wp_nav_menu_max_depth;
	   
	    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
	
	    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		ob_start();
	    $item_id = esc_attr( $item->ID );
	    $removed_args = array(
	        'action',
	        'customlink-tab',
	        'edit-menu-item',
	        'menu-item',
	        'page-tab',
	        '_wpnonce',
	    );
		

	    $original_title = '';
	    if ( 'taxonomy' == $item->type ) {
	        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
	        if ( is_wp_error( $original_title ) )
	            $original_title = false;
	    } elseif ( 'post_type' == $item->type ) {
	        $original_object = get_post( $item->object_id );
	        //print_r($original_object);
	        $original_title = $original_object->post_title;
	    }
		 
        if(isset($_GET['edit-menu-item']) && null!== filter_var($_GET['edit-menu-item'], FILTER_VALIDATE_INT) && $item_id == filter_var($_GET['edit-menu-item'], FILTER_VALIDATE_INT)){
         	$activeina = 'active';
        }
        else{
         	$activeina = 'inactive';
        }

				
	    $classes = array(
	        'menu-item menu-item-depth-' . $depth,
	        'menu-item-' . esc_attr( $item->object ),
	        'menu-item-edit-' . $activeina,
	    );
	
	    $title = $item->title;
	
	    if ( ! empty( $item->_invalid ) ) {
	        $classes[] = 'menu-item-invalid';
	        /* translators: %s: title of menu item which is invalid */
	        $title = sprintf( __( '%s (Invalid)' ), $item->title );
	    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
	        $classes[] = 'pending';
	        /* translators: %s: title of menu item in draft status */
	        $title = sprintf( __('%s (Pending)'), $item->title );
	    }
	
	    $title = empty( $item->label ) ? $title : $item->label;
	
	    ?>
	    <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
	        <div class="menu-item-bar">
	            <div class="menu-item-handle">
					<label class="item-title" for="menu-item-checkbox-<?php echo $item_id; ?>">	
					<input id="menu-item-checkbox-<?php echo $item_id; ?>" type="checkbox" class="menu-item-checkbox" data-menu-item-id="<?php echo $item_id; ?>" disabled="">
	                <span class="menu-item-title"><?php echo esc_html( $title ); ?></span></label>
	                <span class="item-controls">
	                    <span class="item-type">
	                    	<?php 
	                    	if( 'custom' == $item->type && 'socialico'== $item->msisoicon || 'socialicon' == $item->socialico ){
	                    		echo _e("Social Icon");
	                    	}
	                    	else{
	                    		echo esc_html( $item->type_label );
	                    	} 
	                    ?>
	                    </span>
	                    <span class="item-order hide-if-js">
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                add_query_arg(
	                                    array(
	                                        'action' => 'move-up-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                ),
	                                'move-menu_item'
	                            );
	                        ?>
	                        " class="item-move-up" aria-label="<?php esc_attr_e( 'Move up' ); ?>">&#8593;</a>
	                        |
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                add_query_arg(
	                                    array(
	                                        'action' => 'move-down-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                ),
	                                'move-menu_item'
	                            );
	                        ?>
	                        " class="item-move-down" aria-label="<?php esc_attr_e( 'Move down' ); ?>">&#8595;</a>
	                    </span>
	                    <?php 
	                     if(isset($_GET['edit-menu-item']) && null!== filter_var($_GET['edit-menu-item'], FILTER_VALIDATE_INT) && $item_id == filter_var($_GET['edit-menu-item'], FILTER_VALIDATE_INT)){
	                     	$geturl = admin_url( 'nav-menus.php' );
	                     }
	                     else{
	                     	$geturl = add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
	                     }

						?>
	                    <a class="item-edit" id="edit-<?php echo $item_id; ?>" href="<?php echo $geturl; ?>" aria-label="<?php esc_attr_e( 'Edit menu item' ); ?>"><span class="screen-reader-text"><?php _e( 'Edit' ); ?></span></a>
	                </span>
	            </div>
	        </div>
	
	        <div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo $item_id; ?>">
	            <?php if( 'custom' == $item->type ) : ?>
	                <p class="field-url description description-wide">
	                    <label for="edit-menu-item-url-<?php echo $item_id; ?>">
	                        <?php _e( 'URL' ); ?><br />
	                        <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
	                    </label>
	                </p>
	            <?php endif; ?>
	            <p class="description description-thin">
	                <label for="edit-menu-item-title-<?php echo $item_id; ?>">
	                    <?php _e( 'Navigation Label' ); ?><br />
	                    <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
	                </label>
	            </p>
	            <p class="description description-thin">
	                <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
	                    <?php _e( 'Title Attribute' ); ?><br />
	                    <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
	                </label>
	            </p>
	            <p class="field-link-target description">
	                <label for="edit-menu-item-target-<?php echo $item_id; ?>">
	                    <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
	                    <?php _e( 'Open link in a new window/tab' ); ?>
	                </label>
	            </p>
	            <p class="field-css-classes description description-thin">
	                <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
	                    <?php _e( 'CSS Classes (optional)' ); ?><br />
	                    <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
	                </label>
	            </p>
	            <p class="field-xfn description description-thin">
	                <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
	                    <?php _e( 'Link Relationship (XFN)' ); ?><br />
	                    <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
	                </label>
	            </p>
	            <p class="field-description description description-wide">
	                <label for="edit-menu-item-description-<?php echo $item_id; ?>">
	                    <?php _e( 'Description' ); ?><br />
	                    <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
	                    <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.'); ?></span>
	                </label>
	            </p>        
	            <?php
	            /* New fields insertion starts here */
	            ?>      
	            <?php 
	            
	            if( 'custom' == $item->type && 'socialico'== $item->msisoicon || 'socialicon' == $item->socialico ) :
	            ?>
	            <p class="field-custom description description-wide">
	                <label for="edit-menu-item-subtitle-<?php echo $item_id; ?>">
	                    <?php _e( 'Add Icon' ); ?><br />
	                    <input type="button" id="<?php echo $item_id; ?>" class="button gwts-gwl-imgupload" value="Choose Icon">
	                    <div id ="gwts-gwl-sortableitem-<?php echo $item_id; ?>" class="image-preview">	                    	
	                    </div>
	                    <?php if(!empty($item->subtitle)) {?>
	                    <div class="msi-uplodimg msi-view-upload-icn-<?php echo $item_id; ?>">
	                    	<img src="<?php echo esc_attr( $item->subtitle ); ?>">
	                    </div>
	                    <?php } ?>
	                    <input type="hidden" id="edit-menu-item-subtitle-<?php echo $item_id; ?>" class="widefat code edit-menu-item-custom-icn" name="menu-item-subtitle[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->subtitle ); ?>" />
	                    <input type="hidden" id="edit-menu-item-socialicn-<?php echo $item_id; ?>" name="menu-item-socialicn[<?php echo $item_id; ?>]" value="socialico" />
	                </label>
	            </p>
	            <!-- icon size -->
	             <p class="field-custom description description-wide">
	                <label for="edit-menu-item-iconsize-<?php echo $item_id; ?>">
	                    <?php _e( 'Choose Icon Size' ); ?><br />
	                    <select name="menu-item-iconsize[<?php echo $item_id; ?>]" id="<?php echo $item_id; ?>" class="slect-menu-item-size">
	                    	<?php echo $item->iconsize; ?>
	                    	<option value="16" <?php if( $item->iconsize == 16 ){ echo 'selected="selected"';} ?>>16 × 16</option>
	                    	<option value="24" <?php if( $item->iconsize == 24 ){ echo 'selected="selected"';} ?>>24 × 24</option>
	                    	<option value="32" <?php if( $item->iconsize == 32 ){ echo 'selected="selected"';} ?>>32 × 32</option>
	                    	<option value="48" <?php if( $item->iconsize == 48 ){ echo 'selected="selected"';} ?>>48 × 48</option>
	                    	<option value="92" <?php if( $item->iconsize == 92 ){ echo 'selected="selected"';} ?>>92 × 92</option>
	                    	<option value="other" <?php if( $item->iconsize == 'other' ){ echo 'selected="selected"';} ?>>Other</option>
	                    </select> <span>px</span>
	                    <div class="msi-width-n-height" id="menu-item-iconsize-<?php echo $item_id; ?>" <?php if( $item->iconsize != 'other' ){ echo 'style="display: none;"';} ?>>
	                    	<span>Width: </span><input type="number" value="<?php echo $item->customwid; ?>" name="menu-item-custom-width-size[<?php echo $item_id; ?>]" min="1" max="500" onKeyPress="if(this.value.length==3) return false;" />

	                    	<span> Height: </span><input maxlength="3" size="3" type="number" value="<?php echo $item->customhei; ?>" name="menu-item-custom-height-size[<?php echo $item_id; ?>]" min="1" max="500" onKeyPress="if(this.value.length==3) return false;" /><span>px</span>
	                    </div>
	                </label>
	            </p>

	            <?php
	        	endif;
	            /* New fields insertion ends here */
	            ?>
	            <fieldset class="field-move hide-if-no-js description description-wide">
					<span class="field-move-visual-label" aria-hidden="true"><?php _e( 'Move' ); ?></span>
					<button type="button" class="button-link menus-move menus-move-up" data-dir="up"><?php _e( 'Up one' ); ?></button>
					<button type="button" class="button-link menus-move menus-move-down" data-dir="down"><?php _e( 'Down one' ); ?></button>
					<button type="button" class="button-link menus-move menus-move-left" data-dir="left"></button>
					<button type="button" class="button-link menus-move menus-move-right" data-dir="right"></button>
					<button type="button" class="button-link menus-move menus-move-top" data-dir="top"><?php _e( 'To the top' ); ?></button>
				</fieldset>

	            <div class="menu-item-actions description-wide submitbox">
	                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
	                    <p class="link-to-original">
	                        <?php printf( __('Original: %s'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
	                    </p>
	                <?php endif; ?>
	                <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
	                echo wp_nonce_url(
	                    add_query_arg(
	                        array(
	                            'action' => 'delete-menu-item',
	                            'menu-item' => $item_id,
	                        ),
	                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                    ),
	                    'delete-menu_item_' . $item_id
	                ); ?>"><?php _e('Remove'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
	                    ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel'); ?></a>
	            </div>
	
	            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
	            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
	            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
	            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
	            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
	            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
	        </div><!-- .menu-item-settings-->
	        <ul class="menu-item-transport"></ul>
	    <?php
	    
	    $output .= ob_get_clean();

	}
}