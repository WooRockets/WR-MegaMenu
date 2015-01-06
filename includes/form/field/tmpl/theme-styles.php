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

?>
<div class="wr-form-field-theme-styles" id="<?php $this->get( 'id' ); ?>">
<?php
// Backup original attributes
$original_attrs = $this->attributes;
$multiple = ( isset( $this->attributes['multiple'] ) ) ? 'multiple="multiple"' : '';
?>
<select <?php $this->html_attributes( array( 'class', 'id' ) ); ?> <?php echo esc_html( $multiple ) ?> >
<?php
foreach ( $this->choices as $theme => $value ) :

// Update attributes
$value = $theme . '_' . $value;
//$this->attributes['value'] = $value;
$select = ( $this->value == $value ) ? 'selected="selected"' : '';
?>
<option value="<?php echo esc_attr( $value ) ?>" <?php echo esc_html( $select ) ?>><?php echo esc_html_e( $theme, $this->text_domain ) ?></option>
<?php
// Restore original attributes
$this->attributes = $original_attrs;
endforeach;
?>
</select>

</div>
