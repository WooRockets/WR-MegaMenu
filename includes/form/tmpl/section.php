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

// Check if this section has own template
$tmpl = WR_Megamenu_Loader::get_path( "form/tmpl/section/{$sid}.php" );

// Check if a specific section is requested
if ( empty( $section_id ) || $section_id == $sid ) :

if ( ! empty( $tmpl ) ) :
	include $tmpl;
else :
	if ( isset( $section['fields'] ) ) :
		$this->current_fields = $section['fields'];

		// Load fields template
		include WR_Megamenu_Loader::get_path( 'form/tmpl/fields.php' );
	endif;

	if ( isset( $section['fieldsets'] ) ) :
		$this->current_fieldsets = $section['fieldsets'];

		// Load fieldsets template
		include WR_Megamenu_Loader::get_path( 'form/tmpl/fieldsets.php' );
	endif;

	if ( isset( $section['accordion'] ) ) :
		$this->current_accordion = $section['accordion'];

		// Load accordion template
		include WR_Megamenu_Loader::get_path( 'form/tmpl/accordion.php' );
	endif;

	if ( isset( $section['tabs'] ) ) :
		$this->current_tabs = $section['tabs'];

		// Load tabs template
		include WR_Megamenu_Loader::get_path( 'form/tmpl/tabs.php' );
	endif;
endif;

endif;
