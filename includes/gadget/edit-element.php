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
 * Gadget class for loading editor for WR MegaMenu element.
 *
 * @package  WR_Megamenu
 * @since	2.0.2
 */
class WR_Megamenu_Gadget_Edit_Element extends WR_Megamenu_Gadget_Base {
	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'edit-element';

	/**
	 * Load form for editing WR MegaMenu element.
	 *
	 * @return  void
	 */
	public function form_action() {
		global $mega_menu;

		// Use output buffering to capture HTML code for element editor
		ob_start();

		if ( isset( $_GET['wr_shortcode_preview'] ) && 1 == $_GET['wr_shortcode_preview'] ) {
			$mega_menu->shortcode_iframe_preview();
		} else {
			$mega_menu->get_modal_content();
		}

		// Set response for injecting into template file
		$this->set_response( 'success', ob_get_clean() );

		// Register action to remove unnecessary assets
		// Register action to remove unnecessary assets
		global $Wr_Megamenu_Preview_Class;
		if ( $Wr_Megamenu_Preview_Class != 'WR_Megamenu_Widget' ) {
			add_action( 'mm_admin_print_styles',  array( &$this, 'filter_assets' ), 0 );
			add_action( 'mm_admin_print_scripts', array( &$this, 'filter_assets' ), 0 );
		}

	}



	/**
	 * Filter required assets.
	 *
	 * @return  void
	 */
	public function filter_assets() {
		static $executed;
		global $wp_styles, $wp_scripts;
		$form_only = ( isset( $_GET['form_only'] ) && absint( $_GET['form_only'] ) );
		if ( ! isset( $executed ) ) {


			// Check if requesting form only

			// Remove unnecessary assets
			foreach ( array( &$wp_styles, &$wp_scripts ) as $assets ) {
				if ( @count( $assets->queue ) ) {
					foreach ( $assets->queue as $k => $v ) {
						// Keep only required assets
						if ( $form_only ) {
							unset( $assets->queue[ $k ] );
						} elseif ( 'wr-' != substr( $v, 0, 3 ) ) {
							unset( $assets->queue[ $k ] );
						}
					}
				}
			}

			// Get response data
			$response = $this->get_response();

			// Allow required assets to be filterable
			$on_demand_assets = array();

			if ( ! $form_only ) {
				$on_demand_assets['jsn-tabs']	= 'jquery-ui-tabs';
				$on_demand_assets['ui-sortable'] = 'jquery-ui-sortable';
			}

			$on_demand_assets = apply_filters( 'wr-mm-edit-element-required-assets', $on_demand_assets );

			// Detect and load required assets on demand
			foreach ( $on_demand_assets as $sign => $handle ) {
				if ( is_numeric( $sign ) ) {
					$this->load_asset( $handle );
				} elseif ( preg_match( '/\s(id|class)\s*=\s*[\'"][^\'"]*' . $sign . '[^\'"]*[\'"]/', $response['data'] ) ) {
					$this->load_asset( $handle );
				}
			}

			// State that this method is already executed
			$executed = true;
		} else {
			// Never load jQuery core when serving form only
			if ( $form_only ) {
				foreach ( $wp_scripts->queue as $k => $v ) {
					if ( 'jquery' == substr( $v, 0, 6 ) ) {
						unset( $wp_scripts->queue[ $k ] );
					}
				}
			}
		}
	}

	/**
	 * Method to load specified asset.
	 *
	 * @param   string  $handle  Asset handle.
	 *
	 * @return  void
	 */
	protected function load_asset( $handle ) {
		if ( is_array( $handle ) ) {
			foreach ( $handle as $h ) {
				$this->load_asset( $h );
			}

			return;
		}

		// Prepare asset handle
		if ( preg_match( '/\.(css|js)$/', $handle ) ) {
			$handle = WR_Megamenu_Init_Assets::file_to_handle( $handle );
		}

		// Load asset
		WR_Megamenu_Init_Assets::load( $handle );
	}
}
