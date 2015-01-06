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

class WR_Megamenu_Addon {

	// prodiver name
	protected $provider;

	// register assets (js/css)
	protected $assets_register;

	// enqueue assets for Admin pages
	protected $assets_enqueue_admin;

	// enqueue assets for Modal setting iframe
	protected $assets_enqueue_modal;

	// enqueue assets for Frontend
	protected $assets_enqueue_frontend;

	/**
	 * Get provider data
	 *
	 * @return type
	 */
	public function get_provider() {
		return $this->provider;
	}

	/**
	 * Get provider assets path & uri
	 *
	 * @return type
	 */
	public function get_assets_register() {
		return $this->assets_register;
	}

	/**
	 * Get custom enqueued assets for WP admin
	 *
	 * @return type
	 */
	public function get_assets_enqueue_admin() {
		return $this->assets_enqueue_admin;
	}

	/**
	 * Get custom enqueued assets for WR modal
	 *
	 * @return type
	 */
	public function get_assets_enqueue_modal() {
		return $this->assets_enqueue_modal;
	}

	/**
	 * Get custom enqueued assets for Front end
	 *
	 * @return type
	 */
	public function get_assets_enqueue_frontend() {
		return $this->assets_enqueue_frontend;
	}

	/**
	 * Set provider data
	 *
	 * @param array $provider
	 */
	public function set_provider( $provider ) {
		$this->provider = $provider;
	}

	/**
	 * Register custom assets
	 *
	 * @param array $assets
	 */
	public function set_assets_register( $assets ) {
		$this->assets_register = $assets;
	}

	/**
	 * Add custom assets for WP admin
	 *
	 * @param array $assets
	 */
	public function set_assets_enqueue_admin( $assets ) {
		$this->assets_enqueue_admin = $assets;
	}

	/**
	 * Add custom assets for WR modal
	 *
	 * @param array $assets
	 */
	public function set_assets_enqueue_modal( $assets ) {
		$this->assets_enqueue_modal = $assets;
	}

	/**
	 * Add custom assets for WP frontend
	 *
	 * @param array $assets
	 */
	public function set_assets_enqueue_frontend( $assets ) {
		$this->assets_enqueue_frontend = $assets;
	}

	/**
	 * Initialize addon
	 */
	public function __construct() {
		add_filter( 'wr_mm_provider',                array( &$this, 'get_provider_data' ) );
		add_filter( 'wr_mm_register_assets',         array( &$this, 'register_assets_register' ) );
		add_filter( 'wr_mm_assets_enqueue_admin',    array( &$this, 'enqueue_assets_admin' ) );
		add_filter( 'wr_mm_assets_enqueue_modal',    array( &$this, 'enqueue_assets_modal' ) );
		add_filter( 'wr_mm_assets_enqueue_frontend', array( &$this, 'enqueue_assets_frontend' ) );
	}

	/**
	 * Get provider data and return necessary information
	 *
	 * @param array $providers
	 *
	 * @return string
	 */
	public function get_provider_data( $providers ) {

		// get provider data
		$provider = $this->get_provider();

		if ( empty ( $provider ) || empty ( $provider['file'] ) ) {
			return $providers;
		}

		// variables
		$file = $provider['file'];
		// Fix Standard Elements
		if ( basename( $file ) == 'shortcode.php' ) {
			$path = WR_MEGAMENU_ROOT_PATH . 'shortcodes/';
			$uri  = WR_MEGAMENU_ROOT_URL . 'shortcodes/';
		} else {
			$path = plugin_dir_path( $file );
			$uri  = plugin_dir_url( $file );
		}

		$shortcode_dir    = empty ( $provider['shortcode_dir'] ) ? 'shortcodes' : $provider['shortcode_dir'];
		$js_shortcode_dir = empty ( $provider['js_shortcode_dir'] ) ? 'assets/js/shortcodes' : $provider['js_shortcode_dir'];

		// Check if path is absolute
		if ( ! is_dir( $shortcode_dir ) ) {
			$shortcode_dir = $path . $shortcode_dir;
		}

		//get plugin name & main file
		$main_file		= pathinfo( $file );
		$folder		   = basename( $main_file['dirname'] );
		$main_file		= $folder . '/' . $main_file['basename'];
		$providers[$path] = array(
			'path'             => $path,
			'uri'              => $uri,
			'file'             => $main_file,
			'file_path'        => $file,
			'folder'           => $folder,
			'name'             => $provider['name'],
			'shortcode_dir'	   => $shortcode_dir,
			'js_shortcode_dir' => array( 'path' => $path . $js_shortcode_dir, 'uri' => $uri . $js_shortcode_dir ),
		);

		return $providers;
	}

	/**
	 * Register custom assets
	 *
	 * @param array $assets
	 *
	 * @return array
	 */
	public function register_assets_register( $assets ) {
		$this_asset = $this->get_assets_register();
		$assets	    = array_merge( $assets, empty ( $this_asset ) ? array() : $this_asset );

		return $assets;
	}

	/**
	 * Register custom assets for WP admin
	 *
	 * @param array $assets
	 *
	 * @return array
	 */
	public function enqueue_assets_admin( $assets ) {
		$this_asset = $this->get_assets_enqueue_admin();
		$assets     = array_merge( $assets, empty ( $this_asset ) ? array() : $this_asset );

		return $assets;
	}

	/**
	 * Register custom assets for WR modal
	 *
	 * @param array $assets
	 *
	 * @return array
	 */
	public function enqueue_assets_modal( $assets ) {
		$this_asset = $this->get_assets_enqueue_modal();
		$assets     = array_merge( $assets, empty ( $this_asset ) ? array() : $this_asset );

		return $assets;
	}

	/**
	 * Register custom assets for WP frontend
	 *
	 * @param array $assets
	 *
	 * @return array
	 */
	public function enqueue_assets_frontend( $assets ) {
		$this_asset = $this->get_assets_enqueue_frontend();
		$assets     = array_merge( $assets, empty ( $this_asset ) ? array() : $this_asset );

		return $assets;
	}

	/**
	 * Register Path to extended Parameter type
	 *
	 * @param string $path
	 */
	public function register_extended_parameter_path( $path ) {
		WR_Megamenu_Loader::register( $path, 'WR_Megamenu_Helpers_Html_' );
	}

	/**
	 * Show admin notice
	 *
	 * @param string $addon_name
	 * @param string $core_required
	 *
	 * @return string
	 */
	static function show_notice( $data, $action, $type = 'error' ) {
		// show message
		ob_start();

		switch ( $action ) {
			// show message about core version required
			case 'core_required':
				extract( $data );

				?>
				<div class="<?php echo esc_attr( $type ); ?>">
					<p>
						<?php _e( "You can not activate this WR MegaMenu's provider:", WR_MEGAMENU_TEXTDOMAIN ); ?> <br>
						<b><?php echo esc_html( $addon_name ); ?></b>
					</p>

					<p>
						<?php _e( "It requires WR MegaMenu's version:", WR_MEGAMENU_TEXTDOMAIN ); ?> <br>
						<b><?php echo esc_html( $core_required ); ?></b> <br>
						<?php echo esc_html( 'or above to work. Please update WR MegaMenu to newest version.' ); ?>
						<br>
					</p>
				</div>

				<!-- custom js to hide "Plugin actived" -->

				<?php
				$js_code = "$( '#message.updated' ).hide();";
				echo balanceTags( WR_Megamenu_Helpers_Functions::script_box( $js_code ) );

				break;

			default:
				break;
		}

		$message = ob_get_clean();

		return $message;
	}

	/**
	 * Get Constant name defines core version required of this addon plugin
	 *
	 * @param string $addon_file
	 */
	static function core_version_constant( $addon_file ) {
		$path_parts = pathinfo( $addon_file );
		if ( $path_parts ) {
			// get dir name of add on
			$dirname = basename( $path_parts['dirname'] );
			$dirname = str_replace( '-', '_', $dirname );

			// return the Constant defines core version required of this add on
			return strtoupper( $dirname ) . '_CORE_VERSION';
		}

		return '';
	}

	/**
	 * Get Constant value of Constant defines core version required
	 *
	 * @param array  $provider
	 * @param string $addon_file
	 *
	 * @return string
	 */
	static function core_version_requied_value( $provider, $addon_file ) {

		// include defines.php from provider plugin folder, where defines core version required by addon
		if ( file_exists( $provider['path'] . 'defines.php' ) ) {
			include_once $provider['path'] . 'defines.php';
		}

		// get constant name defines core version required
		$constant = WR_Megamenu_Addon::core_version_constant( $addon_file );

		// get value of core version required
		return ( defined( $constant ) ) ? constant( $constant ) : NULL;
	}

	/**
	 * Check compatibility of this addon & WR core
	 *
	 * @param string $core_required
	 * @param string $core_version
	 * @param string $addon_file
	 *
	 * @return bool
	 */
	static function compatibility_handle( $core_required, $core_version, $addon_file ) {

		// if current core version < core version required
		if ( version_compare( $core_required, $core_version, '>' ) ) {

			// deactivate addon
			deactivate_plugins( array( $addon_file ) );

			return FALSE;
		}

		return TRUE;
	}

}