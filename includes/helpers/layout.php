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

class WR_Megamenu_Helpers_Layout {

	private $template_data;

	/**
	 * Load template file which located in PLUGINPATH/templates
	 * @param unknown_type $template_name
	 */
	public function load_template( $template_name ) {
		$template_name = $template_name . '.php';
		$file_path     = WR_MEGAMENU_ROOT_PATH . 'templates/' . $template_name;

		if ( file_exists( $file_path ) ) {
			if ( $data = $this->get_template_data() ) {
				extract( $data );
			}
			include $file_path;
		} else {
			'<h2>' . __( 'Template file not found.', WR_MEGAMENU_TEXTDOMAIN ) . '</h2>';
		}
	}

	/**
	 * Set neccessary data used in template
	 * @param string $key
	 * @param mixed $value
	 */
	public function set_template_data( $key, $value )
	{
		$this->template_data[$key] = $value;
	}

	/**
	 * Get current template data
	 */
	public function get_template_data()
	{
		return $this->template_data;
	}


}