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

class WR_Megamenu_Helpers_Html_Select_Submenu extends WR_Megamenu_Helpers_Html {
	/**
	 * Simple Input text
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {

		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		$selected_value = $element['std'];

		$menu_helper = new WR_Megamenu_Helpers_Menu();
		$menu_items  = $menu_helper->get_menu_items( (int) $element['menu_type'], (int) $element['menu_id'], 99 );
		$output      = '';
		
		if ( count( $menu_items ) ) {
			$multiple = ( isset( $element['multiple'] ) ) ? 'multiple="multiple"' : '';
			// Add default select2 for all select html type
			$element['class'] .= ' select2-select';
			$element['class']  = str_replace( 'form-control', '', $element['class'] );

			$output .= "<select class='{$element['class']}' id='{$element['id']}' name='{$element['id']}' {$multiple}>\n";
			$output .= self::walk_dropdown_submenu_tree( $menu_items, 0, array() ,$selected_value );
			$output .= "</select>\n";
		} else {
			$output .= '<div class="alert alert-warning">'.__( 'This menu don\'t have any sub menus', WR_MEGAMENU_TEXTDOMAIN ).'</div>';
		}

		return parent::final_element( $element, $output, $label );
	}

	static function walk_dropdown_submenu_tree( ) {
		$args = func_get_args();
		//$args = array( $items, $depth, $r );
		$walker = new WR_Walker_Submenus_Dropdown;

		return call_user_func_array( array( &$walker, 'walk' ), $args );

	}

}

/**
 * Create HTML dropdown list of Submenus.
 * @uses Walker
 */
class WR_Walker_Submenus_Dropdown extends Walker {

	var $tree_type = array( WR_MEGAMENU_POST_TYPE_NAME );

	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );


	function start_el( &$output, $menu, $depth = 0, $args = array(), $id = 0 ) {

		if ( $depth ) {
			$indent = str_repeat( '&#8211;', $depth ) . ' ';
		} else {
			$indent = '';
		}

		$output .= "\t<option class=\"level-$depth\" value=\"" . $menu->ID . '"';

		$selected = ( $menu->ID == $id ) ? 'selected' : '';
		$output  .= $selected . '>';
		$output  .= $indent . $menu->title;

		$output .= "</option>\n";
	}
}
