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

class WR_Megamenu_Helpers_Html_Radio_Button_Group extends WR_Megamenu_Helpers_Html {
	/**
	 * Radio Button group
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element  = parent::get_extra_info( $element );
		$label    = parent::get_label( $element );
		$str_icon = isset($element['icons']) ? $element['icons'] : '';
		$icons    = array();
		if ( $str_icon ) {
			$icons = explode( '_#_', $str_icon );
		}
		$element['class'] = str_replace( 'form-control', '', $element['class'] );

		$output = "<div class='btn-group wr-btn-group' data-toggle='buttons'>";
		$i = 0;
		foreach ( $element['options'] as $key => $text ) {
			$active  = ( $key == $element['std'] ) ? 'active' : '';
			$checked = ( $key == $element['std'] ) ? 'checked' : '';
			$output .= "<label class='btn btn-default {$active}'>";
			$output .= "<input type='radio' name='{$element['id']}' $checked id='{$element['id']}' class='{$element['class']}' value='$key'/>";

			if ( isset( $icons[$i] ) ) {
				$output .= '<i class="'.$icons[$i].'"></i>' . $text;
			} else {
				$output .= $text;
			}
			$output .= '</label>';
			$i++;
		}

		$output .= '</div>';

		return parent::final_element( $element, $output, $label );
	}
}