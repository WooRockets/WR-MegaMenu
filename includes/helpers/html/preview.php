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

class WR_Megamenu_Helpers_Html_Preview extends WR_Megamenu_Helpers_Html {
	/**
	 * Preview Box of shortcode
	 * @return type
	 */
	static function render() {

		return "<div id='preview_container' class='wr-preview-container'>
		<legend>" . __( 'Preview', WR_MEGAMENU_TEXTDOMAIN ) . "</legend>
		<div id='wr_overlay_loading' class='jsn-overlay jsn-bgimage image-loading-24'></div>
		<iframe id='shortcode_preview_iframe' name='shortcode_preview_iframe' class='shortcode_preview_iframe'></iframe>
		</div>";
	}
}