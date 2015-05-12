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

if ( ! class_exists( 'WR_Submenu' ) ) :

/**
 * Widget element for WR MegaMenu.
 *
 * @since  1.0.0
 */
class WR_Submenu extends WR_Megamenu_Shortcode_Element {
	/**
	 * Constructor
	 *
	 * @return  void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Configure shortcode.
	 *
	 * @return  void
	 */
	function element_config() {
		$this->config['shortcode']   = strtolower( __CLASS__ );
		$this->config['name']        = __( 'Submenu', WR_MEGAMENU_TEXTDOMAIN );
		$this->config['cat']         = __( 'Menu', WR_MEGAMENU_TEXTDOMAIN );
		$this->config['icon']        = 'wr-icon-submenu';
		$this->config['description'] = __( 'MegaMenu which displays all sub items at once', WR_MEGAMENU_TEXTDOMAIN );
		// Use Ajax to speed up element settings modal loading speed
		$this->config['edit_using_ajax'] = true;
	}

	/**
	 * Define shortcode settings.
	 *
	 * @return  void
	 */
	function element_items() {

		$this->items = array(
			'content' => array(
				array(
					'name'      => __( 'Element Title', WR_MEGAMENU_TEXTDOMAIN ),
					'id'        => 'el_title',
					'type'      => 'text_field',
					'class'     => 'input-sm hidden',
					'showlabel' => '0',
					'std'       => __( '', WR_MEGAMENU_TEXTDOMAIN ),
					'role'      => 'title',
					'tooltip'   => __( 'Set title for current element for identifying easily', WR_MEGAMENU_TEXTDOMAIN )
				),
				array(
					'name'       => __( 'Select Submenu', WR_MEGAMENU_TEXTDOMAIN ),
					'id'         => 'select_submenu_type',
					'type'       => 'radio_group',
					'std'        => 'all',
					'options'    => array( 'all' => __( 'All', WR_MEGAMENU_TEXTDOMAIN ), 'custom' => __( 'Custom', WR_MEGAMENU_TEXTDOMAIN ) ),
					'has_depend' => '1',
				),

				array(
					'id'         => 'list_sub_menu',
					'type'       => 'list_submenu',
					'menu_id'    => @$_POST['menu_id'],
					'menu_type'  => @$_POST['menu_type'],
					'std'        => '',
					'dependency' => array( 'select_submenu_type', '=', 'custom' ),
				),

				array(
					'id'    => 'menu_id',
					'type'  => 'hidden',
					'class' => 'input-sm',
					'std'   => @$_POST['menu_id'],
				),
				array(
					'id'    => 'menu_type',
					'type'	=> 'hidden',
					'class' => 'input-sm',
					'std'	=> @$_POST['menu_type'],
				),
			),
			'appearance' => array(

				array(
					'name'    => __( 'Column breaking', WR_MEGAMENU_TEXTDOMAIN ),
					'id'      => 'column_breaking',
					'type'    => 'radio_group',
					'std'     => 'off',
					'class'   => '',
					'options' => array(
						'off'	           => __( 'Off', WR_MEGAMENU_TEXTDOMAIN ),
						'items_per_column' => __( 'Item Per Column', WR_MEGAMENU_TEXTDOMAIN ),
						'no_of_column'     => __( 'No of Column', WR_MEGAMENU_TEXTDOMAIN ),
					),
					'has_depend' => '1',
				),

				array(
					'name'      => __( '', WR_MEGAMENU_TEXTDOMAIN ),
					'id'        => 'items_per_column',
					'showlabel' => '0',
					'type'      => 'select',
					'class'     => 'input-sm',
					'std'		=> '3',
					'options'	=> array(
						'1'  => '1',
						'2'  => '2',
						'3'  => '3',
						'4'  => '4',
						'5'  => '5',
						'6'  => '6',
						'7'  => '7',
						'8'  => '8',
						'9'  => '9',
						'10' => '10',
					),
					'dependency' => array( 'column_breaking', '=', 'items_per_column' ),
				),
				array(
					'name'      => __( '', WR_MEGAMENU_TEXTDOMAIN ),
					'id'        => 'no_of_column',
					'showlabel' => '0',
					'type'      => 'select',
					'class'     => 'input-sm',
					'std'       => '2',
					'options'   => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5'  => '5',
						'6'  => '6',
						'7'  => '7',
						'8'  => '8',
						'9'  => '9',
						'10' => '10',
					),
					'dependency' => array( 'column_breaking', '=', 'no_of_column' ),
				),

			)
		);

	}

	/**
	 * Generate HTML code from shortcode content.
	 *
	 * @param   array   $atts	 Shortcode attributes.
	 * @param   string  $content  Current content.
	 *
	 * @return  string
	 */
	function element_shortcode_full( $atts = null, $content = null ) {
		$params = shortcode_atts( $this->config['params'], $atts );
		extract( $params );

		$menu_helper = new WR_Megamenu_Helpers_Menu();
		$menu_items  = array();

		if ( $select_submenu_type == 'all' ) {
			$menu_items = $menu_helper->get_menu_items( $menu_type, $menu_id, 99 );
		} elseif ( $select_submenu_type == 'custom' ) {
			$selected_menus = explode( '__#__', $list_sub_menu );

			if ( count( $selected_menus ) && ( $selected_menus[0] != '' ) ) {
				$menu_items = $selected_menus;
			} else {
				$menu_items = array();
			}
		}

		// Retrieve all menu items.
		$html          = array();
		$count         = count( $menu_items );
		$caption_class = '';
		
		if ( is_admin() ) {
			$caption_class = 'label label-default';
		}

		if ( $count ) {
			foreach ( $menu_items as $item ) {

				if ( is_object( $item ) ) {
					
					if ( $item->sub_level == '1' ) {
						$menu_item_id = $item->ID;
					} else {
						continue;
					}	
				} else {
					$menu_item_id = (int)$item;
				}
				
				// Check menu has icon
				$icon = get_post_meta( $menu_item_id, '_icon_mega_', true );
				
				if ( $icon ) {
					$icon_html = '<i class="' . $icon . '"></i>';
				} else {
					$icon_html = '';
				}
				
				$menu_item = get_post( $menu_item_id );
				// setup information for menu
				$menu_item = wp_setup_nav_menu_item( $menu_item );

				$class        = (is_admin()) ? 'submenu-items sub-menu' : 'submenu-items';
				$parent_class = apply_filters( 'wr_menu_item_caption', $menu_item->class, $menu_item );
				
				$menu_title = '';
				if ( isset( $menu_item->title ) ) {
					$menu_title = '<span class="ig-menu-title">' . $menu_item->title . '</span>';
				}

				$html[] = '<div class="block-sub-menu">';
				$html[] = '<a class="'.$parent_class.' caption" href="'.$menu_item->url.'" title="'.$menu_item->title.'"><span class="'.$caption_class.'">' . $icon_html . $menu_title . '</span></a>';
				$html[] = '<div class="clearfix"></div>';
				$html[] = '<span class="divider"></span>';

				$args     = array();
				$defaults = array( 'menu' => '', 'container' => 'div', 'container_class' => '', 'container_id' => '', 'menu_class' => 'menu', 'menu_id' => '', 'echo' => true, 'fallback_cb' => 'wp_page_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'depth' => 0, 'walker' => '', 'theme_location' => '' );
				
				$items = $menu_helper->get_menu_items( $menu_type, $menu_item_id, 99 );
				$args  = wp_parse_args( $args, $defaults );
				$args['count_items']      = count( $items );
				$args['class_submenu']    = $class;
				$args['column_breaking']  = $column_breaking;
				$args['no_of_column']     = $no_of_column;
				$args['items_per_column'] = $items_per_column;
                                
                $submenu_items_elment = $this->wr_walk_submenu_child( $items, 0, (object) $args );
                
                if( $submenu_items_elment ) {
                    $html[] = '<ul class="'.$class.' ">';
                    $html[] = $submenu_items_elment;
                    $html[] = '</ul>';
                }

				$html[] = '</div>';
			}
		} else {
			$html[] =	'<p class="jsn-bglabel">' . __( 'This menu does not have any sub menu item.', WR_MEGAMENU_TEXTDOMAIN )
				. ' <a class="preview-submenu" href="' . admin_url( 'nav-menus.php?action=edit&menu=' . $menu_type ) .'" target="_blank">' . __( 'Add new', WR_MEGAMENU_TEXTDOMAIN ) . '</a>'
				.'</p>';
		}
		
		if ( ! is_admin() ) {

			$html[] = "<script type='text/javascript'>( function ($) {
				$( document ).ready( function ()
				{
					 $('.block-sub-menu').each(function() {

						var _this = $(this);
						var submenu_items = _this.find('> .submenu-items');
						var count = submenu_items.length;

						if (count > 0) {
							var width = 100/count + '%';
							submenu_items.css('width', width);
						}

					 })
				});
			} )( jQuery )</script>";

		}

		return $this->element_wrapper( implode( "\n", $html ), $params );

	}

	function wr_walk_submenu_child( ) {
		$args   = func_get_args();
		$walker = new WR_Walker_SubMenu;
		return call_user_func_array( array( &$walker, 'walk' ), $args );
	}

}

class WR_Walker_SubMenu extends Walker_Nav_Menu {
	var $count = 1;
	var $count_row = 0;
    var $check_insert_break = FALSE;
    var $count_items = NULL;
    var $current_parentid = NULL;


    function wr_count_item( $id_parentid ){
    	global $wpdb;
    	$this->count_items = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->postmeta WHERE meta_key = '_menu_item_menu_item_parent' AND meta_value = $id_parentid " );
    }

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            
		$indent      = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
                
                if ( $this->check_insert_break && $item->sub_level == 1 ) {
                    $output .= '</ul><ul class="'.$args->class_submenu.'" >';
                    $this->check_insert_break = FALSE;
                }
                
		if ( $args->column_breaking != 'off' ) {	


			if($item->sub_level == 1 && $this->current_parentid != $item->menu_item_parent ){

				$this->current_parentid = $item->menu_item_parent;

				global $wpdb;
    			$this->count_items = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->postmeta WHERE meta_key = '_menu_item_menu_item_parent' AND meta_value = $item->menu_item_parent " );

			}


			if ( $depth == 0 ) {
				if ( $args->column_breaking == 'no_of_column' ) {
					$args->items_per_column = ceil( ( $this->count_items / $args->no_of_column ) );
                    $surplus = $this->count_items % $args->no_of_column;
                    if ( $this->count < $this->count_items){
                        if( ($this->count % $args->items_per_column) == 0 && ( $this->count < ($surplus * $args->items_per_column)  || $surplus == 0 ) ){
                            $this->check_insert_break = TRUE;
                        } elseif ( $surplus != 0 &&  ( ( $this->count - ( $args->items_per_column * $surplus ) )  % ( $args->items_per_column - 1 ) ) == 0 && $this->count >= ( $surplus * $args->items_per_column ) ) {
                            $this->check_insert_break = TRUE;
                        }
                    }
	            } else if ( $args->column_breaking == 'items_per_column' ) {
                    if ( $this->count_row == 0 ) {
					} else if ( ( $args->items_per_column == 1) || ( ( $this->count_row % $args->items_per_column ) == 0 ) ){
						$output .= '</ul><ul class="'.$args->class_submenu.'" >';
					}
	            }
            }
            
            if($item->sub_level == 1){
            	$this->count++;
            	$this->count_row++;
            }

		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';


		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output  = $args->before;
		$item_output .= '<a'. $attributes .'>';
		/** This filter is documented in wp-includes/post-template.php */
		if ( isset( $item->icon ) && $item->icon != '' ) {
			$item_output .= ' <i class="'.$item->icon.'"></i>';
		};
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}
	
}


endif;
