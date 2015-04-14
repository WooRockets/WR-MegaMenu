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
 * WR_Megamenu assets initialization.
 * @package  WR_Megamenu
 * @since	1.0.0
 */
class WR_Megamenu_Assets
{
	/**
	 * Assets to be registered.
	 * @var  array
	 */
	protected static $assets = array(

		/**
		 * Third party assets.
		 */
		/**
		 * Bootstrap 3 based assets.
		 */
		'wr-mm-bootstrap3-css' => array(
			'src' => 'assets/3rd-party/bs3/bootstrap/css/bootstrap.min.css',
			'ver' => '3.0.0',
		),

		'wr-mm-bootstrap3-responsive-css' => array(
			'src' => 'assets/3rd-party/bs3/bootstrap/css/bootstrap-responsive.min.css',
			'deps' => array( 'wr-mm-bootstrap3-css' ),
		),

		'wr-mm-bootstrap3-icomoon-css' => array(
			'src' => 'assets/3rd-party/bs3/font-icomoon/css/icomoon.css',
			'deps' => array( 'wr-mm-bootstrap3-css' ),
		),

		'wr-classygradient-css' => array(
			'src'  => 'assets/3rd-party/classygradient/css/jquery.classygradient.css',
			'deps' => array( 'wr-colorpicker-css' ),
			'ver'  => '1.0.0',
		),

		'wr-classygradient-js' => array(
			'src'  => 'assets/3rd-party/classygradient/js/jquery.classygradient.js',
			'deps' => array( 'jquery-ui-draggable', 'wr-colorpicker-js' ),
			'ver'  => '1.0.0',
		),

		'wr-colorpicker-css' => array(
			'src' => 'assets/3rd-party/colorpicker/css/colorpicker.css',
		),

		'wr-colorpicker-js' => array(
			'src'  => 'assets/3rd-party/colorpicker/js/colorpicker.js',
			'deps' => array( 'jquery' )
		),

		'wr-mm-fontselector-js' => array(
			'src' => 'assets/3rd-party/joomlashine/js/jsn-fontselector.js',
		),

		'wr-font-icomoon-css' => array(
			'src' => 'assets/3rd-party/font-icomoon/css/icomoon.css',
		),

		'wr-joomlashine-css' => array(
			'src'  => 'assets/3rd-party/joomlashine/css/jsn-gui.css',
			'deps' => array( 'wr-mm-bootstrap3-css' ),
		),

		'wr-joomlashine-iconselector-js' => array(
			'src'  => 'assets/3rd-party/joomlashine/js/jsn-iconselector.js',
			'deps' => array( 'jquery' )
		),

		'wr-joomlashine-modalresize-js' => array(
			'src'  => 'assets/3rd-party/joomlashine/js/jsn-modalresize.js',
			'deps' => array( 'jquery' )
		),

		'wr-jquery-easing-js' => array(
			'src'  => 'assets/3rd-party/jquery-easing/jquery.easing.min.js',
			'deps' => array( 'jquery' ),
			'ver'  => '1.3',
		),

		'wr-jquery-lazyload-js' => array(
			'src'  => 'assets/3rd-party/jquery-lazyload/jquery.lazyload.js',
			'deps' => array( 'jquery' ),
			'ver'  => '1.8.4',
		),

		'wr-jquery-livequery-js' => array(
			'src'  => 'assets/3rd-party/jquery-livequery/jquery.livequery.min.js',
			'deps' => array( 'jquery' ),
			'ver'  => '1.3.4',
		),

		'wr-jquery-resize-js' => array(
			'src'  => 'assets/3rd-party/jquery-resize/jquery.ba-resize.js',
			'deps' => array( 'jquery' ),
			'ver'  => '1.1',
		),

		'wr-jquery-select2-css' => array(
			'src' => 'assets/3rd-party/jquery-select2/select2.css',
			'ver' => '3.3.2',
		),

		'wr-jquery-select2-js' => array(
			'src'  => 'assets/3rd-party/jquery-select2/select2.js',
			'deps' => array( 'jquery' ),
			'ver'  => '3.3.2',
		),

		'wr-jquery-select2-bootstrap3-css' => array(
			'src' => 'assets/3rd-party/jquery-select2/select2-bootstrap3.css',
			'ver' => '3.3.2',
		),

		'wr-jquery-tipsy-css' => array(
			'src' => 'assets/3rd-party/jquery-tipsy/tipsy.css',
			'ver' => '1.0.0a',
		),

		'wr-jquery-tipsy-js' => array(
			'src'  => 'assets/3rd-party/jquery-tipsy/jquery.tipsy.js',
			'deps' => array( 'jquery' ),
			'ver'  => '1.0.0a',
		),

		'wr-jquery-ui-css' => array(
			'src' => 'assets/3rd-party/jquery-ui/css/ui-bootstrap/jquery-ui-1.9.0.custom.css',
			'ver' => '1.9.0',
		),

		'wr-form-css' => array(
			'src'  => 'assets/woorockets/css/form.css',
			'deps' => array( 'wr-jquery-ui-css', 'wr-joomlashine-css', 'wr-jquery-tipsy-css' ),
		),

		'wr-form-js' => array(
			'src'  => 'assets/woorockets/js/form.js',
			'deps' => array( 'jquery-ui-tabs', 'wr-jquery-tipsy-js' ),
		),

		'wr-mm-js' => array(
			'src'  => 'assets/js/megamenu.js',
			'deps' => array( 'wr-mm-layout-js' )
		),
		'wr-mm-css' => array(
			'src' => 'assets/css/backend.css',
		),
		'wr-mm-popover-js' => array(
			'src' => 'assets/js/popover.js',
		),
		'wr-mm-confirmation-js' => array(
			'src' => 'assets/js/bootstrap3-confirmation.js',
		),
		'wr-mm-element-font-css' => array(
			'src' => 'assets/3rd-party/wr-element-font/css/wr-element-font.css',
			'ver' => '1.0.0',
		),
		'wr-mm-layout-font-css' => array(
			'src' => 'assets/3rd-party/wr-layout-font/css/wr-layout-font.css',
			'ver' => '1.0.0',
		),

		'wr-mm-icon-options-js' => array(
			'src' => 'assets/js/icon-options.js',
			'ver' => '1.0.0',
		),

		'wr-font-awesome-css' => array(
			'src' => 'assets/3rd-party/font-awesome/css/font-awesome.min.css',
			'ver' => '4.3.0',
		),
	);

	/**
	 * Initialize WR MegaMenu assets.
	 * @return  void
	 */
	public static function init() {
		add_filter( 'wr_mm_register_assets', array( __CLASS__, 'wr_mm_register_assets' ) );
		add_filter( 'wr_mm_asset_hook_prefix', array( __CLASS__, 'wr_mm_hook_prefix' ) );
		add_action( 'admin_head', array( __CLASS__, 'load_assets' ), 99 );
	}

	public static function load_assets() {
		global $pagenow, $post_type;
		// Load common assets

		if ( is_admin() ) {
			$page_setting = (isset($_GET['page']) ) ? $_GET['page']: '';
			
			if ( ( $pagenow == 'nav-menus.php' ) || ( $post_type == 'wr_megamenu_profile' ) || ( $page_setting == 'wr-megamenu-settings' ) || ( $page_setting == 'wr-menu-addons' ) ) {
				WR_Megamenu_Init_Assets::load( array( 'wr-mm-bootstrap3-css', 'wr-bootstrap3-js', 'wr-joomlashine-css', 'wr-mm-css' ) );
				WR_Megamenu_Init_Assets::load( array( 'wr-font-icomoon-css', 'wr-font-awesome-css' ) );
				WR_Megamenu_Init_Assets::load( array( 'wr-jquery-ui-css', 'wr-jquery-select2-css', 'wr-jquery-select2-bootstrap3-css', 'wr-mm-admin-css' ) );
			}

			if ( 'admin.php' == $pagenow && isset( $_GET[ 'page' ] ) && in_array( $_GET[ 'page' ], WR_Megamenu_Admin_Menu::$pages ) ) {
				// Add filter to register assets to be loaded
				switch ( $_GET[ 'page' ] ) {
					case 'wr-megamenu-settings':
						// Load required assets
						WR_Megamenu_Init_Assets::load( array( 'wr-form-css', 'wr-form-js' ) );
						break;

					case 'wr-menu-addons':
						// Load required assets
						WR_Megamenu_Init_Assets::load( array( 'wr-addons-css', 'wr-addons-js' ) );
						break;

				}
			} else {
				if ( ( 'post.php' == $pagenow || 'post-new.php' == $pagenow || 'widgets.php' == $pagenow ) && ( $post_type == 'wr_megamenu_profile' ) ) {
					if ( class_exists( 'WR_Pb_Init' ) ) {
						global $Wr_Pb_Widgets;
						$Wr_Pb_Widgets = array();
					}
					// Load css
					WR_Megamenu_Init_Assets::load( array( 'wr-mm-element-font-css', 'wr-mm-layout-font-css'  ) );

					// Load js
					if ( function_exists( 'wp_enqueue_media' ) ) {
						wp_enqueue_media();
					} else {
						wp_enqueue_style( 'thickbox' );
						wp_enqueue_script( 'media-upload' );
						wp_enqueue_script( 'thickbox' );
					}

					$scripts = array( 'jquery', 'jquery-ui', 'jquery-ui-resizable', 'jquery-ui-sortable', 'jquery-ui-tabs', 'jquery-ui-dialog', 'jquery-ui-button', 'jquery-ui-slider', 'wr-jquery-livequery-js', 'jquery-resize-js', 'wr-joomlashine-modalresize-js', 'wr-jquery-select2-js' );

					WR_Megamenu_Init_Assets::load( $scripts );

					WR_Megamenu_Init_Assets::load( array( 'wr-mm-js' ) );

					$scripts = array( 'wr-mm-layout-js', 'wr-mm-placeholder' );
					WR_Megamenu_Init_Assets::load( apply_filters( 'wr_mm_assets_enqueue_admin', $scripts ) );


					WR_Megamenu_Init_Assets::load( 'wr-mm-modal-js' );

					WR_Megamenu_Init_Assets::load( array( 'wr-colorpicker-js', 'wr-colorpicker-css' ) );

					// Load element editor script
					WR_Megamenu_Init_Assets::load( 'wr-mm-handleelement-js' );

					// Load element settings script
					WR_Megamenu_Init_Assets::load( 'wr-mm-handlesetting-js' );

					// Load ZeroClipboard JavaScript library for Shortcode Content tab
					WR_Megamenu_Init_Assets::load( 'wr-zeroclipboard-js' );

					WR_Megamenu_Init_Assets::load( 'wr-mm-widget-js' );

					WR_Megamenu_Helpers_Functions::wr_localize();
				}
			}
		} else {
			WR_Megamenu_Init_Assets::load( array( 'wr-mm-bootstrap3-css', 'wr-bootstrap3-js', 'wr-joomlashine-css', 'wr-mm-css' ) );
			WR_Megamenu_Init_Assets::load( array( 'wr-font-icomoon-css', 'wr-font-awesome-css' ) );
		}

	}

	/**
	 * Set hook prefix for loading assets.
	 * @param   string $prefix Current hook prefix.
	 * @return  string
	 */
	public static function wr_mm_hook_prefix( $prefix = '' )
	{
		if ( 'admin' == $prefix && class_exists( 'WR_Megamenu_Helpers_Functions' ) && WR_Megamenu_Helpers_Functions::is_modal() ) {
			$prefix = 'mm_admin';
		}

		return $prefix;
	}


	/**
	 * Apply 'wr_mm_register_assets' filter.
	 * @param   array $assets Current assets.
	 * @return  array
	 */
	public static function wr_mm_register_assets( $assets = array() )
	{
		// Prepare assets path
		self::$assets = WR_Megamenu_Init_Assets::prepare( self::$assets, basename( dirname( dirname( dirname( __FILE__ ) ) ) ) );

		if ( ! is_admin() ) {
			$assets[ 'wr-mm-bootstrap-css' ] = array(
				'src' => WR_MEGAMENU_ROOT_URL . 'assets/3rd-party/bs3/bootstrap/css/bootstrap_frontend.min.css',
				'ver' => '3.0.2',
			);
			$assets[ 'wr-mm-bootstrap-js' ] = array(
				'src'  => WR_MEGAMENU_ROOT_URL . 'assets/3rd-party/bs3/bootstrap/js/bootstrap_frontend.min.js',
				'ver'  => '3.0.2',
				'deps' => array( 'jquery' ),
			);
		}

		$assets[ 'wr-mm-modal-js' ] = array(
			'src' => WR_MEGAMENU_ROOT_URL . 'assets/woorockets/js/modal.js',
			'ver' => '1.0.0',
		);

		$assets[ 'wr-mm-handleelement-js' ] = array(
			'src' => WR_MEGAMENU_ROOT_URL . 'assets/woorockets/js/handle_element.js',
			'ver' => '1.0.0',
		);

		$assets[ 'wr-mm-handlesetting-js' ] = array(
			'src' => WR_MEGAMENU_ROOT_URL . 'assets/woorockets/js/handle_setting.js',
			'ver' => '1.0.0',
		);

		$assets[ 'wr-zeroclipboard-js' ] = array(
			'src' => WR_MEGAMENU_ROOT_URL . 'assets/3rd-party/zeroclipboard/ZeroClipboard.min.js',
			'ver' => '1.3.5',
		);

		$assets[ 'wr-mm-premade-pages-js' ] = array(
			'src' => WR_MEGAMENU_ROOT_URL . 'assets/woorockets/js/premade-pages/premade.js',
			'ver' => '1.0.0',
		);

		$assets[ 'wr-mm-admin-css' ] = array(
			'src' => WR_MEGAMENU_ROOT_URL . 'assets/woorockets/css/form_design.css',
			'ver' => '1.0.0',
		);
		// $assets[ 'wr-mm-jquery-easing-js' ] = array(
		// 'src' => WR_MEGAMENU_ROOT_URL . 'assets/3rd-party/jquery-easing/jquery.easing.min.js',
		// 'ver' => '1.3',
		// );
		$assets[ 'wr-mm-layout-js' ] = array(
			'src'  => WR_MEGAMENU_ROOT_URL . 'assets/woorockets/js/layout.js',
			'deps' => array( 'wr-jquery-easing-js' ),
			'ver'  => '1.0.0',
		);
		$assets[ 'wr-mm-widget-js' ] = array(
			'src' => WR_MEGAMENU_ROOT_URL . 'assets/woorockets/js/widget.js',
			'ver' => '1.0.0',
		);
		$assets[ 'wr-mm-placeholder' ] = array(
			'src' => WR_MEGAMENU_ROOT_URL . 'assets/woorockets/js/placeholder.js',
			'ver' => '1.0.0',
		);

		$assets[ 'wr-mm-jqueryfancybox-css' ] = array(
			'src' => WR_MEGAMENU_ROOT_URL . 'assets/3rd-party/jquery-fancybox/jquery.fancybox-1.3.4.css',
			'ver' => '1.3.4',
		);

		$assets[ 'wr-mm-jqueryfancybox-js' ] = array(
			'src' => WR_MEGAMENU_ROOT_URL . 'assets/3rd-party/jquery-fancybox/jquery.fancybox-1.3.4.js',
			'ver' => '1.3.4',
		);
		
		$assets[ 'wr-mm-imagefrontend-js' ] = array(
			'src' => WR_MEGAMENU_ROOT_URL . 'shortcodes/image/assets/js/image_frontend.js',
		);
	
		return array_merge( $assets, self::$assets );
	}
}
