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

class WR_Megamenu_Gadget_Duplicate_Profile extends WR_Megamenu_Gadget_Base {
	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'duplicate-profile';

	/**
	 * Load form for editing WR MegaMenu element.
	 *
	 * @return  void
	 */
	public function duplicate_action() {

		$profile_id       = $_GET['profile_id'];
		$post             = get_post( $profile_id );
		$post_title       = $post->post_title . ' - copy';
		$post->ID         = 0;
		$post->post_title = $post_title;
		$post->post_name  = sanitize_title( $post_title );

		$id = wp_insert_post( $post );

		if ( $id ) {
			$old_data     = get_post_meta( $profile_id, WR_MEGAMENU_META_KEY, true );
			$old_themes_options = addslashes( get_post_meta( $profile_id, WR_MEGAMENU_META_KEY . '_themes_options', true ) );
			$old_location = get_post_meta( $profile_id, '_wr_megamenu_profile_location_', true );

			update_post_meta( $id, WR_MEGAMENU_META_KEY, $old_data );
			update_post_meta( $id, WR_MEGAMENU_META_KEY . '_themes_options', $old_themes_options );
			update_post_meta( $id, '_wr_megamenu_profile_location_', $old_location );

			wp_redirect( add_query_arg( array( 'updated' => 1, 'profile_id' => $profile_id ), admin_url( 'edit.php?post_type=wr_megamenu_profile' ) ) );
		}

		exit();
	}


}
