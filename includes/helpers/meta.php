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

class WR_Megamenu_Helpers_Meta {

	public function init() {
		add_filter( 'manage_edit-wr_megamenu_profile_columns', array( &$this, 'wr_megamnu_profiles_columns_filter' ), 10, 1 );
		add_filter( 'post_row_actions',                        array( &$this, 'wr_megamenu_duplicate_profile' ), 10, 2 );
		add_filter( 'bulk_post_updated_messages',              array( &$this, 'bulk_profile_updated_messages' ), 10, 2 );

		add_action( 'manage_wr_megamenu_profile_posts_custom_column', array( $this, 'custom_wr_megamenu_profile_column' ), 10, 2 );
		add_action( 'admin_head',                                     array( $this, 'wr_megamenu_hide_slugs' ) );
		add_action( 'restrict_manage_posts',                          array( $this, 'wr_megamenu_restrict_manage_posts' ) );
		add_action( 'pre_get_posts',                                  array( $this, 'filter_profiles' ) );
	}

	function wr_megamenu_hide_slugs() {
		$hide_slugs = '<style type=\"text/css\"> #slugdiv, #edit-slug-box { display: none; }</style>';
		echo balanceTags( $hide_slugs );
	}

	/**
	 * Customize the profiles management columns
	 * @param $columns
	 * @return new $columns array
	 */
	public function wr_megamnu_profiles_columns_filter( $columns ) {
		$columns = array(
			'cb'       => '<input type="checkbox" />',
			'title'    => __( 'Title', WR_MEGAMENU_TEXTDOMAIN ),
			'menu'     => __( 'Menu', WR_MEGAMENU_TEXTDOMAIN ),
			'location' => __( 'Location', WR_MEGAMENU_TEXTDOMAIN ),
			'author'   => __( 'Author', WR_MEGAMENU_TEXTDOMAIN ),
			'date'     => __( 'Date' )
		);
		return $columns;
	}

	/**
	 * Display custom columns
	 * @param $column
	 * @param $post_id
	 * return void
	 */
	public function custom_wr_megamenu_profile_column( $column, $post_id ) {
		$data     = get_post_meta( $post_id, WR_MEGAMENU_META_KEY, true );
		$settings = (array) json_decode( $data, true );

		$menu_type      = isset( $settings['menu_type'] ) ? $settings['menu_type'] : '' ;
		$theme_location = isset( $settings['location'] ) ? $settings['location'] : '';

		switch ( $column ) {
			case 'menu':
				$menu = wp_get_nav_menu_object( $menu_type );
				if ( $menu ) {
					echo esc_html( $menu->name );
				} else {
					echo '--';
				}
			break;
				
			case 'location':
				$menus_registered = get_registered_nav_menus();
				if ( isset( $menus_registered[ $theme_location ] ) ) {
					echo esc_html( $menus_registered[ $theme_location ] );
				} else {
					echo '--';
				}
			break;
		}

	}

	/**
	 * Filters the request based on additional profile filters.
	 */
	public function filter_profiles( $query_vars ) {
		if ( isset( $query_vars->query_vars['post_type'] ) && ! empty( $_GET['wr_megamenu_location'] ) ) {
			if ( $query_vars->query_vars['post_type'] == 'wr_megamenu_profile' ) {
				$query_vars->set( 'meta_key', '_wr_megamenu_profile_location_' );
				$query_vars->set( 'meta_compare', '=' );
				$query_vars->set( 'meta_value', $_GET['wr_megamenu_location'] );
			}
		}

		add_filter( 'posts_where', array( &$this, 'filter_profiles_where' ), 10, 2 );
		add_filter( 'posts_join',  array( &$this, 'filter_profiles_join'  ), 10, 2 );

		return $query_vars;
	}

	/**
	 * Handles additional meta key/value filters in the WHERE clause.
	 */
	public function filter_profiles_where( $where, $object ) {
		return $where;
	}

	/**
	 * Creates additional joins to handle additional meta key/value filters.
	 */
	function filter_profiles_join( $join, $object ) {
		return $join;
	}

	/**
	 * Show filter field on manage posts wr_megamenu_profile
	 * 
	 * @return html
	 */
	public function wr_megamenu_restrict_manage_posts() {
		
		if ( ! empty( $_GET['post_type'] ) && ( $_GET['post_type'] == 'wr_megamenu_profile' ) ) {
			// Only show select megamenu location filter on wr_megamenu_profile post type.
			$locations = get_registered_nav_menus();
			$selected_location = isset( $_GET['wr_megamenu_location'] ) ? $_GET['wr_megamenu_location'] : '';
			echo '<select name="wr_megamenu_location">';
			echo '<option value="">' . __( 'Show all locations', WR_MEGAMENU_TEXTDOMAIN ) . '</option>';
			foreach ( $locations as $key => $location ) {
				echo '<option value="'.$key.'"'.selected( $key, $selected_location ).'>' . $location . '</option>';
			}
			
			echo '</select>';
		}
	}

	public function bulk_profile_updated_messages( $bulk_messages, $bulk_counts ) {
		$msg = isset( $_REQUEST['duplicated'] ) ? absint( $_REQUEST['duplicated'] ) : 0;
		$bulk_messages['wr_megamenu_profile']['updated'] = __( '%s profile duplicated.', $msg );

		return $bulk_messages;
	}

	public function wr_megamenu_duplicate_profile( $actions, $post ) {
		$news = array();

		$duplicate         = add_query_arg( array( 'action' => 'duplicate', 'profile_id' => $post->ID ), admin_url( 'admin.php?wr-mm-gadget=duplicate-profile' ) );
		$news              = array_merge( $news, array_slice( $actions, 0 , 1 ) );
		$news['duplicate'] = '<a href="'.wp_nonce_url( $duplicate ).'" title="' . esc_attr( sprintf( __( 'Duplicate %s' ), _draft_or_post_title() ) ) . '" rel="permalink">' . __( 'Duplicate', WR_MEGAMENU_TEXTDOMAIN ) . '</a>';
		$news              = array_merge( $news, array_slice( $actions, 1 ) );

		return $news;
	}

}