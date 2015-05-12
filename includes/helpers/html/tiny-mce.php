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

class WR_Megamenu_Helpers_Html_Tiny_Mce extends WR_Megamenu_Helpers_Html {
	/**
	 * text area with WYSIWYG
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		$rows    = isset($element['rows']) ? $element['rows'] : 10;
		if ( @ $element['exclude_quote'] == '1' ) {
			$element['std'] = str_replace( '<wr_quote>', '"', $element['std'] );
		}

		$settings = array(
			'textarea_name' => $element['id'],
			'textarea_rows' => $rows,
			'editor_class' => 'wr_mm_editor',
		);

		ob_start();
		echo "<form id='wr_tiny_mce' class='wr_tiny_mce' method='post'>";
		wp_editor( $element['std'], $element['id'], $settings );
		echo '</form>';
		$output = ob_get_clean();
		return parent::final_element( $element, $output, $label, true );
	}
}