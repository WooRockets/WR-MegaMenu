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

?>
<div class="wr-form-tabs">
	<ul class="nav nav-tabs clearfix">
		<?php $first = true; foreach ( $this->current_tabs as $tid => $tab ) : ?>
		<li<?php if ( $first ) : ?> class="active"<?php endif; ?>>
			<a data-toggle="tab" href="#wr-form-tab-<?php esc_attr_e( $tid ); ?>">
				<?php esc_html_e( isset( $tab['title'] ) ? $tab['title'] : $tid, $this->text_domain ); ?>
			</a>
		</li>
		<?php $first = false; endforeach; ?>
	</ul>

	<div class="tab-content">
		<?php $first = true; foreach ( $this->current_tabs as $tid => $tab ) : ?>
		<div class="tab-pane<?php if ($first) echo ' active'; ?>" id="wr-form-tab-<?php esc_attr_e( $tid ); ?>">
			<?php
			if ( isset( $tab['fields'] ) ) :
				$this->current_fields = $tab['fields'];

				// Load fields template
				include WR_Megamenu_Loader::get_path( 'form/tmpl/fields.php' );
			endif;

			if ( isset( $tab['fieldsets'] ) ) :
				$this->current_fieldsets = $tab['fieldsets'];

				// Load fieldsets template
				include WR_Megamenu_Loader::get_path( 'form/tmpl/fieldsets.php' );
			endif;

			if ( isset( $tab['accordion'] ) ) :
				$this->current_accordion = $tab['accordion'];

				// Load accordion template
				include WR_Megamenu_Loader::get_path( 'form/tmpl/accordion.php' );
			endif;
			?>
		</div>
		<?php $first = false; endforeach; ?>
	</div>
</div>
