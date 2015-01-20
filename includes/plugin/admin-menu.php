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
 * WR MegaMenu admin menu initialization.
 *
 * @package  WR_Megamenu
 * @since    1.0.0
 */
class WR_Megamenu_Admin_Menu {
	/**
	 * Define pages.
	 *
	 * @var  array
	 */
	public static $pages = array( 'wr-megamenu-settings', 'wr-menu-addons', 'wr-megamenu-about-us' );

	/**
	 * Initialize WR MegaMenu admin menu.
	 *
	 * @return  void
	 */
	public static function init() {
		global $pagenow;

		// Get product information
		$plugin = WR_Megamenu_Product_Info::get( WR_MEGAMENU_IDENTIFIED_NAME );

		// Generate menu title
		$menu_title = __( 'WR MegaMenu', WR_MEGAMENU_TEXTDOMAIN );

		if (isset($plugin['Available_Update']) && $plugin['Available_Update'] && ( 'admin.php' != $pagenow || ! isset( $_GET['page'] ) || ! in_array( $_GET['page'], self::$pages ) ) ) {
			$menu_title .= " <span class='wr-available-updates update-plugins count-{$plugin['Available_Update']}'><span class='pending-count'>{$plugin['Available_Update']}</span></span>";
		}

		$menu = array(
			'page_title' => __( $menu_title, WR_MEGAMENU_TEXTDOMAIN ),
			'menu_title' => __( 'Settings', WR_MEGAMENU_TEXTDOMAIN ) ,
			'capability' => 'manage_options',
			'menu_slug'  => 'wr-megamenu-settings',
			'function'   => array( __CLASS__, 'settings' ),
		);

		/*
		WR_Megamenu_Init_Admin_Menu::add( $menu , 'edit.php?post_type=wr_megamenu_profile' );
		*/

		if ( @$plugin['Addons'] ) {
			// Generate menu title
			$menu_title = __( 'Add-ons', WR_MEGAMENU_TEXTDOMAIN );
			if ( @$plugin['Available_Update'] && ( 'admin.php' == $pagenow && isset( $_GET['page'] ) && in_array( $_GET['page'], self::$pages ) ) ) {
				$menu_title .= " <span class='wr-available-updates update-plugins count-{$plugin['Available_Update']}'><span class='pending-count'>{$plugin['Available_Update']}</span></span>";
			}

			// Update admin menus
			$menu = array(
				'page_title' => __( 'WR MegaMenu - Add-ons', WR_MEGAMENU_TEXTDOMAIN ),
				'menu_title' => $menu_title,
				'capability' => 'manage_options',
				'menu_slug'  => 'wr-menu-addons',
				'function'   => array( __CLASS__, 'addons' ),
			);

			WR_Megamenu_Init_Admin_Menu::add( $menu , 'edit.php?post_type=wr_megamenu_profile' );
		}

		WR_Megamenu_Init_Admin_Menu::add(
			array(
				'page_title' => __( 'WR MegaMenu - About', WR_MEGAMENU_TEXTDOMAIN ),
				'menu_title' => __( 'About', WR_MEGAMENU_TEXTDOMAIN ),
				'capability' => 'manage_options',
				'menu_slug'  => 'wr-megamenu-about-us',
				'function'   => array( __CLASS__, 'about_us' )
			),
			'edit.php?post_type=wr_megamenu_profile'
		);
	}

	/**
	 * Render settings screen.
	 *
	 * @return  void
	 */
	public static function settings() {
		// Instantiate settings class
		// WR_Megamenu_Settings::init();
		include WR_MEGAMENU_TPL_PATH . '/settings.php';
	}

	/**
	 * Render addons management screen.
	 *
	 * @return  void
	 */
	public static function addons() {
		// Instantiate product addons class
		WR_Megamenu_Init_Assets::load( array( 'wr-addons-js' ) );
		WR_Megamenu_Product_Addons::init( WR_MEGAMENU_IDENTIFIED_NAME );
	}

	/**
	 * Render about-us screen.
	 *
	 * @return void
	 */
	public static function about_us() {
		// Load assets
		WR_Megamenu_Init_Assets::load( array( 'wr-mm-bootstrap3-css', 'wr-bootstrap3-js' ) );
		// Load template
		include WR_MEGAMENU_TPL_PATH . '/about-us.php';
	}

}
