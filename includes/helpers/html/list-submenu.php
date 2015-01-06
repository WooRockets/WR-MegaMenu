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

class WR_Megamenu_Helpers_Html_List_Submenu extends WR_Megamenu_Helpers_Html
{
	/**
	 * Simple Input text
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );

		$element['std'] = explode( '__#__', $element['std'] );

		$menu_helper = new WR_Megamenu_Helpers_Menu();
		$menu_items  = $menu_helper->get_menu_items( (int) $element['menu_type'], (int) $element['menu_id'], 99 );
		$output	     = '';
		if ( count( $menu_items ) ) {
			$output .= "<ul class='wrap_submenu' id='{$element['id']}'>\n";
			$output .= self::walk_list_submenu_tree( $menu_items, 0, array( 'element_id' => $element['id'] ), (array) $element['std'] );
			$output .= "</ul>\n";

		} else {
			$output .= '<div class="alert alert-warning">' . __( 'This menu don\'t have any sub menus', WR_MEGAMENU_TEXTDOMAIN ) . '</div>';
		}

		$output .= "<script type='text/javascript'>( function ($) {
			$( document ).ready( function ()
			{

			   load_el_submenu();

				$( '.wrap_submenu > li' ).on( 'click', function() {
					var _this = $(this),
					input_checkbox = _this.find( 'input[type=\"checkbox\"]' ).first();
					_this.toggleClass( 'active' );

					if (_this.hasClass( 'active' ) ) {
						input_checkbox.attr( 'checked', true);
					} else {
						input_checkbox.attr( 'checked', false);
					}

					load_el_submenu();

					input_checkbox.trigger( 'change' );
				});

				function load_el_submenu() {

					var sub_menus = [];
					var select_submenus = null;

				   $( 'input[name^=\"param-select_submenu_type\"]' ).each (function() {
						if($(this).is( ':checked' ) ) {
							select_submenus = $(this).val();
						}
				   });


					$( '.wrap_submenu > li' ).each(function() {
						 var _this = $(this),
						 is_checked = false,
						 input_checkbox = _this.find( 'input[type=\"checkbox\"]' ).first(),
						 text = input_checkbox.next( 'label' ).first().text(),
						 key =  ' ' + $.trim(text.split( ' ' ).join( '_' ).toLowerCase() );

						 if ( (select_submenus == 'custom' ) ) {
							if (input_checkbox.is( ':checked' ) ) {
								is_checked = true;
							} else {
								is_checked = false;
							}
						 } else if (select_submenus == 'all' ) {
							is_checked = true;
						 }
						 if (is_checked)  {
							sub_menus[key] = text;
						 }
				   });

					sub_el_title(sub_menus);
				}

				function sub_el_title (sub_menus) {

					var el_title = '';
					for (var i in sub_menus) {
						 el_title += ', ' + sub_menus[i];
					}
					el_title = $.trim(el_title, ',' );
					el_title = el_title.substring(1, el_title.length);

					$( '#param-el_title' ).val(el_title);
				}

			});
			} )( jQuery )</script>";

		return parent::final_element( $element, $output, $label );
	}


	static function walk_list_submenu_tree() {
		$args = func_get_args();
		//$args = array( $items, $depth, $r );
		$walker = new WR_Walker_Submenus_List;

		return call_user_func_array( array( &$walker, 'walk' ), $args );
	}

}

/**
 * Create HTML dropdown list of Submenus.
 * @uses Walker
 */
class WR_Walker_Submenus_List extends Walker
{

	var $tree_type = array( WR_MEGAMENU_POST_TYPE_NAME );

	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );


	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker:start_lvl()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category. Used for tab indentation.
	 * @param array $args An array of arguments. @see wp_terms_checklist()
	 */
	function start_lvl( &$output, $depth = 0, $args = array() )
	{
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent<ul class='children'>\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category. Used for tab indentation.
	 * @param array $args An array of arguments. @see wp_terms_checklist()
	 */
	function end_lvl( &$output, $depth = 0, $args = array() )
	{
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	function start_el( &$output, $menu, $depth = 0, $args = array(), $ids = array() )
	{
		if ( $depth ) {
			$indent = str_repeat( '<span class="space"></span>', $depth );
		} else {
			$indent = '';
		}
		$output .= "\n<li class=\"level-$depth " . ( ( in_array( $menu->ID, $ids ) ) ? 'active' : '' ) . ( ( $depth > 0 ) ? 'disabled' : '' ) . '" data-menu="' . $menu->ID . '">';
		if ($depth == 0) $output .= '<input value="' . $menu->ID . '" type="checkbox" name="' . $args['element_id'] . '" id="' . $args['element_id'] . '" class="hidden" ' . checked( in_array( $menu->ID, $ids ), true, false ) . ' /> <label class="selectit">';
		
		$output .= $indent . ' ';
		
		// Check sub-menu has icon
		$icon = get_post_meta( $menu->ID, '_icon_mega_', true );
		
		if ( $icon ) {
			$output .= '<i class="' . $icon . '"></i>';
		}
		
		$output .= esc_html( apply_filters( 'wr_menu_title', $menu->title ) );
		
		if ($depth == 0) $output .= '</label>';

	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $category The current term object.
	 * @param int $depth Depth of the term in reference to parents. Default 0.
	 * @param array $args An array of arguments. @see wp_terms_checklist()
	 */
	function end_el( &$output, $category, $depth = 0, $args = array() )
	{
		$output .= "</li>\n";
	}
}