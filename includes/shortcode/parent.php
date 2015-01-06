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

/*
 * Parent class for parent elements
 */

class WR_Megamenu_Shortcode_Parent extends WR_Megamenu_Shortcode_Element {
	/**
	 * Constructor
	 *
	 * @return  void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * get params & structure of shortcode
	 * OVERWRIGE parent function
	 */
	public function shortcode_data() {
		$params                 = WR_Megamenu_Helpers_Shortcode::generate_shortcode_params( $this->items );
		$this->config['params'] = array_merge( array( 'div_margin_top' => '', 'div_margin_bottom' => '', 'disabled_el' => 'no', 'css_suffix' => '' ), $params );

		// get content of sub-shortcode
		$sub_items_content = array();
		$sub_items         = isset($this->config['params']['sub_items_content']) ? $this->config['params']['sub_items_content'] : array();
		foreach ( $sub_items as $sub_item_type => &$sub_shortcodes ) {
			foreach ( $sub_shortcodes as $sub_shortcode ) {

				$sub_sc = new $sub_item_type();

				// empty std
				if ( empty( $sub_shortcode['std'] ) ) {

					// only empty 'std'
					if ( count( $sub_shortcode ) == 1 ) {
						// get default shortcode structure of sub-shortcode
						$sub_sc->config['params'] = WR_Megamenu_Helpers_Shortcode::generate_shortcode_params( $sub_sc->items, null, null, false, true );

						// re-generate shortcode structure
						$sub_shortcode['std'] = WR_Megamenu_Helpers_Shortcode::generate_shortcode_structure( $sub_sc->config['shortcode'], $sub_sc->config['params'] );
					} // array of empty 'std' & pre-defined std for other items
					else {
						// MODIFY $instance->items
						WR_Megamenu_Helpers_Shortcode::generate_shortcode_params( $sub_sc->items, NULL, $sub_shortcode, TRUE );

						// re-generate shortcode structure
						$sub_sc->shortcode_data();

						// get updated std of sub-shortcode
						$sub_shortcode['std'] = $sub_sc->config['shortcode_structure'];
					}
				} // std is set
				else {

					// if std of sub-shortcode is predefined ( such as GoogleMap )
					$params         = stripslashes( $sub_shortcode['std'] );
					$extract_params = WR_Megamenu_Helpers_Shortcode::extract_params( urldecode( $params ) );

					// MODIFY $instance->items
					WR_Megamenu_Helpers_Shortcode::generate_shortcode_params( $sub_sc->items, NULL, $extract_params, TRUE );

					// re-generate shortcode structure
					$sub_sc->shortcode_data();
				}

				$sub_items_content[] = $sub_shortcode['std'];
			}
		}
		$sub_items_content = implode( '', $sub_items_content );
		// END get content of sub-shortcode

		$this->config['shortcode_structure'] = WR_Megamenu_Helpers_Shortcode::generate_shortcode_structure( $this->config['shortcode'], $this->config['params'], $sub_items_content );
	}

}