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
 * WR MegaMenu plugin initialization.
 *
 * @package  WR_Megamenu
 * @since	1.0.0
 */

class WR_Megamenu_Plugin {
	/**
	 * Initialize WR Sample plugin.
	 *
	 * @return  void
	 */
	public static function init() {
		global $wp_widget_factory, $mega_menu, $wr_megamenu_element, $wr_megamenu_widgets;

		// Init neccessary WR Library classes
		WR_Megamenu_Init_Admin_Menu::hook();
		// Load required assets
		WR_Megamenu_Assets::init();

		WR_Megamenu_Init_Assets	::hook();
		// Load update simulator
		WR_Megamenu_Update_Simulator::hook();

		// Init element
		$wr_megamenu_element = new WR_Megamenu_Element();
		$wr_megamenu_element->init();

		//
		if ( is_admin() ){
			$mega_menu = new WR_Megamenu_Core_Backend();

			// Insert WooRockets banner
			global $pagenow;
			$post_type = '';
			if ( ( $pagenow == 'post-new.php' ) && ( isset( $_REQUEST['post_type'] ) ) ) {
				$post_type = $_REQUEST['post_type'];
			}
			elseif ( ( $pagenow == 'post.php' ) && ( isset( $_REQUEST['post'] ) ) ) {
				$post_type = get_post_type( $_REQUEST['post'] );
			}
			if ( $post_type == 'wr_megamenu_profile' ) {
				self::insert_banner();
			}
		} else {
			// Process menu frontend
			$frontend = new WR_Megamenu_Core_Frontend();
			$frontend->apply_megamenu();
		}

		// Register 'admin_menu' action
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );

		// Register 'wr_mm_installed_product' filter
		add_filter( 'wr_mm_installed_product', array( __CLASS__, 'register_product' ) );

		// Initialize widget support
		$wr_megamenu_widgets = ! empty( $wr_megamenu_widgets ) ? $wr_megamenu_widgets : WR_Megamenu_Helpers_Functions::widgets();


	}

	/**
	 * Do 'admin_menu' action.
	 *
	 * @return  void
	 */
	public static function admin_menu() {
		// Register admin menu
		WR_Megamenu_Admin_Menu::init();
	}

	/**
	 * Apply 'wr_mm_installed_product' filter.
	 *
	 * @param   array  $plugins  Array of installed WooRockets product.
	 *
	 * @return  array
	 */
	public static function register_product( $plugins ) {
		// Register product identification
		$plugins[] = WR_MEGAMENU_IDENTIFIED_NAME;

		return $plugins;
	}

	/**
	 * Insert WooRockets banner.
	 * 
	 * @return void
	 */
	public static function insert_banner() {
		$banner1 = '<img width=\"278\" height=\"156\" src=\"' . WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/banners/ContactForm_S.jpg' . '\" alt=\"Contact Form\" />';
		$link1 = '<a style=\"display: block; margin: 0px 1px 20px 1px; line-height: 0;\" href=\"http://www.woorockets.com/plugins/wr-contactform/?utm_source=MegaMenu%20Edit%20Page&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins\" target=\"_blank\">' . $banner1 . '</a>';
		$banner2 = '<img width=\"278\" height=\"156\" src=\"' . WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/banners/PageBuilder_S.jpg' . '\" alt=\"Page Builder\" />';
		$link2 = '<a style=\"display: block; margin: 0px 1px 20px 1px; line-height: 0;\" href=\"http://www.woorockets.com/plugins/wr-pagebuilder/?utm_source=MegaMenu%20Edit%20Page&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins\" target=\"_blank\">' . $banner2 . '</a>';
		$banner3 = '<img width=\"278\" height=\"156\" src=\"' . WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/banners/Corsa_S.jpg' . '\" alt=\"Corsa\" />';
		$link3 = '<a style=\"display: block; margin: 0px 1px 20px 1px; line-height: 0;\" href=\"http://www.woorockets.com/themes/corsa/?utm_source=MegaMenu%20Edit%20Page&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins\" target=\"_blank\">' . $banner3 . '</a>';
		$script = '
			$("#side-sortables").append("' . $link1 . $link2 . $link3 . '");
		';
		WR_Megamenu_Init_Assets::inline( 'js', $script );
	}

	/**
	 * Fired when plugin is activated.
	 *
	 * @return void
	 */
	public static function on_activation() {
		update_option( 'wr_megamenu_do_activation_redirect', 'Yes' );
	}

	/**
	 * Do activation redirect
	 *
	 * @return void
	 */
	public static function do_activation_redirect() {
		if ( get_option( 'wr_megamenu_do_activation_redirect', 'No' ) == 'Yes' ) {
			update_option( 'wr_megamenu_do_activation_redirect', 'No' );
			wp_redirect( admin_url( 'edit.php?post_type=wr_megamenu_profile&page=wr-megamenu-about-us' ) );
		}
	}

}
