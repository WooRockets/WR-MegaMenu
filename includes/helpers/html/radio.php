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

class WR_Megamenu_Helpers_Html_Radio extends WR_Megamenu_Helpers_Html {
	/**
	 * Radio
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element['class'] = isset( $element['class'] ) ? $element['class'] : 'radio-inline';
		$element['type_input'] = 'radio';
		return WR_Megamenu_Helpers_Shortcode::render_parameter( 'checkbox', $element );
	}
}