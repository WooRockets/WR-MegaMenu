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
 * Parent class for layout elements
 */

class WR_Megamenu_Shortcode_Layout extends WR_Megamenu_Shortcode_Abstract {

	public function __construct() {
		$this->type = 'layout';
		$this->config['el_type'] = 'element';

		$this->element_config();
		$this->element_items();
		$this->shortcode_data();

		/* add shortcode */
		add_shortcode( $this->config['shortcode'], array( &$this, 'element_shortcode' ) );

		// enqueue custom script for current element
		if ( WR_Megamenu_Helpers_Functions::is_modal_of_element( $this->config['shortcode'] ) ) {
			WR_Megamenu_Helpers_Functions::shortcode_enqueue_assets( $this, 'admin_assets', '' );
		}
	}

	/**
	 * html structure of item in List item
	 * @return type
	 */
	public function element_button( $sort ) {

	}

	/**
	 * html structure of element in Page Builder area
	 */
	public function element_in_megamenu() {

	}

	/**
	 * DEFINE shortcode content
	 *
	 * @param type $atts
	 * @param type $content
	 */
	public function element_shortcode( $atts = null, $content = null ) {

	}

	/**
	 * get params & structure of shortcode
	 */
	public function shortcode_data() {

	}

}
