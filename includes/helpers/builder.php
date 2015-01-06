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

class WR_Megamenu_Helpers_Builder
{
	/**
	 * Generate megamenu page header
	 * @param string $header_str
	 */
	public function generate_header( $header_str = 'WR MegaMenu Builder', $icon_class = '' )
	{
		$header  = '<div clas"icon32 ' . $icon_class . '"></div>';
		$header .= '<h2>' . $header_str . '</h2>';
		return $header;
	}

	/**
	 * Get MegaMenu data (setting, information) by Menu and Location
	 * @param int $profile_id
	 * @param int $menu_id
	 * @return array
	 */
	public static function get_megamenu_data( $profile_id, $menu_id = null )
	{
		$data     = get_post_meta( $profile_id, WR_MEGAMENU_META_KEY, true );
		$settings = (array)json_decode( $data, true );

		if (  count( $settings ) ) {
			$menu_settings = @$settings['settings'];

			if ( $menu_id ) {
				if ( isset( $menu_settings[ $menu_id ] ) ) {
					return (array)$menu_settings[ $menu_id ];
				} else {
					return array();
				}
			} else {
				return $settings;
			}
		}

		return array();
	}


	/**
	 *	Parse the widget the setting string to array
	 * @param string $options_str sample: widget-recent-comments%5B0%5D%5Btitle%5D=WidgetTitle&widget-recent-comments%5B0%5D%5Bnumber%5D=5
	 */
	public static function parse_menu_widget_options( $options_str )
	{
		parse_str( urldecode( $options_str ), $options );
		return $options;
	}

}