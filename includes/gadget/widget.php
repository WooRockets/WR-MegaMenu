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
 * Gadget class for loading editor for WR MegaMenu element.
 *
 * @package  WR_Megamenu
 * @since	1.0
 */
class WR_Megamenu_Gadget_Widget extends WR_Megamenu_Gadget_Base {
	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'widget';

	// fix
	public function widget_action() {
		include_once ABSPATH . 'wp-admin/includes/widgets.php';

		wp_enqueue_style( 'wr-megamenu_modal', WR_MEGAMENU_ROOT_URL . '/assets/css/modal.css' );

		@session_start();

		global $wp_widget_factory;
		$widgets   = $wp_widget_factory->widgets;
		$widget_id = $_GET['widget_id'];

		$menu     = isset( $_REQUEST['menu'] ) ? $_REQUEST['menu'] : '';
		$location = isset( $_REQUEST['location'] ) ? $_REQUEST['location'] : '';

		if ( ! $widget_id ) {
			exit( __( 'No widget ID' ) );
		}

		if ( ! $widgets[ $widget_id ] ){
			exit( __( 'Can not find this widget' ) );
		}
		$instance = array();
		$options  = array();

		if ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] == 'edit' ) {
			$options = $_SESSION[ 'wr_megamenu_widget_options_' . $widget_id ];
			$options = (array) json_decode( $options );
		} else {
			unset( $_SESSION[ 'wr_megamenu_widget_options_' . $widget_id ] );
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
		
		ob_start();

		echo '<div class="jsn-bootstrap3" id="widget-options-container">
		<form id="widget-options" class="form-horizontal form-inline" onsubmit="javascript:void(0)" autocomplete="false">
		<input type="hidden" name="wr_megamenu_menu" id="wr_megamenu_menu" value="' . $menu . '">
		<input type="hidden" name="wr_megamenu_location" id="wr_megamenu_location" value="' . $location . '">
		<input type="hidden" name="wr_megamenu_widget_id" id="wr_megamenu_widget_id" value="' . $widget_id_base . '">
		<input type="hidden" name="wr_megamenu_widget_title_id" id="wr_megamenu_widget_title_id" value="' . $wg->get_field_id( 'title' ) . '">
		';

		$wg->form( $instance );

		echo '</form></div>';

		echo balanceTags( ob_get_clean() );

	}

	/**
	 * Render the output.
	 *
	 * @param   string  $action  Gadget action to execute.
	 *
	 * @return  void
	 */
	protected function render( $action = 'default' ) {

	}
}
