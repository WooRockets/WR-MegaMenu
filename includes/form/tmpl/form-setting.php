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

$numSection = 0;
// Check if this is an Ajax request for specific form section
if ( empty( $section_id ) || ! isset( $_GET['ajax'] ) || ! $_GET['ajax'] ) :
?>
<form action="<?php echo esc_url( $this->action ); ?>" class="<?php esc_attr_e( empty( $alignment ) ? 'wr-form' : "wr-form form-{$alignment}" ); ?>" id="<?php esc_attr_e( $this->id ); ?>" method="POST" name="<?php esc_attr_e( $this->id ); ?>" role="form">
	<?php wp_nonce_field( $this->id ); ?>
	<div class="jsn-bootstrap3">
	<?php foreach ( $this->messages as $class => $message) : ?>
	<div class="alert alert-block<?php if ( 'alert' != $class ) esc_attr_e( " alert-{$class}" ); ?>">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php _e( $message, $this->text_domain ); ?>
	</div>
	<?php endforeach; ?>
	</div>
	<table class="form-table">
		<tbody>
<?php
endif;

$first = true;

foreach ( $this->fields as $sid => $section ) :
		
if ( ! isset( $_GET['ajax'] ) || ! $_GET['ajax'] || empty( $section_id ) || $section_id == $sid ) {
	// Load section template
	include WR_Megamenu_Loader::get_path( 'form/tmpl/section-setting.php' );
}

$first = false;
endforeach;

?>
	</tbody>
	</table>

	<?php if ( isset( $this->buttons ) ) : ?>
		<p class="submit">
			<?php foreach ( $this->buttons as $bid => $button ) : ?>
			<button class="<?php esc_attr_e( $button['class'] ); ?>" id="wr-form-action-<?php esc_attr_e( $bid ); ?>" type="<?php esc_attr_e( $button['type'] ); ?>">
				<?php _e( $button['label'], $this->text_domain ); ?>
			</button>
			<?php endforeach; ?>
		</p>
	<?php endif; ?>
</form>
<?php
// Print Javascript initialization
$script = '
		// Init form
		new $.WR_Form( ' . json_encode( array_merge( array( 'form_id' => esc_attr( $this->id ) ), array_combine( $js_init, array_map( 'is_string', $js_init ) ) ) ) . ' );';

WR_Megamenu_Init_Assets::inline( 'js', $script, true );
