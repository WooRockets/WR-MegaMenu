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

include_once ABSPATH . 'wp-admin/includes/widgets.php';
@session_start();
class WR_Megamenu_Builder {
	/**
	 * Constructor class
	 */
	public function __construct()
	{
		$type	=	isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
		switch ( $type ){
			case 'modal_page': $this->modal_page();
			break;
			default:
				$this->init_menu_builder_layout();
				break;

		}
	}
	/**
	 * Init the MegaMenu Builder page
	 */
	private function init_menu_builder_layout()
	{
		$data           = array();
		$layout_helper  = new WR_Megamenu_Helpers_Layout();
		$builder_helper = new WR_Megamenu_Helpers_Builder();

		//$layout_helper->add_admin_assets();
		// Include libraries.
		$profile_id = $_REQUEST['profile_id'];
		if ( ! $profile_id ) {
			exit(_e( 'Profile not found.', WR_MEGAMENU_TEXTDOMAIN ) );;
		} else {
			$profile = get_post( $profile_id );
			if ( $profile ) {
				$layout_helper->set_template_data( 'profile', $profile );
			}
		}

		$layout_helper->set_template_data( 'builder_helper', $builder_helper );
		$layout_helper->load_template( 'builder' );
	}



	/**
	 * Load modal page as blank page
	 * with no bars or header, footer...
	 */
	public function modal_page()
	{
		$action = $_REQUEST['action'];
		wp_enqueue_style( 'wr-megamenu_modal', WR_MEGAMENU_ROOT_URL . '/assets/css/modal.css' );
		$this->{$action}();
	}

	public function widget_option()
	{
		@session_start();

		global $wp_widget_factory;
		$widgets   = $wp_widget_factory->widgets;
		$widget_id = $_GET['widget_id'];

		$menu     = isset($_REQUEST['menu']) ? $_REQUEST['menu'] : '';
		$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

		if ( ! $widget_id ) {
			exit(__( 'No widget ID' ) );
		}

		if ( ! $widgets[ $widget_id ] ){
			exit(__( 'Can not find this widget' ) );
		}
		$instance = array();
		$options  = array();

		if ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] == 'edit' ){
			$options = $_SESSION['wr_megamenu_widget_options_' . $widget_id];
			$options = (array) json_decode( $options );
		} else {
			unset($_SESSION['wr_megamenu_widget_options_' . $widget_id]);
		}

		$wg         = new $widget_id;
		$wg->number = 0;

		//Get the base ID of widget.
		$widget_id_base	= $wg->id_base;

		if ( isset( $options ) && count( $options ) ){
			// Process field name prefix
			$sample_name = $wg->get_field_name( '' );
			$_patern     = '#([^\[\]\r\n\s\t]+)\[#';
			preg_match_all( $_patern, $sample_name, $matches, PREG_SET_ORDER );

			if ( $matches ) {
				$options_index	= $matches[0][1];
			}

			$instance	= (array)$options[$options_index][0];

		}

		echo '<div class="jsn-bootstrap3" id="widget-options-container">
		<form id="widget-options" class="form-horizontal form-inline" onsubmit="javascript:void(0)" autocomplete="false">
		<input type="hidden" name="wr_megamenu_menu" id="wr_megamenu_menu" value="' . $menu . '">
		<input type="hidden" name="wr_megamenu_location" id="wr_megamenu_location" value="' . $location . '">
		<input type="hidden" name="wr_megamenu_widget_id" id="wr_megamenu_widget_id" value="' . $widget_id_base . '">
		<input type="hidden" name="wr_megamenu_widget_title_id" id="wr_megamenu_widget_title_id" value="' . $wg->get_field_id( 'title' ) . '">
		';

		$wg->form( $instance );

		echo '</form></div>';
	}

}

$mega_menu = new WR_Megamenu_Builder();