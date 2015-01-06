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
 * WR MegaMenu plugin settings.
 *
 * @package  WR MegaMenu
 * @since	1.0.0
 */
class WR_Megamenu_Settings {
	/**
	 * Define WR Sample settings.
	 *
	 * @var  array
	 */
	protected static $options = array(
		/**
		 * Define name space.
		 */
		'name_space' => 'wr_megamenu_settings',

		/**
		 * Define text domain for language translation.
		 */
		'text_domain' => WR_MEGAMENU_TEXTDOMAIN,



		/**
		 * Define input fields.
		 */
		'fields' => array(

			/**
			 * Fields of General tab
			 */
			'theme-styles' => array(
				'type'     => 'theme-styles',
				'label'    => 'Theme styles',
				'desc'     => 'Select a theme for WR MegaMenu',
				'choices'  => array(),
			),
			'customer-username' => array(
				'type'  => 'text',
				'label' => 'Customer Username',
				'desc'  => 'The username you used at WooRockets website to purchase addons.',
			),

			'customer-password' => array(
				'type'  => 'password',
				'label' => 'Customer Password',
				'desc'  => 'The password you used at WooRockets website to purchase addons.',
			),

		),
		'buttons' => array(
			'wr-mm-submit-form' => array(
				'type'  => 'submit',
				'label' => 'Save Changes',
				'class' => 'button button-primary',
			)
		),
		/**
		 * Define form action URL.
		 */
		'action' => 'admin.php?page=wr-megamenu-settings',
	);

	/**
	 * Variable to hold current settings.
	 *
	 * @var  array
	 */
	protected static $settings;

	/**
	 * Render WR Sample settings screen.
	 *
	 * @return  void
	 */
	public static function init() {
		// Check if we have settings to save
		if ( count( $_POST ) && isset( $_POST['wr_megamenu_settings'] ) ) {
			// Check nonce and capabilities
			$nonce = $_POST['_wpnonce'];

			if ( ! wp_verify_nonce( $nonce, 'wr-megamenu-settings' ) ) {
				$error = __( 'Unable to submit this form, please refresh and try again.', WR_MEGAMENU_TEXTDOMAIN );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				$error = __( 'Oops, you don&#8217;t have access to manage settings.', WR_MEGAMENU_TEXTDOMAIN );
			}

			if ( isset( $error ) ) {
				self::$options['messages'] = array( 'error' => $error );
			} else {
				// Get input
				$settings = $_POST['wr_megamenu_settings'];

				// Validate input
				foreach ( $settings as $name => $value ) {
					if ( is_array( $value ) ) {
						$value = array_map( 'sanitize_text_field', $value );
					} else {
						$value = sanitize_text_field( $value );
					}

					$settings[ $name ] = $value;
				}

				// Save WooRockets customer account
				if ( ! empty( $settings['customer-username'] ) || ! empty( $settings['customer-password'] ) ) {
					update_option( 'wr_mm_customer_account', array( 'username' => $settings['customer-username'], 'password' => $settings['customer-password'] ) );

					// Skip saving WooRockets customer account along with other settings
					unset( $settings['customer-username'] );
					unset( $settings['customer-password'] );
				}

				// Save settings
				update_option( 'wr_megamenu_settings', $settings );

				// Update current settings
				self::$settings = $settings;

				self::$options['messages'] = array( 'success' => __( 'Settings saved successfully.', WR_MEGAMENU_TEXTDOMAIN ) );
			}
		}

		// Get template file
		$tmpl = WR_MEGAMENU_TPL_PATH . '/settings.php';

		if ( ! $tmpl ) {
			return _e( 'Missing template file.', WR_MEGAMENU_TEXTDOMAIN );
		}

		// Get current WR MegaMenu settings
		self::get( true );

		// Init form object
		$form = WR_Form::get_instance( 'wr-megamenu-settings', self::$options );

		// Load template file
		include $tmpl;
	}

	/**
	 * Method to get WR MegaMenu settings.
	 *
	 * @param   boolean  $update_options  Whether to update options array with real value or not?
	 *
	 * @return  array
	 */
	public static function get( $update_options = false ) {
		if ( ! isset( self::$settings ) ) {
			// Get current settings
			$settings = get_option( 'wr_megamenu_settings', array() );

			// Apply default settings if neccessary
			if ( ! $update_options && ! count( $settings ) ) {
				foreach ( self::$options['fields'] as $name => $value ) {
					if ( isset( $value['default'] ) ) {
						$settings[ $name ] = $value['default'];
					}
				}
			}

			self::$settings = $settings;
		}

		// Update options array if requested
		if ( $update_options ) {
			// Set current settings to field values
			if ( count( self::$settings ) ) {
				foreach ( self::$settings as $name => $value ) {
					self::$options['fields'][ $name ]['value'] = $value;
				}
			}

			// Get WooRockets customer account
			$customer_account = get_option( 'wr_mm_customer_account', null );

			if ( ! empty( $customer_account ) ) {
				foreach ( array( 'username', 'password' ) as $field ) {
					self::$options['fields'][ "customer-{$field}" ]['value'] = $customer_account[ $field ];
				}
			}
		}

		return self::$settings;
	}
}
