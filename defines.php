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

define( 'WR_MEGAMENU_ROOT_PATH', plugin_dir_path( __FILE__ ) );
define( 'WR_MEGAMENU_ROOT_URL', plugin_dir_url( __FILE__ ) );
define( 'WR_MEGAMENU_MAIN_FILE', WR_MEGAMENU_ROOT_PATH . 'main.php' );
define( 'WR_MEGAMENU_BUILDER_ENTRY_URL', admin_url( 'admin.php?page=wr-megamenu-builder' ) );
define( 'WR_MEGAMENU_META_KEY', '_wr_megamenu_' );
define( 'WR_MEGAMENU_OPTION_KEY', 'wr-megamenu-megaed-menus' );
define( 'WR_MEGAMENU_TMP_WIDGET_OPTION', 'wr-megamenu-tmp-widget-settings' );

// Text domain for WR MegaMenu plugin
define( 'WR_MEGAMENU_TEXTDOMAIN', 'wr-megamenu' );

// Define absolute path of shortcodes folder
define( 'WR_MEGAMENU_LAYOUT_PATH', WR_MEGAMENU_ROOT_PATH . 'includes/shortcode/layout' );
define( 'WR_MEGAMENU_ELEMENT_PATH', WR_MEGAMENU_ROOT_PATH . 'shortcodes' );
define( 'WR_MEGAMENU_ELEMENT_URL', WR_MEGAMENU_ROOT_URL . 'shortcodes' );

// Define nonce ID
define( 'WR_MEGAMENU_NONCE', 'wr_nonce_check' );

// Define product identified name
define( 'WR_MEGAMENU_IDENTIFIED_NAME', 'wr_megamenu' );

// Define URL to load element editor
define( 'WR_MEGAMENU_URL', admin_url( 'admin.php?wr-mm-gadget=edit-element' ) );

// Define Custom Post Type name
define( 'WR_MEGAMENU_POST_TYPE_NAME', 'wr_megamenu_profile' );

// Define absolute path of templates folder
define( 'WR_MEGAMENU_TPL_PATH', WR_MEGAMENU_ROOT_PATH . 'templates' );

//// Register extra path and class suffix with class auto-loader
WR_Megamenu_Loader::register( WR_MEGAMENU_ROOT_PATH . 'includes', 'WR_Megamenu_' );
WR_Megamenu_Loader::register( WR_MEGAMENU_ROOT_PATH . 'includes/plugin', 'WR_Megamenu_' );
