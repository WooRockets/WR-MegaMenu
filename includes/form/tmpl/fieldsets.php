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

foreach ( $this->current_fieldsets as $fid => $fieldset ) :
?>
<fieldset id="wr-form-fieldset-<?php esc_attr_e( $fid ); ?>">
	<?php if ( isset( $fieldset['title'] ) ) : ?>
	<legend>
		<?php
		esc_html_e( $fieldset['title'], $this->text_domain );

		// Check if accordion toggler should be embeded
		if ( @$fieldset['accordion_toggler'] && isset( $fieldset['accordion'] ) ) :
		?>
		<span class="wr-form-fieldset-accordion-toggler">
			<a class="icon-minus collapse-all" title="<?php _e( 'Collapse All', $this->text_domain ); ?>"></a>
			<a class="icon-plus expand-all" title="<?php _e( 'Expand All', $this->text_domain ); ?>"></a>
		</span>
		<?php
		endif;

		// Check if field inputable switcher should be embeded
		if ( @$fieldset['state_switcher'] && ( isset( $fieldset['fields'] ) || isset( $fieldset['accordion'] ) ) ) :
			// Check if field inputable is enabled?
			$enabled = isset( $fieldset['fields'][ $fid ] ) ? $fieldset['fields'][ $fid ]->get( 'value', 1, true ) : true;
		?>
		<span class="wr-form-fieldset-state-switcher btn-group">
			<a class="btn btn-default<?php if ( $enabled ) echo ' btn-success disabled'; ?> turn-on"><?php _e( 'On', $this->text_domain ); ?></a>
			<a class="btn btn-default<?php if ( ! $enabled ) echo ' btn-danger disabled'; ?> turn-off"><?php _e( 'Off', $this->text_domain ); ?></a>
		</span>
		<?php
		endif;
		?>
	</legend>
	<?php endif; ?>

	<?php
	if ( isset( $fieldset['fields'] ) ) :
		$this->current_fields = $fieldset['fields'];

		// Load fields template
		include WR_Megamenu_Loader::get_path( 'form/tmpl/fields.php' );
	endif;

	if ( isset( $fieldset['accordion'] ) ) :
		$this->current_accordion = $fieldset['accordion'];

		// Load accordion template
		include WR_Megamenu_Loader::get_path( 'form/tmpl/accordion.php' );
	endif;
	?>
</fieldset>
<?php
endforeach;
