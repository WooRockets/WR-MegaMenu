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

if ( ! class_exists( 'WR_Megamenu_Product_Update' ) ) :

/**
 * Product update class.
 *
 * @package  WR_Library
 * @since    1.0.0
 */
class WR_Megamenu_Product_Update extends WR_Megamenu_Product_Info {
	/**
	 * Installed WooRockets product.
	 *
	 * @var  array
	 */
	protected static $plugins = array();

	/**
	 * Hook into WordPress.
	 *
	 * @return  void
	 */
	public static function hook() {
		// Register necessary action and filter
		static $registered;

		if ( ! isset( $registered ) ) {
			// Execute parent hook
			parent::hook();

			// Register filter to get product update
			add_filter( 'site_transient_update_plugins', array( __CLASS__, 'site_transient_update_plugins' ) );

			// Register action to display product update details
			add_action( 'install_plugins_pre_plugin-information', array( __CLASS__, 'install_plugins_pre_information' ) );

			// Register filter to post-process product update
			add_filter( 'upgrader_post_install', array( __CLASS__, 'upgrader_post_install' ), 10, 3 );

			$registered = true;
		}

		// Get installed product
		$plugins = array_unique( apply_filters( 'wr_mm_installed_product', array() ) );

		// Get product info
		foreach ( $plugins as $plugin ) {
			if ( ! isset( self::$plugins[ $plugin ] ) ) {
				self::$plugins[ $plugin ] = self::get( $plugin );
			}
		}
	}

	/**
	 * Set site transient to fetch update information.
	 *
	 * @param   array  $value  The value of update_plugins site transient.
	 *
	 * @return  mixed
	 */
	public static function site_transient_update_plugins( $value ) {
		if ( count( self::$plugins ) ) {
			// Preset value
			if ( ! is_object( $value ) ) {
				$value = (object) array( 'response' => array() );
			}

			foreach ( self::$plugins as $identification => $plugin ) {
				if ( ! empty( $plugin ) ) {
					// Get plugin base name
					$plugin_basename = plugin_basename( $plugin['Main_File'] );

					// Check if plugin has update
					$updatable = self::updatable( $plugin['Item_ID'] );

					if ( $updatable ) {
						if ( ! isset( $updatable->purchase_data ) || ! isset( $updatable->purchase_data->download_url ) ) {
							// Create action links handle
							$id = str_replace( '-', '_', $identification );

							eval('function wr_mm_action_links_' . $id . '( $links ) { return ' . __CLASS__ . '::action_links( "' . $id . '", $links ); }' );

							// Register filter to change plugin action links
							add_filter( 'plugin_action_links_' . $plugin_basename, 'wr_mm_action_links_' . $id );

							// Continue the loop
							continue;
						}

						// Set update response
						$value->response[ $plugin_basename ] = (object) array(
							'id'          => 0,
							'slug'        => 'woorockets.' . $identification,
							'new_version' => $updatable->last_update,
							'url'         => $updatable->url,
							'package'     => $updatable->purchase_data->download_url,
						);
					}
				}
			}
		}

		return $value;
	}

	/**
	 * Display product update details.
	 *
	 * @return  void
	 */
	public static function install_plugins_pre_information() {
		// Check if plugin belongs to WooRockets
		if ( 0 === strpos( $_REQUEST['plugin'], 'woorockets.' ) ) {
			// Get plugin information
			if ( $plugin = self::get( str_replace( 'woorockets.', '', $_REQUEST['plugin'] ) ) ) {
				header( 'Location: ' . $plugin['PluginURI'] );

				// Exit immediately to prevent WordPress from processing further
				exit;
			}
		}
	}

	/**
	 * Post-process product update.
	 *
	 * @param   boolean  $response    Install response.
	 * @param   array    $hook_extra  Extra arguments passed to hooked filters.
	 * @param   array    $result      Installation result data.
	 *
	 * @return  void
	 */
	public static function upgrader_post_install( $response, $hook_extra, $result ) {
		if ( count( self::$plugins ) ) {
			foreach ( self::$plugins as $plugin ) {
				if ( ! empty( $plugin ) ) {
					// Get plugin base name
					$plugin_basename = plugin_basename( $plugin['Main_File'] );

					if ( $plugin_basename == $hook_extra['plugin'] ) {
						// Set new last update time
						update_option( "{$plugin['Item_ID']}_last_update", date( 'D M d H:i:s O Y' ) );

						// Finalize plugin update
						if ( '.tmp' === substr( $result['destination_name'], -4 ) ) {
							// Get WordPress Filesystem Abstraction object
							$wp_filesystem = WR_Megamenu_Init_File_System::get_instance();

							// Remove existing plugin directory
							$name = substr( $result['destination_name'], 0, -4 );

							if ( $wp_filesystem->exists( $result['local_destination'] . '/' . $name ) ) {
								$wp_filesystem->delete( $result['local_destination'] . '/' . $name, true );
							}

							// Rename temporary plugin directory
							$wp_filesystem->move( $result['destination'], $result['local_destination'] . '/' . $name );

							// Re-activate plugin
							activate_plugin( $result['local_destination'] . '/' . $hook_extra['plugin'], '', is_network_admin(), true );
						}
					}
				}
			}
		}
	}

	/**
	 * Change plugin action links.
	 *
	 * @param   string  $identification  WooRockets plugin identification.
	 * @param   array   $links           Current action links.
	 *
	 * @return  void
	 */
	public static function action_links( $identification, $links ) {
		// Apply filter to get plugin settings link
		$settings_link = apply_filters( "{$identification}_settings_url", '#' );

		// Generate HTML link to ask user input purchase data
		$html = sprintf(
			__( "<a href='%s'>Please input Envato information to get product's updates</a>", WR_LIBRARY_TEXTDOMAIN ),
			$settings_link
		);

		return array_merge( $links, ( array ) $html );
	}
}

endif;
