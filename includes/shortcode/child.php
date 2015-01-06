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
 * Parent class for sub elements
 */

class WR_Megamenu_Shortcode_Child extends WR_Megamenu_Shortcode_Element {

	/**
     * Over write parent method
     *
     * @param string $content
     * @param string $shortcode_data
     * @param string $el_title
     * @return string
     */
	public function element_in_megamenu( $content = '', $shortcode_data = '', $el_title = '', $index = '' ) {
		$this->config['sub_element'] = true;
		return parent::element_in_megamenu( $content, $shortcode_data, $el_title, $index );
	}

}
