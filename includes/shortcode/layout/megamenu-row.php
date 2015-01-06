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

/*
 * Define a Row shortcode
 */
if ( ! class_exists( 'WR_Megamenu_Row' ) ) {

	class WR_Megamenu_Row extends WR_Megamenu_Shortcode_Layout {

		/* default layouts for Row */
		static $layouts = array(
			array( 6, 6 ),
			array( 4, 4, 4 ),
			array( 3, 3, 3, 3 ),
			array( 4, 8 ),
			array( 8, 4 ),
			array( 3, 9 ),
			array( 9, 3 ),
			array( 3, 6, 3 ),
			array( 3, 3, 6 ),
			array( 6, 3, 3 ),
			array( 2, 2, 2, 2, 2, 2 ),
		);

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['exception'] = array(
				'admin_assets'	   => array(
					'wr-colorpicker-js',
					'wr-colorpicker-css',
					'row.js',
				),
			);
			// Use Ajax to speed up element settings modal loading speed
			$this->config['edit_using_ajax'] = true;
		}

		/**
		 * contain setting items of this element ( use for modal box )
		 *
		 */
		function element_items() {
			$this->items = array(
				'Notab' => array(

					array(
						'name'       => __( 'Background', WR_MEGAMENU_TEXTDOMAIN ),
						'id'         => 'background',
						'type'       => 'select',
						'std'        => 'none',
						'class'		 => 'input-sm',
						'options'    => array(
							'none'     => __( 'None', WR_MEGAMENU_TEXTDOMAIN ),
							'solid'    => __( 'Solid Color', WR_MEGAMENU_TEXTDOMAIN ),
							'gradient' => __( 'Gradient Color', WR_MEGAMENU_TEXTDOMAIN ),
							'pattern'  => __( 'Pattern', WR_MEGAMENU_TEXTDOMAIN ),
							'image'    => __( 'Image', WR_MEGAMENU_TEXTDOMAIN )
						),
						'has_depend' => '1',
					),
					array(
						'name' => __( 'Solid Color', WR_MEGAMENU_TEXTDOMAIN ),
						'type' => array(
							array(
								'id'           => 'solid_color_value',
								'type'         => 'text_field',
								'class'        => 'input-small',
								'std'          => '#FFFFFF',
								'parent_class' => 'combo-item',
							),
							array(
								'id'           => 'solid_color_color',
								'type'         => 'color_picker',
								'std'          => '#ffffff',
								'parent_class' => 'combo-item',
							),
						),
						'container_class' => 'combo-group',
						'dependency'      => array( 'background', '=', 'solid' ),
					),
					array(
						'name'       => __( 'Gradient Color', WR_MEGAMENU_TEXTDOMAIN ),
						'id'         => 'gradient_color',
						'type'       => 'gradient_picker',
						'std'        => '0% #FFFFFF,100% #000000',
						'dependency' => array( 'background', '=', 'gradient' ),
					),
					array(
						'id'              => 'gradient_color_css',
						'type'            => 'text_field',
						'std'             => '',
						'type_input'      => 'hidden',
						'container_class' => 'hidden',
						'dependency'      => array( 'background', '=', 'gradient' ),
					),
					array(
						'name'       => __( 'Gradient Direction', WR_MEGAMENU_TEXTDOMAIN ),
						'id'         => 'gradient_direction',
						'type'       => 'select',
						'std'        => 'vertical',
						'options'    => array( 'vertical' => __( 'Vertical', WR_MEGAMENU_TEXTDOMAIN ), 'horizontal' => __( 'Horizontal', WR_MEGAMENU_TEXTDOMAIN ) ),
						'dependency' => array( 'background', '=', 'gradient' ),
					),
					array(
						'name'       => __( 'Pattern', WR_MEGAMENU_TEXTDOMAIN ),
						'id'         => 'pattern',
						'type'       => 'select_media',
						'std'        => '',
						'class'      => 'jsn-input-large-fluid',
						'dependency' => array( 'background', '=', 'pattern' ),
					),
					array(
						'name'    => __( 'Repeat', WR_MEGAMENU_TEXTDOMAIN ),
						'id'      => 'repeat',
						'type'    => 'radio_button_group',
						'std'     => 'full',
						'options' => array(
							'full'       => __( 'Full', WR_MEGAMENU_TEXTDOMAIN ),
							'vertical'   => __( 'Vertical', WR_MEGAMENU_TEXTDOMAIN ),
							'horizontal' => __( 'Horizontal', WR_MEGAMENU_TEXTDOMAIN ),
						),
						'dependency' => array( 'background', '=', 'pattern' ),
					),
					array(
						'name'       => __( 'Image', WR_MEGAMENU_TEXTDOMAIN ),
						'id'         => 'image',
						'type'       => 'select_media',
						'std'        => '',
						'class'      => 'jsn-input-large-fluid',
						'dependency' => array( 'background', '=', 'image' ),
					),
					array(
						'name'    => __( 'Stretch', WR_MEGAMENU_TEXTDOMAIN ),
						'id'      => 'stretch',
						'type'    => 'radio_button_group',
						'std'     => 'none',
						'options' => array(
							'none'    => __( 'None', WR_MEGAMENU_TEXTDOMAIN ),
							'full'    => __( 'Full', WR_MEGAMENU_TEXTDOMAIN ),
							'cover'   => __( 'Cover', WR_MEGAMENU_TEXTDOMAIN ),
							'contain' => __( 'Contain', WR_MEGAMENU_TEXTDOMAIN ),
						),
						'dependency' => array( 'background', '=', 'pattern' ),
					),
					array(
						'name'       => __( 'Position', WR_MEGAMENU_TEXTDOMAIN ),
						'id'         => 'position',
						'type'       => 'radio',
						'label_type' => 'image',
						'dimension'  => array( 23, 23 ),
						'std'        => 'center center',
						'options'    => array(
							'left top'      => array( 'left top' ),
							'center top'    => array( 'center top' ),
							'right top'     => array( 'right top', 'linebreak' => true ),
							'left center'   => array( 'left center' ),
							'center center' => array( 'center center' ),
							'right center'  => array( 'right center', 'linebreak' => true ),
							'left bottom'   => array( 'left bottom' ),
							'center bottom' => array( 'center bottom' ),
							'right bottom'  => array( 'right bottom' ),
						),
						'dependency' => array( 'background', '=', 'image' ),
					),
					array(
						'name'       => __( 'Enable Paralax', WR_MEGAMENU_TEXTDOMAIN ),
						'id'         => 'paralax',
						'type'       => 'radio',
						'std'        => 'no',
						'options'    => array( 'yes' => __( 'Yes', WR_MEGAMENU_TEXTDOMAIN ), 'no' => __( 'No', WR_MEGAMENU_TEXTDOMAIN ) ),
						'dependency' => array( 'background', '=', 'pattern__#__image' ),
					),
					array(
						'name' => __( 'Border', WR_MEGAMENU_TEXTDOMAIN ),
						'type' => array(
							array(
								'id'           => 'border_width_value_',
								'type'         => 'text_append',
								'type_input'   => 'number',
								'class'        => '',
								'std'          => '0',
								'append'       => 'px',
								'validate'     => 'number',
								'parent_class' => 'input-group-inline',
							),

							array(
								'id'           => 'border_style',
								'type'         => 'select',
								'class'        => 'input-sm',
								'std'          => 'solid',
								'options'      => WR_Megamenu_Helpers_Type::get_border_styles(),
								'parent_class' => 'combo-item',
							),
							array(
								'id'           => 'border_color',
								'type'         => 'color_picker',
								'std'          => '#000',
								'parent_class' => 'combo-item',
							),
						),
						'container_class' => 'combo-group',
					),
					array(
						'name'               => __( 'Padding', WR_MEGAMENU_TEXTDOMAIN ),
						'container_class'    => 'combo-group',
						'id'                 => 'div_padding',
						'type'               => 'margin',
						'extended_ids'       => array( 'div_padding_top', 'div_padding_bottom', 'div_padding_right', 'div_padding_left' ),
						'div_padding_top'    => array( 'std' => '10' ),
						'div_padding_bottom' => array( 'std' => '10' ),
						'div_padding_right'  => array( 'std' => '10' ),
						'div_padding_left'   => array( 'std' => '10' ),
					),

					array(
						'name'         => __( 'Custom CSS', WR_MEGAMENU_TEXTDOMAIN ),
						'id'           => '',
						'type'         => 'spacer',
						'blank_output' => '1',
					),
					array(
						'name'    => __( 'CSS Class', WR_MEGAMENU_TEXTDOMAIN ),
						'id'      => 'css_suffix',
						'type'    => 'text_field',
						'std'     => __( '', WR_MEGAMENU_TEXTDOMAIN ),
						'tooltip' => __( 'Add custom css class for the wrapper div of this element', WR_MEGAMENU_TEXTDOMAIN ),
					),
					array(
						'name'    => __( 'ID', WR_MEGAMENU_TEXTDOMAIN ),
						'id'      => 'id_wrapper',
						'type'    => 'text_field',
						'std'     => __( '', WR_MEGAMENU_TEXTDOMAIN ),
						'tooltip' => __( 'Add custom id for the wrapper div of this element', WR_MEGAMENU_TEXTDOMAIN ),
					),
				)
			);
		}

		/**
		 *
		 * @param type $content		: inner shortcode elements of this row
		 * @param type $shortcode_data : not used
		 * @return string
		 */
		public function element_in_megamenu( $content = '', $shortcode_data = '' ) {
			if ( empty($content) ) {
				$column = new WR_Megamenu_Column();
				$column_html = $column->element_in_megamenu();
				$column_html = $column_html[0];
			} else {
				$column_html = WR_Megamenu_Helpers_Shortcode::do_shortcode_admin( $content );
			}
			if ( empty($shortcode_data) )
				$shortcode_data = $this->config['shortcode_structure'];
			// remove [/wr_megamenu_row][wr_megamenu_column...] from $shortcode_data
			$shortcode_data = explode( '][', $shortcode_data );
			$shortcode_data = $shortcode_data[0] . ']';
			
			// Remove empty value attributes of shortcode tag.
			$shortcode_data	= preg_replace( '/\[*([a-z_]*[\n\s\t]*=[\n\s\t]*"")/', '', $shortcode_data );
						
			$custom_style = WR_Megamenu_Helpers_Placeholder::get_placeholder( 'custom_style' );
			$row[] = '<div class="jsn-row-container ui-sortable row-fluid shortcode-container" ' . $custom_style . '>
							<textarea class="hidden" data-sc-info="shortcode_content" name="shortcode_content[]" >' . $shortcode_data . '</textarea>
							<div class="jsn-iconbar left">
								<a href="javascript:void(0);" title="' . __( 'Move Up', WR_MEGAMENU_TEXTDOMAIN ) . '" class="jsn-move-up disabled"><i class="icon-chevron-up"></i></a>
								<a href="javascript:void(0);" title="' . __( 'Move Down', WR_MEGAMENU_TEXTDOMAIN ) . '" class="jsn-move-down disabled"><i class=" icon-chevron-down"></i></a>
							</div>
							<div class="wr-row-content">
							' . $column_html . '
							</div>
							<div class="jsn-iconbar jsn-vertical">
								<a href="javascript:void(0);" onclick="return false;" class="add-container" title="' . __( 'Add column', WR_MEGAMENU_TEXTDOMAIN ) . '"><i class="wr-icon-add-col"></i></a>
								<a href="javascript:void(0);" onclick="return false;" title="Edit row" data-shortcode="' . $this->config['shortcode'] . '" class="element-edit row"><i class="icon-pencil"></i></a>
								<a href="javascript:void(0);" onclick="return false;" class="item-delete row" title="' . __( 'Delete row', WR_MEGAMENU_TEXTDOMAIN ) . '"><i class="icon-trash"></i></a>
							</div>
							<textarea class="hidden" name="shortcode_content[]" >[/' . $this->config['shortcode'] . ']</textarea>
						</div>';
			return $row;
		}

		/**
		 * get params & structure of shortcode
		 */
		public function shortcode_data() {
			$this->config['params'] = WR_Megamenu_Helpers_Shortcode::generate_shortcode_params( $this->items, null, null, false, true );
			$this->config['shortcode_structure'] = WR_Megamenu_Helpers_Shortcode::generate_shortcode_structure( $this->config['shortcode'], $this->config['params'] );
		}

		/**
		 * define shortcode structure of element
		 */
		function element_shortcode( $atts = null, $content = null ) {

			$extra_class = $style = $custom_script = '';
			if ( isset( $atts ) && is_array( $atts ) ) {
				$arr_styles = array();

				$background = '';
				switch ( $atts['background'] ) {
					case 'none':
						// if ( $atts['width'] == 'full' )
							$background = 'background: none;';
						break;
					case 'solid':
						$solid_color = $atts['solid_color_value'];
						$background  = "background-color: $solid_color;";
						break;
					case 'gradient':
						$background = $atts['gradient_color_css'];
						break;
					case 'pattern':
						$pattern_img     = $atts['pattern'];
						$pattern_repeat  = $atts['repeat'];
						$pattern_stretch = $atts['stretch'];
						$background = "background-image:url(\"$pattern_img\");";
						switch ( $pattern_repeat ) {
							case 'full':
								$background_repeat = 'repeat';
								break;
							case 'vertical':
								$background_repeat = 'repeat-y';
								break;
							case 'horizontal':
								$background_repeat = 'repeat-x';
								break;
						}
						$background .= "background-repeat:$background_repeat;";

						switch ( $pattern_stretch ) {
							case 'none':
								$background_size = '';
								break;
							case 'full':
								$background_size = '100% 100%';
								break;
							case 'cover':
								$background_size = 'cover';
								break;
							case 'contain':
								$background_size = 'contain';
								break;
						}
						$background .= ! empty( $background_size ) ? "background-size:$background_size;" : '';

						break;
					case 'image':
						$image = isset($atts['image']) ? $atts['image'] : '';
						$image_position = $atts['position'];
						if ( $image ) {
							$background = "background-image:url(\"$image\");background-position:$image_position;";
						} else {
							$background = '';
						}
						break;
				}
				$arr_styles[] = $background;

				if ( isset( $atts['paralax']) && $atts['paralax'] == 'yes' )
					$arr_styles[] = 'background-attachment:fixed;';

				if ( isset( $atts['border_width_value_'] ) && intval( $atts['border_width_value_'] ) ) {
					$border       = array();
					$border[]     = $atts['border_width_value_'] . 'px';
					$border[]     = $atts['border_style'];
					$border[]     = $atts['border_color'];
					$border       = implode( ' ', $border );
					$arr_styles[] = "border-top:$border; border-bottom:$border;";
				}
				if ( isset( $atts['div_padding_top'] ) ) {
					$arr_styles[] = "padding-top:{$atts['div_padding_top']}px;";
					$arr_styles[] = "padding-bottom:{$atts['div_padding_bottom']}px;";
				}

				// if ( $atts['width'] != 'full' ) {
					$pl = isset($atts['div_padding_left']) ? $atts['div_padding_left'] : 0;
					$pr = isset($atts['div_padding_right']) ? $atts['div_padding_right'] : 0;
					$arr_styles[] = "padding-left:{$pl}px;";
					$arr_styles[] = "padding-right:{$pr}px;";
				// }


				$arr_styles = implode( '', $arr_styles );
				$style = ! empty( $arr_styles ) ? "style='$arr_styles'" : '';
			}

			$extra_class .= ! empty ( $atts['css_suffix'] ) ? ' ' . esc_attr( $atts['css_suffix'] ) : '';
			$extra_class  = ltrim( $extra_class, ' ' );
			$extra_id     = ! empty ( $atts['id_wrapper'] ) ? ' ' . esc_attr( $atts['id_wrapper'] ) : '';
			$extra_id     = ! empty ( $extra_id ) ? "id='" . ltrim( $extra_id, ' ' ) . "'" : '';
			return $custom_script . "<div class='jsn-bootstrap3'>" . "<div $extra_id class='row $extra_class' $style>" . WR_Megamenu_Helpers_Shortcode::remove_autop( $content ) . '</div>' . '</div>';
		}

	}

}