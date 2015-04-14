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

class WR_Megamenu_Helpers_Frontend {

	/**
	 * Generate the arguments needed to create navigation
	 * @param array $args
	 */
	public function get_args( $args = array() ) {
		$walker	= new WR_Megamenu_Walker();

		$defaults = array(
			'container'       => 'div',
			'container_class' => 'wr-megamenu-container jsn-bootstrap3 '.$args['theme_location'].'_'.$args['profile_id'].'',
			'container_id'    => '',
			'menu_class'      => 'wr-mega-menu nav-menu',
			'menu_id'         => 'wr-megamenu-menu-' . $args['menu_type'],
			'menu'            => $args['menu_type'],
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => $walker,
		);
		$args = array_merge( $args, $defaults );
		return $args;
	}
}