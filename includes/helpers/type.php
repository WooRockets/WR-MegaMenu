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
 * @todo : Defines values of setting options
 */

if ( ! class_exists( 'WR_Megamenu_Helpers_Type' ) ) {

	class WR_Megamenu_Helpers_Type {

		/**
    	 ** Google map type options
    	 *
    	 * @return array
    	 */
		static function get_gmap_type() {
			return array(
				'HYBRID'    => __( 'Hybrid', WR_MEGAMENU_TEXTDOMAIN ),
				'ROADMAP'   => __( 'Roadmap', WR_MEGAMENU_TEXTDOMAIN ),
				'SATELLIGE' => __( 'Satellite', WR_MEGAMENU_TEXTDOMAIN ),
				'TERRAIN'   => __( 'Terrain', WR_MEGAMENU_TEXTDOMAIN ),
			);
		}

		/**
		 ** Zoom level options for google element
		 *
		 * @return array
		 */
		static function get_zoom_level() {
			return array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',
				'9' => '9',
				'10' => '10',
				'11' => '11',
				'12' => '12',
				'13' => '13',
				'14' => '14',
			);
		}

		/**
		 * Container style options
         *
		 * @return array
		 */
		static function get_container_style() {
			return array(
				'no-appearance' => __( 'No Styling', WR_MEGAMENU_TEXTDOMAIN ),
				'img-rounded'   => __( 'Rounded', WR_MEGAMENU_TEXTDOMAIN ),
				'img-circle'    => __( 'Circle', WR_MEGAMENU_TEXTDOMAIN ),
				'img-thumbnail' => __( 'Thumbnail', WR_MEGAMENU_TEXTDOMAIN )
			);
		}

		/**
		 ** Zoom level options for QRCode element
		 *
		 * @return array
		 */
		static function get_qr_container_style() {
			return array(
				'no-appearance' => __( 'No Styling', WR_MEGAMENU_TEXTDOMAIN ),
				'img-thumbnail' => __( 'Thumbnail', WR_MEGAMENU_TEXTDOMAIN )
			);
		}

		/**
		 ** pricing table design options
		 *
		 * @return array
		 */
		static function get_pr_tbl_design_options() {
			return array(
				'table-style-one' => __( 'Design option 1', 	WR_MEGAMENU_TEXTDOMAIN ),
				'table-style-two' => __( 'Design option 2', 	WR_MEGAMENU_TEXTDOMAIN ),
			);
		}

		/**
		 * * Table design options
		 *
		 * @return array
		 */
		static function get_table_row_color() {
			return array(
				'default' => __( 'Default', WR_MEGAMENU_TEXTDOMAIN ),
				'active'  => __( 'Active (Grey)', WR_MEGAMENU_TEXTDOMAIN ),
				'success' => __( 'Success (Green)', WR_MEGAMENU_TEXTDOMAIN ),
				'warning' => __( 'Warning (Orange)', WR_MEGAMENU_TEXTDOMAIN ),
				'danger'  => __( 'Danger (Red)', WR_MEGAMENU_TEXTDOMAIN ),
			);
		}

		/**
		 ** alert type options
		 *
		 * @return array
		 */
		static function get_alert_type() {
			return array(
				'alert-warning' => __( 'Default', WR_MEGAMENU_TEXTDOMAIN ),
				'alert-success' => __( 'Success', WR_MEGAMENU_TEXTDOMAIN ),
				'alert-info'    => __( 'Info', WR_MEGAMENU_TEXTDOMAIN ),
				'alert-danger'  => __( 'Danger', WR_MEGAMENU_TEXTDOMAIN ),
			);
		}

		/**
		 ** progress bar color options
		 *
		 * @return array
		 */
		static function get_progress_bar_color() {
			return array(
				'default'              => __( 'Default', WR_MEGAMENU_TEXTDOMAIN ),
				'progress-bar-info'    => __( 'Info (Light Blue)', WR_MEGAMENU_TEXTDOMAIN ),
				'progress-bar-success' => __( 'Success (Green)', WR_MEGAMENU_TEXTDOMAIN ),
				'progress-bar-warning' => __( 'Warning (Orange)', WR_MEGAMENU_TEXTDOMAIN ),
				'progress-bar-danger'  => __( 'Danger (Red)', WR_MEGAMENU_TEXTDOMAIN ),
			);
		}

		/**
		 ** progress bar style options
		 *
		 * @return array
		 */
		static function get_progress_bar_style() {
			return array(
				'multiple-bars' => __( 'Multiple bars', WR_MEGAMENU_TEXTDOMAIN ),
				'stacked' 		=> __( 'Stacked', WR_MEGAMENU_TEXTDOMAIN ),
			);
		}

		/**
		 ** progress bar item options
		 *
		 * @return array
		 */
		static function get_progress_bar_item_style() {
			return array(
				'solid'   => __( 'Solid', WR_MEGAMENU_TEXTDOMAIN ),
				'striped' => __( 'Striped', WR_MEGAMENU_TEXTDOMAIN ),
			);
		}

		/**
		 * Static function to get button color Options
		 *
		 * @return array
		 */
		static function get_button_color() {
			return array(
				'btn-default' => __( 'Default', WR_MEGAMENU_TEXTDOMAIN ),
				'btn-primary' => __( 'Primary (Dark Blue)', WR_MEGAMENU_TEXTDOMAIN ),
				'btn-info'    => __( 'Info (Light Blue)', WR_MEGAMENU_TEXTDOMAIN ),
				'btn-success' => __( 'Success (Green)', WR_MEGAMENU_TEXTDOMAIN ),
				'btn-warning' => __( 'Warning (Orange)', WR_MEGAMENU_TEXTDOMAIN ),
				'btn-danger'  => __( 'Danger (Red)', WR_MEGAMENU_TEXTDOMAIN ),
				'btn-link'    => __( 'Link', WR_MEGAMENU_TEXTDOMAIN )
			);
		}

		/**
		 * Button size options
         *
		 * @return array
		 */
		static function get_button_size() {
			return array(
				'default' => __( 'Default', WR_MEGAMENU_TEXTDOMAIN ),
				'btn-xs'  => __( 'Mini', WR_MEGAMENU_TEXTDOMAIN ),
				'btn-sm'  => __( 'Small', WR_MEGAMENU_TEXTDOMAIN ),
				'btn-lg'  => __( 'Large', WR_MEGAMENU_TEXTDOMAIN )
			);
		}

		/**
		 * "Open in" option for anchor
         *
		 * @return array
		 */
		static function get_open_in_options() {
			return array(
				'current_browser' => __( 'Current Browser', WR_MEGAMENU_TEXTDOMAIN ),
				'new_browser'     => __( 'New Tab', WR_MEGAMENU_TEXTDOMAIN ),
				'lightbox'     => __( 'Lightbox', WR_MEGAMENU_TEXTDOMAIN ),
			);
		}

		/**
		 * Icon position for List shortcode
         *
		 * @return array
		 */
		static function get_icon_position() {
			return array(
				'left'  => __( 'Left', WR_MEGAMENU_TEXTDOMAIN ),
				'right' => __( 'Right', WR_MEGAMENU_TEXTDOMAIN ),
			);
		}

		/**
		 * Position options
         *
		 * @return array
		 */
		static function get_full_positions() {
			return array(
				'top'    => __( 'Top', WR_MEGAMENU_TEXTDOMAIN ),
				'bottom' => __( 'Bottom', WR_MEGAMENU_TEXTDOMAIN ),
				'left'   => __( 'Left', WR_MEGAMENU_TEXTDOMAIN ),
				'right'  => __( 'Right', WR_MEGAMENU_TEXTDOMAIN ),
			);
		}

		/**
		 * Icon size options
         *
		 * @return array
		 */
		static function get_icon_sizes() {
			return array(
				'16' => '16',
				'24' => '24',
				'32' => '32',
				'48' => '48',
				'64' => '64',
			);
		}

		/**
		 * Icon style for List shortcode
         *
		 * @return array
		 */
		static function get_icon_background() {
			return array(
				'circle' => __( 'Circle', WR_MEGAMENU_TEXTDOMAIN ),
				'square' => __( 'Square', WR_MEGAMENU_TEXTDOMAIN )
			);
		}

		/**
		 * Font options
         *
		 * @return array
		 */
		static function get_fonts() {
			return array(
				'standard fonts' => __( 'Standard fonts', WR_MEGAMENU_TEXTDOMAIN ),
				'google fonts'   => __( 'Google fonts', WR_MEGAMENU_TEXTDOMAIN )
			);
		}

		/**
		 * Text align options
         *
		 * @return array
		 */
		static function get_text_align() {
			return array(
				'inherit' => __( 'Inherit', WR_MEGAMENU_TEXTDOMAIN ),
				'left'    => __( 'Left', WR_MEGAMENU_TEXTDOMAIN ),
				'center'  => __( 'Center', WR_MEGAMENU_TEXTDOMAIN ),
				'right'   => __( 'Right', WR_MEGAMENU_TEXTDOMAIN )
			);
		}

		/**
		 * Font size options
         *
		 * @return array
		 */
		static function get_font_size_types() {
			return array(
				'px'   => 'px',
				'em'   => 'em',
				'inch' => 'inch',
			);
		}

		/**
		 * Border style options
         *
		 * @return array
		 */
		static function get_border_styles() {
			return array(
				'solid'  => __( 'Solid', WR_MEGAMENU_TEXTDOMAIN ),
				'dotted' => __( 'Dotted', WR_MEGAMENU_TEXTDOMAIN ),
				'dashed' => __( 'Dashed', WR_MEGAMENU_TEXTDOMAIN ),
				'double' => __( 'Double', WR_MEGAMENU_TEXTDOMAIN ),
				'groove' => __( 'Groove', WR_MEGAMENU_TEXTDOMAIN ),
				'ridge'  => __( 'Ridge', WR_MEGAMENU_TEXTDOMAIN ),
				'inset'  => __( 'Inset', WR_MEGAMENU_TEXTDOMAIN ),
				'outset' => __( 'Outset', WR_MEGAMENU_TEXTDOMAIN )
			);
		}

		/**
		 * Font style options
         *
		 * @return array
		 */
		static function get_font_styles() {
			return array(
				'inherit' => __( 'Inherit', WR_MEGAMENU_TEXTDOMAIN ),
				'italic'  => __( 'Italic', WR_MEGAMENU_TEXTDOMAIN ),
				'normal'  => __( 'Normal', WR_MEGAMENU_TEXTDOMAIN ),
				'bold'    => __( 'Bold', WR_MEGAMENU_TEXTDOMAIN )
			);
		}

		/**
		 * Dummy content
         *
		 * @return array
		 */
		static function lorem_text( $word_count = 50 ) {
			return ucfirst( WR_Megamenu_Helpers_Common::lorem_text( $word_count, true ) );
		}

		/**
		 * Dummy person name
         *
		 * @return array
		 */
		static function lorem_name() {
			$usernames = array( 'Jane Poe', 'Robert Roe', 'Mark Moe', 'Brett Boe', 'Carla Coe', 'Donna Doe', 'Juan Doe', 'Frank Foe', 'Grace Goe', 'Harry Hoe', 'Jackie Joe', 'Karren Koe', 'Larry Loe', 'Marta Moe', 'Norma Noe', 'Paula Poe', 'Quintin Qoe', 'Ralph Roe', 'Sammy Soe', 'Tommy Toe', 'Vince Voe', 'William Woe', 'Xerxes Xoe', 'Yvonne Yoe', 'Zachary Zoe', 'John Smith', 'Udin Sedunia', 'Mubarok Bau' );
			$index     = rand( 0, 27 );
			return $usernames[$index];
		}

		/**
		 * Get 1st option of array
         *
		 * @param array $arr
		 * @return array
		 */
		static function get_first_option( $arr ) {
			foreach ( $arr as $key => $value ) {
				if ( ! is_array( $key ) )
					return $key;
			}
		}

		/**
		 * Static function to get category options
		 *
		 * @param bool $has_root
		 *
		 * @return array
		 */
		static function get_categories( $has_root = false ) {
			$categories = get_categories();
			$arr_return = array();
			$return     = array();
			if ( $categories ) {
				if ( $has_root )
					$return[] = __( 'Root', WR_MEGAMENU_TEXTDOMAIN );
				foreach ( $categories as $i => $category ) {
					$arr_return[] = array( 'id' => $category->term_id, 'parent' => $category->parent, 'title' => $category->name );
				}
				$level = 0;
				foreach ( $arr_return as $i => $item ) {
					if ( $item['parent'] == 0 ) {
						$id = $item['id'];
						unset( $arr_return[$i] );
						if ( ! isset( $item['title'] ) OR ! $item['title'] ) {
							$item['title'] = __( '( no title )', WR_MEGAMENU_TEXTDOMAIN );
						}
						$return[$item['id']] = $item['title'];
						self::_recur_tree( $return, $arr_return, $id, $level );
					}
				}
			}
			return $return;
		}

		/**
		 * Posts list
         *
		 * @global type $wpdb
		 * @return array
		 */
		static function get_posts() {
			global $wpdb;
			$numposts = $wpdb->get_var( "SELECT COUNT(* ) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'" );
			if ( 0 < $numposts )
				$numposts = number_format( $numposts );
			$posts = get_posts( array( 'posts_per_page' => $numposts ) );
			$arr_return = array();
			$return     = array();
			if ( $posts ) {
				foreach ( $posts as $i => $post ) {
					$arr_return[] = array( 'id' => $post->ID, 'parent' => $post->post_parent, 'title' => $post->post_title );
				}

				foreach ( $arr_return as $i => $item ) {
					$return[$item['id']] = ( strlen( $item['title'] ) > 30 ) ? substr( $item['title'], 0, strrpos( substr( $item['title'], 0, 30 ), ' ' ) ) . '...' : $item['title'];
				}
			}
			return $return;
		}

		/**
		 * Pages list
         *
		 * @param type $has_root
		 * @return array
		 */
		static function get_pages( $has_root = false ) {
			$pages = get_pages();
			$arr_return = array();
			$return     = array();
			if ( $pages ) {
				if ( $has_root )
					$return[] = __( 'Root', WR_MEGAMENU_TEXTDOMAIN );
				foreach ( $pages as $i => $page ) {
					$arr_return[] = array( 'id' => $page->ID, 'parent' => $page->post_parent, 'title' => $page->post_title );
				}

				$level = 0;
				foreach ( $arr_return as $i => $item ) {
					if ( $item['parent'] == 0 ) {
						$id = $item['id'];
						unset( $arr_return[$i] );
						$return[$item['id']] = $item['title'];
						self::_recur_tree( $return, $arr_return, $id, $level );
					}
				}
			}

			return $return;
		}

		/**
		 * listing tree type using recursive
		 *
		 * @param array $return
		 * @param array $arr_return
		 * @param int $id
		 * @param int $level
		 * @param string $type
		 * @param string $prefix
		 */
		private static function _recur_tree( &$return, $arr_return, $id, $level, $type = '0', $prefix = '' ) {
			if ( $type == '0' ) {
				$level++;
				foreach ( $arr_return as $i => $item ) {
					if ( $item['parent'] == $id ) {
						unset( $arr_return[$i] );
						if ( ! isset( $item['title'] ) OR ! $item['title'] ) {
							$item['title'] = __( '( no title )', WR_MEGAMENU_TEXTDOMAIN );
						}
						$return[$item['id']] = str_repeat( '&#8212; ', $level ) . $item['title'];
						self::_recur_tree( $return, $arr_return, $item['id'], $level, $type );
					}
				}
			} else if ( $type == '1' ) {
				$level++;
				foreach ( $arr_return as $i => $item ) {
					if ( $item->parent == $id ) {
						unset( $arr_return[$i] );
						if ( ! $item->name ) {
							$item->name = __( '( no name )', WR_MEGAMENU_TEXTDOMAIN );
						}
						$return[$item->term_id] = str_repeat( '&#8212; ', $level ) . $item->name;
						self::_recur_tree( $return, $arr_return, $item->term_id, $level, $type );
					}
				}
			} else if ( $type == '-1' ) {
				$level++;
				foreach ( $arr_return as $i => $item ) {
					if ( $item->post_parent == $id ) {
						unset( $arr_return[$i] );
						if ( ! $item->post_title ) {
							$item->post_title = __( '( no title )', WR_MEGAMENU_TEXTDOMAIN );
						}
						$return[$item->ID] = str_repeat( '&#8212; ', $level ) . $item->post_title;
						self::_recur_tree( $return, $arr_return, $item->ID, $level, $type );
					}
				}
			} else if ( $type == '-2' ) {
				$level++;
				foreach ( $arr_return as $i => $item ) {
					if ( $item->menu_item_parent == $id ) {
						unset( $arr_return[$i] );
						if ( ! $item->title ) {
							$item->title = __( '( no title )', WR_MEGAMENU_TEXTDOMAIN );
						}
						if ( $prefix ) {
							$return[$prefix][$item->ID] = str_repeat( '&#8212; ', $level ) . $item->title;
							self::_recur_tree( $return, $arr_return, $item->ID, $level, $type, $prefix );
						}
					}
				}
			}
			return;
		}

		/**
		 * link type options
		 *
		 * @return multitype:
		 */
		static function get_link_types() {
			$taxonomies = self::get_public_taxonomies();
			$post_types = self::get_post_types();
			$arr = array(
				'no_link' => __( 'No Action', WR_MEGAMENU_TEXTDOMAIN ),
				'url' => __( 'Go to URL', WR_MEGAMENU_TEXTDOMAIN ),
				'single_entry' => array( 'text' => __( 'Go to Single Entry', WR_MEGAMENU_TEXTDOMAIN ), 'type' => 'optiongroup' ),
			);
			$arr = array_merge( $arr, $post_types );
			$arr = array_merge( $arr, array( 'taxonomy' => array( 'text' => __( 'Go to Taxonomy Overview Page', WR_MEGAMENU_TEXTDOMAIN ), 'type' => 'optiongroup' ) ) );
			$arr = array_merge( $arr, $taxonomies );
			return $arr;
		}

		/**
		 * Get single entry list: Post, Page, Product...
		 *
		 * @return array
		 */
		static function get_single_entry() {
			$post_types = self::get_post_types();
			return $post_types;
		}

		/**
		 ** content source options
		 *
		 * @return array
		 */
		static function get_content_source() {
			$taxonomies = self::get_public_taxonomies();
			$post_types = self::get_post_types();
			$arr = array(
				'nav_menu_item' => __( 'Menu', WR_MEGAMENU_TEXTDOMAIN ),
				'single_entry' => array( 'text' => __( 'Single Entries', WR_MEGAMENU_TEXTDOMAIN ), 'type' => 'optiongroup' ),
			);
			$arr = array_merge( $arr, $post_types );
			$arr = array_merge( $arr, array( 'taxonomy' => array( 'text' => __( 'Taxonomy Overview Page', WR_MEGAMENU_TEXTDOMAIN ), 'type' => 'optiongroup' ) ) );
			$arr = array_merge( $arr, $taxonomies );
			return $arr;
		}

		/**
		 ** image link type options
		 *
		 * @return array
		 */
		static function get_image_link_types() {
			$imageLinkType = array();
			$linkTypes = self::get_link_types();
			$imageLinkType = array_slice( $linkTypes, 0, 1 );
			$imageLinkType['large_image'] = __( 'Show Large Image', WR_MEGAMENU_TEXTDOMAIN );
			$imageLinkType = array_merge( $imageLinkType, array_slice( $linkTypes, 1 ) );
			return $imageLinkType;
		}

		/**
		 ** terms by taxonomies
		 *
		 * @param string $taxonomy
		 * @param string $allow_root
		 * @param string $order_by
		 *
		 * @return array
		 */
		static function get_term_taxonomies( $taxonomy = '', $allow_root = false, $order_by = 'count' ) {
			$taxonomies = self::get_public_taxonomies();
			$term_taxos = array();
			foreach ( $taxonomies as $taxo_slug => $taxo_name ) {
				if ( ! isset( $term_taxos[$taxo_slug] ) )
					$term_taxos[$taxo_slug] = array();
				if ( $allow_root ) {
					$exclude_taxo = self::_get_exclude_taxonomies();
					if ( in_array( $taxo_slug , $exclude_taxo ) ) {
						$term_taxos[$taxo_slug]['root'] = __( 'Root', WR_MEGAMENU_TEXTDOMAIN );
					}
				}
				$terms = get_terms(
					$taxo_slug, array(
						'orderby' => $order_by,
						'hide_empty' => 0,
					)
				);

				if ( $order_by == 'name' ) {
					$return     = array();
					$level = 0;
					$arr_return = $terms;
					foreach ( $arr_return as $i => $item ) {
						if ( $item->parent == 0 ) {
							unset( $arr_return[$i] );
							if ( ! $item->name ) {
								$item->name = __( '( no name )', WR_MEGAMENU_TEXTDOMAIN );
							}
							$return[$item->term_id] = $item->name;
							self::_recur_tree( $return, $arr_return, $item->term_id, $level, '1' );
						}
					}
					foreach ( $return as $id => $name ) {
						foreach ( $terms as $term ) {
							if ( $id == $term->term_id ) {
								$term_taxos[$taxo_slug][$term->term_id] = __( $name, WR_MEGAMENU_TEXTDOMAIN );
							}
						}
					}
				} else {
					foreach ( $terms as $term ) {
						$term_taxos[$taxo_slug][$term->term_id] = __( $term->name, WR_MEGAMENU_TEXTDOMAIN );
					}
				}
			}
			if ( $taxonomy )
				return $term_taxos[$taxonomy];
			return $term_taxos;
		}

		/**
		 * Static function get categories for Content Clips shortcode
		 *
		 * @param string $check_val
		 * @param array $attrs
		 *
		 * @return array
		 */
		static function get_categories_content_clips( $check_val, $attrs ) {
			$term_taxos = self::get_term_taxonomies();
			$result     = array();
			foreach ( $term_taxos as $taxo => $terms ) {
				$tmp_arr = array();
				$tmp_arr['options']    = $terms;
				$tmp_arr['dependency'] = array( $check_val, '=', $taxo );
				$result[] = array_merge( $attrs, $tmp_arr );
			}
			return $result;
		}

		/**
		 ** list of single item by post types: post, page, custom post type...
		 *
		 * @param string $posttype
		 *
		 * @return array
		 */
		static function get_single_by_post_types( $posttype = '' ) {
			$posttypes = self::get_post_types();
			$results   = array();
			foreach ( $posttypes as $slug => $name ) {
				if ( ! isset( $results[$slug] ) )
					$results[$slug] = array();
				// query post by post type
				$args = array( 'post_type' => $slug, 'posts_per_page' => -1, 'post_status' => ($slug == 'attachment' ) ? 'inherit' : 'publish' );
				$query = new WP_Query( $args );
				while ( $query->have_posts() ) {
					$query->the_post();
					$results[$slug][get_the_ID()] = __( get_the_title(), WR_MEGAMENU_TEXTDOMAIN );
				}
				wp_reset_postdata();
			}
			if ( $posttype )
				return $results[$posttype];
			return $results;
		}

		/**
		 ** Single Entry options for Button Bar
		 *
		 * @param string $check_val
		 * @param array $attrs
		 *
		 * @return array
		 */
		static function get_single_item_button_bar( $check_val, $attrs ) {
			$post_singles = self::get_single_by_post_types();
			$term_taxos   = self::get_term_taxonomies();
			$result = array();
			foreach ( array_merge( $post_singles, $term_taxos ) as $taxo => $terms ) {
				$tmp_arr = array();
				$tmp_arr['options']    = $terms;
				$tmp_arr['dependency'] = array( $check_val, '=', $taxo );
				$result[] = array_merge( $attrs, $tmp_arr );
			}
			return $result;
		}

		/**
		 ** Single Entries options for Content List
		 *
		 * @param string $check_val
		 * @param array $attrs
		 *
		 * @return array
		 */
		static function get_single_entries_ctl( $check_val, $attrs ) {
			global $wpdb;
			$posttypes = array();
			$posttypes['nav_menu_item'] = __( 'Menu', WR_MEGAMENU_TEXTDOMAIN );
			$posttypes = array_merge( $posttypes, self::get_post_types() );
			$post_singles = $arr_post_has_parent = array();
			// Check taxonomies is parent type
			$exclude_taxo = self::_get_exclude_taxonomies();
			$public_taxs  = self::get_public_taxonomies( true );

			foreach ( $posttypes as $slug => $name ) {
				if ( ! isset( $post_singles[$slug] ) ) {
					$post_singles[$slug] = array();
					if ( in_array( $slug , $exclude_taxo ) AND $slug != 'nav_menu_item' ) {
						$post_singles[$slug]['root'] = __( 'Root', WR_MEGAMENU_TEXTDOMAIN );
					}
				}

				$arr_posts = array();
				if ( $slug == 'page' ) {
					// process for page tree
					$sql   = $wpdb->prepare(
							"SELECT *
							FROM $wpdb->posts AS posts
							WHERE posts.post_type = %s AND posts.post_status = %s
							ORDER BY posts.post_parent ASC , posts.post_title ASC", 'page', 'publish'
							);
					$data  = $wpdb->get_results( $sql );
					$level = 0;

					foreach ( $data as $i => $item ) {
						if ( $item->post_parent == 0 ) {
							unset( $data[$i] );
							if ( ! $item->post_title ) {
								$item->post_title = __( '( no title )', WR_MEGAMENU_TEXTDOMAIN );
							}
							$arr_posts[$item->ID] = __( $item->post_title, WR_MEGAMENU_TEXTDOMAIN );
							self::_recur_tree( $arr_posts, $data, $item->ID, $level, '-1' );
						}
					}
				} else {
					// query post by post type
					$args = array( 'post_type' => $slug, 'posts_per_page' => -1, 'post_status' => ($slug == 'attachment' ) ? 'inherit' : 'publish' );
					$query = new WP_Query( $args );
					while ( $query->have_posts() ) {
						$query->the_post();
						$post_id = get_the_ID();
						$arr_posts[$post_id] = __( get_the_title(), WR_MEGAMENU_TEXTDOMAIN );
					}
					wp_reset_postdata();
				}

				$arr_post_ids = array();
				foreach ( $arr_posts as $id => $title ) {
					if ( $id ) {
						$arr_post_ids[] = $id;
					}
				}

				$arr_post_ids	= implode( ',', $arr_post_ids );
				if ( $arr_post_ids ) {
					$sql = $wpdb->prepare(
							"SELECT term_rel.term_taxonomy_id AS term_taxonomy_id, name, object_id, taxonomy, term.term_id AS term_id
							FROM $wpdb->term_relationships AS term_rel
							INNER JOIN $wpdb->term_taxonomy as term_taxonomy
							ON term_taxonomy.term_taxonomy_id = term_rel.term_taxonomy_id
							INNER JOIN $wpdb->terms AS term
							ON term_taxonomy.term_id = term.term_id
							WHERE term_rel.object_id IN ( %s )", $arr_post_ids
							);

					$result = $wpdb->get_results( $sql );
				} else {
					$result = array();
				}
				$arr_taxonomy = array();
				if ( count( $result ) ) {
					foreach ( $result as $i => $item ) {
						if ( ! in_array( $item->taxonomy, $arr_taxonomy ) ) {
							$arr_taxonomy[] = $item->taxonomy;
						}
					}
				}

				if ( count( $result ) ) {
					if ( count( $arr_taxonomy ) >= 1 ) {
						foreach ( $arr_taxonomy as $j => $taxonomy ) {
							foreach ( $public_taxs as $tax_slug => $pb_tax ) {
								if ( $tax_slug == $taxonomy AND ! empty( $pb_tax ) ) {
									if ( $taxonomy == 'product_type' ) {
										$pb_tax = __( 'Product Type', WR_MEGAMENU_TEXTDOMAIN );
									}
									$post_singles[$slug][$taxonomy] = array( 'text' => $pb_tax, 'type' => 'optiongroup' );

									if ( ! in_array( $slug, $arr_post_has_parent ) ) {
										$arr_post_has_parent[] = $slug;
									}
								}
							}
							foreach ( $result as $i => $item ) {
								foreach ( $arr_posts as $id => $title ) {
									if ( $item->object_id == $id AND $item->taxonomy == $taxonomy ) {
										$post_singles[$slug][$item->term_id] = __( $item->name, WR_MEGAMENU_TEXTDOMAIN );

										if ( ! in_array( $slug, $arr_post_has_parent ) ) {
											$arr_post_has_parent[] = $slug;
										}
									}
								}
							}
							unset( $arr_taxonomy[$j] );
						}
					} else {
						foreach ( $arr_posts as $id => $title ) {
							foreach ( $result as $i => $item ) {
								if ( $item->object_id == $id ) {
									$post_singles[$slug][$item->term_id] = __( $item->name, WR_MEGAMENU_TEXTDOMAIN );
								}
							}
						}
					}
				} else {
					foreach ( $arr_posts as $id => $title ) {
						$post_singles[$slug][$id] = $title;
					}
				}
			}

			$result     = array();
			$term_taxos = self::get_term_taxonomies( '', true, 'name' );
			foreach ( $posttypes as $_slug => $post ) {
				if ( in_array( $_slug, $exclude_taxo ) OR in_array( $_slug, $arr_post_has_parent ) ) {
					unset( $posttypes[$_slug] );
				}
			}

			foreach ( array_merge( $post_singles, $term_taxos ) as $taxo => $terms ) {
				$tmp_arr = array();
				if ( ! in_array( $taxo , $exclude_taxo ) ) {
					$tmp_arr['multiple'] = '1';
				}
				$allow = true;
				if ( count( $arr_post_has_parent ) ) {
					foreach ( $posttypes as $_slug => $post ) {
						if ( $_slug == $taxo ) {
							$allow = false;
							break;
						}
					}
				}
				if ( $allow ) {
					$tmp_arr['options'] = $terms;
				} else {
					$tmp_arr['options'] = array();
				}
				if ( $taxo == 'nav_menu_item' ) {
					$attrs['class'] = 'select2-select no_plus_depend';
				}
				$tmp_arr['no_order']   = '1';
				$tmp_arr['dependency'] = array( $check_val, '=', $taxo );
				$result[] = array_merge( $attrs, $tmp_arr );
			}
			return $result;
		}

		/**
		 ** exclude taxonomy and posttypes array for taxonomies parent-child type
		 *
		 * @return array
		 */
		static function _get_exclude_taxonomies() {
			global $wpdb;
			// set default exclude value
			$exclude_taxo   = array();
			$exclude_taxo[] = 'page';
			$exclude_taxo[] = 'nav_menu_item';

			$sql    = $wpdb->prepare( "SELECT DISTINCT( post_type ) FROM $wpdb->posts WHERE post_parent != %d", 0 );
			$result = $wpdb->get_results( $sql );

			foreach ( $result as $i => $item ) {
				if ( ! empty( $item->post_type ) AND ! in_array( $item->post_type, $exclude_taxo ) ) {
					$exclude_taxo[] = $item->post_type;
				}
			}

			$sql    = $wpdb->prepare(
					"SELECT term_taxonomy_id, taxonomy
					FROM $wpdb->term_taxonomy
					WHERE parent != %d", 0
					);
			$result = $wpdb->get_results( $sql );
			foreach ( $result as $i => $item ) {
				if ( ! in_array( $item->taxonomy , $exclude_taxo ) )
					$exclude_taxo[] = $item->taxonomy;
			}
			return $exclude_taxo;
		}

		/**
		 ** taxonomy without parent-child type
		 *
		 * @return string
		 */
		static function get_tax_no_parent() {
			global $wpdb;
			$arr_tax_no_parent = array();
			$sql = $wpdb->prepare( "SELECT taxonomy, parent FROM $wpdb->term_taxonomy WHERE 1 = %s", '1' );
			$result = $wpdb->get_results( $sql );

			$excluded = array();
			foreach ( $result as $i => $item ) {
				if ( ! in_array( $item->taxonomy, $excluded ) ) {
					if ( $item->parent == 0 AND ! in_array( $item->taxonomy, $arr_tax_no_parent ) ) {
						$arr_tax_no_parent[] = $item->taxonomy;
					} else if ( $item->parent != 0 AND in_array( $item->taxonomy, $arr_tax_no_parent ) ) {
						foreach ( $arr_tax_no_parent as $j => $_item ) {
							if ( $_item == $item->taxonomy ) {
								unset( $arr_tax_no_parent[$j] );
								$excluded[] = $item->taxonomy;
							}
						}
					}
				}
			}

			return implode( ',', $arr_tax_no_parent );
		}

		/**
		 ** public taxonomy options
		 *
		 * @param bool $is_full
		 *
		 * @return array
		 */
		static function get_public_taxonomies( $is_full = false ) {
			$arr_taxs = array();
			if ( ! $is_full ) {
				$taxs = get_taxonomies( array( 'public' => true, 'show_ui' => true ), 'objects' );
			} else {
				$taxs = get_taxonomies( null, 'objects' );
			}
			foreach ( $taxs as $i => $tax ) {
				if ( isset($tax->labels->singular_name ) && trim( $tax->labels->singular_name ) != '' ) {
					$arr_taxs[$tax->name] = __( $tax->labels->singular_name, WR_MEGAMENU_TEXTDOMAIN );
				}
			}
			return $arr_taxs;
		}

		/**
		 * Static function get post type options
		 *
		 * @param bool $allow_filter
		 *
		 * @return array
		 */
		static function get_post_types( $allow_filter = false ) {
			$arr_posts = array();
			$posts     = get_post_types( array( 'public' => true, 'show_ui' => true ), 'objects' );
			foreach ( $posts as $i => $post ) {
				if ( ! $allow_filter ) {
					if ( $post->name == 'attachment' ) continue;
					if ( isset($post->labels->singular_name ) && trim( $post->labels->singular_name ) != '' ) {
						$arr_posts[$post->name] = __( $post->labels->singular_name, WR_MEGAMENU_TEXTDOMAIN );
					}
				} else {
					$arr_posts[] = $post->name;
				}
			}
			return $arr_posts;
		}

		/**
		 * Private static function get exclude taxonomy array
		 *
		 * @return array
		 */
		private static function _get_exclude_tax() {
			global $wpdb;
			$exclude_taxo = array();

			$sql    = $wpdb->prepare( "SELECT DISTINCT( post_type ) FROM $wpdb->posts WHERE post_parent != 0", null );
			$result = $wpdb->get_results( $sql );

			foreach ( $result as $i => $item ) {
				if ( ! empty( $item->post_type ) AND ! in_array( $item->post_type, $exclude_taxo ) ) {
					$exclude_taxo[] = $item->post_type;
				}
			}
			return $exclude_taxo;
		}

		/**
		 * Private static function to get contentlist orderby array
		 *
		 * @return array
		 */
		private static function _get_ctl_order_by() {
			$arr_return = array();
			// setup for base post type
			$arr_return['post'] = array(
				'title'    => __( 'Title', WR_MEGAMENU_TEXTDOMAIN ),
				'comment_count' => __( 'Comment Count', WR_MEGAMENU_TEXTDOMAIN ),
				'date'     => __( 'Date', WR_MEGAMENU_TEXTDOMAIN )
			);
			$arr_return['page'] = array(
				'title'    => __( 'Title', WR_MEGAMENU_TEXTDOMAIN ),
				'comment_count' => __( 'Comment Count', WR_MEGAMENU_TEXTDOMAIN ),
				'date'     => __( 'Date', WR_MEGAMENU_TEXTDOMAIN )
			);

			$post_types = self::get_post_types();
			// setup for extend post type
			foreach ( $post_types as $slug => $post ) {
				if ( $slug ) {
					$arr_column = array();
					$arr_sort   = array(
						'title'    => 'title',
						'parent'   => 'parent',
						'comment_count' => 'comment_count',
						'date'     => array( 'date', true )
					);
					if ( has_filter( 'manage_edit-' . $slug . '_sortable_columns' ) ) {
						$arr_sort = array_merge( $arr_sort, apply_filters( 'manage_edit-' . $slug . '_sortable_columns', array() ) );
						if ( has_filter( 'manage_edit-' . $slug . '_columns' ) ) {
							$arr_column = apply_filters( 'manage_edit-' . $slug . '_columns', array() );
						}

						if ( $arr_sort AND $arr_column ) {
							$new_arr = array();
							foreach ( $arr_sort as $key => $value ) {
								foreach ( $arr_column as $_key => $_value ) {
									if ( $key == $_key ) {
										// process html
										if ( self::_is_html( $_value ) ) {
											$_value = substr( $_value, strpos( $_value, 'data-tip="' ) + 10 );
											$_value = substr( $_value, 0, strpos( $_value, '"' ) );
										}
										$new_arr[strtolower( $key )] = $_value;
									}
								}
							}
							$arr_return[$slug] = $new_arr;
						}
					}
				}
			}

			// setup for taxonomy
			$taxonomies = self::get_public_taxonomies();
			foreach ( $taxonomies as $slug => $tax ) {
				$arr_return[$slug] = array(
					'name'		=> __( 'Name', WR_MEGAMENU_TEXTDOMAIN ),
					'description' => __( 'Description', WR_MEGAMENU_TEXTDOMAIN ),
					'slug'		=> __( 'Slug', WR_MEGAMENU_TEXTDOMAIN ),
					'count'       => __( 'Count', WR_MEGAMENU_TEXTDOMAIN )
				);
			}

			return $arr_return;
		}

		/**
		 ** contentlist orderby options
		 *
		 * @param string $check_val
		 * @param array $attrs
		 * @return array
		 */
		static function get_list_ctl_order_by( $check_val, $attrs ) {
			$result = array();
			$data   = self::_get_ctl_order_by();
			foreach ( $data as $taxo => $terms ) {
				$tmp_arr = array();
				$tmp_arr['options'] = array_merge( array( 'no_order' => __( ' - No ordering - ', WR_MEGAMENU_TEXTDOMAIN ) ), $terms );
				$tmp_arr['no_order']   = '1';
				$tmp_arr['dependency'] = array( $check_val, '=', $taxo );
				$result[] = array_merge( $attrs, $tmp_arr );
			}

			return $result;
		}

		/**
		 ** contentlist order
		 *
		 * @return array
		 */
		static function get_ctl_order() {
			return array(
				'asc'	=> __( 'Ascending', WR_MEGAMENU_TEXTDOMAIN ),
				'desc'	=> __( 'Descending', WR_MEGAMENU_TEXTDOMAIN )
			);
		}

		/**
		 * Private static function to check context string is html type
		 *
		 * @param string $string
		 *
		 * @return boolean
		 */
		private static function _is_html( $string = '' ) {
			if ( $string ) {
				if ( strlen( $string ) != strlen( strip_tags( $string ) ) ) {
					return true; // Contains HTML
				}
			}

			return false;
		}

		/**
		 * Private static function to get menu item options
		 *
		 * @return array
		 */
		private static function _get_menu_items() {
			$nav_menu_items = $arr_options = array();
			$nav_menus = wp_get_nav_menus();
			if ( count( $nav_menus ) ) {
				foreach ( $nav_menus as $i => $menu ) {
					$nav_menu_items[$menu->term_id] = wp_get_nav_menu_items( $menu, null );
				}
			}
			if ( count( $nav_menu_items ) ) {
				foreach ( $nav_menu_items as $term_id => $items ) {
					$arr_options[$term_id]['root'] = __( 'Root', WR_MEGAMENU_TEXTDOMAIN );
					$level = 0;
					foreach ( $items as $i => $item ) {
						if ( $item->menu_item_parent == 0 ) {
							unset( $items[$i] );
							if ( ! $item->title ) {
								$item->title = __( '( no title )', WR_MEGAMENU_TEXTDOMAIN );
							}
							$arr_options[$term_id][$item->ID] = __( $item->title, WR_MEGAMENU_TEXTDOMAIN );
							self::_recur_tree( $arr_options, $items, $item->ID, $level, '-2', $term_id );
						}
					}
				}
			}
			return $arr_options;
		}

		/**
		 * menu item options
		 *
		 * @param string $check_val
		 * @param array $attrs
		 *
		 * @return array
		 */
		static function get_list_menu_items( $check_val, $attrs ) {
			$result = array();
			$data   = self::_get_menu_items();
			foreach ( $data as $taxo => $terms ) {
				$tmp_arr = array();
				$tmp_arr['options']    = $terms;
				$tmp_arr['no_order']   = '1';
				$tmp_arr['dependency'] = array( $check_val, '=', $taxo );
				$result[] = array_merge( $attrs, $tmp_arr );
			}

			return $result;
		}

		/**
		 * Static function to get pricing type of sub items
		 *
		 * @return array
		 */
		static function get_sub_item_pricing_type() {
			return array(
				'text' 		=> __( 'Free text', WR_MEGAMENU_TEXTDOMAIN ),
				'checkbox' 	=> __( 'Yes / No', WR_MEGAMENU_TEXTDOMAIN )
			);
		}

	}

}
?>
