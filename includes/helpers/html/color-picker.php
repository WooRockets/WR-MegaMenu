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

class WR_Megamenu_Helpers_Html_Color_Picker extends WR_Megamenu_Helpers_Html {
	/**
	 * Color picker
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element  = parent::get_extra_info( $element );
		$label    = parent::get_label( $element );
		$bg_color = ( $element['std'] ) ? $element['std'] : '#000';
		$wrap_color_class = ( isset($element['wrap_color_class']) ) ? $element['wrap_color_class'] : '';
		$_hidden  = ( isset( $element['hide_value'] ) && $element['hide_value'] == false ) ? 'type="text"' : 'type="hidden"';
		$output   = '<input ' . $_hidden . " size='10' id='{$element['id']}' class='input-mini' disabled='disabled' name='{$element['id']}' value='{$element['std']}'  DATA_INFO />";
		$output  .= "<div id='color-picker-{$element['id']}' class='color-selector {$wrap_color_class}'><div style='background-color: {$bg_color}'></div></div>";

		//$output = "<input class='{$element['class']} wr_color_picker' id='{$element['id']}' name='{$element['id']}' type='text' value='{$element['std']}'  DATA_INFO />
		//<div class='cw-color-picker wr_color_picker_cw' rel='{$element['id']}'></div>";

		add_filter( 'wr-mm-edit-element-required-assets', array( __CLASS__, 'enqueue_assets_modal' ) );

		return parent::final_element( $element, $output, $label );
	}

	/**
     * Enqueue color picker assets
     *
     * @param array $scripts
     * @return array
     */
	static function enqueue_assets_modal( $scripts ){
		$scripts = array_merge( $scripts, array( 'wr-colorpicker-js', 'wr-colorpicker-css', ) );

		return $scripts;
	}
}