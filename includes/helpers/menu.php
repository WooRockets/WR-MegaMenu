<?php
/**
 * @version    $Id$
 * @package    WR MegaMenu
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 * Technical Support:  Feedback - http://www.woorockets.com
 */

class WR_Megamenu_Helpers_Menu {
	
	public $default_setting = array();
	
	public function get_default_setting()
	{
		$this->default_setting = array(
			'megamenu_type'           => 'submenu', // posible values: submenu,widget
			'container_width'         => '',
			'full_width_value'        => '0',
			'widget_container_width'  => '',
			'widget_full_width_value' => '0',
			'content_column'          => '3',
			'submenu_start_level'     => '3',
		);
		return $this->default_setting;
	}

	/**
	 * Get children menu items
	 * @param string $menu
	 * @param string $location
	 * @param int $depth
	 * @param init $parent_id
	 * @return array $extracted_items
	 */
	public function get_menu_items( $menu, $parent_id = 0, $depth = 1 ) {
		$menu_items      = wp_get_nav_menu_items( $menu );
		$extracted_items = array();
		
		if ( $menu_items ) {
			$parents_set = array();
			$i		     = 0;
			
			foreach ( $menu_items as $item ) {
				if ( ! $parent_id ) {
					if ( $depth == 1 ) {
						
						// Get only the 1st level items
						if ( ! $item->menu_item_parent ) {
							array_push( $extracted_items, $item );
						}
					} else {

					}
				} else {
					// Get all submenu items of parent.
					$lv = 0;
					if ( $item->menu_item_parent == $parent_id || in_array( $item->menu_item_parent, $parents_set ) ) {
						if ( $item->menu_item_parent == $parent_id ) {
							$parents_set[ 0 ] = $parent_id;
						}

						// Push current item id to parents list
						// used for calculating menuitem level
						// and get children menu items without recursiving.
						$sub_level					 = array_search( $item->menu_item_parent, $parents_set );
						$parents_set[ $sub_level + 1 ] = $item->ID;

						// Set level for current menu item.
						$item->sub_level = $sub_level + 1;

						// Place current item in the list.
						if ( $sub_level < $depth ) {
							array_push( $extracted_items, $item );
						}

						$lv++;
					}
				}
			}
		}

		return $extracted_items;
	}

}