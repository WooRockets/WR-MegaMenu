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

class WR_Megamenu_Helpers_Html_Text_Area extends WR_Megamenu_Helpers_Html {
	/**
	 * Textarea option
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label = parent::get_label( $element );
		$element['row'] = ( isset( $element['row'] ) ) ? $element['row'] : '8';
		$element['col'] = ( isset( $element['col'] ) ) ? $element['col'] : '50';
		if ( $element['exclude_quote'] == '1' ) {
			$element['std'] = str_replace( '<wr_quote>', '"', $element['std'] );
		}
		$output = "<textarea class='{$element['class']}' id='{$element['id']}' rows='{$element['row']}' cols='{$element['col']}' name='{$element['id']}' DATA_INFO>{$element['std']}</textarea>";

		return parent::final_element( $element, $output, $label );
	}
}