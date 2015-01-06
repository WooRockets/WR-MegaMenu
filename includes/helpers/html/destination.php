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

class WR_Megamenu_Helpers_Html_Destination extends WR_Megamenu_Helpers_Html {
	/**
	 * Selectbox of Google Map Destination
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		$output  = "<div id='{$element['id']}_wrapper' class='wr-destination-wrapper'><select id=\"select_{$element['id']}\"><option value=\"none\">".__( 'None', WR_MEGAMENU_TEXTDOMAIN ).'</option></select></div>';
		$output .= "<div class='image_loader'></div>";
		$output .= "<input type='hidden' id='{$element['id']}' class='{$element['class']}' value='{$element['std']}'  DATA_INFO />";
		return parent::final_element( $element, $output, $label );
	}
}