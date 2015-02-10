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

/**
 * Form field renderer.
 *
 * @package  WR_Library
 * @since    1.0.0
 */
class WR_Megamenu_Form_Field {
	/**
	 * Array of instantiated object.
	 *
	 * @var  array
	 */
	protected static $instances = array();

	/**
	 * Field type.
	 *
	 * @var  string
	 */
	protected $type = 'text';

	/**
	 * Field identification.
	 *
	 * @var  string
	 */
	protected $id = null;

	/**
	 * Field name.
	 *
	 * @var  string
	 */
	protected $name = null;

	/**
	 * Field label.
	 *
	 * @var  string
	 */
	protected $label = null;

	/**
	 * Field description.
	 *
	 * @var  string
	 */
	protected $desc = null;

	/**
	 * Field placeholder.
	 *
	 * @var  string
	 */
	protected $placeholder = null;

	/**
	 * Default value.
	 *
	 * @var  mixed
	 */
	protected $default = null;

	/**
	 * Current field value.
	 *
	 * @var  mixed
	 */
	protected $value = null;

	/**
	 * Additional HTML attributes for input field element.
	 *
	 * @var  array
	 */
	protected $attributes = array(
		'autocomplete' => 'off',
		'class'        => 'form-control',
	);

	/**
	 * Text domain.
	 *
	 * @var  string
	 */
	protected $text_domain = WR_LIBRARY_TEXTDOMAIN;

	/**
	 * Instantiate a form field object.
	 *
	 * @param   array  $config  Field declaration.
	 * @param   array  $merge   Array of property should be merged.
	 *
	 * @return  WR_Megamenu_Form_Field
	 */
	public static function get_instance( $config, $merge = null ) {
		// Generate object id
		$id = md5( json_encode( array( $config, $merge ) ) );

		if ( ! isset( self::$instances[$id] ) ) {
			$class = __CLASS__;

			if ( isset( $config['type'] ) ) {
				// Generate name of form field class to be instantiated
				$class = explode( '-', $config['type'] );
				$class = array_map( 'ucfirst', $class );
				$class = __CLASS__ . '_' . implode( '_', $class );

				// Try to auto-load the class
				class_exists( $class, true ) || $class = __CLASS__;
			}

			// Instantiate a new field object
			if ( $merge && is_array( $merge ) ) {
				self::$instances[ $id ] = new $class( $config, $merge );
			} else {
				self::$instances[ $id ] = new $class( $config );
			}
		}

		return self::$instances[ $id ];
	}

	/**
	 * Constructor.
	 *
	 * @param   array  $config  Field declaration.
	 * @param   array  $merge   Array of property should be merged.
	 *
	 * @return  void
	 */
	public function __construct( $config, $merge = array( 'attributes' ) ) {
		$props = array_keys( get_object_vars( $this ) );

		foreach ( $config as $key => $value ) {
			if ( in_array( $key, $props ) ) {
				$this->{$key} = in_array( $key, $merge ) ? array_merge( $this->{$key}, ( array ) $value ) : $value;
			}
		}

		if ( is_null( $this->value ) && ! is_null( $this->default ) ) {
			$this->value = $this->default;
		}
	}

	/**
	 * Get value for a property.
	 *
	 * @param   string   $prop     Property to get value for.
	 * @param   mixed    $default  Default value if property is not set.
	 * @param   boolean  $return   Whether to return or print the value?
	 *
	 * @return  mixed
	 */
	public function get( $prop, $default = null, $return = false ) {
		if ( method_exists( $this, $prop ) ) {
			// Prepare arguments
			$args = func_get_args();

			// Remove first argument
			array_shift( $args );

			$default = call_user_func_array( array( $this, $prop ), $args );
		} elseif ( array_key_exists( $prop, get_object_vars( $this ) ) ) {
			$default = $this->{$prop};
		}

		if ( $return ) {
			return $default;
		} else {
			if ( preg_match( '/<[^\>]+>/', $default ) ) {
				echo '' . $default;
			} else {
				esc_attr_e( $default, $this->text_domain );
			}
		}
	}

	/**
	 * Generate HTML element id from field name.
	 *
	 * @return  string
	 */
	protected function id() {
		if ( ! isset( $this->id ) ) {
			$this->id = isset( $this->name ) ? trim( preg_replace( '/[^a-zA-Z0-9\-_]+/', '_', $this->name ), '_' ) : null;
		}

		return $this->id;
	}

	/**
	 * Translate label then return.
	 *
	 * @return  string
	 */
	protected function label() {
		return esc_html__( $this->label );
	}

	/**
	 * Render input field for user to interact with.
	 *
	 * @param   string  $tpl   Render field using this template.
	 *
	 * @return  string
	 */
	protected function input( $tpl = null ) {
		// Prepare field template
		if ( empty( $tpl ) ) {
			$tpl = $this->type;
		}

		// Preset HTML code
		$html = '';

		// Backup current field attributes to allow recursive call
		$backup = $this->attributes;

		// Get path to template file
		$file = WR_Megamenu_Loader::get_path( "form/field/tmpl/{$tpl}.php" );

		if ( empty( $file ) ) {
			$file = WR_Megamenu_Loader::get_path( 'form/field/tmpl/text.php' );
		}

		// Load field template
		ob_start();
		include $file;
		$html = ob_get_clean();

		// Restore field attributes
		$this->attributes = $backup;

		return $html;
	}

	/**
	 * Generate HTML attributes.
	 *
	 * @param   array    $ignore  Array of attribute should not be rendered.
	 * @param   boolean  $return  Whether to return or print the value?
	 *
	 * @return  string
	 */
	protected function html_attributes( $ignore = array(), $return = false ) {
		// Filter attributes
		$default = array(
			'id'          => $this->id(),
			'name'        => $this->name,
			'value'       => $this->value,
			'placeholder' => $this->placeholder,
		);

		if ( in_array( $this->type, array( 'checkbox', 'number', 'password', 'radio', 'text' ) ) && ! isset( $this->attributes['type'] ) ) {
			$this->attributes['type'] = $this->type;
		}

		$attrs = apply_filters( 'wr_form_field_attributes', array_merge( $default, $this->attributes ) );

		// Clean unnecessary attributes
		if ( ! is_array( $ignore ) ) {
			$ignore = array( $ignore );
		}

		if ( count( $ignore ) ) {
			foreach ( array_keys( $attrs ) as $key ) {
				if ( in_array( $key, $ignore ) ) {
					unset( $attrs[ $key ] );
				}
			}
		}

		// Generate HTML attributes
		$html = array();

		foreach ( $attrs as $key => $value ) {
			$html[] = esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
		}

		if ( $return ) {
			return implode( ' ', $html );
		} else {
			echo '' . implode( ' ', $html );
		}
	}
}
