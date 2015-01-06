<?php
/**
 * @version    $Id$
 * @package    WR_Library
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 * Technical Support:  Feedback - http://www.woorockets.com
 */

if ( ! class_exists( 'WR_Megamenu_Init_Plugin' ) ) :

/**
 * WR Library initialization.
 *
 * @package  WR_Library
 * @since    1.0.0
 */
class WR_Megamenu_Init_Plugin {
	/**
	 * Define Ajax actions.
	 *
	 * @var  array
	 */
	protected static $actions = array();

	/**
     * Register action to initialize WR Library.
     *
     * @return  void
     */
	public static function hook() {
		// Register action to initialize WR Library
		static $registered;

		if ( ! isset( $registered ) ) {
			add_action( 'init', array( __CLASS__, 'init' ) );

			$registered = true;
		}
	}


	/**
	 * Initialize WR Library.
	 *
	 * @return  void
	 */
	public static function init() {
		global $pagenow;

		if ( 'admin-ajax.php' == $pagenow && isset( $_GET['action'] ) && in_array( $_GET['action'], self::$actions ) ) {
			// Init WordPress Filesystem Abstraction
			WR_Megamenu_Init_File_System::get_instance();

			// Register Ajax actions
			switch ( $_GET['action'] ) {
				case 'wr-addons-management' :
					WR_Megamenu_Product_Addons::hook();
				break;
			}
		}

		// Add filter to fine-tune uploaded file name
		add_filter( 'wp_handle_upload_prefilter', array( __CLASS__, 'wp_handle_upload_prefilter' ) );

		// Do 'wr_megamenu_init' action
		do_action( 'wr_megamenu_init' );

	}

	/**
	 * Apply 'wp_handle_upload_prefilter' filter.
	 *
	 * @param   array  $file  Array containing uploaded file details.
	 *
	 * @return  string
	 */
	public static function wp_handle_upload_prefilter( $file ) {
		if ( $name = iconv( 'utf-8', 'ascii//TRANSLIT//IGNORE', $file['name'] ) ) {
			$file['name'] = $name;
		}

		return $file;
	}

}

endif;
