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

class WR_Megamenu_Helpers_Html_Large_Image extends WR_Megamenu_Helpers_Html {
	/**
	 * Selectbox of Image Size options
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		// Add default select2 for all large image html type
		$element['class'] .= ' select2-select';
		$output  = "<div id='{$element['id']}_wrapper' class='large_image_wrapper'><select id=\"select_{$element['id']}\" class=\"{$element['class']}\"><option value=\"none\">".__( 'None', WR_MEGAMENU_TEXTDOMAIN ).'</option></select></div>';
		$output .= "<div class='image_loader'></div>";
		$output .= "<input type='hidden' id='{$element['id']}' value='{$element['std']}'  DATA_INFO />";
		return parent::final_element( $element, $output, $label );
	}
}