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

class WR_Megamenu_Helpers_Html_Tag extends WR_Megamenu_Helpers_Html {
	/**
	 * Tag
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element['exclude_class'] = array( 'form-control' );
		$element = parent::get_extra_info( $element );
		$label = parent::get_label( $element );
		$element['class'] = ( $element['class'] ) ? $element['class'] . ' select2' : 'select2';
		$output = "<input type='hidden' value='{$element['std']}' id='{$element['id']}' class='{$element['class']}' data-share='wr_share_data' DATA_INFO />";

		add_filter( 'wr_mm_assets_enqueue_modal', array( __CLASS__, 'enqueue_assets_modal' ) );

		return parent::final_element( $element, $output, $label );
	}

	/**
     * Enqueue select2 assets
     *
     * @param array $scripts
     * @return array
     */
	static function enqueue_assets_modal( $scripts ){
		$scripts = array_merge( $scripts, array( 'wr-mm-jquery-select2-js', ) );

		return $scripts;
	}
}