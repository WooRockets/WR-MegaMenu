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

// Define necessary attributes
if ( ! isset( $this->attributes['class'] ) || 'form-control' == $this->attributes['class'] ) {
	$this->attributes['class'] = 'btn btn-primary';
}

if ( ! isset( $this->attributes['type'] ) ) {
	$this->attributes['type'] = 'submit';
}
?>
<button <?php $this->html_attributes( array( 'autocomplete', 'placeholder', 'name', 'value' ) ); ?>><?php esc_html_e( $this->attributes['text'], $this->text_domain ); ?></button>
