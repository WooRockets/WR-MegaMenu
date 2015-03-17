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

if ( ! class_exists( 'WR_Megamenu_Image' ) ) :

/**
 * Create Image element
 *
 * @package  WR MegaMenu Shortcodes
 * @since	1.0.0
 */
class WR_Megamenu_Image extends WR_Megamenu_Shortcode_Element
{
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
	public function element_config()
	{
		$this->config['shortcode']   = strtolower( __CLASS__ );
		$this->config['name']        = __( 'Image', WR_MEGAMENU_TEXTDOMAIN );
		$this->config['cat']         = __( 'Media', WR_MEGAMENU_TEXTDOMAIN );
		$this->config['icon']        = 'wr-icon-image';
		$this->config['description'] = __( 'Simple image with animation', WR_MEGAMENU_TEXTDOMAIN );

		// Define exception for this shortcode
		$this->config['exception'] = array(

			'admin_assets'	=> array(
				// Link Type
				'wr-linktype.js',

				// Shortcode initialization
				'image.js',
			),

			'frontend_assets' => array(
				// Bootstrap 3
				'wr-pb-bootstrap-css',
				'wr-pb-bootstrap-js',

				// Fancy Box
				'wr-pb-jquery-fancybox-css',
				'wr-pb-jquery-fancybox-js',

				// Lazy Load
				'wr-jquery-lazyload-js',

				// Shortcode initialization
				'image_frontend.js',
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
	public function element_items()
	{
		$this->items = array(
			'content' => array(
				array(
					'name'	=> __( 'Element Title', WR_MEGAMENU_TEXTDOMAIN ),
					'id'	  => 'el_title',
					'type'	=> 'text_field',
					'class'   => 'input-sm',
					'std'	 => __( '', WR_MEGAMENU_TEXTDOMAIN ),
					'role'	=> 'title',
					'tooltip' => __( 'Set title for current element for identifying easily', WR_MEGAMENU_TEXTDOMAIN )
				),

				array(
					'name'	=> __( 'Image File', WR_MEGAMENU_TEXTDOMAIN ),
					'id'	  => 'image_file',
					'type'	=> 'select_media',
					'std'	 => '',
					'class'   => 'jsn-input-large-fluid',
					'tooltip' => __( 'Choose image', WR_MEGAMENU_TEXTDOMAIN ),
				),
				array(
					'name'	=> __( 'Image Size', WR_MEGAMENU_TEXTDOMAIN ),
					'id'	  => 'image_size',
					'type'	=> 'large_image',
					'tooltip' => __( 'Set image size', WR_MEGAMENU_TEXTDOMAIN ),
				),
				array(
					'name'	=> __( 'Alt Text', WR_MEGAMENU_TEXTDOMAIN ),
					'id'	  => 'image_alt',
					'type'	=> 'text_field',
					'class'   => 'input-sm',
					'std'	 => '',
					'tooltip' => __( 'Set alt text for image', WR_MEGAMENU_TEXTDOMAIN ),
				),
				array(
					'name'	=> __( 'Caption', WR_MEGAMENU_TEXTDOMAIN ),
					'id'	  => 'image_caption',
					'type'	=> 'text_field',
					'class'   => 'input-sm',
					'std'	 => '',
					'tooltip' => __( 'Set caption for image', WR_MEGAMENU_TEXTDOMAIN )
				),
				array(
					'name'	   => __( 'On Click', WR_MEGAMENU_TEXTDOMAIN ),
					'id'		 => 'link_type',
					'type'	   => 'select',
					'class'	  => 'input-sm',
					'std'		=> WR_Megamenu_Helpers_Type::get_first_option( WR_Megamenu_Helpers_Type::get_image_link_types() ),
					'options'	=> WR_Megamenu_Helpers_Type::get_image_link_types(),
					'tooltip'	=> __( 'Set link type of image', WR_MEGAMENU_TEXTDOMAIN ),
					'has_depend' => '1',
				),
				array(
					'name'	   => __( 'Large Image Size', WR_MEGAMENU_TEXTDOMAIN ),
					'id'		 => 'image_image_size',
					'type'	   => 'large_image',
					'tooltip'	=> __( 'Choose image size', WR_MEGAMENU_TEXTDOMAIN ),
					'dependency' => array( 'link_type', '=', 'large_image' ),
				),
				array(
					'name'	   => __( 'URL', WR_MEGAMENU_TEXTDOMAIN ),
					'id'		 => 'image_type_url',
					'type'	   => 'text_field',
					'class'	  => 'input-sm',
					'std'		=> 'http://',
					'dependency' => array( 'link_type', '=', 'url' ),
					'tooltip'	=> __( 'Url of link when click on image', WR_MEGAMENU_TEXTDOMAIN ),
				),
				array(
					'name'	=> __( 'Single Item', WR_MEGAMENU_TEXTDOMAIN ),
					'id'	  => 'single_item',
					'type'	=> 'type_group',
					'std'	 => '',
					'items'   => WR_Megamenu_Helpers_Type::get_single_item_button_bar(
							'link_type',
							array(
								'type'		 => 'items_list',
								'options_type' => 'select',
								'ul_wrap'	  => false,
							)
						),
					'tooltip' => __( 'Choose item to link to', WR_MEGAMENU_TEXTDOMAIN ),
				),
				array(
					'name'	   => __( 'Open in', WR_MEGAMENU_TEXTDOMAIN ),
					'id'		 => 'open_in',
					'type'	   => 'select',
					'std'		=> WR_Megamenu_Helpers_Type::get_first_option( WR_Megamenu_Helpers_Type::get_open_in_options() ),
					'options'	=> WR_Megamenu_Helpers_Type::get_open_in_options(),
					'dependency' => array( 'link_type', '!=', 'no_link' ),
					'tooltip'	=> __( 'Select type of opening action when click on element', WR_MEGAMENU_TEXTDOMAIN ),
				),
			),
			'appearance' => array(

				array(
					'name'	=> __( 'Container Style', WR_MEGAMENU_TEXTDOMAIN ),
					'id'	  => 'image_container_style',
					'type'	=> 'select',
					'class'   => 'input-sm',
					'std'	 => WR_Megamenu_Helpers_Type::get_first_option( WR_Megamenu_Helpers_Type::get_container_style() ),
					'options' => WR_Megamenu_Helpers_Type::get_container_style(),
					'tooltip' => __( 'Set Container Style', WR_MEGAMENU_TEXTDOMAIN ),
				),
				array(
					'name'	=> __( 'Alignment', WR_MEGAMENU_TEXTDOMAIN ),
					'id'	  => 'image_alignment',
					'type'	=> 'select',
					'class'   => 'input-sm',
					'std'	 => WR_Megamenu_Helpers_Type::get_first_option( WR_Megamenu_Helpers_Type::get_text_align() ),
					'options' => WR_Megamenu_Helpers_Type::get_text_align(),
					'tooltip' => __( 'Setting position: right, left, center, inherit parent style', WR_MEGAMENU_TEXTDOMAIN )
				),
				array(
					'name'				=> __( 'Margin', WR_MEGAMENU_TEXTDOMAIN ),
					'container_class'	 => 'combo-group',
					'id'				  => 'image_margin',
					'type'				=> 'margin',
					'extended_ids'		=> array( 'image_margin_top', 'image_margin_right', 'image_margin_bottom', 'image_margin_left' ),
					'image_margin_top'	=> array( 'std' => '' ),
					'image_margin_bottom' => array( 'std' => '' ),
					'tooltip'			 => __( 'Set margin size', WR_MEGAMENU_TEXTDOMAIN )
				),
				array(
					'name'	=> __( 'Fade in Animations', WR_MEGAMENU_TEXTDOMAIN ),
					'id'	  => 'image_effect',
					'type'	=> 'radio',
					'std'	 => 'no',
					'options' => array( 'yes' => __( 'Yes', WR_MEGAMENU_TEXTDOMAIN ), 'no' => __( 'No', WR_MEGAMENU_TEXTDOMAIN ) ),
					'tooltip' => 'Whether to fading in or not',
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
	public function element_shortcode_full( $atts = null, $content = null )
	{
		$arr_params = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );
		$html_elemments = $script = '';
		$alt_text	   = ($image_alt) ? " alt='{$image_alt}'" : '';

		if (isset($arr_params['image_margin_top']))
			$arr_params['div_margin_top'] = $arr_params['image_margin_top'];
		if (isset($arr_params['image_margin_bottom']))
			$arr_params['div_margin_bottom'] = $arr_params['image_margin_bottom'];
		if (isset($arr_params['image_margin_right']))
			$arr_params['div_margin_right'] = $arr_params['image_margin_right'];
		if (isset($arr_params['image_margin_left']))
			$arr_params['div_margin_left'] = $arr_params['image_margin_left'];

		// No add image effect in admin view
		if ( is_admin() ) {
			$image_effect = 'no';
		}
		
		$class_img = ($image_container_style != 'no-styling') ? $image_container_style : '';
		$class_img = ($image_effect == 'yes') ? $class_img . ' image-scroll-fade' : $class_img;
		$class_img = ( ! empty( $class_img ) ) ? ' class="' . $class_img . '"' : '';

		if ( $image_file ) {
			$image_id   = WR_Megamenu_Helpers_Functions::get_image_id( $image_file );
			$attachment = wp_prepare_attachment_for_js( $image_id );
			$image_file = ( ! empty( $attachment['sizes'][ $image_size ]['url'])) ? $attachment['sizes'][ $image_size ]['url'] : $image_file;
			$html_elemments .= "<img src='{$image_file}'{$alt_text}{$class_img} />";
			$script = '';
			$target = '';

			if ( $image_effect == 'yes' AND ! isset( $_POST['action'] ) ) {
				$data           = getimagesize( $image_file );
				$width          = $data[0];
				$height         = $data[1];
				$html_elemments = "<img src='" . WR_Megamenu_Helpers_Functions::path( 'assets/3rd-party' ) . '/jquery-lazyload/grey.gif' . "' data-original='{$image_file}' width='{$width}' height='{$height}' {$alt_text} {$class_img}/>";
			}

			if ( $open_in ) {
				switch ( $open_in ) {
					case 'current_browser':
						$target = '';
						break;
					case 'new_browser':
						$target = ' target="_blank"';
						break;
					case 'new_window':
						$cls_button_fancy = 'wr-button-new-window';
						$script           = WR_Megamenu_Helpers_Functions::new_window( ".$cls_button_fancy", array( 'width' => '75%', 'height' => '75%' ) );						
						break;
					case 'lightbox':
						$cls_button_fancy = 'mm-image-fancy';
						break;
				}
			}

			$class = ( isset( $cls_button_fancy ) && ! empty( $cls_button_fancy ) ) ? " class='{$cls_button_fancy}'" : '';

			// get Single Item and check type to get right link
			$single_item = explode( '__#__', $single_item );
			$single_item = $single_item[0];
			$taxonomies  = WR_Megamenu_Helpers_Type::get_public_taxonomies();
			$post_types  = WR_Megamenu_Helpers_Type::get_post_types();
			// single post
			if ( array_key_exists( $link_type, $post_types ) ) {
				$permalink	  = home_url() . "/?p=$single_item";
				$html_elemments = "<a href='{$permalink}'{$target}{$class}>" . $html_elemments . '</a>';
			} // taxonomy
			else if ( array_key_exists( $link_type, $taxonomies ) ) {
				$permalink = get_term_link( intval( $single_item ), $link_type );
				if ( ! is_wp_error( $permalink ) )
					$html_elemments = "<a href='{$permalink}'{$target}{$class}>" . $html_elemments . '</a>';
			} else {
				switch ( $link_type ) {
					case 'url':
						$html_elemments = "<a href='{$image_type_url}'{$target}{$class}>" . $html_elemments . '</a>';
						break;
					case 'large_image':
						$image_id	    = WR_Megamenu_Helpers_Functions::get_image_id( $image_file );
						$attachment	    = wp_prepare_attachment_for_js( $image_id );
						$image_url	    = ( ! empty( $attachment['sizes'][ $image_image_size ]['url'])) ? $attachment['sizes'][ $image_image_size ]['url'] : $image_file;
						$html_elemments = "<a href='{$image_url}'{$target}{$class}>" . $html_elemments . '</a>';
						break;
				}
			}

			if ( $image_caption != '' ) {
				$html_elemments = $html_elemments . '<div class="clearfix"></div><div class="image_caption">'.$image_caption.'</div>';
			}

			if ( strtolower( $image_alignment ) != 'inherit' ) {
				if ( strtolower( $image_alignment ) == 'left' )
					$cls_alignment = 'pull-left';
				if ( strtolower( $image_alignment ) == 'right')
					$cls_alignment = 'pull-right';
				if ( strtolower( $image_alignment ) == 'center')
					$cls_alignment = 'text-center';
				$html_elemments = "<div class='{$cls_alignment}'>" . $html_elemments . '</div>';
			}
		}

		return $this->element_wrapper( $html_elemments . $script, $arr_params );
	}
}

endif;
