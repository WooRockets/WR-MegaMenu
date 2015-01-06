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

/**
 * HTML editor class use jquery-te 3rd-party.
 *
 * @package  WR_Megamenu
 * @since    2.1.0
 */
class WR_Megamenu_Helpers_Html_Editor extends WR_Megamenu_Helpers_Html {
	
	/**
	 * Render editor using jquery-te library
	 * 
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label = parent::get_label( $element );
		$element['row'] = ( isset( $element['row'] ) ) ? $element['row'] : '8';
		$element['col'] = ( isset( $element['col'] ) ) ? $element['col'] : '50';
		if ( @$element['exclude_quote'] == '1' ) {
			$element['std'] = str_replace( '<wr_quote>', '"', $element['std'] );
		}
		$output = "<textarea class='{$element['class']} wr_mm_editor' id='{$element['id']}' rows='{$element['row']}' cols='{$element['col']}' name='{$element['id']}' DATA_INFO>{$element['std']}</textarea>";
		
		add_filter( 'wr_mm_assets_register_modal', array( __CLASS__, 'register_assets_register_modal' ) );
		add_filter( 'wr_mm_assets_enqueue_modal', array( __CLASS__, 'enqueue_assets_modal' ) );
		
		return parent::final_element( $element, $output, $label, true );
	}
	
	/**
	 * Register jquery-te assets
	 *
	 * @param array $scripts
	 * @return array
	 */
	static function register_assets_register_modal( $assets ){
		$assets['wr-mm-jquery-te-js'] = array(
			'src' => 'assets/3rd-party/jquery-te/jquery-te-1.4.0.min.js',
			'ver' => '1.4.0',
		);
		$assets['wr-mm-jquery-te-css'] = array(
			'src' => 'assets/3rd-party/jquery-te/jquery-te-1.4.0.css',
			'ver' => '1.4.0',
		);
	
		return $assets;
	}
	
	/**
	 * Enqueue jquery-te assets
	 *
	 * @param array $scripts
	 * @return array
	 */
	static function enqueue_assets_modal( $scripts ){
		$scripts = array_merge( $scripts, array( 'wr-mm-jquery-te-js', 'wr-mm-jquery-te-css' ) );
	
		return $scripts;
	}
	
}