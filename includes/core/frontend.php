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

class WR_Megamenu_Core_Frontend {

	private $profile_id = 0;

	private $settings = null;

	private $echo = null;
	
	/**
	 * Mega a menu in a location if mapped
	 * with saved data from builder
	 */
	function apply_megamenu() {
		add_filter( 'wr_mm_register_assets',  array( &$this, 'register_assets' ) );
		$this->load_base_assets();

		add_filter( 'wp_nav_menu_args',       array( $this, 'get_args' ), 100 );
		add_filter( 'wp_setup_nav_menu_item', array( &$this, 'setup_nav_item' ) );
		add_filter( 'wp_nav_menu_objects',    array( $this, 'nav_menu_objects' ), 10, 2 );
	}

	/**
	 * Generate arguments depends on location and menu
	 */
	function get_args( $args ) {
		$this->profile_id = WR_Megamenu_Helpers_Functions::get_profile_by_location( $args['theme_location'] );

		if ( $this->profile_id ) {

			// Show only once in one location
			if ( $this->echo == $args['theme_location'] ) {
				$args['echo'] = FALSE;
			}
			$this->echo = $args['theme_location'];
			
			$args['profile_id'] = $this->profile_id;
			$this->settings	    = WR_Megamenu_Helpers_Builder::get_megamenu_data( $this->profile_id );
			// load assets for a profile
			$this->load_profile_assets();

			$menu_type = $this->settings['menu_type'];
			$location  = $this->settings['location'];

			// Get the nav menu based on the requested menu
			$menu      = wp_get_nav_menu_object( $menu_type );
			$locations = get_nav_menu_locations();
			
			if ( ! $menu && $location && isset( $locations[ $location ] ) ) {
				// Get the nav menu based on the theme_location
				$menu = wp_get_nav_menu_object( $locations[$location] );
			}
			
			if ( $menu && $menu->term_id == $menu_type && isset( $locations[ $location ] ) ) {
				$args['menu_type']      = $menu_type;
				$args['theme_location'] = $location;

				$helper = new WR_Megamenu_Helpers_Frontend();

				return $helper->get_args( $args );
			} else {
				return $args;
			}
		} else {
			return $args;
		}

		return $args;

	}
	
	function setup_nav_item( $menu_item ) {
		$icon = get_post_meta( $menu_item->ID, '_icon_mega_', true );

		$menu_item->icon = $icon;

		return $menu_item;
	}
	
	function nav_menu_objects( $sorted_menu_items, $args ) {
		// Add class menu-parent-item for menu has sub-menu items
		foreach ( $sorted_menu_items as $i => &$menu ) {
			if ( ! empty( $menu->classes ) ) {
				foreach ( $menu->classes as $j => $class ) {
					if ( strtolower( $class ) == 'menu-item-has-children' ) {
						$menu->classes[] = 'menu-parent-item';
						break;
					}
				}
			}
		}
		
		return $sorted_menu_items;
	}

	function load_base_assets() {
		WR_Megamenu_Init_Assets::load( array( 'wr-bootstrap3-frontend-js', 'wr-mm-bootstrap3-icomoon-css', 'wr-font-awesome-css', 'wr-megamenu-site-css', 'wr-megamenu-site-js' ) );
	}

	public function load_profile_assets() {
		$profile_selector = $this->settings['location'] .'_' . $this->profile_id ;
		$theme_style      = isset( $this->settings['theme_style'] ) ? $this->settings['theme_style'] : '';
		$themes_options   = get_post_meta( $this->profile_id, WR_MEGAMENU_META_KEY . '_themes_options', true );
		$themes_options   = json_decode( $themes_options, true );

		// Load profile theme
		$default           = isset( $theme_style ) && ( $theme_style != '' ) ? $theme_style . '/' . $theme_style . '.css' : 'default/default.css';
		$profile_theme_url = WR_MEGAMENU_ROOT_URL . 'themes/'. $default;

		wp_enqueue_style( "wr-{$this->profile_id}", $profile_theme_url, array(), '1.0' );
		
		if ( isset( $themes_options[ $theme_style ] ) ) {
			$theme_options = $themes_options[ $theme_style ];
			$setting	   = json_decode( $theme_options, true );
			$style         = '';

			// Menu bar
			$style .= '.wr-megamenu-container.' . $profile_selector . ' {background: ' . $setting['menu-bar-bg'] . ' !important;}';
			$style .= '.' . $profile_selector . ' .wr-mega-menu > li:hover > a, .' . $profile_selector . ' .wr-mega-menu > li.focus > a {background: ' . $setting['menu-bar-on_hover'] . ' !important;}';

			if ( $setting['menu-bar-font'] != 'inherit' ) {
				$style .= '.' . $profile_selector . ' .wr-mega-menu > li > a {
							 color: ' . $setting['menu-bar-menu_color'] . ' !important;
							 font-family: ' . $setting['menu-bar-font_face'] . ' !important;
							 font-size:' . $setting['menu-bar-font_size'] . 'px !important;
							 font-weight:' . $setting['menu-bar-font_weight'] . ' !important;
						 }';
			}

			if ( $setting['menu-bar-icon_display_mode'] == 'icon_only' ) {
				$style .= ".$profile_selector .wr-mega-menu > li > a .menu_title, .$profile_selector .wr-mega-menu .sub-menu a .menu_title, .$profile_selector .wr-mega-menu .block-sub-menu a .ig-menu-title {display:none;}";
			} else if ( $setting['menu-bar-icon_display_mode'] == 'text_only' ) {
				$style .= ".$profile_selector .wr-mega-menu > li > a > i, .$profile_selector .wr-mega-menu .sub-menu a i {display:none !important;}";
			}

			$style .= ".$profile_selector .wr-mega-menu > li > a > i {font-size: " . $setting['menu-bar-icon_size'] . 'px !important;}';

			if ( $setting['menu-bar-icon_position'] == 'top' ) {
				$style .= ".$profile_selector .wr-mega-menu > li > a > i {display:block !important;}";
				$style .= ".$profile_selector .wr-mega-menu > li > a > i {text-align: center; width: 100% !important ;}";

			}
			
			if ( $setting['heading-text-font'] != 'inherit' ) {
				$style .= '.' . $profile_selector . ' .wr-mega-menu a.caption {
							 color: ' . $setting['heading-text-menu_color'] . ' !important;
							 font-family: ' . $setting['heading-text-font_face'] . ' !important;
							 font-size:' . $setting['heading-text-font_size'] . 'px !important;
							 font-weight:' . $setting['heading-text-font_weight'] . ' !important;
						 }';
			}

			if ( $setting['normal-text-font'] != 'inherit' ) {
				$style .= '.' . $profile_selector . ' ul.sub-menu li a,
							ul.submenu-items li a {
							 color: ' . $setting['normal-text-menu_color'] . ' !important;
							 font-family: ' . $setting['normal-text-font_face'] . ' !important;
							 font-size:' . $setting['normal-text-font_size'] . 'px !important;
							 font-weight:' . $setting['normal-text-font_weight'] . ' !important;
						 }';
			}
			
			WR_Megamenu_Init_Assets::print_inline( 'css', $style );

			$script = ' ';
			if ( $setting['menu-bar-menu_layout'] == 'vertical' ) {
				$script .= " $( '.wr-megamenu-container.$profile_selector' ).addClass( 'vertical' );";
			}

			if ( $setting['submenu-panel-bullet_icon'] == 'yes' ) {
				$script .= "$( '.$profile_selector ul.sub-menu li a, .$profile_selector ul.submenu-items li a' ).prepend( '<i class=\"glyphicon glyphicon-chevron-right\"></i>' );";
			}

			if ( $setting['menu-bar-stick_menu'] == 'yes' ) {
				$script .= "$(document).scroll(function () {
								var y = $(document).scrollTop(),
								mega_container = $( '.wr-megamenu-container.$profile_selector' );
								responsive = $( '.it-responsive-mega' );
								if (y > mega_container.parent().offset().top) {
									mega_container.addClass( 'stick' );
									responsive.addClass( 'stick' );
								} else {
									mega_container.removeClass( 'stick' );
									responsive.removeClass( 'stick' );
								}
							});";
			}

			WR_Megamenu_Init_Assets::inline( 'js', $script );

		}

		$script = "

			$( '.$profile_selector .mega-item.wr-megamenu-fixed, .$profile_selector .menu-item-has-children.menu-default' ).on( 'hover', function () {

				var
					mega_inner = null,
					mega_menu = $(this).find( ' > .wr-megamenu-inner' ),
					sub_menu = $(this).find( ' > .sub-menu' ),
					is_mega_inner = false
					;

				if (sub_menu.length > 0) {
					mega_inner = sub_menu;
				} else if (mega_menu.length > 0) {
					mega_inner = mega_menu;
					is_mega_inner = true;
				}
				if (mega_inner != null) {
					if (mega_inner.outerWidth() > ($(window).outerWidth() - mega_inner.offset().left ) ) {
						if (!is_mega_inner) {
							mega_inner.addClass( 'wr-megamenu-rtl' );
							$( '.$profile_selector ul.sub-menu li.wr-megamenu-item' ).css({'text-align': 'right', 'background': 'inherit'});
							$( '.$profile_selector ul.wr-mega-menu ul ul.sub-menu' ).css( 'right', '99%' );
							$( '.$profile_selector ul.wr-mega-menu ul li' ).on( 'hover', function () {
								$(this).find( '> ul.sub-menu' ).css({'right': '100%'});
							});
							$( '.wr-megamenu-container.$profile_selector ul ul' ).addClass('pull-right');
						} else {
							mega_inner.addClass('wr-megamenu-left-inner');
						}
					}
				}
			});
		";
		
		WR_Megamenu_Init_Assets::inline( 'js', $script );

		// Custom css
		$custom_css_data = WR_Megamenu_Helpers_Functions::custom_css_data( isset ($this->profile_id) ? $this->profile_id : NULL );
		extract( $custom_css_data );

		$css_files = stripslashes( $css_files );

		if ( ! empty( $css_files ) ) {
			$css_files = json_decode( $css_files );
			$data	   = $css_files->data;

			foreach ( $data as $idx => $file_info ) {
				$checked = $file_info->checked;
				$url     = $file_info->url;

				// if file is checked to load, enqueue it
				if ( $checked ) {
					echo balanceTags( "<link rel='stylesheet' id='wr-mg-custom-file-{$this->profile_id}-{$idx}'  href='/{$url}' type='text/css' media='all' />" );
				}
			}
		}

		$css_custom = stripslashes( $css_custom );

		if ( ! empty( $css_custom ) ) {
			WR_Megamenu_Init_Assets::print_inline( 'css', $css_custom );
		}

	}

	function register_assets( $assets ) {
		return array_merge(
			$assets,
			array(
				'wr-megamenu-site-js' => array(
					'src' => WR_MEGAMENU_ROOT_URL . 'assets/js/frontend.js',
				),
				'wr-megamenu-site-css' => array(
					'src' => WR_MEGAMENU_ROOT_URL . 'assets/css/frontend.css',
				),
			)
		);
	}

}
