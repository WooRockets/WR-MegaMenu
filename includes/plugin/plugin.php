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

		$style = '
			/*** Premium ***/
			#wr-promo-ab {
				background: url(' . WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/about-us/bg-wr-promo-2.jpg) center top no-repeat;
				background-size: auto 100%;
				text-align: center;
				overflow: hidden;
				font-family: \'Open Sans\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			}
			#wr-promo-ab h3 {
			    margin: 180px 0 15px;
			    color: #fff;
			    font-size: 25px;
			    font-weight: bold;
			}
			#wr-promo-ab ul {
			    margin: 0 auto 25px auto;
			    padding: 0;
			    list-style: none;
			    color: #6c7885;
			    width: 250px;
			}
			#wr-promo-ab li {
			    line-height: 31px;
			    margin: 0 5px 10px;
			    text-align: left;
			    list-style: none;
			    background: none;
			    padding: 0;
			}
			#wr-promo-ab li span {
			    background: #6c7886;
			    float: left;
			    border-radius: 50%;
			    -o-border-radius: 50%;
			    -ms-border-radius: 50%;
			    -moz-border-radius: 50%;
			    -webkit-border-radius: 50%;
			    margin: 0 5px 0 0;
			}
			#wr-promo-ab li img {
			    margin: 8px;
			    float: left !important;
			}
			#wr-promo-ab .btn-premium {
			    margin: 0 0 78px 0;
			}
			#wr-promo-ab .btn-premium a {
				display: inline-block;
				margin: 0 10px;
				background: #418858;
				color: #fff;
				padding: 10px 5px;
				border-radius: 3px;
				-o-border-radius: 3px;
				-ms-border-radius: 3px;
				-moz-border-radius: 3px;
				-webkit-border-radius: 3px;
				font-size: 11px;
				box-shadow: 0 4px 0 0 #2a6d40;
				-o-box-shadow: 0 4px 0 0 #2a6d40;
				-ms-box-shadow: 0 4px 0 0 #2a6d40;
				-moz-box-shadow: 0 4px 0 0 #2a6d40;
				-webkit-box-shadow: 0 4px 0 0 #2a6d40;
				text-decoration: none;
				transition: all 0.3s;
				-o-transition: all 0.3s;
				-ms-transition: all 0.3s;
				-moz-transition: all 0.3s;
				-webkit-transition: all 0.3s;
			}
			#wr-promo-ab .btn-premium strong {
			    font-size: 18px;
			}
			#wr-promo-ab .btn-premium a:hover {
			    background: #2a6d40;
			    text-decoration:none;
			    box-shadow: 0 4px 0 0 #418858;
			    -o-box-shadow: 0 4px 0 0 #418858;
			    -ms-box-shadow: 0 4px 0 0 #418858;
			    -moz-box-shadow: 0 4px 0 0 #418858;
			    -webkit-box-shadow: 0 4px 0 0 #418858;
			}
			@media only screen and (max-width: 1200px) and (min-width: 768px), (max-device-width: 1200px) and (max-device-width: 768px) {
				#wr-promo-ab .btn-premium a {
					padding: 10px 0;
					margin: 0 10px;
				}
				#wr-promo-ab .btn-premium strong {
					font-size:16px;
				}
			}
        ';
		WR_Megamenu_Init_Assets::inline( 'css', $style );

		$content = '<div id=\"wr-promo-ab\"><h3>Premium<br> WooCommerce Themes</h3><ul><li><span><img src=\"' . WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/about-us/excellent-icon.png\"></span>Excellent designs</li><li><span><img src=\"' . WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/about-us/unlimited-icon.png\"></span>Unlimited customization ability</li><li><span><img src=\"' . WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/about-us/additional-icon.png\"></span>Additional eCommerce features</li></ul><p class=\"btn-premium\"><a href=\"http://www.woorockets.com/themes/?utm_source=MegaMenu&utm_medium=Editor&utm_campaign=Cross%20Promo%20Banner\" target=\"_blank\"><strong>View the collection now</strong><br><span>And learn how our themes can boost your business!</span></a></p></div>';

		$script = '
			$("#side-sortables").append("' . $content . '");
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
