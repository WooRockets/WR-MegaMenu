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

class WR_Megamenu_Core_Backend {
	/**
	 * Constructure
	 */
	public function __construct() {
		// Init admin pages
		add_action( 'admin_init',                 array( 'WR_Megamenu_Gadget_Base', 'hook' ), 100 );
		add_action( 'init',                       array( $this, 'register_wr_megamenu_profiles' ), 99 );
		add_action( 'admin_init',                 array( &$this, 'modal_register' ) );
		add_action( 'edit_form_after_title',      array( &$this, 'edit_form_megamenu_editor' ) );
		add_action( 'admin_head',                 array( &$this, 'enqueue_script_nav_menu' ) );
		add_filter( 'wp_setup_nav_menu_item',     array( &$this, 'setup_nav_item' ) );
		// hook saving post
		add_action( 'save_post', array( &$this, 'save_default_profile' ) );

		// ajax
		add_action( 'wp_ajax_wr_megamenu_get_menu_items',     array( &$this, 'get_menu_items' ) );
		add_action( 'wp_ajax_wr_megamenu_save_megamenu_data', array( &$this, 'save_megamenu_data' ) );
		add_action( 'wp_ajax_wr_megamenu_save_css_custom',    array( &$this, 'save_css_custom' ) );
		add_action( 'wp_ajax_wr_megamenu_preview_widget',     array( &$this, 'preview_widget' ) );
		add_action( 'wp_ajax_wr_megamenu_get_menu_layout',    array( &$this, 'get_menu_layout' ) );
		add_action( 'wp_ajax_wr_megamenu_get_shortcode_tpl',  array( &$this, 'get_shortcode_tpl' ) );
		add_action( 'wp_ajax_wr_megamenu_get_json_custom',    array( &$this, 'ajax_json_custom' ) );
		add_action( 'wp_ajax_wr_megamenu_get_menu_icons',     array( &$this, 'ajax_get_menu_icon' ) );
        add_action( 'wp_ajax_wr_megamenu_insert_icons_database',     array( &$this, 'ajax_insert_icons_database' ) );
		
		// get image size
		add_filter( 'wr_mm_get_json_image_size',           array( &$this, 'get_image_size' ) );
		//add_filter( 'wp_default_editor', create_function( '', 'return "html";' ) );
		add_filter( 'tiny_mce_before_init',                array( &$this, 'tiny_mce_before_init' ) );
		add_filter( 'post_updated_messages',               array( &$this, 'post_updated_messages' ) );

		$meta = new WR_Megamenu_Helpers_Meta();
		$meta->init();

		register_activation_hook( WR_MEGAMENU_MAIN_FILE,  array( &$this, 'on_activation' ) );
		register_deactivation_hook( WR_MEGAMENU_MAIN_FILE, array( &$this, 'on_deactivation' ) );
	}

	/**
	 * Change profile message
	 * @param $messages
	 * @return mixed
	 */
	function post_updated_messages( $messages ) {
		global $post;
		if ( $post->post_type == 'wr_megamenu_profile' ) {
			$messages['post'][1] = __( 'Profile updated' );
		}

		return $messages;
	}

	/**
	 * Init tiny mce
	 * @param $init
	 * @return mixed
	 */
	function tiny_mce_before_init( $init ) {
		$init['setup'] = <<<JS
[function(ed) {
	ed.on( 'blur', function(ed) {
		tinyMCE.triggerSave();
		jQuery( '.wr_mm_editor' ).first().trigger( 'change' );
	});
}][0]
JS;

		return $init;
	}

	/**
	 * Add custom ajax json for backend
	 * 
	 * @return void|string
	 */
	function ajax_json_custom() {

		if ( ! isset($_POST[WR_MEGAMENU_NONCE] ) || ! wp_verify_nonce( $_POST[WR_MEGAMENU_NONCE], WR_MEGAMENU_NONCE ) )
			return;

		if ( ! $_POST['custom_type'] )
			return 'false';

		$response = apply_filters( 'wr_mm_get_json_' . $_POST['custom_type'], $_POST );
		echo balanceTags( $response );

		exit;
	}

	/**
	 * Ajax function for get menu icons
	 * 
	 * @return array
	 */
	function ajax_get_menu_icon() {
		if ( ! isset($_POST[WR_MEGAMENU_NONCE] ) || ! wp_verify_nonce( $_POST[WR_MEGAMENU_NONCE], WR_MEGAMENU_NONCE ) )
			return;
		
		$item_ids = ( ! empty( $_POST['item_ids'] ) ) ? $_POST['item_ids'] : '';
		
		if ( ! $item_ids )
			return;
		
		$arr_results = array();
		$arr_ids     = explode( ',', $item_ids );
		foreach ( $arr_ids as $i => $item_id ) {
			$item_id = (int) $item_id;
			
			if ( $item_id ) {
				$value = get_post_meta( $item_id, '_icon_mega_', true );
				$icons = array(
					'id'                 => 'icon_mega[' .$item_id. ']',
					'showlabel'          => '0',
					'item_id'            => $item_id,
					'type'               => 'icons',
					'std'                => $value,
					'role'               => 'title',
					'title_prepend_type' => 'icon',
					'tooltip'            => __( 'Select an icon', WR_MEGAMENU_TEXTDOMAIN ),
				);
				$icon_value = ( $value ) ? $value : 'icon-wand';
				
				ob_start();
				?>
<div class="panel-group" id="accordion<?php echo esc_attr( $item_id )?>">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion<?php echo esc_attr( $item_id )?>" href="#collapseOne<?php echo esc_attr( $item_id )?>">
					<i class="<?php echo esc_attr( $icon_value ) ?>"></i><?php _e( 'Icon', WR_MEGAMENU_TEXTDOMAIN ) ?>
					<span class="caret pull-right"></span>
				</a>
			</h4>
		</div>
		<div id="collapseOne<?php echo esc_attr( $item_id )?>" class="panel-collapse collapse">
			<div class="panel-body">
				<?php echo balanceTags( WR_Megamenu_Helpers_Shortcode::render_parameter( 'icons', $icons ) ); ?>
			</div>
		</div>
	</div>
</div>
				<?php
				$arr_results[] = array( 'id' => $item_id, 'html' => ob_get_clean() );
			}
		}
		
		echo json_encode( $arr_results );
		
		exit;
	}
    
    /**
	 * Insert-icon-database
	 * 
	 * 
	 */
	function ajax_insert_icons_database() {
                $post_id = isset($_POST['post_id']) ? (int) $_POST['post_id'] : 0;
                $value_icon = isset($_POST['value_icon']) ? $_POST['value_icon'] : 0;
                if( $post_id && $value_icon ) {
                    update_post_meta($post_id, '_icon_mega_', addslashes( $value_icon ) );
                }
		exit;
	}
	
	/**
	 * Get image size
	 *
	 * @param array $post_request
	 * @return string
	 */
	function get_image_size( $post_request ) {
		$response  = '';
		$image_url = $post_request['image_url'];

		if ( $image_url ) {
			$image_id   = WR_Megamenu_Helpers_Functions::get_image_id( $image_url );
			$attachment = wp_prepare_attachment_for_js( $image_id );
			if ( $attachment['sizes'] ) {
				$sizes               = $attachment['sizes'];
				$attachment['sizes'] = null;
				foreach ( $sizes as $key => $item ) {
					$item['total_size']	= $item['height'] + $item['width'];
					$attachment['sizes'][ucfirst( $key )] = $item;
				}
			}
			$response = json_encode( $attachment );
		}

		return $response;
	}

	/**
	 * Add icon field for menu nav item
	 * 
	 * @param array $menu_item
	 * @return array
	 */
	function setup_nav_item( $menu_item ) {
		$icon = get_post_meta( $menu_item->ID, '_icon_mega_', true );
	
		$menu_item->icon = $icon;
	
		return $menu_item;
	}

	public function enqueue_script_nav_menu() {
		if ( isset( $GLOBALS['hook_suffix'] ) && $GLOBALS['hook_suffix'] != 'nav-menus.php' )
			return;
		
		WR_Megamenu_Init_Assets::load( array( 'wr-joomlashine-iconselector-js', 'wr-mm-icon-options-js' ) );
		WR_Megamenu_Init_Assets::localize( 'wr-mm-icon-options-js', 'Wr_Megamenu_Ajax', WR_Megamenu_Helpers_Functions::localize_js() );
	}
	
	/**
	 * Save default profile
	 * @param $profile_id
	 */
	public function save_default_profile( $profile_id ) {

		global $post;
		if ( ! current_user_can( 'edit_page', $profile_id ) ) {
			return;
		}

		if ( ! isset($_POST[ WR_MEGAMENU_NONCE . '_builder' ] ) || ! wp_verify_nonce( $_POST[ WR_MEGAMENU_NONCE . '_builder' ], 'wr_mm_builder' ) ) {
			return;
		}

		if ( isset( $_POST['menu_options'] ) && ( $_POST['menu_options'] != '' ) ) {

			$post_data      = json_decode( stripcslashes( $_POST['menu_options'] ), true );
			$themes_options = $_POST['theme_style_options'];

			extract( $post_data );
			$settings = array();
			parse_str( $setting_menu, $output );
			$settings['is_mega']		   = $is_mega;
			$settings['setting_menu']	   = $output;
			$settings['shortcode_content'] = $shortcode_content;

			$data = array();

			$old_data = get_post_meta( $profile_id, WR_MEGAMENU_META_KEY, true );
			$old_data = (array) json_decode( $old_data, true );

			if ( count( $old_data ) ) {
				$data = $old_data;
			}

			$data['menu_type']           = $menu_type;
			$data['theme_style']         = $theme_style;
			$data['location']            = $location;
			$data['settings'][$menu_id ] = $settings;

			update_post_meta( $profile_id, WR_MEGAMENU_META_KEY, json_encode( $data ) );
			
			if ( $themes_options ) {
				update_post_meta( $profile_id, WR_MEGAMENU_META_KEY .'_themes_options', $themes_options );
			}
		}

		if ( $post->post_type == 'wr_megamenu_profile' && isset( $_POST['action'] ) && ( $_POST['action'] == 'editpost' ) ) {
			update_post_meta( $profile_id, '_wr_megamenu_profile_location_', $_POST['locations'] );
		}

	}

	/**
	 * Display mega menu html
	 * @param $post
	 */
	public function edit_form_megamenu_editor( $post ) {
		global $pagenow;

		if ( $post->post_type == 'wr_megamenu_profile' ) {
			if ( 'post.php' == $pagenow || 'post-new.php' == $pagenow || 'widgets.php' == $pagenow ) {
				$layout_helper = new WR_Megamenu_Helpers_Layout();
				$layout_helper->set_template_data( 'profile', $post );
				$layout_helper->load_template( 'menu-builder' );
			}
		}
		
	}

	/**
	 * Get layout for each menu
	 */
	public function get_menu_layout()
	{

		$menu_id    = (int) $_POST['menu_id'];
		$profile_id = (int) $_POST['profile_id'];

		$data = WR_Megamenu_Helpers_Builder::get_megamenu_data( $profile_id, $menu_id );
		if ( count( $data ) && ! empty( $data['shortcode_content'] ) ) {
			$content = urldecode( $data['shortcode_content'] );
			$builder = new WR_Megamenu_Helpers_Shortcode();
			// remove wrap p tag
			$content = preg_replace( '/^<p>(.*)<\/p>$/', '$1', $content );
			$content = balanceTags( $content );
			echo balanceTags( $builder->do_shortcode_admin( $content, false, true ) );
		} else {
			echo '';
		}

		exit;

	}

	/**
	 * GET <script type='text/html'... template for shortcode element
	 * @global type $Wr_Pb_Widgets
	 * @return string
	 */
	function get_shortcode_tpl(){
		global $wr_megamenu_element;
		if ( ! isset( $_POST[WR_MEGAMENU_NONCE] ) || ! wp_verify_nonce( $_POST[WR_MEGAMENU_NONCE], WR_MEGAMENU_NONCE ) ) return;

		if ( ! $_POST['shortcode'] ) return;
		$shortcode = $_POST['shortcode'];
		$type	  = $_POST['type'];
		$elements  = $wr_megamenu_element->get_elements();
		if ( $type == 'element' ) {
			if ( isset( $elements['element'][ strtolower( $shortcode ) ]) && is_object( $elements['element'][ strtolower( $shortcode ) ] ) ) {
				$element = $elements['element'][ strtolower( $shortcode ) ];
			} else {
				$class   = WR_Megamenu_Helpers_Shortcode::get_shortcode_class( $shortcode );
				$element = new $class();
			}
			$element->shortcode_data();
			$element_type = $element->element_in_megamenu();
			foreach ( $element_type as $element_structure ) {
				echo balanceTags( "<script type='text/html' id='tmpl-{$shortcode}'>\n{$element_structure}\n</script>\n" );
			}
		} else {
			$shortcode = mysql_real_escape_string( $shortcode );
			$element   = new WR_Megamenu_Widget();
			global $wr_megamenu_widgets;
			$modal_title                                                 = $wr_megamenu_widgets[ $shortcode ]['identity_name'];
			$element->config['shortcode']                                = $shortcode;
			$content = $element->config['exception']['data-modal-title'] = $modal_title;
			$element->config['shortcode_structure']                      = WR_Megamenu_Helpers_Placeholder::add_placeholder( "[wr_megamenu_widget widget_id=\"$shortcode\"]%s[/wr_megamenu_widget]", 'widget_title' );
			$element->config['el_type']                                  = $type;
			$element_type                                                = $element->element_in_megamenu( $content );
			foreach ( $element_type as $element_structure ) {
				echo balanceTags( "<script type='text/html' id='tmpl-{$shortcode}'>\n{$element_structure}\n</script>\n" );
			}
		}

		exit;
	}

	/**
	 * Get submenu items
	 */
	public function get_menu_items()
	{
		$html       = array();
		$location   = $_POST['location'];
		$profile_id = $_POST['profile_id'];
		$depth      = isset($_POST['depth']) ? (int)$_POST['depth'] : '1';
		$parent_id  = isset($_POST['menu_id']) ? $_POST['menu_id'] : '';

		$locations = get_nav_menu_locations();
		$menu_type = 0;

		if ( isset( $locations[$location] ) ) {
			$menu_type = $locations[$location];
		}

		$menu = wp_get_nav_menu_object( $menu_type );

		if ( $menu_type && $menu ) {

			$helper = new WR_Megamenu_Helpers_Menu();
			$items  = $helper->get_menu_items( $menu_type, $parent_id, $depth );
			$html[] = '<input type="hidden" value="false" id="is-mega">';

			if ( count( $items ) ) {
				$html[] = '<ul id="top-level-menu" class="nav navbar-nav">';
				foreach ( $items as $item ) {
					$data             = WR_Megamenu_Helpers_Builder::get_megamenu_data( $profile_id, $item->ID );
					$container_width  = '600';
					$full_width_value = '';
					$is_mega          = 'false';

					if ( count( $data ) ) {
						$setting_menu     = @$data['setting_menu'];
						$is_mega          = @$data['is_mega'];
						$container_width  = isset( $setting_menu['container_width'] ) && ( $setting_menu['container_width'] != '' ) ? $setting_menu['container_width'] : '600';
						$full_width_value = isset( $setting_menu['full_width_value'] ) && ( $setting_menu['full_width_value'] != '' ) ? $setting_menu['full_width_value'] : '0';
					}
					$check       = ($full_width_value == '1' ) ? 'active' : '';
					$full_width  = ($check == 'active' ) ? $check : '';
					$fixed_width = ($check == '' ) ? 'active' : '';
					if ( $is_mega == 'true' ) {
						$switch = '<button class="btn btn-xs on active btn-success">' . __( 'ON', WR_MEGAMENU_TEXTDOMAIN ) . '</button><button class="btn btn-xs off btn-default">' . __( 'OFF', WR_MEGAMENU_TEXTDOMAIN ) . '</button>';
					} else {
						$switch = '<button class="btn btn-xs on btn-default">' . __( 'ON', WR_MEGAMENU_TEXTDOMAIN ) . '</button><button class="btn btn-xs off active btn-danger">' . __( 'OFF', WR_MEGAMENU_TEXTDOMAIN ) . '</button>';
					}

					$html[] = '<li class="top-level-item">
								<div class="btn-group">
									<button class="btn btn-default btn-menu-title" id="menu-item-' . $item->ID . '">' . $item->title . '</button>
									<button class="btn btn-menu-setting-popover hidden dropup" data-menu="' . $item->ID . '">
										<span class="glyphicon glyphicon-cog"></span>
									</button>
									<div class="popover bottom setting-menu-item" id="setting-menu-item-' . $item->ID . '">
										<div class="arrow"></div>
										<h3 class="popover-title">
											' . __( 'Configuration', WR_MEGAMENU_TEXTDOMAIN ) . '
											  <div class="btn-group btn-toggle pull-right">
												 ' . $switch . '
											  </div>
										</h3>
										<div class="popover-content">
											<div class="form-horizontal setting-content">
												<input type="hidden" value="' . $is_mega . '" id="is-mega-' . $item->ID . '">
												<div class="form-group">
													<label class="col-sm-4 control-label">' . __( 'Container Width', WR_MEGAMENU_TEXTDOMAIN ) . '</label>
													<div class="col-sm-4 container-width">
														<div id="container_group" class="btn-group">
														  <button type="button" id="full_width" class="btn btn-default ' . $full_width . '">' . __( 'Full', WR_MEGAMENU_TEXTDOMAIN ) . '</button>
														  <button type="button" id="fixed_width" class="btn btn-default ' . $fixed_width . '">' . __( 'Fixed', WR_MEGAMENU_TEXTDOMAIN ) . '</button>
														</div>
													</div>
													<div class="col-sm-4 fixed-with">
														<div class="input-group">
														  <input type="number" min="100" id="container_width" name="container_width" class="form-control"  value="' . $container_width . '" />
														  <span class="input-group-addon">' . __( 'px' ) . '</span>
														  <input type="hidden" id="full_width_value" name="full_width_value" value="' . $full_width_value . '" />
														</div>

													</div>
												  </div>

											</div>
										</div>
									</div>
								</div>
						  </li>';
				}
				$html[] = '</ul>';
				$html[] = '<div class="clearbreak"></div>';
			} else {
				$html[] = '<p class="jsn-bglabel">' . __( 'This menu does not have any sub menu item.' ) . ' <a href="' . admin_url( 'nav-menus.php?action=edit&menu=' . $menu->term_id ) . '" target="_blank">' . __( 'Add new' ) . '</a>' . '</p>';
			}

			echo json_encode( array( 'menu_type' => $menu->term_id, 'html' => implode( "\n", $html ) ) );
		} else {
			$html[] = '<p id="wr-assign-menu" class="jsn-bglabel">' . __( 'No menu assigned to this location.' ) . '<br/><a href="' . admin_url( 'nav-menus.php?action=locations' ) . '" target="_blank" class="btn btn-default">' . __( 'Manage Locations' ) . '</a>' . '</p>';
			echo json_encode( array( 'menu_type' => '', 'html' => implode( "\n", $html ) ) );
		}

		exit();
	}

	/**
	 *	Method to save Mega data for a menu
	 */
	public function save_megamenu_data()
	{
		extract( $_POST );
		$settings = array();
		parse_str( $setting_menu, $output );
		if( isset($is_mega ) ) $settings['is_mega'] = $is_mega;
		$settings['setting_menu']      = $output;
		$settings['shortcode_content'] = $shortcode_content;

		$data = array();

		$old_data = get_post_meta( $profile_id, WR_MEGAMENU_META_KEY, true );
		$old_data = (array)json_decode( $old_data, true );

		if ( count( $old_data ) ) {
			$data = $old_data;
		}

		$data['menu_type']		  = $menu_type;
		$data['theme_style']		= $theme_style;
		$data['location']		   = $location;
		$data['settings'][$menu_id] = $settings;

		update_post_meta( $profile_id, WR_MEGAMENU_META_KEY, json_encode( $data ) );
		if ( $theme_options ) {
			update_post_meta( $profile_id, WR_MEGAMENU_META_KEY .'_themes_options', $theme_options );
		}

		exit();
	}

	/**
	 * Save custom CSS information: files, code
	 * @return void
	 */
	function save_css_custom()
	{
		if ( ! isset( $_POST[WR_MEGAMENU_NONCE] ) || ! wp_verify_nonce( $_POST[WR_MEGAMENU_NONCE], WR_MEGAMENU_NONCE ) ) {
			return;
		}

		$post_id = esc_sql( $_POST['post_id'] );
		// save custom css code & files
		WR_Megamenu_Helpers_Functions::custom_css( $post_id, 'css_files', 'put', esc_sql( $_POST['css_files'] ) );
		WR_Megamenu_Helpers_Functions::custom_css( $post_id, 'css_custom', 'put', esc_textarea( $_POST['custom_css'] ) );

		exit;
	}

	function preview_widget()
	{


	}

	/**
	 * Create profile post type
	 */
	public function register_wr_megamenu_profiles()
	{

		$labels = array(
			'name'               => __( 'Profiles', WR_MEGAMENU_TEXTDOMAIN ),
			'singular_name'      => __( 'Profile', WR_MEGAMENU_TEXTDOMAIN ),
			'add_new'            => __( 'Add New', WR_MEGAMENU_TEXTDOMAIN ),
			'add_new_item'       => __( 'Add New Profile', WR_MEGAMENU_TEXTDOMAIN ),
			'edit_item'          => __( 'Edit Profile', WR_MEGAMENU_TEXTDOMAIN ),
			'new_item'           => __( 'Add New Profile', WR_MEGAMENU_TEXTDOMAIN ),
			'all_items'          => __( 'All Profiles', WR_MEGAMENU_TEXTDOMAIN ),
			'view_item'          => __( 'View Profile', WR_MEGAMENU_TEXTDOMAIN ),
			'search_items'       => __( 'Search Profiles', WR_MEGAMENU_TEXTDOMAIN ),
			'not_found'          => __( 'No Profiles  Found', WR_MEGAMENU_TEXTDOMAIN ),
			'not_found_in_trash' => __( 'No Profiles found in trash', WR_MEGAMENU_TEXTDOMAIN ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'WR MegaMenu', WR_MEGAMENU_TEXTDOMAIN ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'exclude_from_search' => false,
			'supports'            => array( 'title' ),
			'has_archive'         => true,
			'menu_icon'           => WR_MEGAMENU_ROOT_URL . '/assets/images/icon_megamenu.png',
		);

		register_post_type( WR_MEGAMENU_POST_TYPE_NAME, $args );
	}

	/**
	 * Show Modal page
	 */
	function modal_register()
	{
		if ( WR_Megamenu_Helpers_Functions::is_modal() ) {
			$instance = WR_Megamenu_Helpers_Modal::get_instance();
			if ( ! empty( $_GET['wr_modal_type'] ) ) $instance->show_modal();
			if ( ! empty( $_GET['wr_layout'] ) ) $instance->show_modal( '_layout' );
			if ( ! empty( $_GET['wr_custom_css'] ) ) $instance->show_modal( '_custom_css' );
			if ( ! empty( $_GET['wr_add_element'] ) ) $instance->show_modal( '_add_element' );
		}
	}

	/**
	 * Do action on modal page hook
	 */
	function get_modal_content() {
		do_action( 'wr_megamenu_modal_page_content' );
	}

	/**
	 * Render shortcode preview in a blank page
	 * @return Ambigous <string, mixed>|WP_Error
	 */
	function shortcode_iframe_preview()
	{
		global $wr_megamenu_element;
		if ( isset( $_GET['wr_shortcode_preview'] ) ) {
			if ( ! isset( $_GET['wr_shortcode_name'] ) || ! isset( $_POST['params'] ) ) return __( 'empty shortcode name / parameters', WR_MEGAMENU_TEXTDOMAIN );

			if ( ! isset( $_GET[WR_MEGAMENU_NONCE] ) || ! wp_verify_nonce( $_GET[WR_MEGAMENU_NONCE], WR_MEGAMENU_NONCE ) ) return;

			$shortcode = esc_sql( $_GET['wr_shortcode_name'] );
			$params    = urldecode( $_POST['params'] );
			$pattern   = '/^\[wr_megamenu_widget/i';
			if ( ! preg_match( $pattern, trim( $params ) ) ) {
				// get shortcode class
				$class = WR_Megamenu_Helpers_Shortcode::get_shortcode_class( $shortcode );

				// get option settings of shortcode
				$elements = $wr_megamenu_element->get_elements();
				$element  = isset( $elements['element'][ strtolower( $class ) ] ) ? $elements['element'][ strtolower( $class ) ] : null;
				if ( ! is_object( $element ) ) $element = new $class();

				if ( $_POST['params'] ) {
					$extract_params = WR_Megamenu_Helpers_Shortcode::extract_params( $params, $shortcode );
				} else {
					$extract_params = $element->config;
				}

				$element->shortcode_data();

				$_shortcode_content = $extract_params['_shortcode_content'];

				// Keep non-WR shortcode as they are in preview iframe
				$_shortcode_content = str_replace( '[', '&#91;', $_shortcode_content );
				$_shortcode_content = str_replace( '&#91;wr_', '[wr_', $_shortcode_content );
				$_shortcode_content = str_replace( '&#91;/wr_', '[/wr_', $_shortcode_content );

				$content			= $element->element_shortcode( $extract_params, $_shortcode_content );
			} else {
				$class    = 'WR_Megamenu_Widget';
				$content  = '<script type="text/javascript">jQuery.noConflict();</script>';
				$content .= WR_Megamenu_Helpers_Shortcode::widget_content( array( $params ) );
			}
			global $Wr_Megamenu_Preview_Class;
			$Wr_Megamenu_Preview_Class = $class;

			$html  = '<div id="shortcode_inner_wrapper" class="jsn-bootstrap3">';
			$html .= $content;
			$html .= '</div>';
			echo balanceTags( $html );
		}
	}

	function get_widget_content()
	{

		if ( isset( $_GET['wr_preview_widget'] ) ) {

			if ( ! isset( $_GET[WR_MEGAMENU_NONCE] ) || ! wp_verify_nonce( $_GET[WR_MEGAMENU_NONCE], WR_MEGAMENU_NONCE ) ) return;
			$widget_id     = mysql_real_escape_string( $_GET['widget_id'] );
			$widget_params = urldecode( $_POST['widget_options'] );
			$object        = new $widget_id;

			$options_index = WR_Megamenu_Helpers_Widget::get_widget_base_name( $object );
			$options	   = WR_Megamenu_Helpers_Builder::parse_menu_widget_options( $widget_params );
			if ( count( $options ) && isset( $options[ $options_index ] ) ) {
				$widget_instance = $options[ $options_index ][0];
			}
			$content = WR_Megamenu_Helpers_Widget::get_widget_content( get_class( $object ), $widget_instance );
			$html    = '<div class="widget_inner_wrapper jsn-bootstrap3">';
			$html   .= $content;
			$html   .= '</div>';
			echo balanceTags( $html );
		}

	}

	/**
	 * Fired when plugin is activated
	 */
	function on_activation() {

		if ( ! current_user_can( 'activate_plugins' ) )
			return;
		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
		check_admin_referer( "activate-plugin_{$plugin}" );

	}

	/**
	 * Fired when plugin is deactivated
	 */
	function on_deactivation() {

		global $pagenow;

		if ( ! current_user_can( 'activate_plugins' ) )
			return;
		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';

		check_admin_referer( "deactivate-plugin_{$plugin}" );

		if ( $pagenow == 'plugins.php' ) {

			$wr_mm_action = 'wr_mm_deactivate';
			if( is_network_admin() ){
			    $plugin_url = network_admin_url( 'plugins.php' );
			} else {
			    $plugin_url = admin_url( 'plugins.php' );
			}


			$deactivate_one = isset( $_POST['action'] ) ? false : true;

			// show Confirmation form before doing deactivate
			if ( ! isset( $_REQUEST['wr_mm_wpnonce'] ) && ! isset( $_REQUEST['wr_back'] ) ) {
				// create wr_nonce
				$wr_mm_nonce = wp_create_nonce( $wr_mm_action );
				$method   = $deactivate_one ? 'GET' : 'POST';

				$back_text = __( 'No, take me back', WR_MEGAMENU_TEXTDOMAIN );
				if ( $deactivate_one ) {
					$back_btn = "<a href='$plugin_url' class='button button-large'>" . $back_text . '</a>';
				} else {
					$back_btn = "<input type='submit' name='wr_back' class='button button-large' value='" . $back_text . "'>";
				}
				$form   = " action='{$plugin_url}' method='$method' ";
				$fields = '';

				foreach ( $_REQUEST as $key => $value ) {
					if ( ! is_array( $value ) ) {
						$fields .= "<input type='hidden' name='$key' value='$value' />";
					} else {
						foreach ( $value as $p ) {
							$fields .= "<input type='hidden' name='{$key}[]' value='$p' />";
						}
					}
				}
				$fields .= "<input type='hidden' name='wr_mm_wpnonce' value='$wr_mm_nonce' />";
				// show message
				ob_start();
				?>
				<p>
					<?php _e( 'After deactivating, all data will be deleted. Are you sure you want to deactivate MegaMenu plugin?', WR_MEGAMENU_TEXTDOMAIN ); ?>
				</p>
				<center>
					<form <?php echo balanceTags( $form ); ?>>
						<?php echo balanceTags( $fields ); ?>
						<input type="submit" name="wr_deactivate" class="button button-large"
							   value="<?php _e( 'Yes, deactivate plugin', WR_MEGAMENU_TEXTDOMAIN ); ?>"
							   style="background: #d9534f; color: #fff; text-shadow: none; border: none;">
						<?php echo balanceTags( $back_btn ); ?>
					</form>
				</center>
				<p style="font-style: italic; font-size: 12px; margin-top: 20px;">
                    <?php _e( 'Or if you want to deactivate without removing data and configurations, click on the button below', WR_MEGAMENU_TEXTDOMAIN ); ?>
				</p>
				<center>
					<form <?php echo balanceTags( $form ); ?>>
						<?php echo balanceTags( $fields ); ?>
						<input type="submit" name="wr_deactivate_light"
							   class="button button-large"
                               value="<?php _e( 'Deactivate without removing data', WR_MEGAMENU_TEXTDOMAIN ); ?>"
							   style="background: #f0ad4e; color: #fff; text-shadow: none; border: none;">
					</form>
				</center>

				<?php
				$message = ob_get_clean();
				// Change page title
				_default_wp_die_handler( $message, __( 'WordPress &rsaquo; Confirmation', WR_MEGAMENU_TEXTDOMAIN ) );

				exit;
			} // Do deactivate after confirmation
			else {
				// get nonce
				$wr_mm_nonce = esc_sql( $_REQUEST['wr_mm_wpnonce'] );
				$nonce	= wp_verify_nonce( $wr_mm_nonce, $wr_mm_action );

				// if nonce is invalid
				if ( ! in_array( $nonce, array( 1, 2 ) ) ) {
					_default_wp_die_handler( __( 'Nonce is invalid!', WR_MEGAMENU_TEXTDOMAIN ) );
					exit;
				}

				// do action when customer choose "take me back" in confirmation form
				if ( isset( $_REQUEST['wr_back'] ) ) {
					// remove WR MegaMenu from the checked list
					if ( ( $key = array_search( $plugin, $_REQUEST['checked'] ) ) !== false ) {
						unset( $_REQUEST['checked'][$key] );
					}

					// Overwrite list of checked plugins to deactivating
					$_POST['checked'] = $_REQUEST['checked'];
				} // deactivate WR MegaMenu & parsing content
				else {
					if ( isset( $_REQUEST['wr_deactivate'] ) ) {

						$posts = get_posts(
							array(
								'post_type' => array( 'wr_megamenu_profile' ),
								'post_status'	  => 'any',
							)
						);

						if ( $posts ) {

							foreach ( $posts as $post ) {

								delete_post_meta( $post->ID, WR_MEGAMENU_META_KEY );
								delete_post_meta( $post->ID, WR_MEGAMENU_META_KEY . '_themes_options' );
								delete_post_meta( $post->ID, '_wr_megamenu_profile_location_' );
								delete_post_meta( $post->ID, '_wr_megamenu_css_files' );
								delete_post_meta( $post->ID, '_wr_megamenu_css_custom' );
								
								wp_delete_post( $post->ID );

							}
						}

						// delete meta and posts blog all
						if( is_network_admin() ){
							global $wpdb;
							// get list id blog all
							$list_prefix_musite = $wpdb->get_results(
								"SELECT blog_id FROM $wpdb->blogs",
								ARRAY_A
							);

							if($list_prefix_musite && count($list_prefix_musite) > 1){
								foreach ($list_prefix_musite as $key => $value) {
									if ($value['blog_id'] == 1) continue;
									
									$prefix = $wpdb->prefix.$value['blog_id'].'_';

									// get list id megamenu posts
									$posts = $wpdb->get_results(
										"
										SELECT ID 
										FROM {$prefix}posts 
										WHERE post_type = 'wr_megamenu_profile'
										",
										ARRAY_A
									);

									if($posts){
										foreach ($posts as $key_posts => $value_posts) {
											
											// delete post meta key
											$wpdb->query(
												"
												DELETE FROM {$prefix}postmeta
												WHERE (
													meta_key = '".WR_MEGAMENU_META_KEY."' OR
													meta_key = '".WR_MEGAMENU_META_KEY."_themes_options' OR
													meta_key = '_wr_megamenu_profile_location_' OR
													meta_key = '_wr_megamenu_css_files' OR
													meta_key = '_wr_megamenu_css_custom'
													) AND 
													post_id = {$value_posts['ID']}
												"
											);

											// delete posts
											$wpdb->query(
												"
												DELETE FROM {$prefix}posts
												WHERE ID = {$value_posts['ID']}
												"
											);
										}
									}
								}
							}
						}

					}
				}
			}
		}

	}

}
