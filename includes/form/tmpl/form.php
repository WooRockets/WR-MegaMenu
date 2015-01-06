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

if ( isset( $this->action ) ) : ?>
<form action="<?php echo esc_url( $this->action ); ?>" class="<?php esc_attr_e( empty( $alignment ) ? 'wr-form' : "wr-form form-{$alignment}" ); ?>" id="<?php esc_attr_e( $this->id ); ?>" method="POST" name="<?php esc_attr_e( $this->id ); ?>" role="form">
	<?php wp_nonce_field( $this->id ); ?>
<?php else : ?>
<div class="<?php esc_attr_e( empty( $alignment ) ? 'wr-form' : "wr-form form-{$alignment}" ); ?>" id="<?php esc_attr_e( $this->id ); ?>">
<?php endif; ?>
	<?php foreach ( $this->messages as $class => $message) : ?>
	<div class="alert alert-block<?php if ( 'alert' != $class ) esc_attr_e( " alert-{$class}" ); ?>">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php _e( $message, $this->text_domain ); ?>
	</div>
	<?php endforeach; ?>
	<div class="wr-form-sections">
		<?php if ( $numSection > 1 ) : ?>
		<ul class="nav nav-tabs clearfix">
			<?php $first = true; foreach ( $this->fields as $sid => $section ) : ?>
			<li<?php if ( $first ) : ?> class="active"<?php endif; ?>>
				<a data-toggle="tab" href="#wr-form-section-<?php esc_attr_e( $sid ); ?>">
					<?php _e( isset( $section['title'] ) ? $section['title'] : $sid, $this->text_domain ); ?>
				</a>
			</li>
			<?php $first = false; endforeach; ?>
		</ul>

		<div class="tab-content">
		<?php endif; ?>
<?php
endif;

$first = true;

foreach ( $this->fields as $sid => $section ) :

if ( $numSection > 1 && empty( $section_id ) || ! isset( $_GET['ajax'] ) || ! $_GET['ajax'] ) :

// Check if this section has additional attributes
if ( isset( $section['attributes'] ) ) {
	foreach ( $section['attributes'] as $k => $v ) {
		$section['attributes'][$k] = esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
	}
}
?>
			<div class="tab-pane<?php if ($first) echo ' active'; ?>" id="wr-form-section-<?php esc_attr_e( $sid ); ?>"<?php if ( isset( $section['attributes'] ) ) echo ' ' . implode( ' ', $section['attributes'] ); ?>>
<?php
endif;

// Load section template
if ( ! isset( $_GET['ajax'] ) || ! $_GET['ajax'] || empty($section_id) || $section_id == $sid ) {
	include WR_Megamenu_Loader::get_path( 'form/tmpl/section.php' );
}

if ( $numSection > 1 && empty( $section_id ) || ! isset( $_GET['ajax'] ) || ! $_GET['ajax'] ) :
?>
			</div>
<?php
endif;

$first = false;

endforeach;

// Check if this is an Ajax request for specific form section
if ( empty( $section_id ) || ! isset( $_GET['ajax'] ) || ! $_GET['ajax'] ) :
?>
	</div>
<?php if ( ! isset( $this->action ) ) : ?>
</div>
<?php else : ?>
	<?php if ( isset( $this->buttons ) ) : ?>
	<div class="form-actions">
		<?php foreach ( $this->buttons as $bid => $button ) : ?>
		<button class="<?php esc_attr_e( $button['class'] ); ?>" id="wr-form-action-<?php esc_attr_e( $bid ); ?>" type="<?php esc_attr_e( $button['type'] ); ?>">
			<?php _e( $button['label'], $this->text_domain ); ?>
		</button>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</form>
<?php endif; ?>
<?php
// Print Javascript initialization
$script = '
		// Init form
		new $.WR_Form( ' . json_encode( array_merge( array( 'form_id' => esc_attr( $this->id ) ), array_combine( $js_init, array_map( 'is_string', $js_init ) ) ) ) . ' );';

WR_Megamenu_Init_Assets::inline( 'js', $script, true );

endif;

// Exit immediately if this is an Ajax request
if ( isset( $_GET['ajax'] ) && $_GET['ajax'] ) {
	exit;
}
