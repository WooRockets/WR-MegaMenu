<?php
/*
Plugin Name: WR MegaMenu
Plugin URI: http://woorockets.com
Description: WR MegaMenu
Version: 1.1.3
Author: WooRockets
Author URI: http://woorockets.com
License: GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/
// Load class auto-loader
require_once dirname( __FILE__ ) . '/includes/loader.php';

// Include constant definition file
include_once dirname( __FILE__ ) . '/defines.php';

// Activate WR MegaMenu plugin
register_activation_hook( WR_MEGAMENU_MAIN_FILE, array( 'WR_Megamenu_Plugin', 'on_activation' ) );
// Redirect after plugin activation
add_action( 'admin_init', array( 'WR_Megamenu_Plugin', 'do_activation_redirect' ) );

// Register WR MegaMenu Plugin initialization
add_action( 'wr_megamenu_init', array( 'WR_Megamenu_Plugin', 'init' ) );
// Initialize WR Library
WR_Megamenu_Init_Plugin::hook();
