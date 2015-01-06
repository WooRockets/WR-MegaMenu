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

class WR_Megamenu_Helpers_Html_Button_Group extends WR_Megamenu_Helpers_Html {
	/**
	 * Button group
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );

		$output = "<div class='btn-group'>
		  <a class='btn btn-default dropdown-toggle' data-toggle='dropdown' href='#'>
			".__( 'Convert to', WR_MEGAMENU_TEXTDOMAIN )."...
			<span class='caret'></span>
		  </a>
		  <ul class='dropdown-menu'>";
		foreach ( $element['actions'] as $action ) {
			$output .= "<li><a href='#' data-action = '{$action["action"]}' data-action-type = '{$action["action_type"]}'>{$action['std']}</a></li>";
		}
		$output .= '</ul></div>';
		return parent::final_element( $element, $output, $label );
	}
}