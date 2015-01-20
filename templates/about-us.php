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

<div class="wrap">
	<div class="jsn-bootstrap3">
		<h2><strong><?php esc_html_e( 'Welcome to WR Mega Menu', WR_MEGAMENU_TEXTDOMAIN ); ?></strong></h2>
		<div class="wr-button-bar">
			<!-- <a class="btn btn-info wr-button" href="<?php echo admin_url( 'admin.php?page=wr-mm-settings' ); ?>">Settings</a> -->
			<a class="btn btn-info wr-button" href="http://bit.ly/wrmm-about-docs" target="_blank"><?php _e( 'Docs', WR_MEGAMENU_TEXTDOMAIN ); ?></a>
			<a href="https://twitter.com/WooRockets" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @WooRockets</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			<span class="wr-plugin-version"><?php _e( 'Version', WR_MEGAMENU_TEXTDOMAIN ); ?> <?php $plugin_data = get_plugin_data( WR_MEGAMENU_MAIN_FILE ); echo $plugin_data['Version']; ?>. <?php _e( 'Follow us to get latest updates!', WR_MEGAMENU_TEXTDOMAIN ); ?></span>
		</div>
		<p><?php _e( 'Thank you for installing! <strong>WR Mega Menu</strong> is your easy way to turn existing menu into a customizable mega menu in your WordPress website. User friendly, highly customizable and responsive, WR Mega Menu is simple to get started but powerful to create highly customized and creative mega menu configurations.', WR_MEGAMENU_TEXTDOMAIN ); ?></p>
		<div role="tabpanel">
			<ul class="nav nav-tabs wr-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#hot-features" aria-controls="hot-features" role="tab" data-toggle="tab"><?php _e( 'Hot Features', WR_MEGAMENU_TEXTDOMAIN ); ?></a>
				</li>
				<li role="presentation">
					<a href="#for-developers" aria-controls="for-developers" role="tab" data-toggle="tab"><?php _e( 'For Developers', WR_MEGAMENU_TEXTDOMAIN ); ?></a>
				</li>
				<li role="presentation">
					<a href="#for-translators" aria-controls="for-translators" role="tab" data-toggle="tab"><?php _e( 'For Translators', WR_MEGAMENU_TEXTDOMAIN ); ?></a>
				</li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="hot-features">
					<div class="feature-block">
						<h3><?php _e( 'Intuitive Layout', WR_MEGAMENU_TEXTDOMAIN ); ?></h3>
						<p><?php _e( 'Once installed, it’s located in the default WordPress main panel. To help you easily manage your menu, <strong>WR Mega Menu</strong> is designed with a simple and intuitive layout. You can easily select what kind of content to be shown in the submenu without going back to the front-end.', WR_MEGAMENU_TEXTDOMAIN ); ?></p>
					</div>
					<div class="feature-block">
						<h3><?php _e( 'Drag and Drop Layout', WR_MEGAMENU_TEXTDOMAIN ); ?></h3>
						<p><?php _e( 'Drag and drop is a convenient functionality for creating element in <strong>WR Mega Menu</strong>. You can easily arrange columns, move page elements into another position and even resize columns using just your mouse. You can also use the “Move button” on the sidebar to move rows up or down.', WR_MEGAMENU_TEXTDOMAIN ); ?></p>
					</div>
					<div class="feature-block">
						<h3><?php _e( 'Built-in elements', WR_MEGAMENU_TEXTDOMAIN ); ?></h3>
						<p><?php _e( 'We have created some predefined elements so you can choose the most suitable field and add as many elements as you want for your site without any coding. Interestingly, you can easily search these elements with the Spotlight Filter.', WR_MEGAMENU_TEXTDOMAIN ); ?></p>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="for-developers">
					<p><?php _e( 'If you are going to build Add-on for WR Mega Menu, this document is made for you. This part includes a knowledge base about WR Mega Menu, some basic APIs, and a tutorial to make a simple Add-on with a simple element.', WR_MEGAMENU_TEXTDOMAIN ); ?></p>
					<!-- <a class="btn btn-info wr-button" href="http://www.woorockets.com/docs/wr-megamenu-user-manual/" target="_blank">Docs for Developers</a> -->
					<p><?php _e( 'Get our Source Code at Github!', WR_MEGAMENU_TEXTDOMAIN ); ?></p>
					<a class="btn btn-info wr-button" href="http://bit.ly/wrmm-about-github" target="_blank"><?php _e( 'Source Code', WR_MEGAMENU_TEXTDOMAIN ); ?></a>
					<p><?php _e( 'Having any exciting ideas or improvements for WR Mega Menu to grow our WordPress Community? Drop an email to our WooRockets Astronaut Tony at', WR_MEGAMENU_TEXTDOMAIN ); ?> <a href="mailto:tony@woorockets.com">tony@woorockets.com</a>!</p>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="for-translators">
					<p><?php _e( 'If you are reading this, we need your contribution! We appreciate all kinds of support for Translating WR Mega Menu into your language!', WR_MEGAMENU_TEXTDOMAIN ); ?> <a href="http://bit.ly/wrmm-about-transifex" target="_blank"><?php _e( 'Translate WR Mega Menu', WR_MEGAMENU_TEXTDOMAIN ); ?></a>.</p>
				</div>
			</div>
		</div>
		<br />
		<br />
		<div class="wr-banner-wrapper">
			<h3><?php _e( 'See our other awesomeness', WR_MEGAMENU_TEXTDOMAIN ); ?></h3>
			<div class="wr-banner-l">
				<a href="http://www.woorockets.com/plugins/wr-megamenu/?utm_source=MegaMenu%20Setting&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins" target="_blank">
					<img src="<?php echo WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/banners/PageBuilder_S.jpg'; ?>" alt="WR Page Builder" />
				</a>
				<a href="http://www.woorockets.com/plugins/wr-contactform/?utm_source=MegaMenu%20Setting&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins" target="_blank">
					<img src="<?php echo WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/banners/ContactForm_S.jpg'; ?>" alt="WR Contact Form" />
				</a>
				<a href="http://www.woorockets.com/themes/corsa/?utm_source=MegaMenu%20Setting&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins" target="_blank">
					<img src="<?php echo WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/banners/Corsa_S.jpg'; ?>" alt="WR Corsa" />
				</a>
			</div>
		</div>
	</div>
</div>

<?php
// Load inline style
$style = '
	.jsn-bootstrap3 { max-width: 1148px; }
	.jsn-bootstrap3 .wr-tabs li a { font-size: 16px; }
	.jsn-bootstrap3 p { font-size: 14px; text-align: justify; }
	.jsn-bootstrap3 .wr-button { vertical-align: top !important; padding: 3px 12px !important; margin-right: 5px; margin-bottom: 10px !important; }
	.jsn-bootstrap3 .wr-button-bar { margin-bottom: 10px; }
	.jsn-bootstrap3 h3 { font-size: 20px !important; font-weight: bold !important; }
	.jsn-bootstrap3 #hot-features p { padding-left: 20px; }
	.jsn-bootstrap3 #hot-features .feature-block { background: #fff; border-radius: 8px; padding: 1px 20px 10px 20px; margin-top: 10px; }
	.jsn-bootstrap3 #for-developers > p:first-child, .jsn-bootstrap3 #for-translators > p:first-child { margin-top: 20px; }
	.jsn-bootstrap3 .translators-list a { text-decoration: underline; }
	.wr-banner-wrapper .wr-banner { float: left; line-height: 0; margin: 0px 10px 0px 10px; }
	.wr-banner-l a { text-decoration: none; }
	.wr-banner-l img { margin-right: 10px; }
	.wr-plugin-version { display: inline-block; vertical-align: top; margin: 5px 0px 0px 5px; font-size: 14px; }
';
WR_Megamenu_Init_Assets::inline( 'css', $style );
