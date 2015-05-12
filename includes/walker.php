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

class WR_Megamenu_Walker extends Walker_Nav_Menu {

	private $mega_wrapper_width = '100%';

	private $style = '';

	private $is_mega = false;

	/**
     * Starts the list before the elements are added.
     * @see Walker::start_lvl()
     * @since 3.0.0
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of arguments. @see wp_nav_menu()
     */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( $depth == 0 ) {
			if ( $this->is_mega ) {
				$output .= '';
			} else {
				$output .= '<ul class="sub-menu sub-menu-' . ( $depth + 1 ) . '" ' . $this->style . '>';
			}
		} else if ( $this->is_mega ) {
			$output .= '';
		} else {
			$output .= '<ul class="sub-menu sub-menu-' . ( $depth ) . '">';
		}
	}

	/**
     * Ends the list of after the elements are added.
     * @see Walker::end_lvl()
     * @since 3.0.0
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of arguments. @see wp_nav_menu()
     */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( $depth == 0 ) {
			if ( $this->is_mega ) {
				$output .= '';
			} else {
				$output .= '</ul>';
			}
		} else if ( $this->is_mega ) {
			$output .= '';
		} else {
			$output .= '</ul>';
		}
	}

	/**
	 * Starting build menu element
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$el_styles  = array();
		$item_output = '<a href="' . $item->url . '" class="menu-item-link">';
	
		if ( isset( $item->icon ) && $item->icon != '' ) {
			$item_output .= ' <i class="'.$item->icon.'"></i>';
		};
	
		$item_output .= '<span class="menu_title">' .$item->title . '</span></a>';
	
		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'wr-megamenu-item';
		$classes[] = 'level-' . $depth;
	
		$data = WR_Megamenu_Helpers_Builder::get_megamenu_data( $args->profile_id, $item->ID );
	
		if ( $depth == 0 ) {
			if ( count( $data ) && ( $data['is_mega'] == 'true' ) ) {
				$this->is_mega = true;
				$classes[]     = 'mega-item';
				$settings      = $data['setting_menu'];
	
				if ( isset( $settings['full_width_value'] ) && $settings['full_width_value'] == '1' ) {
					// min width
					$this->mega_wrapper_width = '100%;';
					$el_styles[] = 'position:static !important';
				} else {
					$this->mega_wrapper_width = @$settings['container_width'] ? $settings['container_width'] . 'px' : '100%';
					$classes[]				= 'wr-megamenu-fixed';
				}
	
				$this->style = 'style="width:' . $this->mega_wrapper_width . '; left:0;"';
	
				if ( $this->is_mega ) {
					$item_output .= '<div class="wr-megamenu-inner" ' . $this->style . ' data-container="'.$this->mega_wrapper_width.'">';
					$shortcode_content = urldecode( $data['shortcode_content'] );
					if ( ! empty( $shortcode_content ) ) {
	
						$shortcode_content = preg_replace_callback( '/\[wr_megamenu_widget\s+([A-Za-z0-9_-]+=\"[^"\']*\"\s*)*\s*\](.*)\[\/wr_megamenu_widget\]/Us', array( 'WR_Megamenu_Helpers_Shortcode', 'widget_content' ), $shortcode_content );
						$item_output       .= do_shortcode( $shortcode_content );
					}
					$item_output .= '</div>';
				}
			} else {
				$classes[] = 'menu-default';
				$this->is_mega			= false;
				$this->style			  = '';
				$this->mega_wrapper_width = 'auto';
			}
		}
		// Generate class and style attribute
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
	
		$el_styles = $el_styles ? ' style="' . esc_attr( join( ';', $el_styles ) ) . '"' : '';
	
		if ( $depth != 0 && $this->is_mega ) {
			$output    .= '';
			$item_output = '';
		} else {
			$output .= '<li ' . $class_names . ' ' . $el_styles . '>';
		}
	
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the list of after the elements are added.
	 * @see Walker::end_lvl()
	 * @since 3.0.0
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param array $args An array of arguments. @see wp_nav_menu()
	 */
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( $depth != 0 && $this->is_mega ) {
			$output .= '';
		} else {
			$output .= '</li>';
		}
	}

}