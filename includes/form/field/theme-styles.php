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
 * Select selector field renderer.
*
* @package  WR_Megamenu
* @since    1.0.0
*/
class WR_Megamenu_Form_Field_Theme_Styles extends WR_Megamenu_Form_Field {
	/**
	 * Field type.
	 *
	 * @var  string
	 */
	protected $type = 'theme-styles';

	/**
	 * Supported content types.
	 *
	 * @var  array
	 */
	protected $choices = array();

	/**
	 * Constructor.
	 *
	 * @param   array  $config  Field declaration.
	 * @param   array  $merge   Array of property should be merged.
	 *
	 * @return  void
	 */
	public function __construct( $config, $merge = array( 'attributes', 'choices' ) ) {
		// Get all themes for mega menu
		$path = apply_filters( 'wr_megamenu_themes', WR_MEGAMENU_ROOT_PATH . 'themes' );

		$files = WR_Megamenu_Helpers_Functions::get_theme_styles( $path );
		$this->choices = $files;
		// Call parent method to do remaining initialization
		parent::__construct( $config, $merge );
	}

}
