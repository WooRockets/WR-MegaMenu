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

class WR_Megamenu_Helpers_Modal
{

	private static $instance;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_filter( 'wr_mm_register_assets', array( &$this, 'apply_assets' ) );
		$this->enqueue_assets();
	}

	/**
	 * Register custom assets to use on Modal
	 * @param array $assets
	 * @return array
	 */
	public function apply_assets( $assets ) {
		$assets['wr-megamenu-modal-css'] = array(
			'src' => '/assets/css/modal.css',
			'ver' => '1.0.0',
		);
		$assets['wr-megamenu-codemirror-css'] = array(
			'src' => '/assets/3rd-party/codemirror/codemirror.css',
			'ver' => '1.0.0',
		);
		$assets['wr-megamenu-codemirror-js'] = array(
			'src' => '/assets/3rd-party/codemirror/codemirror.js',
			'ver' => '1.0.0',
		);
		$assets['wr-megamenu-codemirrormode-css-js'] = array(
			'src' => '/assets/3rd-party/codemirror/mode/css.js',
			'ver' => '1.0.0',
		);

		$assets['wr-megamenu-placeholder'] = array(
			'src' => '/assets/woorockets/js/placeholder.js',
			'ver' => '1.0.0',
		);
		$assets['wr-customcss-css'] = array(
			'src'  => '/assets/css/custom_css.css',
			'deps' => array( 'wr-mm-bootstrap3-css' ),
			'ver'  => '1.0.0',
		);
		$assets['wr-custom-css-js'] = array(
			'src' => '/assets/js/custom_css.js',
			'ver' => '1.0.0',
		);

		$assets = apply_filters( 'wr_mm_assets_register_modal', $assets );

		return $assets;
	}

	/**
	 * Enqueue scripts
	 */
	public function enqueue_assets() {
		WR_Megamenu_Init_Assets::load( array( 'wr-mm-bootstrap3-css', 'wr-bootstrap3-js', 'wr-joomlashine-css' ) );
		WR_Megamenu_Init_Assets::load( array( 'wr-jquery-ui-css', 'wr-megamenu-modal-css', 'wr-mm-css' ) );
		WR_Megamenu_Init_Assets::load( array( 'wr-bootstrap3-icomoon-css', 'wr-font-awesome-css', 'wr-mm-admin-css' ) );
		WR_Megamenu_Init_Assets::load( array( 'wr-jquery-ui-css', 'wr-jquery-select2-css', 'wr-jquery-select2-bootstrap3-css' ) );
		WR_Megamenu_Init_Assets::load( array( 'wr-mm-jqueryfancybox-css' ) );

		if ( function_exists( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		} else {
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
		}

		$scripts = array( 'jquery', 'jquery-ui', 'jquery-ui-resizable', 'jquery-ui-sortable', 'jquery-ui-tabs', 'jquery-ui-dialog', 'jquery-ui-button', 'jquery-ui-slider', 'wr-jquery-livequery-js', 'jquery-resize-js', 'wr-joomlashine-modalresize-js', 'wr-jquery-select2-js' );

		WR_Megamenu_Init_Assets::load( $scripts );
		$scripts = array( 'wr-mm-layout-js', 'wr-mm-placeholder' );
		WR_Megamenu_Init_Assets::load( $scripts );

		// Check # review
		WR_Megamenu_Init_Assets::load( array( 'wr-mm-modal-js', 'wr-custom-css-js' ) );
		WR_Megamenu_Init_Assets::load( array( 'wr-megamenu-placeholder' ) );

		// Load element editor script
		WR_Megamenu_Init_Assets::load( 'wr-mm-handleelement-js' );

		// Load element settings script
		WR_Megamenu_Init_Assets::load( 'wr-mm-handlesetting-js' );

		// Load ZeroClipboard JavaScript library for Shortcode Content tab
		WR_Megamenu_Init_Assets::load( 'wr-zeroclipboard-js' );

		WR_Megamenu_Init_Assets::load( 'wr-mm-widget-js' );

		// Load Jquery fancybox
		WR_Megamenu_Init_Assets::load( 'wr-mm-jqueryfancybox-js' );

		// Load for element image
		WR_Megamenu_Init_Assets::load( 'wr-mm-imagefrontend-js' );

		WR_Megamenu_Init_Assets::localize( 'wr-custom-css-js', 'Wr_Megamenu_Translate', WR_Megamenu_Helpers_Functions::js_translation() );
		WR_Megamenu_Init_Assets::localize( 'wr-mm-handlesetting-js', 'Wr_Megamenu_Ajax', WR_Megamenu_Helpers_Functions::localize_js() );
		WR_Megamenu_Helpers_Functions::wr_localize();
	}


	/**
	 * Get related content for each Modal
	 * @param type $page
	 */
	public function show_modal( $page = '' )
	{
		add_action( 'wr_megamenu_modal_page_content', array( &$this, 'content' . $page ) );
	}

	/**
	 * HTML content for Custom css Modal
	 */
	public function content_custom_css()
	{
		$assets = apply_filters( 'wr_mm_assets_enqueue_modal', array( 'wr-customcss-css', 'wr-megamenu-codemirror-css', 'wr-megamenu-codemirror-js', 'wr-megamenu-codemirrormode-css-js' ) );
		WR_Megamenu_Init_Assets::load( $assets );
		include WR_MEGAMENU_TPL_PATH . '/custom-css.php';
	}

	public function content_add_element() {
		include WR_MEGAMENU_TPL_PATH . '/select-elements.php';
	}

	/**
	 * HTML content for Shortcode editing Modal
	 */
	public function content()
	{
		// Load required assets
		$assets = apply_filters( 'wr_mm_assets_enqueue_modal', array( 'wr-mm-handlesetting-js' ) );
		WR_Megamenu_Init_Assets::load( $assets );

		include WR_MEGAMENU_TPL_PATH . '/modal.php';

	}

	/**
	 * Ignore settings key in array
	 * @param array $options
	 * @return array
	 */
	static function ignore_settings( $options ) {
		if ( array_key_exists( 'settings', $options ) ) {
			$options = array_slice( $options, 1 );
		}

		return $options;
	}

	/**
	 * Add setting data to a tag
	 * @param string $tag
	 * @param array $data
	 * @param string $content
	 * @return string
	 */
	static function tab_settings( $tag, $data, $content ) {
		$tag_data = array();
		if ( ! empty( $data ) ) {
			foreach ( $data as $key => $value ) {
				if ( ! empty( $value) ) {
					$tag_data[] = "$key = '$value'";
				}
			}
		}
		$tag_data = implode( ' ', $tag_data );

		return "<$tag $tag_data>$content</$tag>";
	}

	/**
	 * get HTML of Modal Settings Box of Shortcode
	 * @param array $options
	 * @return string
	 */
	static function get_shortcode_modal_settings( $settings, $shortcode = '', $input_params = null, $raw_shortcode = null ) {
		$i    = 0;
		$tabs = $contents = $actions = $general_actions = array();

		foreach ( $settings as $tab => $options ) {
			$options = self::ignore_settings( $options );
			if ( $tab == 'action' ) {
				foreach ( $options as $option ) {
					$actions[] = WR_Megamenu_Helpers_Shortcode::render_parameter( $option['type'], $option );
				}
			} else if ( $tab == 'generalaction' ) {
				foreach ( $options as $option ) {
					$option['id']      = isset($option['id']) ? ( 'param-' . $option['id']) : '';
					$general_actions[] = WR_Megamenu_Helpers_Shortcode::render_parameter( $option['type'], $option );
				}
			} else {
				$active = ($i++ == 0) ? 'active' : '';
				if ( strtolower( $tab ) != 'notab' ) {
					$data_                = isset($settings[$tab]['settings']) ? $settings[$tab]['settings'] : array();
					$data_['href']		  = "#$tab";
					$data_['data-toggle'] = 'tab';
					$content_             = ucfirst( $tab );
					$tabs[]               = "<li class='$active'>" . self::tab_settings( 'a', $data_, $content_ ) . '</li>';
				}

				$has_margin = 0;
				$param_html = array();
				foreach ( $options as $idx => $option ) {
					// check if this element has Margin param (1)
					if (isset($option['name']) && $option['name'] == __( 'Margin', WR_MEGAMENU_TEXTDOMAIN ) && $option['id'] != 'div_margin' )
						$has_margin = 1;
					// if (1), don't use the 'auto extended margin ( top, bottom ) option'
					if ($has_margin && isset($option['id']) && $option['id'] == 'div_margin' )
						continue;

					$type		 = $option['type'];
					$option['id'] = isset($option['id']) ? ( 'param-' . $option['id']) : "$idx";
					if ( ! is_array( $type ) ) {
						$param_html[$option['id']] = WR_Megamenu_Helpers_Shortcode::render_parameter( $type, $option, $input_params );
					} else {
						$output_inner = '';
						foreach ( $type as $sub_options ) {
							$sub_options['id'] = isset( $sub_options['id'] ) ? ( 'param-' . $sub_options['id'] ) : '';
							/* for sub option, auto assign bound = 0 {not wrapped by <div class='controls'></div> } */
							$sub_options['bound'] = '0';
							/* for sub option, auto assign 'input-small' class */
							$sub_options['class'] = isset($sub_options['class']) ? ($sub_options['class']) : '';
							$type                 = $sub_options['type'];
							$output_inner        .= WR_Megamenu_Helpers_Shortcode::render_parameter( $type, $sub_options );
						}
						$option                    = WR_Megamenu_Helpers_Html::get_extra_info( $option );
						$label                     = WR_Megamenu_Helpers_Html::get_label( $option );
						$param_html[$option['id']] = WR_Megamenu_Helpers_Html::final_element( $option, $output_inner, $label );
					}
				}

				if ( ! empty( $param_html['param-copy_style_from'] ) ) {
					array_pop( $param_html );
					// move "auto extended margin ( top, bottom ) option" to top of output
					$style_copy = array_shift( $param_html );
					// Shift Preview frame from the array
					$preview = array_shift( $param_html );

					if ( ! empty( $param_html['param-div_margin'] ) ) {
						$margin	    = $param_html['param-div_margin'];
						$param_html = array_merge(
							array(
								$preview,
								$style_copy,
								$margin,
							),
							$param_html
						);
					} else {
						$param_html = array_merge(
							array(
								$preview,
								$style_copy,
							),
							$param_html
						);
					}
				}

				$param_html  = implode( '', $param_html );
				$content_tab = "<div class='tab-pane $active wr-mm-setting-tab' id='$tab'>$param_html</div>";
				$contents[]  = $content_tab;
			}
		}

		return self::setting_tab_html( $shortcode, $tabs, $contents, $general_actions, $settings, $actions );
	}

	/**
	 * Generate tab with content, use for generating Modal
	 * @return string
	 */
	static function setting_tab_html( $shortcode, $tabs, $contents, $general_actions, $settings, $actions )
	{
		$output = '<input type="hidden" value="' . $shortcode . '" id="shortcode_name" name="shortcode_name" />';

		/* Tab Content - Styling */

		$output .= '<div class="jsn-tabs">';
		if ( count( $tabs ) > 0 ) {
			$output .= '<ul class="" id="wr_option_tab">';
			$output .= implode( '', $tabs );
			$output .= '</ul>';
		}
		/* Tab Content */

		$output .= implode( '', $contents );

		$output .= "<div class='jsn-buttonbar wr_action_btn'>";

		/* Tab Content - General actions */
		if ( count( $general_actions ) ) {
			$data     = $settings['generalaction']['settings'];
			$content_ = implode( '', $general_actions );
			$output  .= self::tab_settings( 'div', $data_, $content_ );
		}

		$output .= implode( '', $actions );
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * Append shortcode content tab to all element settings modal.
	 * @param   array &$tabs Current tabs array.
	 * @param   array &$contents Currnt content array.
	 * @param   string $raw_shortcode Raw shortcode content.
	 * @return  void
	 */
	public static function shortcode_content_tab( &$tabs, &$contents, $raw_shortcode )
	{
		// Auto-append `Shortcode Content` tab only if this is not a sub-modal
		if ( ! isset( $_REQUEST['submodal'] ) || ! $_REQUEST['submodal'] ) {
			// Generate tab for shortcode content
			$tabs[] = '<li><a href="#shortcode-content" data-toggle="tab">' . __( 'Shortcode', WR_MEGAMENU_TEXTDOMAIN ) . '</a></li>';

			// Generate content for shortcode content tab
			$contents[] = '<div class="tab-pane clearfix" id="shortcode-content">'
				. '<textarea id="shortcode_content" class="form-control" rows="10" disabled="disabled">' . esc_textarea( $raw_shortcode ) . '</textarea>'
				. '<div class="text-center"><button class="btn btn-success" id="copy_to_clipboard" data-textchange="' . __( 'Done!', WR_MEGAMENU_TEXTDOMAIN ) . '">' . __( 'Copy to Clipboard', WR_MEGAMENU_TEXTDOMAIN ) . '</button></div>'
				. '</div>';
		} else {
			// Generate hidden text area to hold raw shortcode
			$contents[] = '<textarea class="hidden" id="shortcode_content">' . esc_textarea( $raw_shortcode ) . '</textarea>';
		}
	}
	
	/**
	 * content footer
	 *
	 * @param bool $return
	 *
	 * @return mixed|string|void
	 */
	public static function get_footer() {
		$footer = '<div class="jsn-bootstrap3 wr-megamenu-footer">
				<hr />
				<div class="pull-left">
					<div>
						Powered by 
						<a target="_blank" href="http://www.woorockets.com/?utm_source=MegaMenu%20Backend&utm_medium=Text&utm_campaign=Powered%20By">' . __( 'WooRockets.com', WR_MEGAMENU_TEXTDOMAIN ) . '</a> | <a target="_blank" href="http://www.woorockets.com/docs/wr-megamenu-user-manual/?utm_source=MegaMenu%20Backend&utm_medium=Text&utm_campaign=Powered%20By">' . __( 'Documentation', WR_MEGAMENU_TEXTDOMAIN ) . '</a>
					</div>
				</div>
				<div class="clearbreak"></div>
			</div>';
		
		return apply_filters( 'wr_megamenu_modal_footer', $footer );
	}
}
