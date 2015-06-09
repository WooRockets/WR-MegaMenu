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

	wp_enqueue_style( 'wr-megamenu_about_us', WR_MEGAMENU_ROOT_URL . 'assets/woorockets/css/about-us.css' );

	// Get array list of dismissed pointers for current user and convert it to array
	$dismissed_pointers_thank = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

	if( !in_array( 'wr_pb_settings_pointer_megamenu_thank_installing', $dismissed_pointers_thank ) ){
		// Load inline style
		$style = '
			html.wp-toolbar{padding-top: 102px; }
			#wpadminbar{top:70px; }
			#wr-header{position: fixed; top: 0; width: 100%; left: 0; background: #0074a2; height: 70px; z-index: 1; }
			#wr-header .wr-logoheader{float: left; height: 100%; border-right: 1px solid #0080b1; background: #005d82; margin: 0 15px 0 0; }
			#wr-header .wr-logoheader img{margin: 13px 10px 0; }
			#wr-header p{font-size: 14px; color: #FFF; padding: 0 50px 0 0; display: table-cell; height: 70px; vertical-align: middle; }
			#wr-header p a{color: #6BD8FF; text-decoration: none; }
			#wr-header p a:hover{text-decoration: underline; color: #C1EFFF; }
			#wr-header #close-header{float: right; margin: -47px 20px 0 0; font-size: 28px; color: rgba(0,0,0,0.3); cursor: pointer; }
			#wr-header #close-header:hover{color: rgba(0,0,0,1); }
			@media screen and (max-width:600px){
				#wr-header {height: 172px; }
			}
		';
		WR_Megamenu_Init_Assets::inline( 'css', $style );

?>

		<div id="wr-header">
			<a class="wr-logoheader" target="_blank" href="http://www.woorockets.com/?utm_source=MegaMenu%20About&utm_medium=top%20logo&utm_campaign=Cross%20Promo%20Plugins"><img src="<?php echo WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/about-us/logo-header.png'; ?>" alt="woorockets.com" /></a>
			<p><?php printf(__('Thank you for installing WR Mega Menu from WooRockets Team! We are making new hi-quality themes and plugins for you ;) Follow us on <a href="%s" target="_blank" >Twitter</a> or <a href="%s" target="_blank" >Subscribe</a> to our email list and be the first to get updated.', WR_MEGAMENU_TEXTDOMAIN ) , 'http://bit.ly/wr-freebie-twitter', 'http://www.woorockets.com/?utm_source=MegaMenu%20Setting&utm_medium=banner-link&utm_campaign=Cross%20Promo%20Plugins#subscribe'); ?></p>
			<span id="close-header" class="dashicons dashicons-no"></span>
		</div>

		<script type="text/javascript">
			jQuery(document).ready( function($) {
				$("#wr-header #close-header").click(function(){

					$.post( ajaxurl, {
						pointer: "wr_pb_settings_pointer_megamenu_thank_installing", // pointer ID
						action: "dismiss-wp-pointer"
					});

					$("#wr-header").hide();
					$("html.wp-toolbar").css({'padding-top' : '32px'});
					$("#wpadminbar").css({'top' : 0});
					
				})
			});
		</script>

<?php 
	}
?>

<div class="wr-wrap">
	<div id="wr-about">
		<div class="logo-about"><img src="<?php echo WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/about-us/logo.png'; ?>" /></div>
		<div class="content-about">
			<h1><?php _e( 'About WR Mega Menu', WR_MEGAMENU_TEXTDOMAIN ); ?></h1>
			<div class="description">
				<p><?php _e( '<strong>WR Mega Menu</strong> is the simplest tool to create a beautiful menu on your website. It is fully responsive, easy to drag-and-drop and totally in control with few clicks.', WR_MEGAMENU_TEXTDOMAIN ); ?></p>
			</div>
			<div class="info">
				<strong class="version"><?php _e( 'Current version', WR_MEGAMENU_TEXTDOMAIN ); ?>: <?php $plugin_data = get_plugin_data( WR_MEGAMENU_MAIN_FILE ); echo $plugin_data['Version']; ?> (<a target="_blank" href="http://bit.ly/wrmm-about-changelog"><?php _e( 'Change log', WR_MEGAMENU_TEXTDOMAIN ); ?></a>)</strong>
				<p><?php _e( 'Follow us to get latest updates', WR_MEGAMENU_TEXTDOMAIN ); ?>!</p>
				<a href="https://twitter.com/WooRockets" class="twitter-follow-button" data-show-count="false" data-size="large"><?php _e( 'Follow', WR_MEGAMENU_TEXTDOMAIN ); ?> @WooRockets</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</div>
		</div>
	</div>

	<div id="email-features">
		<div class="left-feature">
			<div class="box-email">
				<form action="http://www.woorockets.com/wp-content/plugins/newsletter/do/subscribe.php" method="POST">
					<input type="hidden" value="from-mm" name="nr">
					<input class="txt" type="email" name="ne" required placeholder="<?php _e( 'Enter your email', WR_MEGAMENU_TEXTDOMAIN ); ?>..." />
					<input class="btn" type="submit" value=" " />
				</form>
				<h3><?php _e( 'Join our mailing list', WR_MEGAMENU_TEXTDOMAIN ); ?></h3>
				<p><?php _e( 'Receive the latest updates about WR Mega Menu as well as all the best news from WooRockets', WR_MEGAMENU_TEXTDOMAIN ); ?></p>
			</div>
			<div class="box-document">
				<a target="_black" class="link" href="http://www.woorockets.com/docs/wr-megamenu-user-manual/?utm_source=MegaMenu%20About&utm_medium=link&utm_campaign=Cross%20Promo%20Plugins"></a>
				<img src="<?php echo WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/about-us/support.png'; ?>" />
				<h3><?php _e( 'Documentation', WR_MEGAMENU_TEXTDOMAIN ); ?></h3>
				<p><?php _e( 'Detailed construction of how to use WR Mega Menu', WR_MEGAMENU_TEXTDOMAIN ); ?></p>
			</div>
		</div>
		<div class="right-feature">
			<div role="tabpanel">
				<ul class="nav nav-tabs wr-pb-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#hot-features" aria-controls="hot-features" role="tab" data-toggle="tab"><?php _e( 'Hot Features', WR_MEGAMENU_TEXTDOMAIN ); ?></a>
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
					<div role="tabpanel" class="tab-pane fade" id="for-translators">
						<p><?php _e( 'If you are reading this, we need your contribution! We appreciate all kinds of support for Translating WR Mega Menu into your language!', WR_MEGAMENU_TEXTDOMAIN ); ?> <a href="http://bit.ly/wrmm-about-transifex" target="_blank"><?php _e( 'Translate WR Mega Menu', WR_MEGAMENU_TEXTDOMAIN ); ?></a>.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="get-involved">
		<h2><?php _e( 'GET INVOLVED', WR_MEGAMENU_TEXTDOMAIN ); ?></h2>
		<div class="list-involved">
			<div class="item-involved">
				<div class="item-involved-inner">
					<div class="icon-involved"><span class="dashicons dashicons-star-filled"></span><strong><?php _e( 'Rate WR Mega Menu', WR_MEGAMENU_TEXTDOMAIN ); ?></strong></div>
					<p><?php _e( 'Share your thoughts of WR Mega Menu with other WordPress folks. Next versions of WR Mega Menu will be improved basing on your opinions.', WR_MEGAMENU_TEXTDOMAIN ); ?></p>
				</div>
			</div>
			<div class="item-involved">
				<div class="item-involved-inner">
					<div class="icon-involved"><span class="dashicons dashicons-desktop"></span><strong><?php _e( 'Submit your Website', WR_MEGAMENU_TEXTDOMAIN ); ?></strong></div>
					<p><?php _e( "Share your website using WR Mega Menu with us. We can include it in our showcase collection and have it exposed to thousands of WooRockets's website visitors.", WR_MEGAMENU_TEXTDOMAIN ); ?></p>
				</div>
			</div>
		</div>
		<div class="list-involved">
			<div class="item-involved">
				<div class="item-involved-inner">
					<a target="_blank" class="button-primary" href="http://bit.ly/wrmm-about-rate"><?php _e( 'Review', WR_MEGAMENU_TEXTDOMAIN ); ?></a>
				</div>
			</div>
			<div class="item-involved">
				<div class="item-involved-inner">
					<a target="_blank" class="button-primary" href="http://www.woorockets.com/contact/?utm_source=MegaMenu%20About&utm_medium=button&utm_campaign=Cross%20Promo%20Plugins"><?php _e( 'Submit your website', WR_MEGAMENU_TEXTDOMAIN ); ?></a>
				</div>
			</div>
		</div>
	</div>

	<div id="wr-promo-ab">
			<h3>Premium<br>
			WooCommerce Themes</h3>
			<ul>
				<li><span><img src="<?php echo WR_MEGAMENU_ROOT_URL; ?>assets/woorockets/images/about-us/excellent-icon.png"></span>Excellent designs</li>
				<li><span><img src="<?php echo WR_MEGAMENU_ROOT_URL; ?>assets/woorockets/images/about-us/unlimited-icon.png"></span>Unlimited customization ability</li>
				<li><span><img src="<?php echo WR_MEGAMENU_ROOT_URL; ?>assets/woorockets/images/about-us/additional-icon.png"></span>Additional eCommerce features</li>
			</ul>
			<p class="btn-premium"><a href="http://www.woorockets.com/themes/?utm_source=MegaMenu&utm_medium=About&utm_campaign=Cross%20Promo%20Banner" target="_blank"><strong>View the collection now</strong><br>
			<span>And learn how our themes can boost your business!</span></a></p>
	</div>

	<div id="wr-logo">
		<a target="_blank" href="http://www.woorockets.com/?utm_source=MegaMenu%20About&utm_medium=bot%20logo&utm_campaign=Cross%20Promo%20Plugins" class="link"></a>
		<img src="<?php echo WR_MEGAMENU_ROOT_URL . 'assets/woorockets/images/about-us/logo-footer.png'; ?>" />
		<h3>www.woorockets.com</h3>
	</div>

</div>

<script type="text/javascript">
	(function($) {
		$(document).ready(function() {
			$('#email-features .left-feature .box-email form .txt').focus(function () {
				$('#email-features .left-feature .box-email form').addClass('focus');
			})
			$('#email-features .left-feature .box-email form .txt').blur(function () {
				$('#email-features .left-feature .box-email form').removeClass('focus');
			})
		});
	})(jQuery);
</script>