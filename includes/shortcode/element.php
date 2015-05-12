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
 * Parent class for normal elements
 */

class WR_Megamenu_Shortcode_Element extends WR_Megamenu_Shortcode_Abstract {

	public function __construct() {

		$this->type = 'element';
		$this->config['el_type'] = 'element';

		$this->element_config();
		$this->element_items();
		$this->element_items_extra();
		$this->shortcode_data();

		// add shortcode
		add_shortcode( $this->config['shortcode'], array( &$this, 'element_shortcode' ) );

		// enqueue assets for current element in backend (modal setting iframe)
		if ( WR_Megamenu_Helpers_Functions::is_modal_of_element( $this->config['shortcode'] ) ) {
			add_action( 'mm_admin_enqueue_scripts', array( &$this, 'enqueue_assets_modal' ) );
		}

		do_action( 'wr_mm_element_init' );

		// enqueue custom assets at footer of frontend
		add_action( 'wp_footer', array( &$this, 'custom_assets_frontend' ) );

		// Register required assets
		add_filter( 'wr-mm-edit-element-required-assets', array( &$this, 'required_assets' ) );
	}

	/**
	 * Define required assets for shortcode settings form.
	 *
	 * @param   array  $assets  Current required assets.
	 *
	 * @return  array
	 */
	public function required_assets( $assets ) {
		if ( ! isset( $_GET['wr_shortcode_preview'] ) || ! $_GET['wr_shortcode_preview'] ) {
			// Register admin assets if required
			if ( @is_array( $this->config['exception'] ) && isset( $this->config['exception']['admin_assets'] ) ) {
				$assets[] = $this->config['exception']['admin_assets'];
			}
		} else {
			// Register front-end assets if required
			if ( @is_array( $this->config['exception'] ) && isset( $this->config['exception']['frontend_assets'] ) ) {
				$assets[] = $this->config['exception']['frontend_assets'];
			}
		}

		return $assets;
	}

	/**
     * Custom assets for frontend
     */
	public function custom_assets_frontend() {
		// enqueue custom assets here
	}

	/**
     * Enqueue scripts for frontend
     */
	public function enqueue_assets_frontend() {
		WR_Megamenu_Helpers_Functions::shortcode_enqueue_assets( $this, 'frontend_assets', '_frontend' );
	}

	/**
     * Enqueue scripts for modal setting iframe
     *
     * @param type $hook
     */
	public function enqueue_assets_modal( $hook ) {
		WR_Megamenu_Helpers_Functions::shortcode_enqueue_assets( $this, 'admin_assets', '' );
	}

	/**
     * Define configuration information of shortcode
     */
	public function element_config() {

	}

	/**
     * Define setting options of shortcode
     */
	public function element_items() {

	}

	/**
     * Add more options to all elements
     */
	public function element_items_extra() {
		$shotcode_name = $this->config['shortcode'];

		$disable_el = array(
			'name' => __( 'Disable', WR_MEGAMENU_TEXTDOMAIN ),
			'id' => 'disabled_el',
			'type' => 'radio',
			'std' => 'no',
			'options' => array( 'yes' => __( 'Yes', WR_MEGAMENU_TEXTDOMAIN ), 'no' => __( 'No', WR_MEGAMENU_TEXTDOMAIN ) ),
			'wrap_class' => 'form-group control-group hidden clearfix',
		);

		// if not child element
		if ( strpos( $shotcode_name, 'item_' ) === false ) {
			$css_wrapper = array(
				'name'    => __( 'Custom CSS', WR_MEGAMENU_TEXTDOMAIN ),
				'id'      => '',
				'type'    => 'fieldset',
			);
			$css_suffix = array(
				'name'    => __( 'Class', WR_MEGAMENU_TEXTDOMAIN ),
				'id'      => 'css_suffix',
				'type'    => 'text_field',
				'std'     => __( '', WR_MEGAMENU_TEXTDOMAIN ),
				'tooltip' => __( 'Add custom CSS Class for the wrapper div of this element', WR_MEGAMENU_TEXTDOMAIN )
			);
			$id_wrapper = array(
				'name'    => __( 'ID', WR_MEGAMENU_TEXTDOMAIN ),
				'id'      => 'id_wrapper',
				'type'    => 'text_field',
				'std'     => __( '', WR_MEGAMENU_TEXTDOMAIN ),
				'tooltip' => __( 'Add custom CSS ID for the wrapper div of this element', WR_MEGAMENU_TEXTDOMAIN ),
			);
		}



		if ( isset ( $this->items['appearance'] ) ) {

			$this->items['appearance'] = array_merge(
				$this->items['appearance'], array(
					array(
						'name'    => __( 'Advanced', WR_MEGAMENU_TEXTDOMAIN ),
						'blank_output' => '1',
						'class'   => 'wr_spacer',
						'type'    => 'spacer',
					),
					$css_suffix,
					$id_wrapper,
					$disable_el,
				)
			);

		} else {
			if ( isset ( $this->items['Notab'] ) ) {
				$this->items['Notab'] = array_merge(
					$this->items['Notab'], array(
						$css_suffix,
						$id_wrapper,
						$disable_el,

					)
				);
			}
		}
	}

	/**
	 * DEFINE html structure of shortcode in MegaMenu area
	 *
	 * @param string $content
	 * @param string $shortcode_data: string stores params (which is modified default value) of shortcode
	 * @param string $el_title: Element Title used to identifying elements in WR MegaMenu
	 * Ex:  param-tag=h6&param-text=Your+heading&param-font=custom&param-font-family=arial
	 * @return string
	 */
	public function element_in_megamenu( $content = '', $shortcode_data = '', $el_title = '', $index = '' ) {
		$shortcode		  = $this->config['shortcode'];
		$is_sub_element   = ( isset( $this->config['sub_element'] ) ) ? true : false;
		$parent_shortcode = ( $is_sub_element ) ? str_replace( 'wr_item_', '', $shortcode ) : $shortcode;
		$type			  = ! empty( $this->config['el_type'] ) ? $this->config['el_type'] : 'widget';

		// Empty content if this is not sub element
		if ( ! $is_sub_element )
			$content = '';

		$exception   = isset( $this->config['exception'] ) ? $this->config['exception'] : array();
		$content     = ( isset( $exception['default_content'] ) ) ? $exception['default_content'] : $content;
		$modal_title = '';
		// if is widget
		if ( $type == 'widget' ) {
			global $wr_megamenu_widgets;
			if ( isset( $wr_megamenu_widgets[$shortcode] ) && is_array( $wr_megamenu_widgets[$shortcode] ) && isset( $wr_megamenu_widgets[$shortcode]['identity_name'] ) ) {
				$modal_title = $wr_megamenu_widgets[$shortcode]['identity_name'];
				$content     = $this->config['exception']['data-modal-title'] = $modal_title;
			}
		}

		// if content is still empty, Generate it
		if ( empty( $content ) ) {
			if ( ! $is_sub_element )
				$content = ucfirst( str_replace( 'wr_', '', $shortcode ) );
			else {
				if ( isset( $exception['item_text'] ) ) {
					if ( ! empty( $exception['item_text'] ) )
						$content = WR_Megamenu_Helpers_Placeholder::add_placeholder( $exception['item_text'] . ' %s', 'index' );
				} else
					$content = WR_Megamenu_Helpers_Placeholder::add_placeholder( ( __( ucfirst( $parent_shortcode ), WR_MEGAMENU_TEXTDOMAIN ) . ' ' . __( 'Item', WR_MEGAMENU_TEXTDOMAIN ) ) . ' %s', 'index' );
			}
		}
		$content = ! empty( $el_title ) ? ( $content . ': ' . "<span>$el_title</span>" ) : $content;

		// element name
		if ( $type == 'element' ) {
			if ( ! $is_sub_element )
				$name = ucfirst( str_replace( 'wr_', '', $shortcode ) );
			else
				$name = __( ucfirst( $parent_shortcode ), WR_MEGAMENU_TEXTDOMAIN ) . ' ' . __( 'Item', WR_MEGAMENU_TEXTDOMAIN );
		}
		else {
			$name = $content;
		}
		if ( empty($shortcode_data) )
			$shortcode_data = $this->config['shortcode_structure'];

		// Process index for subitem element
		if ( ! empty( $index ) ) {
			$shortcode_data = str_replace( '_WR_INDEX_' , $index, $shortcode_data );
		}

		$shortcode_data  = stripslashes( $shortcode_data );
		$element_wrapper = ! empty( $exception['item_wrapper'] ) ? $exception['item_wrapper'] : ( $is_sub_element ? 'li' : 'div' );
		$content_class   = ( $is_sub_element ) ? 'jsn-item-content' : 'wr-mm-element';
		$modal_title     = empty ( $modal_title ) ? ( ! empty( $exception['data-modal-title'] ) ? "data-modal-title='{$exception['data-modal-title']}'" : '' ) : $modal_title;
		$element_type    = "data-el-type='$type'";

		$data = array(
			'element_wrapper' => $element_wrapper,
			'modal_title' => $modal_title,
			'element_type' => $element_type,
			'name' => $name,
			'shortcode' => $shortcode,
			'shortcode_data' => $shortcode_data,
			'content_class' => $content_class,
			'content' => $content,
			'action_btn' => empty( $exception['action_btn'] ) ? '' : $exception['action_btn'],
		);
		$extra = array();
		if ( isset( $this->config['exception']['disable_preview_container'] ) ) {
			$extra = array(
				'has_preview' => FALSE,
			);
		}
		$data = array_merge( $data, $extra );
		$html_preview = WR_Megamenu_Helpers_Functions::get_element_item_html( $data );
		return array(
			$html_preview
		);
	}

	/**
	 * DEFINE shortcode content
	 *
	 * @param array $atts
	 * @param string $content
	 */
	public function element_shortcode_full( $atts = null, $content = null ) {

	}

	/**
	 * return shortcode content: if shortcode is disable, return empty
	 *
	 * @param array $atts
	 * @param string $content
	 */
	public function element_shortcode( $atts = null, $content = null ) {
		$arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
		if ( $arr_params['disabled_el'] == 'yes' ) {
			if ( WR_Megamenu_Helpers_Functions::is_preview() ) {
				return ''; //_e( 'This element is deactivated. It will be hidden at frontend', WR_MEGAMENU_TEXTDOMAIN );
			}
			return '';
		}

		// enqueue script for current element in frontend
		add_action( 'wp_footer', array( &$this, 'enqueue_assets_frontend' ), 1 );

		// get full shortcode content
		return $this->element_shortcode_full( $atts, $content );
	}

	/**
	 * Wrap output html of a shortcode
	 *
	 * @param array $arr_params
	 * @param string $html_element
	 * @param string $extra_class
	 * @return string
	 */
	public function element_wrapper( $html_element, $arr_params, $extra_class = '', $custom_style = '' ) {
		$shortcode_name = WR_Megamenu_Helpers_Shortcode::shortcode_name( $this->config['shortcode'] );
		// extract margin here then insert inline style to wrapper div
		$styles = array();
		if ( ! empty ( $arr_params['div_margin_top'] ) ) {
			$styles[] = 'margin-top:' . intval( $arr_params['div_margin_top'] ) . 'px';
		}
		if ( ! empty ($arr_params['div_margin_bottom'] ) ) {
			$styles[] = 'margin-bottom:' . intval( $arr_params['div_margin_bottom'] ) . 'px';
		}
		$style = count( $styles ) ? implode( '; ', $styles ) : '';
		if ( ! empty( $style ) || ! empty( $custom_style ) ){
			$style = "style='$style $custom_style'";
		}

		$class        = "wr-element-container wr-element-$shortcode_name";
		$extra_class .= ! empty ( $arr_params['css_suffix'] ) ? ' ' . esc_attr( $arr_params['css_suffix'] ) : '';
		$class       .= ! empty ( $extra_class ) ? ' ' . ltrim( $extra_class, ' ' ) : '';
		$extra_id     = ! empty ( $arr_params['id_wrapper'] ) ? ' ' . esc_attr( $arr_params['id_wrapper'] ) : '';
		$extra_id     = ! empty ( $extra_id ) ? "id='" . ltrim( $extra_id, ' ' ) . "'" : '';
		return "<div $extra_id class='$class' $style>" . $html_element . '</div>';
	}

	/**
	 * Define html structure of shortcode in "Select Elements" Modal
	 *
	 * @param string $data_sort The string relates to Provider name to sort
	 * @return string
	 */
	public function element_button( $data_sort = '' ) {
		// Prepare variables
		$type  = 'element';
		$data_value = strtolower( $this->config['name'] );

		$extra = sprintf( 'data-value="%s" data-type="%s" data-sort="%s"', esc_attr( $data_value ), esc_attr( $type ), esc_attr( $data_sort ) );

		return self::el_button( $extra, $this->config );
	}

	/**
     * HTML output for a shortcode in Add Element popover
     *
     * @param string $extra
     * @param array $config
     * @return string
     */
	public static function el_button( $extra, $config ) {
		// Generate icon if necessary
		$icon = isset( $config['icon'] ) ? $config['icon'] : 'wr-icon-default';

		$icon = '<i class="wr-icon-formfields ' . $icon . '"></i> ';

		// Generate data-iframe attribute if needed
		$attr = '';

		if ( isset( $config['edit_using_ajax'] ) && $config['edit_using_ajax'] ) {
			$attr = ' data-use-ajax="1"';
		}
		if ( ! isset( $config['description'] ) ) {
			$config['description'] = '';
		}
		return '<li class="jsn-item"' . ( empty( $extra ) ? '' : ' ' . trim( $extra ) ) . '>
					<button data-shortcode="' . $config['shortcode'] . '" class="shortcode-item btn btn-default" title="' . $config['description'] . '"' . $attr . '>
						' . $icon . $config['name'] . '
							<p class="help-block">' . $config['description'] . '</p>
					</button>
				</li>';
	}

	/**
     * Get params & structure of shortcode
     */
	public function shortcode_data() {
		$params = WR_Megamenu_Helpers_Shortcode::generate_shortcode_params( $this->items, null, null, false, true );
		// add Margin parameter for Not child shortcode
		if ( strpos( $this->config['shortcode'], '_item' ) === false ) {
			if( $this->config['shortcode'] == 'wr_submenu' ){
				$this->config['params'] = array_merge( array( 'disabled_el' => 'no', 'css_suffix' => '', 'id_wrapper' => '' ), $params );
			} else {
				$this->config['params'] = array_merge( array( 'div_margin_top' => '10', 'div_margin_bottom' => '10', 'disabled_el' => 'no', 'css_suffix' => '', 'id_wrapper' => '' ), $params );
			}
		}
		else {
			$this->config['params'] = $params;
		}

		$this->config['shortcode_structure'] = WR_Megamenu_Helpers_Shortcode::generate_shortcode_structure( $this->config['shortcode'], $this->config['params'] );
	}

}
