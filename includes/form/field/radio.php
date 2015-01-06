<?php
/**
 * @version    $Id$
 * @package    WR_Library
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 * Technical Support:  Feedback - http://www.woorockets.com
 */

/**
 * Radio field renderer.
*
* @package  WR_Library
* @since    1.0.0
*/
class WR_Megamenu_Form_Field_Radio extends WR_Megamenu_Form_Field {
	/**
	 * Field type.
	 *
	 * @var  string
	 */
	protected $type = 'radio';

	/**
	 * Indicate whether checkbox(es) should be rendered inline or not?
	 *
	 * @var  boolean
	 */
	protected $inline = true;

	/**
	 * Check box options.
	 *
	 * @var  array
	 */
	protected $choices = array();
}
