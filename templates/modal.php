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

if ( ! isset( $_POST ) ) {
	die;
}
;

extract( $_POST );

$submodal = ! empty( $submodal ) ? 'submodal_frame' : '';
if ( ! isset( $params ) ) {
	exit;
}

if ( ! empty( $shortcode ) ) {
	$script = '';
	if ( isset( $init_tab ) && $init_tab == 'appearance' ) {
		// Auto move to Styling tab if previous action
		// is coping style from other element.
		$script .= "
			(function ($) {
				$(document).ready(function (){
					setTimeout(function (){
						$('[href=\"#appearance\"]').click();
					}, 500);

				});
			})(jQuery);";
	}

	if ( @$_REQUEST['form_only'] ) {
		$script .= ' var wr_mm_modal_ajax = true;';
	}

	WR_Megamenu_Init_Assets::print_inline( 'js', $script, true );
	?>

	<div id="wr-element-<?php echo esc_attr( WR_Megamenu_Helpers_Shortcode::shortcode_name( $shortcode ) ); ?>">
		<div class="wr-mm-form-container jsn-bootstrap3">
			<div id="modalOptions" class="form-horizontal <?php echo esc_attr( $submodal ); ?>">
	<?php
	if ( ! empty( $params ) ) {
		$params = stripslashes( $params );
		$params = urldecode( $params );
	}

	// elements
	if ( $el_type == 'element' ) {

		// get shortcode class
		$class = WR_Megamenu_Helpers_Shortcode::get_shortcode_class( $shortcode );
		if ( class_exists( $class ) ) {
			global $wr_megamenu_element;
			$elements = $wr_megamenu_element->get_elements();
			$instance = isset( $elements['element'][strtolower( $class )] ) ? $elements['element'][strtolower( $class )] : null;

			if ( ! is_object( $instance ) ) {
				$instance = new $class();
			}
			if ( ! empty( $params ) ) {
				$extract_params = WR_Megamenu_Helpers_Shortcode::extract_params( $params, $shortcode );

				// if have sub-shortcode, extract sub shortcodes content
				if ( ! empty( $instance->config['has_subshortcode'] ) ) {
					$sub_sc_data                         = WR_Megamenu_Helpers_Shortcode::extract_sub_shortcode( $params, true );
					$sub_sc_data                         = apply_filters( 'wr_mm_sub_items_filter', $sub_sc_data, $shortcode, isset ( $_COOKIE['wr_mm_data_for_modal'] ) ? $_COOKIE['wr_mm_data_for_modal'] : '' );
					$extract_params['sub_items_content'] = $sub_sc_data;
				}

				// MODIFY $instance->items
				WR_Megamenu_Helpers_Shortcode::generate_shortcode_params( $instance->items, NULL, $extract_params, TRUE );

				// if have sub-shortcode, re-generate shortcode structure
				if ( ! empty( $instance->config['has_subshortcode'] ) ) {
					$instance->shortcode_data();
				}
			}

			// get Modal setting box
			$settings      = $instance->items;
			$settings_html = '';
			if ( $shortcode == 'wr_megamenu_row' ) {
				$settings_html .= '<div class="col-sm-12 wr-row-setting">' . WR_Megamenu_Helpers_Modal::get_shortcode_modal_settings( $settings, $shortcode, $extract_params, $params ) . '</div>';
			} else {
				$settings_html .= '<div class="wr-setting-resize">' . WR_Megamenu_Helpers_Modal::get_shortcode_modal_settings( $settings, $shortcode, $extract_params, $params ) . '</div>';
				$settings_html .= '<div class="wr-preview-resize">' . WR_Megamenu_Helpers_Shortcode::render_parameter( 'preview' ) . '</div>';
			}

			echo balanceTags( $settings_html );
		}

		?>
        <form id="frm_shortcode_settings" action="" method="post">
            <?php
				// Render the inputs to store element setting data for Copy style feature
		foreach ( $_POST as $k => $v ) {
			echo '<input type="hidden" id="hid-' . $k .  '" name="' . $k . '" value="' . urlencode( $v ) . '" />';
		}
		echo '<input type="hidden" id="hid-init_tab" name="init_tab" value="appearance" />';
			?>
        </form>
        <?php
	}
	// widgets
	else if ( $el_type == 'widget' ) {
		$instance          = WR_Megamenu_Helpers_Shortcode::extract_widget_params( $params );
		$instance['title'] = isset( $instance['title'] ) ? $instance['title'] : $el_title;

		// generate setting form of widget
		$widget = new $shortcode();
		ob_start();
		$widget->form( $instance );
		$form = ob_get_clean();

		// simplify widget field name
		$exp  = preg_quote( $widget->get_field_name( '____' ) );
		$exp  = str_replace( '____', '(.*? )', $exp );
		$form = preg_replace( '/' . $exp . '/', '$1', $form );

		// simplify widget field id
		$exp  = preg_quote( $widget->get_field_id( '____' ) );
		$exp  = str_replace( '____', '(.*? )', $exp );
		$form = preg_replace( '/' . $exp . '/', 'param-$1', $form );

		// tab and content generate
		$tabs = array();
		foreach ( array( 'content' ) as $i => $tab ) {
			$active               = ( $i ++ == 0 ) ? 'active' : '';
			$data_['href']        = "#$tab";
			$data_['data-toggle'] = 'tab';
			$content_             = ucfirst( $tab );
			$tabs[]               = "<li class='$active'>" . WR_Megamenu_Helpers_Modal::tab_settings( 'a', $data_, $content_ ) . '</li>';
		}

		// content
		$contents   = array();
		$contents[] = "<div class='tab-pane active' id='content'><form id='wr-widget-form'>$form</form></div>";

		$output  = '<div class="wr-setting-resize">' . WR_Megamenu_Helpers_Modal::setting_tab_html( $shortcode, $tabs, $contents, array(), '', array() ) . '</div>';
		$output .= '<div class="wr-preview-resize">' . WR_Megamenu_Helpers_Shortcode::render_parameter( 'preview' ) . '</div>';

		echo balanceTags( $output );
	}
	?>
				<div id="modalAction" class="wr-mm-setting-tab"></div>
			</div>
			<textarea class="hidden" id="shortcode_content"><?php echo esc_attr( $params ); ?></textarea>
			<textarea class="hidden" id="wr_share_data"></textarea>
			<textarea class="hidden" id="wr_merge_data"></textarea>
			<textarea class="hidden" id="wr_extract_data"></textarea>
			<input type="hidden" id="wr_previewing" value="0" />
			<input id="shortcode_type" type="hidden" value="<?php echo esc_attr( $el_type ); ?>" />
			<input id="shortcode_name" type="hidden" value="<?php echo esc_attr( addslashes( $_GET['wr_modal_type'] ) ); ?>" />

			<div class="jsn-modal-overlay"></div>
			<div class="jsn-modal-indicator"></div>

			<?php
			// append custom assets/HTML for specific shortcode here
			do_action( 'wr_mm_modal_footer', $shortcode ); ?>
		</div>
	</div>
	<?php
}