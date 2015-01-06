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

if ( isset( $_POST['wr_megamenu_settings'] ) ) {

	$settings = $_POST['wr_megamenu_settings'];
	// Validate input
	foreach ( $settings as $name => $value ) {
		if ( is_array( $value ) ) {
			$value = array_map( 'sanitize_text_field', $value );
		} else {
			$value = sanitize_text_field( $value );
		}

		$settings[$name] = $value;
	}

	// Save WooRockets customer account
	if ( ! empty( $settings['customer-username'] ) || ! empty( $settings['customer-password'] ) ) {
		update_option( 'wr_mm_customer_account', array( 'username' => $settings['customer-username'], 'password' => $settings['customer-password'] ) );

		// Skip saving WooRockets customer account along with other settings
		unset( $settings['customer-username'] );
		unset( $settings['customer-password'] );
	}

	// Save settings
	update_option( 'wr_megamenu_settings', $settings );


}

$username = '';
$password = '';
$customer_account = get_option( 'wr_mm_customer_account', null );

if ( ! empty( $customer_account ) ) {
	$username = $customer_account['username'];
	$password = $customer_account['password'];
}
?>

<div class="wrap">
	<h2><?php _e( 'WR MegaMenu Settings', WR_MEGAMENU_TEXTDOMAIN ); ?></h2>
	<?php if ( ! empty( $_POST ) ) { ?>
		<div class="updated below-h2" id="message"><p>Settings updated.</p></div>
	<?php } ?>
	<form method="POST" id="wr-megamenu-settings">
		<?php
		settings_fields( 'wr_megamenu_settings' );
		?>
		<table class="form-table">
			<tbody>
			<tr valign="top">
				<th scope="row"><?php __( 'WooRockets Customer Account', WR_MEGAMENU_TEXTDOMAIN ); ?></th>
				<td>
					<div>
						<label for="username">
							<?php __( 'Username:', WR_MEGAMENU_TEXTDOMAIN ); ?>
							<input type="text" autocomplete="off" name="wr_megamenu_settings[customer-username]"
								   id="username" class="input-xlarge" value="<?php echo esc_attr( $username ) ?>">
						</label>
						<label for="password">
							<?php __( 'Password:', WR_MEGAMENU_TEXTDOMAIN ); ?>
							<input type="password" autocomplete="off" name="wr_megamenu_settings[customer-password]"
								   id="password" class="input-xlarge" value="<?php echo esc_attr( $password ) ?>">
						</label>

						<p class="description">
							<?php __( 'Insert the customer account you registered on:', WR_MEGAMENU_TEXTDOMAIN ); ?>
							<a target="_blank"
							   href="http://www.woorockets.com">www.woorockets.com</a>. <?php __( 'This account is only required when you want to update commercial plugins purchased from woorockets.com.', WR_MEGAMENU_TEXTDOMAIN ); ?>
						</p>
					</div>
				</td>
			</tr>

			</tbody>
		</table>
		<p class="submit">
			<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
		</p>
	</form>
</div>