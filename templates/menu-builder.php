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

wp_nonce_field( 'wr_mm_builder', WR_MEGAMENU_NONCE . '_builder' );

$locations = get_registered_nav_menus();
$menus     = wp_get_nav_menus();
$data      = WR_Megamenu_Helpers_Builder::get_megamenu_data( $profile->ID );
$menu_type = isset( $data['menu_type'] ) ? $data['menu_type'] : ( isset( $menus[0]->term_id ) ? $menus[0]->term_id : '' );


$tab_contents = array(
	'menu_bar' => 'Menu Bar',
	'submenu_panel' => 'Submenu Panel',
);

$styling_fields = array();

$styling_fields['menu_bar'] = array(

	array(
		'name'    => __( 'Menu layout', WR_MEGAMENU_TEXTDOMAIN ),
		'id'      => 'menu-bar-menu_layout',
		'type'    => 'radio_button_group',
		'std'     => 'horizontal',
		'icons'   => 'wr-icon-horizontal_#_wr-icon-vertical',
		'options' => array(
			'horizontal' => __( 'Horizontal', WR_MEGAMENU_TEXTDOMAIN ),
			'vertical'   => __( 'Vertical', WR_MEGAMENU_TEXTDOMAIN ),
		),
	),
	array(
		'name'	=> __( 'Stick menu to top', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'menu-bar-stick_menu',
		'type'	=> 'radio_group',
		'std'	 => 'no',
		'options' => array(
			'no' => __( 'No', WR_MEGAMENU_TEXTDOMAIN ),
			'yes'   => __( 'Yes', WR_MEGAMENU_TEXTDOMAIN ),
		),
		'tooltip' => __( 'Stick menu to top when scroll down', WR_MEGAMENU_TEXTDOMAIN )
	),

	array(
		'name'	=> __( 'Font', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'menu-bar-font',
		'type'	=> 'select',
		'class'   => 'input-sm',
		'std'	 => __( 'inherit', WR_MEGAMENU_TEXTDOMAIN ),
		'options'	=> array(
			'inherit' => 'Inherit',
			'custom' => 'Custom',
		),
		'has_depend' => '1',
	),
	array(
		'name'	=> __( 'Font Face', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'menu-bar-font_family',
		'type'	=> array(
			array(
				'id'	  => 'menu-bar-font_type',
				'type'	=> 'select',
				'class'   => 'font-type ',
				'std'	 => 'Standard Font',
				'options'	=> array(
					'Standard Font' => 'Standard Font',
					'Google Font' => 'Google Font',
				),
			),
			array(
				'id'	  => 'menu-bar-font_face',
				'type'	=> 'select',
				'class'   => 'font-face',
				'std'	 => 'Arial',
				'options'	=> array(
					'Arial' => 'Arial',
					'Verdana' => 'Verdana',
					'Times New Roman' => 'Times New Roman',
				),
			),

		),
		'dependency' => array( 'menu-bar-font', '=', 'custom' ),
	),

	array(
		'name' => __( 'Font Attributes', WR_MEGAMENU_TEXTDOMAIN ),
		'id'   => 'menu-bar-font_attributes',
		'type' => array(
			array(
				'id'      => 'menu-bar-font_weight',
				'type'    => 'select',
				'class'   => 'form-control pull-left',
				'std'     => 'normal',
				'options' => array(
					'bold'   => 'Bold',
					'light'  => 'Light',
					'normal' => 'Normal',
					'thin'   => 'Thin',
				),
			),
			array(
				'id'    => 'menu-bar-font_size',
				'type'  => 'select',
				'class' => 'form-control pull-left',
				'std'   => '10',
				'options' => array(
					'10' => '10',
					'12' => '12',
					'13' => '13',
					'14' => '14',
					'15' => '15',
					'16' => '16',
					'17' => '17',
					'18' => '18',
					'19' => '19',
					'20' => '20',
				),
			),
			array(
				'id'               => 'menu-bar-menu_color',
				'type'             => 'color_picker2',
				'std'              => '#000',
				'hide_value'       => 'true',
				'wrap_color_class' => '',
			),
		),
		'dependency' => array( 'menu-bar-font', '=', 'custom' ),
	),
	array(
		'name' => __( 'Background Color', WR_MEGAMENU_TEXTDOMAIN ),
		'type' => array(
			array(
				'id'   => 'menu-bar-bg',
				'type' => 'color_picker2',
				'std'  => '#ffffff',
			),
		),
		'container_class' => 'combo-group',
	),
	array(
		'name' => __( 'Background On Hover', WR_MEGAMENU_TEXTDOMAIN ),
		'type' => array(
			array(
				'id'   => 'menu-bar-on_hover',
				'type' => 'color_picker2',
				'std'  => '#ffffff',
			),
		),
		'container_class' => 'combo-group',
	),
	array(
		'name'         => __( 'Icon', WR_MEGAMENU_TEXTDOMAIN ),
		'id'           => 'menu-bar-icon_spacer',
		'class'        => 'wr_spacer',
		'blank_output' => '1',
		'type'         => 'spacer',
		'tooltip'      => __( 'To add icon for menu item, access to WP Menu management', WR_MEGAMENU_TEXTDOMAIN )
	),
	array(
		'name'	=> __( 'Display Mode', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'menu-bar-icon_display_mode',
		'type'	=> 'radio_button_group',
		'std'	 => 'text_only',
		'icons' => 'wr-icon-text-only_#_wr-icon-icon-only_#_wr-icon-icon-text',
		'options' => array(
			'text_only' => __( 'Text Only', WR_MEGAMENU_TEXTDOMAIN ),
			'icon_only'   => __( 'Icon Only', WR_MEGAMENU_TEXTDOMAIN ),
			'icon_text'   => __( 'Icon vs Text', WR_MEGAMENU_TEXTDOMAIN ),
		),
		'has_depend' => '1',
	),

	array(
		'name'	=> __( 'Icon Position', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'menu-bar-icon_position',
		'type'	=> 'radio_group',
		'std'	 => 'left',
		'options' => array(
			'left' => __( 'Left', WR_MEGAMENU_TEXTDOMAIN ),
			'top'   => __( 'Top', WR_MEGAMENU_TEXTDOMAIN ),
		),
		'tooltip' => __( 'the position of icon', WR_MEGAMENU_TEXTDOMAIN ),
		'dependency' => array( 'menu-bar-icon_display_mode', '=', 'icon_text' ),
	),

	array(
		'name'	=> __( 'Icon Size', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'menu-bar-icon_size',
		'type'	=> 'text_number',
		'exclude_class' => array('form-control'),
		'std'	 => '16',
		'dependency' => array( 'menu-bar-icon_display_mode', '!=', 'text_only' ),
	),

);

$styling_fields['submenu_panel'] = array(

	array(
		'name'	=> __( 'Heading Text', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'heading-text-font',
		'type'	=> 'select',
		'class'   => 'input-sm',
		'std'	 => __( 'inherit', WR_MEGAMENU_TEXTDOMAIN ),
		'options'	=> array(
			'inherit' => 'Inherit',
			'custom' => 'Custom',
		),
		'has_depend' => '1',
	),

	array(
		'name'	=> __( 'Font Face', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'heading-text-font_family',
		'type'	=> array(
			array(
				'id'	  => 'heading-text-font_type',
				'type'	=> 'select',
				'class'   => 'font-type',
				'std'	 => 'Standard Font',
				'options'	=> array(
					'Standard Font' => 'Standard Font',
					'Google Font' => 'Google Font',
				),

			),
			array(
				'id'	  => 'heading-text-font_face',
				'type'	=> 'select',
				'class'   => 'font-face',
				'std'	 => __( 'Arial', WR_MEGAMENU_TEXTDOMAIN ),
				'role'	=> 'title',
				'options'	=> array(
					'Arial' => 'Arial',
					'Verdana' => 'Verdana',
					'Times New Roman' => 'Times New Roman',
				),

			),
		),

		'dependency' => array( 'heading-text-font', '=', 'custom' ),
	),

	array(
		'name'	=> __( 'Font Attributes', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'heading-text-font_attributes',
		'type'	=> array(
			array(
				'id'	  => 'heading-text-font_weight',
				'type'	=> 'select',
				'class'   => 'form-control',
				'std'	 => 'bold',
				'options'	=> array(
					'bold' => 'Bold',
					'light' => 'Light',
					'normal' => 'Normal',
					'thin' => 'Thin',
				),

			),
			array(
				'id'	  => 'heading-text-font_size',
				'type'	=> 'select',
				'class'   => 'form-control',
				'std'	 => '10',
				'options'	=> array(
					'10' => '10',
					'12' => '12',
					'13' => '13',
					'14' => '14',
					'15' => '15',
					'16' => '16',
					'17' => '17',
					'18' => '18',
					'19' => '19',
					'20' => '20',
				),

			),
			array(
				'id'		   => 'heading-text-menu_color',
				'type'		 => 'color_picker2',
				'hide_value'   => 'true',
				'std'		  => '#000',
				'wrap_color_class' => '',
			),
		),

		'dependency' => array( 'heading-text-font', '=', 'custom' ),
	),

	array(
		'name'	=> __( 'Normal Text', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'normal-text-font',
		'type'	=> 'select',
		'class'   => 'input-sm',
		'std'	 => __( 'inherit', WR_MEGAMENU_TEXTDOMAIN ),
		'options'	=> array(
			'inherit' => 'Inherit',
			'custom' => 'Custom',
		),
		'has_depend' => '1',
	),

	array(
		'name'	=> __( 'Font Face', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'normal-text-font_family',
		'type'	=> array(
			array(
				'id'	  => 'normal-text-font_type',
				'type'	=> 'select',
				'class'   => 'font-type',
				'std'	 => 'Standard Font',
				'options'	=> array(
					'Standard Font' => 'Standard Font',
					'Google Font' => 'Google Font',
				),
			),
			array(
				'id'	  => 'normal-text-font_face',
				'type'	=> 'select',
				'class'   => 'font-face',
				'std'	 => 'Arial',
				'role'	=> 'title',
				'options'	=> array(
					'Arial' => 'Arial',
					'Verdana' => 'Verdana',
					'Times New Roman' => 'Times New Roman',
				),

			),
		),

		'dependency' => array( 'normal-text-font', '=', 'custom' ),
	),

	array(
		'name'	=> __( 'Font Attributes', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'normal-text-font_attributes',
		'type'	=> array(
			array(
				'id'	  => 'normal-text-font_weight',
				'type'	=> 'select',
				'class'   => 'form-control',
				'std'	 => 'bold',
				'role'	=> 'title',
				'options'	=> array(
					'bold' => 'Bold',
					'light' => 'Light',
					'normal' => 'Normal',
					'thin' => 'Thin',
				),
			),
			array(

				'id'	  => 'normal-text-font_size',
				'type'	=> 'select',
				'class'   => 'form-control',
				'std'	 => '10',
				'role'	=> 'title',
				'options'	=> array(
					'10' => '10',
					'12' => '12',
					'13' => '13',
					'14' => '14',
					'15' => '15',
					'16' => '16',
					'17' => '17',
					'18' => '18',
					'19' => '19',
					'20' => '20',
				),

			),

			array(
				'id'		   => 'normal-text-menu_color',
				'class'		 => 'form-control',
				'hide_value'   => 'true',
				'type'		 => 'color_picker2',
				'std'		  => '#000',
				'wrap_color_class' => '',
			),
		),

		'dependency' => array( 'normal-text-font', '=', 'custom' ),
	),

	array(
		'name'	=> __( 'Enable Bullet Icon', WR_MEGAMENU_TEXTDOMAIN ),
		'id'	  => 'submenu-panel-bullet_icon',
		'type'	=> 'radio_group',
		'std'	 => 'yes',
		'options' => array(
			'no' => __( 'No', WR_MEGAMENU_TEXTDOMAIN ),
			'yes'   => __( 'Yes', WR_MEGAMENU_TEXTDOMAIN ),
		),
	),

);


?>
<div id="wr-megamenu-builder" class="jsn-master">
	<div class="wr-megamenu-builder-container jsn-section-content jsn-style-light jsn-bootstrap3">
		<div id="wr-menu-controls" class="">
			<div id="wr-menu-top-options">

				<div class="control-group">
					<label class="control-label" for="locations"><?php _e( 'Location', WR_MEGAMENU_TEXTDOMAIN ) ?></label>

					<div class="controls ">
						<select name="locations" id="locations" class="form-control select2-select">
							<?php
foreach ( $locations as $key => $value ) {
	$selected = ( isset($data['location']) && $key == $data['location'] ) ? 'selected="selected"' : '';	
	echo "<option value='" . $key . "' " . $selected . '>' . $value . '</option>';
}
							?>
						</select>

					</div>
					<a class="btn btn-default" href="<?php echo esc_attr( admin_url( 'nav-menus.php?action=locations' ) )?>" target="_blank"><?php _e( 'Manage Locations', WR_MEGAMENU_TEXTDOMAIN )?></a>

				</div>


				<div class="top-buttons-right pull-right">
					<button id="btn-submenu-styling" class="btn btn-default"><?php _e( 'Styling', WR_MEGAMENU_TEXTDOMAIN ) ?></button>
					<button id="page-custom-css" class="btn btn-default"><?php _e( 'Custom CSS', WR_MEGAMENU_TEXTDOMAIN ) ?></button>
					<div  id="menu-styling" class="styling-modal jsn-bootstrap3" style="display: none;">

					<?php

					$themes_style = array();

					// Get all themes for mega menu
					$path = apply_filters( 'wr_megamenu_themes', WR_MEGAMENU_ROOT_PATH . 'themes' );

					$files = WR_Megamenu_Helpers_Functions::get_theme_styles( $path );

if ( count( $files ) ) {
	foreach ( $files as $theme => $value ) {
		$themes_style[ $theme ] = ucfirst( $theme );
	}
}
					$theme_default_options = array(

						'menu-bar-font' => 'inherit',
						'menu-bar-bg_value' => '#000',
						'menu-bar-bg' => '#000',
						'menu-bar-font_type' => 'Standard Font',
						'menu-bar-font_face' => 'Arial',
						'menu-bar-font_size' => '10',
						'menu-bar-font_weight' => 'bold',
						'menu-bar-menu_color' => '#fff',
						'menu-bar-menu_layout' => 'horizontal',
						'menu-bar-on_hover' => '#1cba70',
						'menu-bar-stick_menu' => 'no',
						'menu-bar-icon_display_mode' => 'text_only',
						'menu-bar-icon_position' => 'left',
						'menu-bar-icon_size' => '16',

						'heading-text-font' => 'inherit',
						'heading-text-font_type' => 'Standard Font',
						'heading-text-font_face' => 'Arial',
						'heading-text-font_size' => '10',
						'heading-text-font_weight' => 'bold',
						'heading-text-menu_color' => '#000',

						'normal-text-font' => 'inherit',
						'normal-text-font_type' => 'Standard Font',
						'normal-text-font_face' => 'Arial',
						'normal-text-font_size' => '10',
						'normal-text-font_weight' => 'bold',
						'normal-text-menu_color' => '#000',
						'submenu-panel-bullet_icon' => 'yes',

					);

					// get options from many themes
					$selected_theme = isset($data['theme_style']) ? $data['theme_style'] : 'default' ;

					$themes_options = get_post_meta( $profile->ID, WR_MEGAMENU_META_KEY . '_themes_options', true );

					$themes_options = json_decode( $themes_options, true );

foreach ( $themes_style as $key => $theme ) {

	$setting = isset( $themes_options[ $key ] ) ? json_decode( $themes_options[ $key ], true ) : array();

	$theme_options = wp_parse_args( $setting, $theme_default_options );
	$options = json_encode( $theme_options );

	echo balanceTags( "<input type='hidden' class='style-{$key}' id='style-{$key}' value='{$options}' name='theme_options[]'/>" );

}

					$default = json_encode( $theme_default_options );
					echo balanceTags( "<input type='hidden' class='reset-default' id='reset-default' value='{$default}' />" );

					?>

					<div class="form-group wr-menu-top-modal">
						<label for="param-theme_style" class="param-theme_style">Color Scheme</label>
						<?php

						echo balanceTags(
							WR_Megamenu_Helpers_Shortcode::render_parameter(
								'select',
								array(
									'name'	=> __( 'Theme Style', WR_MEGAMENU_TEXTDOMAIN ),
									'id'	  => 'theme_style',
									'type'	=> 'select',
									'showlabel' => '0',
									'wrap' => '0',
									'wrap_class' => 'controls',
									'std'	 => $selected_theme,
									'options'	=> $themes_style,
								)
							)
						);

						?>
					</div>

					<div class="clearfix"></div>
					<div class="row">
						<div class="col-sm-6 styling-options-resize">
							<ul class="nav nav-tabs" id="menu-styling-tab">
								<?php $first = true; foreach ( $tab_contents as $tid => $tab ) : ?>
									<li<?php if ( $first ) : ?> class="active"<?php endif; ?> data-tabid="<?php esc_attr_e( $tid ); ?>">
										<a data-toggle="tab" href="#menu-style-<?php esc_attr_e( $tid ); ?>">
											<?php esc_html_e( $tab, WR_MEGAMENU_TEXTDOMAIN ); ?>
										</a>
									</li>
									<?php $first = false; endforeach; ?>
							</ul>

							<div class="tab-content">

								<?php $first = true; foreach ( $tab_contents as $tid => $fields ) : ?>
									<div class="tab-pane<?php if ($first) echo ' active'; ?>" id="menu-style-<?php esc_attr_e( $tid ); ?>">
										<?php
foreach ( $styling_fields[ $tid ] as $field ) {
	$field['id'] = isset($field['id']) ? ('param-' . $field['id']) : '';

	if ( ! is_array( $field['type'] ) ) {

		echo balanceTags( WR_Megamenu_Helpers_Shortcode::render_parameter( $field['type'], $field ) );

	} else {

		$output = '';
		foreach ( $field['type'] as $sub_options ) {

			$sub_options['id']    = isset( $sub_options['id'] ) ? ( 'param-' . $sub_options['id'] ) : '';
			$sub_options['bound'] = '0';
			$sub_options['class'] = isset( $sub_options['class'] ) ? ( $sub_options['class'] ) : '';
			$type                 = $sub_options['type'];
			$output .= WR_Megamenu_Helpers_Shortcode::render_parameter( $type, $sub_options );

		}
		$field = WR_Megamenu_Helpers_Html::get_extra_info( $field );
		$label = WR_Megamenu_Helpers_Html::get_label( $field );

		echo balanceTags( WR_Megamenu_Helpers_Html::final_element( $field, $output, $label ) );

	}
}
										?>

									</div>
									<?php $first = false; endforeach; ?>

							</div>
						</div>

						<div class="col-sm-6 preview-styling-resize">
							<legend>Preview</legend>
							<div class="preview-styling">
								<div class="preview-submenu_panel content">

									<ul class="submenu-panel-preview">
										<li class="caption"><a href="#">Heading Text</a></li>
										<ul class="submenu-panel-child">
											<li class="submenu-item"><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Normal Text 1</a></li>
											<li class="submenu-item"><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Normal Text 2</a></li>
											<li class="submenu-item"><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Normal Text 3</a></li>
										</ul>
									</ul>
									<style id="style-submenu_panel">
										.submenu-panel-preview {
											float:left;
											margin:0;
											padding: 0;
											width: 300px;
										}
										.submenu-item i {
											font-size: 11px;
										}

										.submenu-panel-preview > li.caption > a {

										}

									</style>
								</div>
								<div class="preview-menu_bar content">

									<ul class="menubar-preview">
										<li class="menu-item"><a href="#" class="menu-link"><i class="glyphicon glyphicon-home"></i><span class="menu_text">Item 1</span></a></li>
										<li class="menu-item"><a href="#" class="menu-link"><i class="glyphicon glyphicon-home"></i><span class="menu_text">Item 2</span></a></li>
										<li class="menu-item"><a href="#" class="menu-link"><i class="glyphicon glyphicon-home"></i><span class="menu_text">Item 3</span></a></li>
										<li class="menu-item"><a href="#" class="menu-link"><i class="glyphicon glyphicon-home"></i><span class="menu_text">Item 4</span></a></li>
									</ul>
									<style id="style-menu_bar">
										.menubar-preview {
											background-color:#333;
											float:left;
											margin:0;
											padding:0;
										}
										.menu-item {
											display:inline-block;
											height: auto;
											position: relative;
											margin-right: 2px;
											margin-bottom: 0;
										}
										.menu-item a {
											padding:10px 25px;
											display: block;
											color:#fff !important;
										}
										.menu-item:hover a,
										.menu-item:focus a {
											background-color: #24890d;
										}
									</style>
								</div>

							</div>
						</div>

					</div>

					<script>
						jQuery(function () {



							active_tab_panel('menu_bar');

							jQuery("#menu-styling-tab a").click(function (e) {
								e.preventDefault();
								active_tab_panel(jQuery(this).parent().attr('data-tabid'));
								jQuery(this).tab('show');
							});

							function active_tab_panel (tabid) {
								jQuery('.preview-styling-resize .content').hide();
								jQuery('.preview-' + tabid).show();
							}

						});

					</script>

					</div>

				</div>
			</div>

			<div class="modal fade" id="reset-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
				<div class="modal-dialog ">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel"><?php _e( 'Reset Confirmation', WR_MEGAMENU_TEXTDOMAIN )?></h4>
						</div>
						<div class="modal-body">

							<p class="msg-reset"><?php _e( 'When you reset Styling options, you\'re going to revert all changes you\'ve made to default settings. Do you want to reset Styling options?', WR_MEGAMENU_TEXTDOMAIN )?></p>

							<div class="jsn-bglabel">
								<button type="button" class="btn btn-default" id="action-reset" ><?php _e( 'Reset Styling', WR_MEGAMENU_TEXTDOMAIN )?></button>
								<button type="button" class="btn btn-default" id="action-cancel" ><?php _e( 'Cancel', WR_MEGAMENU_TEXTDOMAIN )?></button>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="clearbreak"></div>

			<!-- TOP LEVEL MENU ITEMS PANEL -->
			<div id="top-level-menu-container"></div>


			<!-- MEGAMENU SETTING PANEL -->
			<div class="setting-container-limit">
				<div id="setting-container">
					<!-- WR MegaMenu elements -->
					<div id="form-mm-design-content" class="hidden">
						<div id="wr-mmd-loading" class="text-center"><i class="jsn-icon32 jsn-icon-loading"></i></div>
						<div class="wr-mm-form-container jsn-layout">
							<a href="javascript:void(0);" id="jsn-add-container" class="jsn-add-more"><i
									class="wr-icon-add-row"></i><?php _e( 'Add Row', WR_MEGAMENU_TEXTDOMAIN ) ?></a>
							<div class="row-fluid wr-layout-thumbs">
							   <?php

								$layouts = WR_Megamenu_Row::$layouts;

foreach ( $layouts as $columns ) {
	$columns_name = implode( 'x', $columns );
	$icon_class   = implode( '-', $columns );
	$icon_class   = 'wr-layout-' . $icon_class;
	$icon         = "<i class='{$icon_class}'></i>";

	printf( '<div class="thumb-wrapper col-md-1 col-xs-2" data-columns="%s" title="%s">%s</div>', implode( ',', $columns ), $columns_name, $icon );

}
							?>
							  </div>

							<input type="hidden" id="wr-select-media" value=""/>
							<input type="hidden" id="wr-tinymce-change" value="0"/>
						</div>
					</div>
					<div class="clearfix"></div>
					<div id="turn-off-msg" class="jsn-section-empty hidden">
						<p class="jsn-bglabel"><?php _e( 'MegaMenu is OFF now, turn it ON to start configuring.', WR_MEGAMENU_TEXTDOMAIN )?></p>
						<p class="jsn-bglabel">
							<a href="javascript:void(0)" class="btn btn-success" id="turn-on-mega"><?php _e( 'Turn on MegaMenu', WR_MEGAMENU_TEXTDOMAIN )?></a>
						</p>
					</div>

					<?php
					// Select Element Popover
					include 'select-elements.php';
					?>

					<input type="hidden" id="wr-mm-css-value" name="wr_mm_post_id" value="<?php echo esc_attr( isset ( $profile->ID ) ? $profile->ID : '' ); ?>">
					<input type="hidden" name="profile_id" id="profile_id" value="<?php echo esc_attr( $profile->ID ) ?>"/>
					<input type="hidden" name="selected_menu_id" id="selected_menu_id" value=""/>
					<input type="hidden" name="selected_menu_type" id="selected_menu_type" value="<?php echo esc_attr( $menu_type ) ?>"/>
					<input type="hidden" name="menu_options" id="menu_options" value=""/>
					<input type="hidden" name="theme_style_options" id="theme_style_options" value=""/>

				</div>
			</div>
		</div>
		<?php 
		echo balanceTags( WR_Megamenu_Helpers_Modal::get_footer() );
		?>
	</div>
</div>
<div class="jsn-modal-overlay"></div>
<div class="jsn-modal-indicator"></div>
