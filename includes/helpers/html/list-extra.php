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

class WR_Megamenu_Helpers_Html_List_Extra extends WR_Megamenu_Helpers_Html {
	/**
	 * List Extra Element
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$html  = "<div class='{$element['class']}'>";
		$html .= "<div id='{$element['id']}' class='jsn-items-list ui-sortable'>";

		if ( $element['std'] ) {

		}

		$html .= '</div>';
		$html .= "<a class='jsn-add-more add-more-extra-list' onclick='return false;' href='#'><i class='icon-plus'></i>" . __( 'Add Item', WR_MEGAMENU_TEXTDOMAIN ) . '</a>';
		$html .= '</div>';
		return $html;
	}
}