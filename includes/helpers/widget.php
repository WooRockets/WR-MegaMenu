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

class WR_Megamenu_Helpers_Widget {

	/**
	 * Get Base name of a widget
	 *
	 * @param object $wg widget instance
	 */
	public static function get_widget_base_name( $wg )
	{
		$sample_name = $wg->get_field_name( '' );
		$_patern     = '#([^\[\]\r\n\s\t]+)\[#';
		preg_match_all( $_patern, $sample_name, $matches, PREG_SET_ORDER );

		if ( $matches ) {
			$options_index	= $matches[0][1];
			return  $options_index;
		}

		return '';
	}

	/**
	 * Get the widget HTML
	 * @param string $widget_class_name
	 * @param array $instance
	 */
	public static function get_widget_content( $widget_class_name, $instance = array() ){
		ob_start();
		the_widget( $widget_class_name, $instance );
		return ob_get_clean();
	}
}