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

class WR_Megamenu_Helpers_Html_Filter_List extends WR_Megamenu_Helpers_Html {
	/**
	 * Horizonal list of filter options
	 * @param type $data
	 * @param type $id
	 * @return string
	 */
	static function render( $data, $id ) {
		$html = "<ul id='filter_$id' class='nav nav-pills elementFilter'>";
		foreach ( $data as $idx => $value ) {
			$active = ( $idx == 0 ) ? 'active' : '';
			$html  .= "<li class='$active'><a href='#' class='" . str_replace( ' ', '_', $value ) . "'>" . ucfirst( $value ) . '</a></li>';
		}
		$html .= '</ul>';
		return $html;
	}
}