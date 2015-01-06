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

class WR_Megamenu_Helpers_Html_Button extends WR_Megamenu_Helpers_Html {
	/**
	 * Button
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label = parent::get_label( $element );
		$element['class'] = ( $element['class'] ) ? $element['class'] . ' btn' : 'btn';
		$action_type = isset( $element['action_type'] ) ? " data-action-type = '{$element["action_type"]}' " : '';
		$action = isset( $element['action'] ) ? " data-action = '{$element["action"]}' " : '';
		$output = "<button class='{$element['class']}' $action_type $action>{$element['std']}</button>";
		return parent::final_element( $element, $output, $label );
	}
}