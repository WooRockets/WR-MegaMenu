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

class WR_Megamenu_Element {

	private $wr_elements = array();

	public function init() {
		// Initialize built-in shortcodes
		include 'shortcode.php';

		$this->register_element();
		add_action( 'admin_footer', array( &$this, 'element_tpl' ) );
	}

	/**
	 * Get array of shortcode elements
	 * @return type
	 */
	function get_elements() {
		return $this->wr_elements;
	}

	/**
	 * Add shortcode element
	 * @param type $type: type of element ( element/layout )
	 * @param type $class: name of class
	 * @param type $element: instance of class
	 */
	function set_element( $type, $class, $element = null ) {
		if ( empty( $element ) )
			$this->wr_elements[$type][strtolower( $class )] = new $class();
		else
			$this->wr_elements[$type][strtolower( $class )] = $element;
	}

	/**
	 * Register all Parent & No-child element, for Add Element popover
	 */
	function register_element() {

		global $wr_megamenu_shortcodes;
		$current_shortcode      = WR_Megamenu_Helpers_Functions::current_shortcode();
		$wr_megamenu_shortcodes = ! empty ( $wr_megamenu_shortcodes ) ? $wr_megamenu_shortcodes : WR_Megamenu_Helpers_Shortcode::wr_mm_shortcode_tags();
		foreach ( $wr_megamenu_shortcodes as $name => $sc_info ) {
			$arr  = explode( '_', $name );
			$type = $sc_info['type'];
			if ( ! $current_shortcode || ! is_admin() || in_array( $current_shortcode, $arr ) || ( ! $current_shortcode && $type == 'layout' ) ) {
				$class   = WR_Megamenu_Helpers_Shortcode::get_shortcode_class( $name );
				$element = new $class();
				$this->set_element( $type, $class, $element );
				$this->register_sub_el( $class, 1 );
			}
		}

	}

	/**
	 * print HTML template of shortcodes
	 */
	function element_tpl() {

		global $post_type ;

		if ( $post_type == 'wr_megamenu_profile' ) {
			ob_start();

			// Print template for WR MegaMenu elements
			$elements = $this->get_elements();

			foreach ( $elements as $type_list ) {
				foreach ( $type_list as $element ) {
					// Get element type
					$element_type = $element->element_in_megamenu();

					// Print template tag
					foreach ( $element_type as $element_structure ) {
						echo balanceTags( "<script type='text/html' id='tmpl-{$element->config['shortcode']}'>\n{$element_structure}\n</script>\n" );
					}
				}
			}

			// Print widget template
			global $wr_megamenu_widgets;

			if ( class_exists( 'WR_Megamenu_Widget' ) ) {
				foreach ( $wr_megamenu_widgets as $shortcode => $shortcode_obj ) {
					// Instantiate Widget element
					$element = new WR_Megamenu_Widget();

					// Prepare necessary variables
					$modal_title = $shortcode_obj['identity_name'];
					$content     = $element->config['exception']['data-modal-title'] = $modal_title;

					$element->config['shortcode']		   = $shortcode;
					$element->config['shortcode_structure'] = WR_Megamenu_Helpers_Placeholder::add_placeholder( "[wr_megamenu_widget widget_id=\"$shortcode\"]%s[/wr_megamenu_widget]", 'widget_title' );
					$element->config['el_type']			 = 'widget';

					// Get element type
					$element_type = $element->element_in_megamenu( $content );

					// Print template tag
					foreach ( $element_type as $element_structure ) {
						echo balanceTags( "<script type='text/html' id='tmpl-{$shortcode}'>\n{$element_structure}\n</script>\n" );
					}
				}
			}

			// Allow printing extra footer
			do_action( 'wr_mm_footer' );

			ob_end_flush();
		}

	}

	/**
	 * Regiter sub element
	 *
	 * @param string $class
	 * @param int $level
	 */
	private function register_sub_el( $class, $level = 1 ) {
		$item  = str_repeat( 'Item_', intval( $level ) - 1 );
		$class = str_replace( "WR_$item", "WR_Item_$item", $class );
		if ( class_exists( $class ) ) {
			// 1st level sub item
			$element = new $class();
			$this->set_element( 'element', $class, $element );
			// 2rd level sub item
			$this->register_sub_el( $class, 2 );
		}
	}
} 