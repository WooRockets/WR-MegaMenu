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
 * WordPress update simulator.
 *
 * @package  WR_Megamenu
 * @since    1.0.0
 */
class WR_Megamenu_Update_Simulator {
	/**
	 * Hook into WordPress.
	 *
	 * @return  void
	 */
	public static function hook() {
		// Register necessary filters
		add_filter( 'site_transient_update_plugins', array( __CLASS__, 'site_transient_update_plugins' ) );
	}

	/**
	 * Set site transient to fake update information.
	 *
	 * @param   array  $value  The value of update_plugins site transient.
	 *
	 * @return  mixed
	 */
	public static function site_transient_update_plugins( $value ) {
		// Get update simulator settings
		$settings = WR_Megamenu_Settings::get();

		if ( @$settings['update-simulator'] ) {
			$update = array();

			// Preset value
			if ( ! is_object( $value ) ) {
				$value = (object) array( 'response' => array() );
			}

			foreach ( array( 'pagebuilder', 'uniform', 'poweradmin' ) as $plugin ) {
				// Simulate update info for configured plugins
				if ( ! empty( $settings[ "wr-{$plugin}-version" ] ) && ! empty( $settings[ "wr-{$plugin}-link" ] ) ) {
					// Simulate update available only if plugin is installed
					if ( @is_file( WP_PLUGIN_DIR . '/' . $settings[ "wr-{$plugin}-file" ] ) ) {
						// Make simulated version is really newer
						$current = WR_Megamenu_Product_Info::get( WP_PLUGIN_DIR . '/' . $settings[ "wr-{$plugin}-file" ] );

						if ( version_compare( $current['Version'], $settings[ "wr-{$plugin}-version" ], '<' ) ) {
							$value->response[ $settings[ "wr-{$plugin}-file" ] ] = (object) array(
								'id'          => 0,
								'slug'        => "wr-{$plugin}",
								'new_version' => $settings[ "wr-{$plugin}-version" ],
								'url'         => "https://wordpress.org/plugins/wr-{$plugin}/",
								'package'     => $settings[ "wr-{$plugin}-link" ],
							);
						}
					}
				}
			}
		}

		return $value;
	}
}
