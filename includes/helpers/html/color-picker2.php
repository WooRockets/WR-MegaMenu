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

class WR_Megamenu_Helpers_Html_Color_Picker2 extends WR_Megamenu_Helpers_Html {
	/**
	 * Color picker
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element          = parent::get_extra_info( $element );
		$label	          = parent::get_label( $element );
		$bg_color         = ( $element['std'] ) ? $element['std'] : '#000';
		$wrap_color_class = ( isset($element['wrap_color_class']) ) ? $element['wrap_color_class'] : '';
		$_hidden          = ( ! isset( $element['hide_value']) || ( isset( $element['hide_value'] ) && $element['hide_value'] == false ) ) ? 'type="text"' : 'type="hidden"';
		
		$output = "<div class='color-selector input-group {$wrap_color_class}' id='color-picker-{$element['id']}'>
						<input {$_hidden} size='10' class='input-small {$element['class']}' id='{$element['id']}' name='{$element['id']}' value='{$element['std']}'  DATA_INFO />
						<span class='input-group-btn'>
							<a href='javascript:void(0);' class='btn btn-default btn-sm' title=''>...</a>
						</span>
					</div>";

		if ( ! WR_Megamenu_Helpers_Functions::is_modal() ) {
			WR_Megamenu_Init_Assets::load( array( 'wr-colpick-js', 'wr-colpick-css' ) );
		} else {
			add_filter( 'wr_mm_assets_enqueue_modal', array( __CLASS__, 'enqueue_assets_color' ) );
		}

		return parent::final_element( $element, $output, $label );
	}

	/**
	 * Enqueue color picker assets
	 *
	 * @param array $scripts
	 * @return array
	 */
	static function enqueue_assets_color( $scripts ){
		$scripts = array_merge( $scripts, array( 'wr-colpick-js', 'wr-colpick-css', ) );

		return $scripts;
	}
}