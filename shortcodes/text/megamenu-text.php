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

if ( ! class_exists( 'WR_Megamenu_Text' ) ) {
	/**
	 * Create Text element
	 *
	 * @package  WR MegaMenu Shortcodes
	 * @since	1.0.0
	 */
	class WR_Megamenu_Text extends WR_Megamenu_Shortcode_Element {
		/**
		 * Constructor
		 *
		 * @return  void
		 */
		public function __construct()
		{
			parent::__construct();
		}

		/**
		 * Configure shortcode.
		 *
		 * @return  void
		 */
		function element_config()
		{
			$this->config['shortcode']   = strtolower( __CLASS__ );
			$this->config['name']        = __( 'Text', WR_MEGAMENU_TEXTDOMAIN );
			$this->config['cat']         = __( 'Typography', WR_MEGAMENU_TEXTDOMAIN );
			$this->config['icon']        = 'wr-icon-text';
			$this->config['description'] = __( 'Simple text', WR_MEGAMENU_TEXTDOMAIN );

			// Define exception for this shortcode
			$this->config['exception'] = array(
				'default_content' => __( 'Text', WR_MEGAMENU_TEXTDOMAIN ),

				'admin_assets' => array(
					// Shortcode initialization
					'wr-colorpicker.js',
					'wr-colorpicker-css',
					'wr-mm-fontselector-js',
					'text.js',
				),

				'frontend_assets' => array(
					// 'wr-mm-bootstrap3-responsive-css',
					// 'wr-bootstrap3-frontend-js',
				),
			);

			// Use Ajax to speed up element settings modal loading speed
			$this->config['edit_using_ajax'] = true;
		}

		/**
		 * Define shortcode settings.
		 *
		 * @return  void
		 */
		function element_items() {
			$this->items = array(
				'content' => array(
					array(
						'name'    => __( 'Element Title', WR_MEGAMENU_TEXTDOMAIN ),
						'id'      => 'el_title',
						'type'    => 'text_field',
						'class'   => 'input-sm',
						'std'     => __( '', WR_MEGAMENU_TEXTDOMAIN ),
						'role'    => 'title',
						'tooltip' => __( 'Set title for current element for identifying easily', WR_MEGAMENU_TEXTDOMAIN )
					),

					array(
						'name'    => __( 'Text Content', WR_MEGAMENU_TEXTDOMAIN ),
						'desc'    => __( 'Enter some content for this textblock', WR_MEGAMENU_TEXTDOMAIN ),
						'id'      => 'text_value',
						'type'    => 'tiny_mce',
						'role'    => 'content',
						'std'     => WR_Megamenu_Helpers_Type::lorem_text(),
						'rows'    => 15,
						'tooltip' => __( 'Set content of element', WR_MEGAMENU_TEXTDOMAIN ),
					),
				),

				'appearance' => array(

					array(
						'name'               => __( 'Margin', WR_MEGAMENU_TEXTDOMAIN ),
						'container_class'    => 'combo-group',
						'id'                 => 'text_margin',
						'type'               => 'margin',
						'extended_ids'       => array( 'text_margin_top', 'text_margin_right', 'text_margin_bottom', 'text_margin_left' ),
						'text_margin_top'    => array( 'std' => '' ),
						'text_margin_bottom' => array( 'std' => '' ),
						'tooltip'            => __( 'Set margin size', WR_MEGAMENU_TEXTDOMAIN ),
					),
					array(
						'name'       => __( 'Enable Dropcap', WR_MEGAMENU_TEXTDOMAIN ),
						'id'         => 'enable_dropcap',
						'type'       => 'radio',
						'std'        => 'no',
						'options'    => array( 'yes' => __( 'Yes', WR_MEGAMENU_TEXTDOMAIN ), 'no' => __( 'No', WR_MEGAMENU_TEXTDOMAIN ) ),
						'tooltip'    => __( 'Enable Dropcap', WR_MEGAMENU_TEXTDOMAIN ),
						'has_depend' => '1',
					),
					array(
						'name' => __( 'Font Face', WR_MEGAMENU_TEXTDOMAIN ),
						'id'   => 'dropcap_font_family',
						'type' => array(
							array(
								'id'           => 'dropcap_font_face_type',
								'type'         => 'jsn_select_font_type',
								'class'        => 'input-medium input-sm',
								'std'          => 'standard fonts',
								'options'      => WR_Megamenu_Helpers_Type::get_fonts(),
								'parent_class' => 'combo-item',
							),
							array(
								'id'           => 'dropcap_font_face_value',
								'type'         => 'jsn_select_font_value',
								'class'        => 'input-medium input-sm',
								'std'          => 'Verdana',
								'options'      => '',
								'parent_class' => 'combo-item',
							),
						),
						'dependency'      => array( 'enable_dropcap', '=', 'yes' ),
						'tooltip'         => __( 'Set Font Face', WR_MEGAMENU_TEXTDOMAIN ),
						'container_class' => 'combo-group',
					),
					array(
						'name' => __( 'Font Attributes', WR_MEGAMENU_TEXTDOMAIN ),
						'type' => array(
							array(
								'id'           => 'dropcap_font_size',
								'type'         => 'text_append',
								'type_input'   => 'number',
								'class'        => 'input-mini',
								'std'          => '64',
								'append'       => 'px',
								'validate'     => 'number',
								'parent_class' => 'combo-item input-mini-inline',
							),
							array(
								'id'           => 'dropcap_font_style',
								'type'         => 'select',
								'class'        => 'input-medium wr-mini-input input-sm',
								'std'          => 'bold',
								'options'      => WR_Megamenu_Helpers_Type::get_font_styles(),
								'parent_class' => 'combo-item',
							),
							array(
								'id'           => 'dropcap_font_color',
								'type'         => 'color_picker',
								'std'          => '#000000',
								'parent_class' => 'combo-item',
							),
						),
						'dependency'      => array( 'enable_dropcap', '=', 'yes' ),
						'tooltip'         => __( 'Set Font Attribute', WR_MEGAMENU_TEXTDOMAIN ),
						'container_class' => 'combo-group',
					),
					array(
						'name'          => __( 'Line height', WR_MEGAMENU_TEXTDOMAIN ),
						'id'            => 'line_height',
						'class'         => 'wr-slider wr-slider-height col-sm-3',
						'exclude_class' => array( 'form-control' ),
						'type'          => 'slider_height',
						'std_max'       => '100',
						'std'           => '20',
						'tooltip'       => __( 'Line height', WR_MEGAMENU_TEXTDOMAIN )
					),
				)
			);
		}

		/**
		 * Generate HTML code from shortcode content.
		 *
		 * @param   array $atts Shortcode attributes.
		 * @param   string $content Current content.
		 *
		 * @return  string
		 */
		function element_shortcode_full( $atts = null, $content = null ) {
			$arr_params = shortcode_atts( $this->config['params'], $atts );
			extract( $arr_params );

			$random_id = WR_Megamenu_Helpers_Common::random_string();
			$script	   = $html_element = '';
			
			if ( ! empty( $content ) ) {
				$content = WR_Megamenu_Helpers_Shortcode::remove_autop( $content, true );
			}
			
			$html_element_style = '<style type="text/css">';
			
			if ( isset( $enable_dropcap ) && $enable_dropcap == 'yes' ) {
				
				if ( $content ) {
					$styles = array();
					
					if ( $dropcap_font_face_type == 'google fonts' AND $dropcap_font_face_value != '' ) {
						$script  .= WR_Megamenu_Helpers_Functions::add_google_font_link_tag( $dropcap_font_face_value );
						$styles[] = 'font-family:' . $dropcap_font_face_value;
					} elseif ( $dropcap_font_face_type == 'standard fonts' AND $dropcap_font_face_value ) {
						$styles[] = 'font-family:' . $dropcap_font_face_value;
					}

					if ( intval( $dropcap_font_size ) > 0 ) {
						$styles[] = 'font-size:' . intval( $dropcap_font_size ) . 'px';
						$styles[] = 'line-height:' . intval( $dropcap_font_size ) . 'px';
					}
					switch ( $dropcap_font_style ) {
						case 'bold':
							$styles[] = 'font-weight:700';
							break;
						case 'italic':
							$styles[] = 'font-style:italic';
							break;
						case 'normal':
							$styles[] = 'font-weight:normal';
							break;
					}
	
					if ( strpos( $dropcap_font_color, '#' ) !== false ) {
						$styles[] = 'color:' . $dropcap_font_color;
					}

					if ( count( $styles ) ) {
						$html_element_style .= sprintf( '%s .dropcap:first-letter { float:left;', "#$random_id" );
						$html_element_style .= implode( ';', $styles );
						$html_element_style .= '}';
					}

					$html_element .= "<div class='dropcap'>{$content}</div>";
				}
			} else {
				$html_element .= $content;
			}

			$html_element_style .= '.preview-text {line-height: '.$line_height.'px;}';
			$html_element_style .= '</style>';

			$preview  = $html_element_style;
			$preview .= "<div class='preview-text'>" . $html_element . '</div>';

			$html  = sprintf( '<div class="wr_text" id="%s">', $random_id );
			$html .= $script;
			$html .= $preview;
			$html .= '</div>';

			// Process margins
			if (isset($arr_params['text_margin_top']))
				$arr_params['div_margin_top'] = $arr_params['text_margin_top'];
			if (isset($arr_params['text_margin_bottom']))
				$arr_params['div_margin_bottom'] = $arr_params['text_margin_bottom'];
			if (isset($arr_params['text_margin_right']))
				$arr_params['div_margin_right'] = $arr_params['text_margin_right'];
			if (isset($arr_params['text_margin_left']))
				$arr_params['div_margin_left'] = $arr_params['text_margin_left'];

			return $this->element_wrapper( $html, $arr_params );
		}
	}

}
