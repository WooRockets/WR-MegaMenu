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

class WR_Megamenu_Helpers_Html_Icons extends WR_Megamenu_Helpers_Html {
	/**
	 * Icons
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		$item_id = isset($element['item_id']) ? $element['item_id'] : '';
		$icon_id = ($item_id != '' ) ? '-' . $item_id : '';
		$output  = "<div id='icon_selector".$icon_id."' class='icon_selector' data-item_id='".$item_id."'>
			<input type='hidden' value='{$element['std']}' id='{$element['id']}' DATA_INFO />
		</div>";
		if ( WR_Megamenu_Helpers_Functions::is_modal() ) {
			add_filter( 'wr_mm_assets_enqueue_modal', array( __CLASS__, 'enqueue_assets_modal' ) );
		} else {
			WR_Megamenu_Init_Assets::load( array( 'wr-joomlashine-iconselector-js' ) );
		}

		return parent::final_element( $element, $output, $label );
	}

	/**
	 * Enqueue icon selector assets
	 *
	 * @param array $scripts
	 * @return array
	 */
	static function enqueue_assets_modal( $scripts ){
		$scripts = array_merge( $scripts, array( 'wr-joomlashine-iconselector-js', ) );

		return $scripts;
	}
}