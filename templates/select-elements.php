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

global $wr_megamenu_element, $wr_megamenu_shortcodes, $Wr_Megamenu_By_Sc_Providers_Name;

// Arrray of element objects
$elements = $wr_megamenu_element->get_elements();

if ( empty ( $elements ) || empty ( $elements['element'] ) ) {
	_e( 'You have not install Free or Pro Shortcode package.' );
} else {

	$elements_html = array(); // HTML button of a shortcode
	$categories	   = array(); // array of shortcode category

	foreach ( $elements['element'] as $element ) {
		// don't show sub-shortcode
		if ( ! isset( $element->config['name'] ) ) {
			continue;
		}

		// get shortcode category
		$category = ''; // category name of this shortcode
		if ( ! empty( $wr_megamenu_shortcodes[ $element->config['shortcode'] ] ) ) {
			$category_name = $wr_megamenu_shortcodes[ $element->config['shortcode'] ]['provider']['name'] | '';
			$category      = strtolower( str_replace( ' ', '', $category_name ) );
			if ( ! array_key_exists( $category, $categories ) ) {
				$categories[$category] = $category_name;
			}
		}

		$elements_html[] = $element->element_button( $category );
	}
	?>
	<div id="wr-add-element" class="wr-add-element add-field-dialog jsn-bootstrap3" style="display: none;">
		<div class="jsn-elementselector">
				<div class="jsn-fieldset-filter">
					<fieldset>
						<div class="pull-left">
							<select id="jsn_filter_element" class="jsn-filter-button input-large">
								<optgroup label="<?php _e( 'Menu Elements', WR_MEGAMENU_TEXTDOMAIN ) ?>">
									<?php
	// Reorder the Categories of Elements
	$categories_order = array();
	if ( count( $categories ) > 1 ) {
		$categories_order['all'] = __( 'All Elements', WR_MEGAMENU_TEXTDOMAIN );
	}

	// add Standard Elements as second option
	$standard_el = __( 'Standard Elements', WR_MEGAMENU_TEXTDOMAIN );
	$key = array_search( $standard_el, $categories );
	$categories_order[$key] = $standard_el;

	unset( $key );

	// Sort other options by alphabetical order
	asort( $categories );
	$categories_order = array_merge( $categories_order, $categories );

	foreach ( $categories_order as $category => $name ) {
		$selected = ( $name == __( 'Standard Elements', WR_MEGAMENU_TEXTDOMAIN ) ) ? 'selected' : '';
		printf( '<option value="%s" %s>%s</option>', esc_attr( $category ), $selected, esc_html( $name ) );
	}
									?>
								</optgroup>
								<option value="widget"><?php _e( 'Widgets', WR_MEGAMENU_TEXTDOMAIN ) ?></option>
							</select>
						</div>
						<div class="pull-right jsn-quick-search" role="search">
							<input type="text" class="input form-control jsn-quicksearch-field"
								   placeholder="<?php _e( 'Search', WR_MEGAMENU_TEXTDOMAIN ); ?>...">
							<a href="javascript:void(0);"
							   title="<?php _e( 'Clear Search', WR_MEGAMENU_TEXTDOMAIN ); ?>"
							   class="jsn-reset-search" id="reset-search-btn"><i class="icon-remove"></i></a>
						</div>
					</fieldset>
				</div>
				<!-- Elements -->
				<ul class="jsn-items-list">
					<?php
	// shortcode elements
	foreach ( $elements_html as $idx => $element ) {
		echo balanceTags( $element );
	}

	// widgets
	global $wr_megamenu_widgets;
	foreach ( $wr_megamenu_widgets as $wg_class => $config ) {
		$extra_					= $config['extra_'];
		$config['edit_using_ajax'] = true;
		echo balanceTags( WR_Megamenu_Shortcode_Element::el_button( $extra_, $config ) );
	}
					?>
				</ul>				
			</div>
	</div>


	<?php
}
