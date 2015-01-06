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

class WR_Megamenu_Helpers_Html_Radio_Group extends WR_Megamenu_Helpers_Html {
	/**
	 * Radio Button group
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );

		$output = "<div class='radio-group wr-btn-radio'>";
		foreach ( $element['options'] as $key => $text ) {
			$checked = ( $key == $element['std'] ) ? 'checked' : '';
			$output .= " <label class='radio-inline'><input type='radio' name='{$element['id']}' $checked id='{$element['id']}' class='wr_has_depend' value='$key'/>$text</label>";
		}
		$output .= '</div>';

		return parent::final_element( $element, $output, $label );
	}
}