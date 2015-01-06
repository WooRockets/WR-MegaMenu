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

// Generate an unique id for accordion container
$accordion_container_id = rand();
?>
<div class="panel-group" id="wr-form-accordion-<?php esc_attr_e( $accordion_container_id ); ?>">
<?php $first = true; foreach ( $this->current_accordion as $aid => $accordion ) : ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="<?php if ( ! $first ) echo 'collapsed'; ?>" data-toggle="collapse" data-parent="#wr-form-accordion-<?php esc_attr_e( $accordion_container_id ); ?>" href="#wr_<?php esc_attr_e( $aid ); ?>">
					<?php esc_html_e( isset( $accordion['title'] ) ? $accordion['title'] : $aid, IT_THEME_TEXTDOMAIN ); ?>
				</a>
			</h4>
		</div>
		<div id="wr_<?php esc_attr_e( $aid ); ?>" class="panel-collapse collapse <?php if ( $first ) echo 'in'; ?>">
			<div class="panel-body">
				<?php
				if ( isset( $accordion['fields'] ) ) :
					$this->current_fields = $accordion['fields'];

					// Load fields template
					include WR_Megamenu_Loader::get_path( 'form/tmpl/fields.php' );
				endif;

				if ( isset( $accordion['fieldsets'] ) ) :
					$this->current_fieldsets = $accordion['fieldsets'];

					// Load fieldsets template
					include WR_Megamenu_Loader::get_path( 'form/tmpl/fieldsets.php' );
				endif;
				?>
			</div>
		</div>
	</div>
<?php $first = false; endforeach; ?>
</div>
