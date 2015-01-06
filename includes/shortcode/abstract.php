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

abstract class WR_Megamenu_Shortcode_Abstract
{
	/**
	 * element type: layout/element
	 */
	public $type;

	/**
	 * config information of this element
	 */
	public $config;

	/**
	 * setting options of this element
	 */
	public $items;

	public function __construct() {

	}

	/*
	 * HTML structure of an element in SELECT ELEMENT modal box
	 */

	public function element_button( $sort ) {

	}

	/*
	 * HTML structure of an element in MegaMenu area
	 */

	public function element_in_megamenu() {

	}

}