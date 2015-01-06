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

foreach ( $this->current_fields as $field ) :

// Get field description
$desc = $field->get( 'desc', null, true );

if ( $field->get( 'type', '', true ) == 'hidden' ) :

$field->get( 'input' );

elseif ( 'horizontal' == $alignment ) :
?>
	<div class="form-group clearfix">
		<?php if ( null != $field->get( 'label', null, true ) ) : ?>
		<label class="col-sm-2 control-label" for="<?php $field->get( 'id' ); ?>">
			<?php $field->get( 'label' ); ?>
			<i class="wr-form-field-help icon-help" data-toggle="tooltip" title="<?php $field->get( 'desc' ); ?>"></i>
		</label>
		<?php endif; ?>
		<div class="col-sm-10<?php if ( null == $field->get( 'label', null, true ) ) echo ' pull-right'; ?>">
			<?php $field->get( 'input' ); ?>
		</div>
	</div>
<?php else : ?>
	<div class="form-group">
		<label for="<?php $field->get( 'id' ); ?>">
			<?php $field->get( 'label' ); ?>
			<i class="wr-form-field-help icon-help" data-toggle="tooltip" title="<?php $field->get( 'desc' ); ?>"></i>
		</label>
		<?php $field->get( 'input' ); ?>
	</div>
<?php
endif;

endforeach;
