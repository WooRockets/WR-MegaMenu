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
 * Define a column shortcode
 */
if ( ! class_exists( 'WR_Megamenu_Column' ) ) {

	class WR_Megamenu_Column extends WR_Megamenu_Shortcode_Layout {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		function element_config() {
			$this->config['shortcode']     = strtolower( __CLASS__ );
			$this->config['extract_param'] = array( 'span' );
		}

		/**
		 * contain setting items of this element (use for modal box)
		 *
		 */
		function element_items() {
			
		}

		/**
		 *
		 * @param type $content			 : inner shortcode elements of this column
		 * @param string $shortcode_data
		 * @return string
		 */
		public function element_in_megamenu( $content = '', $shortcode_data = '' ) {
			$column_html    = empty($content) ? '' : WR_Megamenu_Helpers_Shortcode::do_shortcode_admin( $content, true );
			$span           = ( ! empty($this->params['span'] ) ) ? $this->params['span'] : 'span12';
			$shortcode_data = '[' . $this->config['shortcode'] . ' span="' . $span . '"]';
			
			// Remove empty value attributes of shortcode tag.
			$shortcode_data	= preg_replace( '/\[*([a-z_]*[\n\s\t]*=[\n\s\t]*"")/', '', $shortcode_data );
			
			$rnd_id   = WR_Megamenu_Helpers_Common::random_string();
			$column[] = '<div class="jsn-column-container clearafter shortcode-container ">
							<div class="jsn-column ' . $span . '">
								<div class="thumbnail clearafter">
									<textarea class="hidden" name="shortcode_content[]" >' . $shortcode_data . '</textarea>
									<div class="jsn-column-content item-container" data-column-class="' . $span . '" >
										<div class="jsn-handle-drag jsn-horizontal jsn-iconbar-trigger"><div class="jsn-iconbar layout"><a class="item-delete column" onclick="return false;" title="' . __( 'Delete column', WR_MEGAMENU_TEXTDOMAIN ) . '" href="#"><i class="icon-trash"></i></a></div></div>
										<div class="jsn-element-container item-container-content">' . $column_html . '</div>
										<a class="jsn-add-more wr-more-element" href="javascript:void(0);"><i class="icon-plus"></i>' . __( 'Add Element', WR_MEGAMENU_TEXTDOMAIN ) . '</a>
									</div>
									<textarea class="hidden" name="shortcode_content[]" >[/' . $this->config['shortcode'] . ']</textarea>
								</div>
							</div>
						</div>';
			return $column;
		}

		/**
		 * define shortcode structure of element
		 */
		function element_shortcode( $atts = null, $content = null ) {
			extract( shortcode_atts( array( 'span' => 'span6', 'style' => '' ), $atts ) );
			$style   = empty( $style ) ? '' : "style='$style'";
			$span    = intval( substr( $span, 4 ) );
			$span_sm = intval( $span * 3 / 2 );
			$class   = "col-md-$span col-sm-$span_sm";
			return '<div class="' . $class . '" ' . $style . '>' . WR_Megamenu_Helpers_Shortcode::remove_autop( $content ) . '</div>';
		}

	}

}