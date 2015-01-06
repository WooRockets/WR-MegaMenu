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

else : ?>
    <tr valign="top">
        <th scope="row"><label for="<?php $field->get( 'id' ); ?>"><?php $field->get( 'label' ); ?></label></th>
        <td><?php $field->get( 'input' ); ?><p class="description"><?php $field->get( 'desc' ); ?></p></td>
    </tr>
<?php
endif;

endforeach;
