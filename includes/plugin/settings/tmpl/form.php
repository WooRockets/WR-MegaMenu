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
<div class="jsn-master">
	<div class="jsn-bootstrap3">
		<div class="jsn-pane jsn-bgpattern pattern-sidebar" id="wr-megamenu-settings-container">
			<h2 class="jsn-section-header"><?php _e( 'WR MegaMenu', WR_MEGAMENU_TEXTDOMAIN ); ?> - <?php _e( 'Settings', WR_MEGAMENU_TEXTDOMAIN ); ?></h2>
			<div class="jsn-section-content">
				<?php $form->render( 'horizontal', array( 'tabs', 'tips' ) ); ?>
			</div>
		</div>
	</div>
</div>
