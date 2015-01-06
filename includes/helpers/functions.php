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

class WR_Megamenu_Helpers_Functions {

	// Store how many times the action is executed
	static $run_time = 0;
	/**
	 * Translation for Javascript
	 *
	 * @return array
	 */
	static function js_translation() {
	
		$default = array(
			'site_url'       => site_url(),
			'delete_row'     => __( 'Are you sure you want to delete the whole row including all elements it contains?', WR_MEGAMENU_TEXTDOMAIN ),
			'delete_column'  => __( 'Are you sure you want to delete the whole column including all elements it contains?', WR_MEGAMENU_TEXTDOMAIN ),
			'delete_element' => __( 'Are you sure you want to delete the element?', WR_MEGAMENU_TEXTDOMAIN ),
			'table'          => array(
				'table1' => __( "A table must has atleast 1 columns. You can't remove this column", WR_MEGAMENU_TEXTDOMAIN ),
				'table2' => __( "A table must has atleast 2 rows. You can't remove this row", WR_MEGAMENU_TEXTDOMAIN ),
				'table3' => __( "Row span/Column span can't be negative", WR_MEGAMENU_TEXTDOMAIN ),
			),
			'saving'        => __( 'Saving content! Please wait a moment.', WR_MEGAMENU_TEXTDOMAIN ),
			'error_tinymce' => __( 'Having error on loading TinyMCE.', WR_MEGAMENU_TEXTDOMAIN ),
			'settings'      => __( 'Settings', WR_MEGAMENU_TEXTDOMAIN ),
			'page_modal'    => __( 'Page Modal', WR_MEGAMENU_TEXTDOMAIN ),
			'convertText'   => __( 'Convert to ', WR_MEGAMENU_TEXTDOMAIN ),
			'shortcodes'    => array(
				'audio1'     => __( 'No audio source selected', WR_MEGAMENU_TEXTDOMAIN ),
				'googlemap1' => __( 'Select Destination Marker', WR_MEGAMENU_TEXTDOMAIN ),
				'video1'     => __( 'No video file selected', WR_MEGAMENU_TEXTDOMAIN ),
			),
			'noneTxt'          => __( 'None', WR_MEGAMENU_TEXTDOMAIN ),
			'invalid_link'     => __( 'The link is invalid', WR_MEGAMENU_TEXTDOMAIN ),
			'noItem'           => __( 'No %s found', WR_MEGAMENU_TEXTDOMAIN ),
			'singleEntry'      => __( 'Single %s', WR_MEGAMENU_TEXTDOMAIN ),
			'copy'             => __( 'copy', WR_MEGAMENU_TEXTDOMAIN ),
			'itemFilter'       => __( '%s Filter', WR_MEGAMENU_TEXTDOMAIN ),
			'startFrom'        => __( 'Start From', WR_MEGAMENU_TEXTDOMAIN ),
			'menu'             => __( 'Menu', WR_MEGAMENU_TEXTDOMAIN ),
			'filterBy'         => __( 'Filter By', WR_MEGAMENU_TEXTDOMAIN ),
			'attributes'       => __( 'Attributes', WR_MEGAMENU_TEXTDOMAIN ),
			'attribute'        => __( 'Attribute', WR_MEGAMENU_TEXTDOMAIN ),
			'option_attribute' => __( 'Option Attribute', WR_MEGAMENU_TEXTDOMAIN ),
			'no_title'         => __( '(Untitled)', WR_MEGAMENU_TEXTDOMAIN ),
			'wr_shortcode'     => __( 'Add Page Element', WR_MEGAMENU_TEXTDOMAIN ),
			'asset_url'        => WR_MEGAMENU_ROOT_URL . 'assets/woorockets/',
			'limit_title'      => __( 'You used up to 50 characters', WR_MEGAMENU_TEXTDOMAIN ),
			'select_layout'    => __( 'The whole content of current Post will be replaced by content of selected Page item. Do you want to continue?', WR_MEGAMENU_TEXTDOMAIN ),
			'disabled'         => array(
				'deactivate' => __( 'Deactivate element', WR_MEGAMENU_TEXTDOMAIN ),
				'reactivate' => __( 'Activate element', WR_MEGAMENU_TEXTDOMAIN ),
			),
			'button'				=> array(
				'select' => __( 'Select', WR_MEGAMENU_TEXTDOMAIN ),
			),
			'layout'				=> array(
				'modal_title'		   => __( 'Select template', WR_MEGAMENU_TEXTDOMAIN ),
				'upload_layout_success' => __( 'Upload successfully', WR_MEGAMENU_TEXTDOMAIN ),
				'upload_layout_fail'    => __( 'Upload fail', WR_MEGAMENU_TEXTDOMAIN ),
				'delete_layout_success' => __( 'Page is deleted successfully', WR_MEGAMENU_TEXTDOMAIN ),
				'delete_layout_fail'    => __( 'Fail. Can\'t delete layout', WR_MEGAMENU_TEXTDOMAIN ),
				'delete_group'          => __( 'All pages in this group will be remove. Do you want to continue ?', WR_MEGAMENU_TEXTDOMAIN ),
				'delete_layout'         => __( 'This page will be remove. Do you want to continue ?', WR_MEGAMENU_TEXTDOMAIN ),
				'no_layout_name'        => __( 'Template name can not be null' ),
				'name_exist'            => __( 'Template name exists. Please choose another one.' ),
			),
			'custom_css' => array(
				'modal_title'    => __( 'Custom CSS', WR_MEGAMENU_TEXTDOMAIN ),
				'file_not_found' => __( "File doesn't exist", WR_MEGAMENU_TEXTDOMAIN ),
			),
			'element_not_existed'   => __( 'Element not existed!', WR_MEGAMENU_TEXTDOMAIN ),
			'take_style'            => __( 'Take Style', WR_MEGAMENU_TEXTDOMAIN ),
			'mega_this_menu'        => __( 'Mega this menu', WR_MEGAMENU_TEXTDOMAIN ),
			'dismega_this_menu'     => __( 'MegaMenu is OFF now, turn it ON to start configuring', WR_MEGAMENU_TEXTDOMAIN ),
		);

		
		return apply_filters( 'wr_mm_js_translation', $default );
	}

	/**
	 * Check if current page is modal page
	 *
	 * @return type
	 */
	public static function is_modal() {
		return ( ! empty( $_GET['wr-mm-gadget'] ) && $_GET['wr-mm-gadget'] == 'edit-element' );
	}

	/**
	 * Check if current page is modal/ preview page
	 *
	 * @return type
	 */
	public static function is_preview() {
		return ( ! empty( $_GET['wr_shortcode_preview'] ) && $_GET['wr_shortcode_preview'] == '1' );
	}

	/**
	 * Check if current page is modal page
	 *
	 * @param type $shortcode
	 *
	 * @return type
	 */
	public static function is_modal_of_element( $shortcode ) {
		if ( empty ( $shortcode ) ) {
			return false;
		}

		return ( WR_Megamenu_Helpers_Functions::is_modal() && isset( $_GET['wr_modal_type'] ) && $_GET['wr_modal_type'] == $shortcode );
	}

	/**
	 * Common js/css file for WR MegaMenu/Wr Modal/Wr Preview Page
	 *
	 * @return type
	 */
	public static function localize_js() {

		return array(
			'ajaxurl'	  => admin_url( 'admin-ajax.php' ),
			'adminroot'	=> admin_url(),
			'rooturl' 	=> admin_url( 'index.php' ),
			'wr_modal_url' => WR_MEGAMENU_URL . '&action=form',
			'_nonce'	   => wp_create_nonce( WR_MEGAMENU_NONCE ),
			'save'		 => __( 'Save', WR_MEGAMENU_TEXTDOMAIN ),
			'cancel'	   => __( 'Cancel', WR_MEGAMENU_TEXTDOMAIN ),
			'delete'	   => __( 'Delete Element', WR_MEGAMENU_TEXTDOMAIN ),
			'builderurl' 	=> WR_MEGAMENU_URL,
			'assets_url'   => WR_MEGAMENU_URL,
		);
	}

	/**
	 * Localize for js files
	 */
	public static function wr_localize() {
		WR_Megamenu_Init_Assets::localize( 'wr-mm', 'Wr_Megamenu_Translate', WR_Megamenu_Helpers_Functions::js_translation() );
		WR_Megamenu_Init_Assets::localize( 'wr-mm', 'Wr_Megamenu_Ajax', WR_Megamenu_Helpers_Functions::localize_js() );

		WR_Megamenu_Init_Assets::localize( 'wr-mm-handleelement', 'Wr_Megamenu_Translate', WR_Megamenu_Helpers_Functions::js_translation() );
		//WR_Megamenu_Init_Assets::localize( 'wr-mm-handleelement', 'Wr_Megamenu_Js_Html', WR_Megamenu_Helpers_Shortcode::$item_html_template );
		WR_Megamenu_Init_Assets::localize( 'wr-mm-handleelement', 'Wr_Megamenu_Ajax', WR_Megamenu_Helpers_Functions::localize_js() );

		WR_Megamenu_Init_Assets::localize( 'wr-mm-layout', 'Wr_Megamenu_Translate', WR_Megamenu_Helpers_Functions::js_translation() );
		WR_Megamenu_Init_Assets::localize(
			'wr-mm-widget', 'Wr_Megamenu_Preview_Html', WR_Megamenu_Helpers_Functions::get_element_item_html(
				array(
					'element_wrapper' => 'div',
					'modal_title'	 => '',
					'element_type'	=> 'data-el-type="element"',
					'name'			=> 'Widget Element Setting',
					'shortcode'	   => 'WR_SHORTCODE_CONTENT',
					'shortcode_data'  => 'WR_SHORTCODE_DATA',
					'content_class'   => 'wr-mm-element',
					'content'		 => 'Widget Element Setting',
				)
			)
		);
		
	}


	/**
	 * Get custom CSS meta data of post
	 *
	 * @param type $post_id
	 * @param type $meta_key
	 * @param type $action : get / put
	 *
	 * @return type
	 */
	static function custom_css( $post_id, $meta_key, $action = 'get', $value = '' ) {
		switch ( $meta_key ) {

			case 'css_files':
				if ( $action == 'get' )
					$result = get_post_meta( $post_id, '_wr_megamenu_css_files', true );
				else {
					$result = update_post_meta( $post_id, '_wr_megamenu_css_files', $value );
				}
				break;

			case 'css_custom':
				if ( $action == 'get' )
					$result = get_post_meta( $post_id, '_wr_megamenu_css_custom', true );
				else
					$result = update_post_meta( $post_id, '_wr_megamenu_css_custom', $value );
				break;

			default:
				break;
		}
		return $result;
	}

	/**
	 * Get custom css data: Css files, Css code of a post
	 *
	 * @global type $post
	 * @param type $post_id
	 * @return type
	 */
	static function custom_css_data( $post_id ) {

		global $post;

		$arr = array( 'css_files' => '', 'css_custom' => '' );
		if ( isset ( $post_id ) ) {
			$arr['css_files']  = WR_Megamenu_Helpers_Functions::custom_css( $post_id, 'css_files' );
			$arr['css_custom'] = WR_Megamenu_Helpers_Functions::custom_css( $post_id, 'css_custom' );
		}

		return $arr;
	}

	/**
	 * Get a default profile
	 *
	 * @return int
	 */
	static function get_profile_by_location( $location ) {
		$posts = get_posts(
			array(
				'post_type'   => array( 'wr_megamenu_profile' ),
				'post_status' => 'publish',
				'orderby'     => 'modified',
				'order'       => 'DESC',
			)
		);
		
		if ( $posts ) {
			foreach ( $posts as $post ) {
				$loc = get_post_meta( $post->ID, '_wr_megamenu_profile_location_', true );
				
				if ( $loc == $location ) {
					return $post->ID;
				}
			}
		}

		return false;

	}


	/**
	 * Get list of defined widgets
	 *
	 * @global type $wp_widget_factory
	 * @return type
	 */
	public static function list_widgets() {
		global $wp_widget_factory;
		$results = array();
		foreach ( $wp_widget_factory->widgets as $class => $info ) {
			$results[$info->id_base] = array(
				'class'	   => $class,
				'name'		=> __( $info->name, WR_MEGAMENU_TEXTDOMAIN ),
				'description' => __( $info->widget_options['description'], WR_MEGAMENU_TEXTDOMAIN )
			);
		}

		return $results;
	}

	/**
	 * Get all neccessary widgets information
	 *
	 * @return type
	 */
	public static function widgets() {
		$wr_megamenu_widgets = array();
		$widgets	   = WR_Megamenu_Helpers_Functions::list_widgets();
		foreach ( $widgets as $id => $widget ) {

			$config = array(
				'shortcode'     => $widget['class'],
				'name'          => $widget['name'],
				'identity_name' => __( 'Widget', WR_MEGAMENU_TEXTDOMAIN ) . ' ' . $widget['name'],
				'extra_'        => sprintf( 'data-value="%1$s" data-type="%2$s" data-sort="%2$s"', esc_attr( $id ), 'widget' ),
				'description'   => $widget['description'],
			);
			$wr_megamenu_widgets[$widget['class']] = $config;
		}

		return $wr_megamenu_widgets;
	}

	/**
	 * Get current shortcode
	 *
	 * @return type
	 */
	public static function current_shortcode() {

		if ( ! empty( $_GET['wr-mm-gadget'] ) && $_GET['wr-mm-gadget'] == 'edit-element' ) {
			$current_shortcode = ! empty( $_GET['wr_modal_type'] ) ? $_GET['wr_modal_type'] : ( ! empty( $_GET['wr_shortcode_name'] ) ? $_GET['wr_shortcode_name'] : '' );
			$current_shortcode = preg_replace( '/(wr_|item_)/', '', $current_shortcode );

			return $current_shortcode;
		}

		return NULL;
	}


	/**
	 * Modify value in array
	 *
	 * @param type $value
	 * @param type $key
	 * @param type $new_values
	 */
	static function wr_arr_walk( &$value, $key, $new_values ) {
		if ( array_key_exists( $value['id'], $new_values ) )
			$value['std'] = $new_values[$value['id']];
	}

	/**
	 * Modify value in array of sub-shortcode
	 *
	 * @param type $value
	 * @param type $key
	 * @param type $new_values
	 */
	static function wr_arr_walk_subsc( &$value, $key, $new_values ) {
		$value['std'] = $new_values[$key];
	}


	/**
	 * Check if asset file is processed | or add asset file to processed list
	 *
	 * @param string $file
	 * @param bool   $assign
	 */
	static private function assets_check( $file, $assign = false ) {
		@session_start();
		if ( self::$run_time == 0 ) {
			unset( $_SESSION );
		}
		self::$run_time ++;

		global $post;
		$post_id = ! empty( $post ) ? $post->ID : 0;

		// Check if this is backend or frontend
		$side = WR_Megamenu_Helpers_Functions::is_preview() ? 'admin' : 'wp';
		// $side = 'default';

		if ( ! $assign ) {
			if ( in_array( $file, @(array) $_SESSION['wr-mm-processed-assets'][$post_id][$side]['assets'] ) ) {
				return;
			}
		} else {
			// store it as processed asset
			$_SESSION['wr-mm-processed-assets'][$post_id]['assets'][$side][] = $file;
		}
	}

	/**
	 * Get assest file in WR MegaMenu assets directory
	 *
	 * @param type $this_
	 * @param type $js_file
	 */
	static private function assets_default( $this_, $js_file ) {

		// if this asset is processed, leave it
		self::assets_check( $js_file );

		// Get js directory of WooRockets
		$wr_gears    = array_values( WR_Megamenu_Helpers_Shortcode::register_provider() );
		$wr_gears_js = $wr_gears[0]['js_shortcode_dir'];

		// Get js directory of shortcodes
		$js_dir = WR_Megamenu_Helpers_Shortcode::get_provider_info( $this_->config['shortcode'], 'js_shortcode_dir' );
		if ( empty( $js_dir ) || ! count( $js_dir ) ) {
			// if doesn't have a js dir, assign WooRockets js dir
			$js_dir = $wr_gears_js;
		}
		$file_path = $js_dir['path'] . '/' . $js_file;
		$file_uri  = $js_dir['uri'] . '/' . $js_file;

		// if file doesn't exist, try to get it in WRPB js dir
		if ( ! file_exists( $file_path ) ) {
			$file_path = $wr_gears_js['path'] . '/' . $js_file;
			$file_uri  = $wr_gears_js['uri'] . '/' . $js_file;
		}

		if ( file_exists( $file_path ) ) {
			self::asset_enqueue_( $file_uri, $js_file, $file_path );

			// store it as processed asset
			self::assets_check( $js_file, true );

			return true;
		}

		return false;
	}

	/**
	 * Get assets in specific shortcode folder
	 *
	 * @param type $require_sc
	 * @param type $js_file
	 * @param type $sc_path
	 * @param type $sc_uri
	 */
	static private function assets_specific_shortcode( $require_sc, $js_file, $sc_path, $sc_uri ) {
		$sc_path = rtrim( $sc_path, '/' );
		$sc_uri  = rtrim( $sc_uri, '/' );

		// Get parent shortcode name
		$require_sc = str_replace( '_', '-', preg_replace( '/(wr_|item_)/', '', $require_sc ) );

		// Get type of asset file
		$type = strpos( $js_file, '.js' ) ? 'js/' : 'css/';

		// Get path & uri
		$file_path = $sc_path . "/$require_sc/assets/$type" . $js_file;
		$file_uri  = $sc_uri . "/$require_sc/assets/$type" . $js_file;

		if ( file_exists( $file_path ) ) {
			self::asset_enqueue_( $file_uri, $js_file, $file_path );
		}
	}

	/**
	 * Enqueue script/style
	 *
	 * @param unknown $file_uri
	 * @param unknown $js_file
	 */
	static private function asset_enqueue_( $file_uri, $js_file, $file_path ) {
		$enqueue = 0;
		$handle  = WR_Megamenu_Init_Assets::file_to_handle( $js_file );

		if ( is_admin() ) {
			$enqueue = 1;
		} else {
			// $wr_mm_settings_cache = get_option( 'wr_mm_settings_cache', 'enable' );
			//
			// if ( $wr_mm_settings_cache == 'enable' ) {
			// self::store_assets_info( $handle, $file_uri, $file_path );
			// } else {
				$enqueue = 1;
			// }
		}

		if ( $enqueue ) {
			WR_Megamenu_Init_Assets::load( $handle, $file_uri );
		}
	}

	/**
	 * Store handle to Session
	 *
	 * @global type $wp_scripts
	 *
	 * @param type  $handle
	 */
	static function store_assets_info( $handle, $src = '', $file_path = '' ) {
		global $wp_scripts, $post;
		$handle_object = array();

		if ( empty ( $_SESSION['wr-mm-assets-frontend'] ) ) {
			$_SESSION['wr-mm-assets-frontend'] = array();
		}
		if ( empty ( $_SESSION['wr-mm-assets-frontend'][$post->ID] ) )
			$_SESSION['wr-mm-assets-frontend'][$post->ID] = array();

		if ( ! ( empty ( $wp_scripts ) && empty ( $wp_scripts->registered ) ) ) {
			if ( array_key_exists( $handle, $wp_scripts->registered ) ) {
				$handle_object = $wp_scripts->registered[$handle];
				$src		   = $handle_object['src'];
			}
		}

		$type = ( substr( $src, - 2 ) == 'js' ) ? 'js' : 'css';
		if ( empty ( $_SESSION['wr-mm-assets-frontend'][$post->ID][$type] ) )
			$_SESSION['wr-mm-assets-frontend'][$post->ID][$type] = array();

		if ( ! array_key_exists( $handle, $_SESSION['wr-mm-assets-frontend'][$post->ID][$type] ) ) {

			$modified_time												   = filemtime( $file_path );
			$_SESSION['wr-mm-assets-frontend'][$post->ID][$type][$file_path] = $modified_time;
		}

	}

	/**
	 * Enqueue assets for shortcodes
	 *
	 * @global type $Wr_Megamenu_By_Sc_Providers
	 *
	 * @param type  $this_	:   current shortcode object
	 * @param type  $extra	:   frontend_assets/ admin_assets
	 * @param type  $post_fix :   _frontend/ ''
	 */
	public static function shortcode_enqueue_assets( $this_, $extra, $post_fix = '' ) {
		$extra_js = isset( $this_->config['exception'] ) && isset( $this_->config['exception'][$extra] ) && is_array( $this_->config['exception'][$extra] );
		$assets   = array_merge( $extra_js ? $this_->config['exception'][$extra] : array(), array( str_replace( 'wr_', '', $this_->config['shortcode'] ) . $post_fix ) );

		foreach ( $assets as $asset ) {
			if ( ! preg_match( '/\.(css|js)$/', $asset ) ) {
				WR_Megamenu_Init_Assets::load( $asset );
			} else {
				global $Wr_Megamenu_By_Sc_Providers;

				if ( empty( $Wr_Megamenu_By_Sc_Providers ) ) {
					continue;
				}

				// load assets file in common assets directory of provider
				$default_assets = self::assets_default( $this_, $asset );

				// if can't find the asset file, search in /assets folder of the shortcode
				if ( ! $default_assets ) {

					// Get path of directory contains all shortcodes of provider
					$shortcode_dir = WR_Megamenu_Helpers_Shortcode::get_provider_info( $this_->config['shortcode'], 'shortcode_dir' );

					if ( $shortcode_dir == WR_MEGAMENU_LAYOUT_PATH ) {
						// this is core PB
						$sc_path = WR_MEGAMENU_ELEMENT_PATH;
						$sc_uri  = WR_MEGAMENU_ROOT_URL . basename( $sc_path );
					} else {
						// Get directory of shortcodes of this provider
						$plugin_path       = WR_Megamenu_Helpers_Shortcode::get_provider_info( $this_->config['shortcode'], 'path' );
						$plugin_uri        = WR_Megamenu_Helpers_Shortcode::get_provider_info( $this_->config['shortcode'], 'uri' );
						$shortcode_dir_arr = (array) WR_Megamenu_Helpers_Shortcode::get_provider_info( $this_->config['shortcode'], 'shortcode_dir' );
						$shortcode_dir     = reset( $shortcode_dir_arr );

						$sc_path = $plugin_path . basename( $shortcode_dir );

						if ( is_dir( $sc_path ) ) {
							$sc_uri = $plugin_uri . basename( $shortcode_dir );
						} else {
							$sc_path = $plugin_path;
							$sc_uri  = $plugin_uri;
						}
					}

					$ext_regex = '/(_frontend)*\.(js|css)$/';
					if ( preg_match( $ext_regex, $asset ) ) {
						// load assets in directory of shortcodes
						$require_sc = preg_replace( $ext_regex, '', $asset );
						self::assets_specific_shortcode( $require_sc, $asset, $sc_path, $sc_uri );
					} else {
						// load js/css file in directory of current shortcode
						$exts = array( 'js', 'css' );

						foreach ( $exts as $ext ) {
							$require_sc = $this_->config['shortcode'];
							$file	   = $asset . ".$ext";

							// if this asset is processed, leave it
							self::assets_check( $file );

							// enqueue or add to cache file
							self::assets_specific_shortcode( $require_sc, $file, $sc_path, $sc_uri );

							// store it as processed asset
							self::assets_check( $file, true );
						}
					}
				}
			}
		}
	}

	/**
	 * Get html item
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	static function get_element_item_html( $data ) {
		$default = array(
			'element_wrapper' => '',
			'modal_title'     => '',
			'element_type'    => '',
			'name'            => '',
			'shortcode'       => '',
			'shortcode_data'  => '',
			'content_class'   => '',
			'content'         => '',
			'action_btn'      => '',
			'has_preview'     => true,
			'this_'           => '',
		);
		$data = array_merge( $default, $data );
		extract( $data );

		$preview_html = '';
		if ( $has_preview ) {
			$preview_html = '<div class="shortcode-preview-container" style="display: none">
					<div class="shortcode-preview-fog"></div>
					<div class="jsn-overlay jsn-bgimage image-loading-24"></div>
				</div>';
		}

		$extra_class  = WR_Megamenu_Helpers_Placeholder::get_placeholder( 'extra_class' );
		$custom_style = WR_Megamenu_Helpers_Placeholder::get_placeholder( 'custom_style' );
		$other_class  = '';

		$tag = $shortcode;
		
		// Check if this element is deactivate
		if ( strpos( $shortcode_data, 'widget_id' ) ) {
			$tag = 'wr_megamenu_widget';
		}
		
		preg_match_all( '/\[' . $tag . '\s+([A-Za-z0-9_-]+=\"[^"\']*\"\s*)*\s*\]/', $shortcode_data, $rg_sc_params );
		
		if ( ! empty( $rg_sc_params[0] ) ) {
			$sc_name_params = ! empty( $rg_sc_params[0][0] ) ? $rg_sc_params[0][0] : $rg_sc_params[0];
			if ( strpos( $sc_name_params , 'disabled_el="yes"' ) !== false ) {
				$other_class = 'disabled';
			}
		}

		// Remove empty value attributes of shortcode tag.
		$shortcode_data = preg_replace( '/\[*([a-z_]*[\n\s\t]*=[\n\s\t]*""\s)/', '', $shortcode_data );

		// Content
		$content = balanceTags( $content );

		$content = apply_filters( 'wr_mm_content', $content, $shortcode_data, $shortcode );

		// action buttons
		$buttons = array(
			'edit'       => '<a href="#" onclick="return false;" title="' . __( 'Edit element', WR_MEGAMENU_TEXTDOMAIN ) . '" data-shortcode="' . $shortcode . '" class="element-edit"><i class="icon-pencil"></i></a>',
			'clone'      => '<a href="#" onclick="return false;" title="' . __( 'Duplicate element', WR_MEGAMENU_TEXTDOMAIN ) . '" data-shortcode="' . $shortcode . '" class="element-clone"><i class="icon-copy"></i></a>',
			'deactivate' => '<a href="#" onclick="return false;" title="' . __( 'Deactivate element', WR_MEGAMENU_TEXTDOMAIN ) . '" data-shortcode="' . $shortcode . '" class="element-deactivate"><i class="icon-checkbox-unchecked"></i></a>',
			'delete'     => '<a href="#" onclick="return false;" title="' . __( 'Delete element', WR_MEGAMENU_TEXTDOMAIN ) . '" class="element-delete"><i class="icon-trash"></i></a>'
		);

		if ( ! empty ( $other_class ) ) {
			$buttons = array_merge(
				$buttons, array(
					'deactivate' => '<a href="#" onclick="return false;" title="' . __( 'Activate element', WR_MEGAMENU_TEXTDOMAIN ) . '" data-shortcode="' . $shortcode . '" class="element-deactivate"><i class="icon-checkbox-partial"></i></a>',
				)
			);
		}

		$action_btns = ( empty( $action_btn ) ) ? implode( '', $buttons ) : $buttons[$action_btn];
		$buttons     = apply_filters( 'wr_mm_button', "<div class='jsn-iconbar'>$action_btns</div>", $shortcode_data, $shortcode );

		return "<$element_wrapper class='jsn-item jsn-element ui-state-default jsn-iconbar-trigger shortcode-container $extra_class $other_class' $modal_title $element_type data-name='$name' $custom_style>
				<i class='drag-element-icon'></i>
				<textarea class='hidden shortcode-content' shortcode-name='$shortcode' data-sc-info='shortcode_content' name='shortcode_content[]' >$shortcode_data</textarea>
				<div class='$content_class'>$content</div>
				$buttons
				$preview_html
			</$element_wrapper>";
	}

	/**
	 * Custom script tag
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	static function script_box( $content = '' ) {
		ob_start();
		?>
		<script type="text/javascript">
			(function ($) {
				$(document).ready(function () {
					<?php echo balanceTags( $content ); ?>
				});
			})(jQuery)
		</script>
		<?php
		return ob_get_clean();
	}

	/*
	 * Get all theme styles from a path
	 * */
	static function get_theme_styles( $dir ) {
		$dirs  = glob( $dir . '/*', GLOB_BRACE + GLOB_ONLYDIR );
		$files = array();
		
		if ( is_array( $dirs ) ) {
			foreach ( $dirs as $dir ) {
				$styles = glob( $dir . '/*.css' );
				if ( ! empty( $styles ) ) {
					$files[ basename( $dir ) ] = basename( $styles[0] );
				}
			}
		}

		return $files;
	}
	/**
	 * Add google link to header
	 *
	 * @param string $font
	 *
	 * @return string
	 */
	static function add_google_font_link_tag( $font ) {
		ob_start();
		?>
		<script type="text/javascript">
			(function ($) {
				$(document).ready(function () {
					var font_val = '<?php echo esc_js( str_replace( ' ', '+', $font ) ); ?>';

					// Check if has a link tag of this font
					var exist_font = 0;
					$( 'link[rel="stylesheet"]' ).each(function (i, ele) {
						var href = $(this).attr( 'href' );
						if (href.indexOf( 'fonts.googleapis.com/css?family=' + font_val) >= 0) {
							exist_font++;
						}
					});

					// if this font is not included at head, add it
					if (!exist_font) {
						$( 'head' ).append("<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=<?php echo esc_attr( $font ); ?>' type='text/css' media='all' />");
					}
				});
			})(jQuery)
		</script>
		<?php
		return ob_get_clean();
	}

	/**
	 * Get folder path
	 *
	 * @param type $folder
	 * @param type $uri
	 *
	 * @return type
	 */
	public static function path( $folder = '', $uri = '' ) {
		$uri = empty ( $uri ) ? WR_MEGAMENU_ROOT_URL : $uri;

		return $uri . $folder;
	}

	/**
	 * Get image id
	 *
	 * @global type $wpdb
	 *
	 * @param type  $image_url
	 *
	 * @return type
	 */
	public static function get_image_id( $image_url = '' ) {
		global $wpdb;
		$attachment_id = false;

		// If there is no url, return.
		if ( '' == $image_url )
			return;

		// Get the upload directory paths
		$upload_dir_paths = wp_upload_dir();

		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
		if ( false !== strpos( $image_url, $upload_dir_paths['baseurl'] ) ) {

			// If this is the URL of an auto-generated thumbnail, get the URL of the original image
			$image_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $image_url );

			// Remove the upload path base directory from the attachment URL
			$image_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $image_url );

			// Finally, run a custom database query to get the attachment ID from the modified attachment URL
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $image_url ) );
		}

		return $attachment_id;
	}

}
