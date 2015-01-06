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

class WR_Megamenu_Helpers_Html_Gradient_Picker extends WR_Megamenu_Helpers_Html {
	/**
	 * gradient picker
	 * @param type $element
	 */
	static function render( $element ){
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		$output  = "<input type='hidden' class='jsn-grad-ex' id='{$element['id']}' name='{$element['id']}' value='{$element['std']}'  DATA_INFO />";
		$output .= "<div class='classy-gradient-box'></div>";

		add_filter( 'wr-mm-edit-element-required-assets', array( __CLASS__, 'enqueue_assets_modal' ) );

		return parent::final_element( $element, $output, $label );
	}

	/**
     * Enqueue gradient assets
     *
     * @param array $scripts
     * @return array
     */
	static function enqueue_assets_modal( $scripts ){
		$scripts = array_merge( $scripts, array( 'wr-classygradient-js', 'wr-classygradient-css', ) );

		return $scripts;
	}
}