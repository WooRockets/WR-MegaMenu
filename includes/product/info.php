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

if ( ! class_exists( 'WR_Megamenu_Product_Info' ) ) :

/**
 * Product info class.
 *
 * @package  WR_Library
 * @since	1.0.0
 */
class WR_Megamenu_Product_Info {
	/**
	 * Link to get product information.
	 *
	 * @var  string
	 */
	protected static $product_info = 'http://www.woorockets.com/versioning/wr_plugins.php';

	/**
	 * Link to get product installation package.
	 *
	 * @var  string
	 */
	protected static $product_download = 'http://www.woorockets.com/index.php?option=com_lightcart&controller=remoteconnectauthentication&task=authenticate&tmpl=component';

	/**
	 * Link to check product upgrade availability.
	 *
	 * @var  string
	 */
	protected static $product_upgrade = 'http://www.woorockets.com/versioning/product_upgrade.php';

	/**
	 * Retrieved product information.
	 *
	 * @var  array
	 */
	protected static $product_info_data;

	/**
	 * Time to cache product information.
	 *
	 * @var  integer
	 */
	protected static $cache_time = 86400;

	/**
	 * Products information.
	 *
	 * @var  array
	 */
	protected static $products = array();

	/**
	 * Method to get product info.
	 *
	 * Product info will be returned in the following format:
	 *
	 * array(
	 *	 'Name'			 => 'WR Sample',
	 *	 'Description'	  => 'Sample plugin that demonstrates the functionality of WR Library (WooRockets’s shared library). By woorockets.com.',
	 *	 'Version'		  => '1.0.0',
	 *	 'Identified_Name'  => 'wr-sample',
	 *	 'Addons'		   => null,
	 *	 'Available_Update' => 0,
	 * )
	 *
	 * @param   string  $plugin  Path to plugin main file.
	 *
	 * @return  mixed  Plugin info if plugin is installed, NULL otherwise.
	 */
	public static function get( $plugin ) {
		// Verify plugin main file
		if ( false === strpos( $plugin, '/' ) && false === strpos( $plugin, '\\' ) && ! @is_file( $plugin ) ) {
			$plugin = self::check( $plugin );

			if ( empty( $plugin ) ) {
				return null;
			}
		}

		// Request product info only if not available
		if ( ! isset( self::$products[ $plugin ] ) ) {
			// Get plugin data if neccessary
			if ( function_exists( 'get_plugin_data' ) ) {
				$data = get_plugin_data( $plugin );
			}

			// Get plugin folder name
			$name = str_replace( '-', '_', basename( dirname( $plugin ) ) );

			// Get extra info from constant
			foreach ( array( 'Identified_Name' => null, 'Addons' => null ) as $key => $default ) {
				// Generate constant name
				$const = strtoupper( "{$name}_{$key}" );

				if ( ! defined( $const ) && @is_file( dirname( $plugin ) . '/defines.php' ) ) {
					include_once dirname( $plugin ) . '/defines.php';
				}

				// Get constant value
				if ( defined( $const ) ) {
					eval( '$const = ' . $const . ';' );
				} else {
					$const = $default;
				}

				// Store extra info
				$data[ $key ] = $const;
			}

			// Get information about product add-ons and available update
			if ( isset( $data['Identified_Name'] ) && ! empty( $data['Addons'] ) ) {
				// Preset add-ons
				$addons = array();

				if ( is_string( $data['Addons'] ) ) {
					// Get add-ons details
					$items = explode( ',', $data['Addons'] );

					foreach ( $items as $name ) {
						// Check if add-on is installed
						$addon = self::get( $name );

						// Define add-on info
						if ( $addon ) {
							$addons[ $addon['Identified_Name'] ] = $addon['Version'];
						} else {
							$addons[ str_replace( '-', '_', $name ) ] = null;
						}
					}
				} elseif ( true === $data['Addons'] ) {
					$addons = $data['Identified_Name'] . '_addons';
				}

				// Get product add-ons information
				$data['Available_Update'] = 0;

				if ( $results = self::addons( $addons ) ) {
					// Count available update
					foreach ( $results as $result ) {
						// Verify core and add-on compatibility
						$result->compatible = true;

						if ( isset( $result->tags ) && ! empty( $result->tags ) ) {
							$result->compatible = version_compare( $data['Version'], $result->tags, '>=' );
						}

						if ( $result->compatible && $result->updatable ) {
							$data['Available_Update']++;
						}
					}

					// Store product add-ons information
					$data['Addons'] = $results;
				}
			}

			self::$products[ $plugin ] = $data;
		}

		return self::$products[ $plugin ];
	}

	/**
	 * Method to get product add-ons and available update.
	 *
	 * @param   array	$addons		Either product add-ons category name or an array of product add-ons, e.g. array( 'wr-addon-1' => '1.0.0', 'wr-addon-2' => null ).
	 * @param   array	$product_info  Latest product info from WooRockets server.
	 * @param   array	$results	   Current results.
	 *
	 * @return  array
	 */
	public static function addons( $addons, $product_info = array(), $results = array() ) {
		global $pagenow;

		// Get latest product info
		if ( ! @count( $product_info ) ) {
			$product_info = self::info();

			if ( ! $product_info ) {
				return false;
			}
		}

		// Get product add-ons information
		if ( is_array( $addons ) ) {
			// Get product add-ons information from a pre-defined array of add-ons
			foreach ( $addons as $addon => $current ) {
				if ( ! isset( $results[ $addon ] ) ) {
					foreach ( $product_info->items as $item ) {
						if ( isset( $item->items ) ) {
							// Check recursively
							$results = self::addons( array( $addon => $current ), $item, $results );

							continue;
						}

						if ( isset( $item->identified_name ) && $item->identified_name == $addon ) {
							// Found add-on
							$results[ $addon ] = $item;

							break;
						}
					}

					// Check if add-on update is available?
					if ( isset( $results[ $addon] ) && ! isset( $results[ $addon ]->updatable ) ) {
						// Set default installation and update status
						$results[ $addon ]->installed = false;
						$results[ $addon ]->updatable = false;

						// Check if add-on is installed?
						if ( ! empty( $current ) ) {
							$results[ $addon ]->installed = true;

							// Check if add-on has newer version?
							if ( version_compare( $results[ $addon ]->version, $current, '>' ) ) {
								$results[ $addon ]->updatable = true;
							}
						}

						// If authentication is not defined then it is not required
						if ( ! isset( $results[ $addon ]->authentication ) ) {
							$results[ $addon ]->authentication = false;
						}
					}
				}
			}
		} elseif ( is_string( $addons ) && '_addons' == substr( $addons, -7 ) ) {
			// Get product add-ons information from product info retrieved from WooRockets server
			foreach ( $product_info->items as $item ) {
				if ( ! isset( $item->category_codename ) || $item->category_codename != $addons ) {
					continue;
				}

				// Reset add-ons
				$addons = array();

				foreach ( $item->items as $product ) {
					// Check if add-on is installed
					$addon = self::get( $product->identified_name );

					// Define add-on info
					$addons[ $product->identified_name ] = $addon ? $addon['Version'] : null;
				}

				// If we have an array of product add-ons, re-call this method to get real data
				if ( is_array( $addons ) && count( $addons ) ) {
					$results = self::addons( $addons, $item );
				} else {
					return false;
				}

				break;
			}
		}

		return $results;
	}

	/**
	 * Check if a plugin is installed or not?
	 *
	 * @param   string   $name	  Plugin's identified name defined in WooRockets server.
	 * @param   boolean  $abs_path  Return either absolute path to plugin main file or just plugin slug?
	 *
	 * @return  mixed  Either absolute path to plugin main file or plugin slug if plugin is installed, NULL otherwise.
	 */
	protected static function check( $name, $abs_path = true ) {
		// Check if this plugin is installed
		$name	   = str_replace( '_', '-', trim( $name ) );
		$plugin	 = null;
		$plugin_dir = WP_PLUGIN_DIR;

		if ( @is_file( "{$plugin_dir}/{$name}.php" ) ) {
			$plugin = "{$plugin_dir}/{$name}.php";
		}

		if ( ! $plugin && @is_file( "{$plugin_dir}/{$name}/main.php" ) ) {
			$plugin = "{$plugin_dir}/{$name}/main.php";
		}

		if ( ! $plugin && @is_file( "{$plugin_dir}/{$name}/{$name}.php" ) ) {
			$plugin = "{$plugin_dir}/{$name}/{$name}.php";
		}

		if ( $plugin && ! $abs_path ) {
			$plugin = str_replace( "{$plugin_dir}/", '', $plugin );
		}

		return $plugin;
	}

	/**
	 * Get latest product info from WooRockets server.
	 *
	 * @return  array
	 */
	protected static function info() {
		// Get WordPress's WordPress Filesystem Abstraction object
		$wp_filesystem = WR_Megamenu_Init_File_System::get_instance();

		// Request WooRockets server for product info only if not available
		if ( ! isset( self::$product_info_data ) ) {
			// Generate path to cache file
			$path = wp_upload_dir();
			$path = $path['basedir'] . '/woorockets/cache';

			if ( ! @is_dir( $path ) ) {
				$result = explode( '/', str_replace( '\\', '/', $path ) );
				$path   = array();

				while ( count( $result ) ) {
					$path[] = current( $result );

					if ( ! @is_dir( implode( '/', $path ) ) ) {
						$wp_filesystem->mkdir( implode( '/', $path ), 0755 );
					}

					// Shift paths
					array_shift( $result );
				}
			}

			$path = ( is_array( $path ) ? implode( '/', $path ) : $path ) . '/product_info.json';

			// Check if we need to get product info from WooRockets.com server
			$refresh = false;

			if ( ! $wp_filesystem->is_file( $path ) || self::$cache_time < ( time() - $wp_filesystem->mtime( $path ) ) ) {
				$refresh = true;
			}

			if ( $refresh ) {
				// Request WooRockets.com server for product info
				$result = download_url( self::$product_info );

				if ( ! is_wp_error( $result ) ) {
					self::$product_info_data = json_decode( $wp_filesystem->get_contents( $result ) );

					if ( self::$product_info_data ) {
						// Move temporary file to cache folder
						$wp_filesystem->move( $result, $path, true );
					} else {
						// Remove temporary file
						$wp_filesystem->delete( $result );
					}
				}
			} else {
				// Get product info from cache file
				self::$product_info_data = json_decode( $wp_filesystem->get_contents( $path ) );
			}
		}

		return self::$product_info_data;
	}
}

endif;
