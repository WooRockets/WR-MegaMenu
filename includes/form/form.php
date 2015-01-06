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
 * Form processing.
 *
 * @package  WR_Library
 * @since    1.0.0
 */
class WR_Megamenu_Form {
	/**
	 * Array of instantiated class object.
	 *
	 * @var  array
	 */
	protected static $instances = array();

	/**
	 * Form id.
	 *
	 * @var  string
	 */
	protected $id = null;

	/**
	 * Fields declaration.
	 *
	 * @var  array
	 */
	protected $fields = array();

	/**
	 * Form messages.
	 *
	 * @var  array
	 */
	protected $messages = array();

	/**
	 * Name space.
	 *
	 * @var  string
	 */
	protected $name_space = null;

	/**
	 * Text domain.
	 *
	 * @var  string
	 */
	protected $text_domain = WR_LIBRARY_TEXTDOMAIN;

	/**
	 * Instantiate a WR_Megamenu_Form object then return.
	 *
	 * @param   string  $form_id  An unique string to identify object instance.
	 * @param   array   $fields   Form fields declaration.
	 *
	 * @return  WR_Megamenu_Form
	 */
	public static function get_instance( $form_id, $fields = array() ) {
		if ( ! isset( $instances[ $form_id ] ) ) {
			$instances[ $form_id ] = new WR_Megamenu_Form( $form_id, $fields );
		}

		return $instances[ $form_id ];
	}

	/**
	 * Constructor.
	 *
	 * @param   string  $form_id  An unique string to identify object instance.
	 * @param   array   $fields   Form fields declaration.
	 *
	 * @return  void
	 */
	public function __construct( $form_id, $fields = array() ) {
		$this->id = $form_id;

		if ( is_array( $fields ) && count( $fields ) ) {
			$this->setup_form( $fields );
		}
	}

	/**
	 * Setup form.
	 *
	 * @param   array    $fields    Fields declaration.
	 * @param   boolean  $override  Whether to remove existing form fields or not?
	 *
	 * @return  void
	 */
	public function setup_form( $fields, $override = false ) {
		// Filter form fields
		$fields = apply_filters( 'wr_setup_form', $fields );

		if ( $override ) {
			$this->fields = array();
		}

		// Set text domain
		if ( isset( $fields['text_domain'] ) ) {
			$this->text_domain = $fields['text_domain'];
		}

		// Set name space
		if ( isset( $fields['name_space'] ) ) {
			$this->name_space = $fields['name_space'];
		}

		// Add sections
		if ( isset( $fields['sections'] ) ) {
			$this->add_section( $fields['sections'] );
		}

		// Add tabs
		if ( isset( $fields['tabs'] ) ) {
			$this->add_tab( $fields['tabs'] );
		}

		// Add accordion
		if ( isset( $fields['accordions'] ) ) {
			$this->add_accordion( $fields['accordions'] );
		}

		// Add fieldsets
		if ( isset( $fields['fieldsets'] ) ) {
			$this->add_fieldset( $fields['fieldsets'] );
		}

		// Add fields
		if ( isset( $fields['fields'] ) ) {
			$this->add_field( $fields['fields'] );
		}

		// Set action
		if ( isset( $fields['action'] ) ) {
			$this->action = defined( 'WP_ADMIN' ) ? admin_url( $fields['action'] ) : site_url( $fields['action'] );
		}

		// Add messages
		if ( isset( $fields['messages'] ) ) {
			$this->messages = $fields['messages'];
		}

		// Add buttons
		if ( isset( $fields['buttons'] ) ) {
			foreach ( ( array ) $fields['buttons'] as $key => $button ) {
				// Prepare button attributes
				if ( ! is_array( $button ) ) {
					$button = array( 'label' => ( string ) $button );
				}

				if ( ! isset( $button['class'] ) ) {
					$button['class'] = 'btn';
				}

				if ( ! isset( $button['type'] ) ) {
					$button['type'] = 'button';
				}

				// Store button
				$this->buttons[ $key ] = $button;
			}
		}
	}

	/**
	 * Render form.
	 *
	 * @param   string   $alignment   Form alignment, either 'form-inline', 'form-horizontal' or leave empty for vertical alignment.
	 * @param   array    $js_init     Print Javascript initialization for which: tabs, accordion, tips?
	 * @param   string   $section_id  Which form section to render? Leave empty to render all sections by default.
	 *
	 * @return  void
	 */
	public function render( $alignment = null, $js_init = array( 'tips', 'accordions', 'tabs' ), $section_id = '' ) {
		// Do 'wr_pre_render_form' action
		do_action( 'wr_pre_render_form', $this );

		// Render all form sections or a specified one?
		if ( ! empty( $section_id ) && array_key_exists( $section_id, $this->fields ) ) {
			// Update Javascript initialization
			$js_init[] = 'ajax';

			// Backup current fields data
			$fields = $this->fields;

			// Remove data of unnecessary form section
			foreach ( array_keys( $this->fields ) as $sid ) {
				if ( $section_id != $sid ) {
					unset( $this->fields[ $sid ]['fields'   ] );
					unset( $this->fields[ $sid ]['fieldsets'] );
					unset( $this->fields[ $sid ]['accordion'] );
					unset( $this->fields[ $sid ]['tabs'     ] );
				}
			}
		}
		// Load assets
		WR_Megamenu_Init_Assets::load( array( 'wr-form-css', 'wr-form-js' ) );

		// Load form template
		if ( ! empty( $alignment ) ) {
			$tpl = WR_Megamenu_Loader::get_path( "form/tmpl/form-{$alignment}.php" );
		}

		if ( isset( $tpl ) && ! empty( $tpl ) ) {
			include $tpl;
		} else {
			include WR_Megamenu_Loader::get_path( 'form/tmpl/form.php' );
		}

		// Render all form sections or a specified one?
		if ( ! empty( $section_id ) && array_key_exists( $section_id, $this->fields ) ) {
			// Restore original fields data
			$this->fields = $fields;
		}

		// Do 'wr_post_render_form' action
		do_action( 'wr_post_render_form', $this );
	}

	/**
	 * Add sections.
	 *
	 * @param   string   $section_id     An unique string to identify this section.
	 * @param   array    $section_attrs  Section attributes, e.g. array( 'title' => 'Title', 'class' => 'Some classes' )
	 *
	 * @return  void
	 */
	protected function add_section( $section_id, $section_attrs = null ) {
		if ( is_array( $section_id ) ) {
			foreach ( $section_id as $id => $attrs ) {
				$this->add_section( $id, $attrs );
			}
		} else {
			if ( isset( $this->fields[ $section_id ] ) ) {
				// Section already exists, merge attributes
				$this->fields[ $section_id ] = array_merge( $this->fields[ $section_id ], $section_attrs );
			}

			$this->fields[ $section_id ] = $section_attrs;
		}
	}

	/**
	 * Add tabs.
	 *
	 * @param   string   $tab_id      An unique string to identify this tab.
	 * @param   array    $tab_attrs   Tab attributes, e.g. array( 'title' => 'Title', 'class' => 'Some classes' )
	 * @param   string   $section_id  Section to add tab to.
	 *
	 * @return  void
	 */
	protected function add_tab( $tab_id, $tab_attrs = null, $section_id = 'default' ) {
		if ( is_array( $tab_id ) ) {
			foreach ( $tab_id as $id => $attrs ) {
				// Build arguments
				$args   = array( $id, $attrs );
				$args[] = isset( $attrs['section_id'] ) ? $attrs['section_id'] : $section_id;

				// Add field
				call_user_func_array( array( $this, 'add_tab' ), $args );
			}
		} else {
			if ( @isset( $this->fields[ $section_id ]['tabs'][ $tab_id ] ) ) {
				// Tab already exists, merge attributes
				$tab_attrs = array_merge( $this->fields[ $section_id ]['tabs'][ $tab_id ], $tab_attrs );
			}

			$this->fields[ $section_id ]['tabs'][ $tab_id ] = $tab_attrs;
		}
	}

	/**
	 * Add accordions.
	 *
	 * @param   string   $accordion_id      An unique string to identify this accordion.
	 * @param   array    $accordion_attrs   Tab attributes, e.g. array( 'title' => 'Title', 'class' => 'Some classes' )
	 * @param   string   $section_id        Section to add accordion to.
	 * @param   string   $tab_id            Tab to add accordion to.
	 * @param   string   $fieldset_id       Fieldset to add accordion to.
	 *
	 * @return  void
	 */
	protected function add_accordion( $accordion_id, $accordion_attrs = null, $section_id = 'default', $tab_id = null, $fieldset_id = null ) {
		if ( is_array( $accordion_id ) ) {
			foreach ( $accordion_id as $id => $attrs ) {
				// Build arguments
				$args   = array( $id, $attrs );
				$args[] = isset( $attrs['section_id']  ) ? $attrs['section_id']  : $section_id;
				$args[] = isset( $attrs['tab_id']      ) ? $attrs['tab_id']      : $tab_id;
				$args[] = isset( $attrs['fieldset_id'] ) ? $attrs['fieldset_id'] : $fieldset_id;

				// Add field
				call_user_func_array( array( $this, 'add_accordion' ), $args );
			}
		} else {
			if ( empty( $tab_id ) && empty( $fieldset_id ) ) {
				if ( @isset( $this->fields[ $section_id ]['accordion'][ $accordion_id ] ) ) {
					// Accordion already exists, merge attributes
					$accordion_attrs = array_merge( $this->fields[ $section_id ]['accordion'][ $accordion_id ], $accordion_attrs );
				}

				$this->fields[ $section_id ]['accordion'][ $accordion_id ] = $accordion_attrs;
			} elseif ( empty( $fieldset_id ) ) {
				if ( @isset( $this->fields[ $section_id ]['tabs'][ $tab_id ]['accordion'][ $accordion_id ] ) ) {
					// Accordion already exists, merge attributes
					$accordion_attrs = array_merge( $this->fields[ $section_id ]['tabs'][ $tab_id ]['accordion'][ $accordion_id ], $accordion_attrs );
				}

				$this->fields[ $section_id ]['tabs'][ $tab_id ]['accordion'][ $accordion_id ] = $accordion_attrs;
			} elseif ( empty( $tab_id ) ) {
				if ( @isset( $this->fields[ $section_id ]['fieldsets'][ $fieldset_id ]['accordion'][ $accordion_id ] ) ) {
					// Accordion already exists, merge attributes
					$accordion_attrs = array_merge( $this->fields[ $section_id ]['fieldsets'][ $fieldset_id ]['accordion'][ $accordion_id ], $accordion_attrs );
				}

				$this->fields[ $section_id ]['fieldsets'][ $fieldset_id ]['accordion'][ $accordion_id ] = $accordion_attrs;
			} else {
				if ( @isset( $this->fields[ $section_id ]['tabs'][ $tab_id ]['fieldsets'][ $fieldset_id ]['accordion'][ $accordion_id ] ) ) {
					// Accordion already exists, merge attributes
					$accordion_attrs = array_merge( $this->fields[ $section_id ]['tabs'][ $tab_id ]['fieldsets'][ $fieldset_id ]['accordion'][ $accordion_id ], $accordion_attrs );
				}

				$this->fields[ $section_id ]['tabs'][ $tab_id ]['fieldsets'][ $fieldset_id ]['accordion'][ $accordion_id ] = $accordion_attrs;
			}
		}
	}

	/**
	 * Add fieldsets.
	 *
	 * @param   string   $fieldset_id     An unique string to identify this tab.
	 * @param   array    $fieldset_attrs  Fieldset attributes, e.g. array( 'title' => 'Title', 'class' => 'Some classes' )
	 * @param   string   $section_id      Section to add fieldset to.
	 * @param   string   $tab_id          Tab to add fieldset to.
	 * @param   string   $accordion_id    Accordion to add fieldset to.
	 *
	 * @return  void
	 */
	protected function add_fieldset( $fieldset_id, $fieldset_attrs = null, $section_id = 'default', $tab_id = null, $accordion_id = null ) {
		if ( is_array( $fieldset_id ) ) {
			foreach ( $fieldset_id as $id => $attrs ) {
				// Build arguments
				$args   = array( $id, $attrs );
				$args[] = isset( $attrs['section_id'] )   ? $attrs['section_id']   : $section_id;
				$args[] = isset( $attrs['tab_id'] )       ? $attrs['tab_id']       : $tab_id;
				$args[] = isset( $attrs['accordion_id'] ) ? $attrs['accordion_id'] : $accordion_id;

				// Add field
				call_user_func_array( array( $this, 'add_fieldset' ), $args );
			}
		} else {
			if ( empty( $tab_id ) && empty( $accordion_id ) ) {
				if ( @isset( $this->fields[ $section_id ]['fieldsets'][ $fieldset_id ] ) ) {
					// Fieldset already exists, merge attributes
					$fieldset_attrs = array_merge( $this->fields[ $section_id ]['fieldsets'][ $fieldset_id ], $fieldset_attrs );
				}

				$this->fields[ $section_id ]['fieldsets'][ $fieldset_id ] = $fieldset_attrs;
			} elseif ( empty( $accordion_id ) ) {
				if ( @isset( $this->fields[ $section_id ]['tabs'][ $tab_id ]['fieldsets'][ $fieldset_id ] ) ) {
					// Fieldset already exists, merge attributes
					$fieldset_attrs = array_merge( $this->fields[ $section_id ]['tabs'][ $tab_id ]['fieldsets'][ $fieldset_id ], $fieldset_attrs );
				}

				$this->fields[ $section_id ]['tabs'][ $tab_id ]['fieldsets'][ $fieldset_id ] = $fieldset_attrs;
			} elseif ( empty( $tab_id ) ) {
				if ( @isset( $this->fields[ $section_id ]['accordion'][ $accordion_id ]['fieldsets'][ $fieldset_id ] ) ) {
					// Fieldset already exists, merge attributes
					$fieldset_attrs = array_merge( $this->fields[ $section_id ]['accordion'][ $accordion_id ]['fieldsets'][ $fieldset_id ], $fieldset_attrs );
				}

				$this->fields[ $section_id ]['accordion'][ $accordion_id ]['fieldsets'][ $fieldset_id ] = $fieldset_attrs;
			} else {
				if ( @isset( $this->fields[ $section_id ]['tabs'][ $tab_id ]['accordion'][ $accordion_id ]['fieldsets'][ $fieldset_id ] ) ) {
					// Fieldset already exists, merge attributes
					$fieldset_attrs = array_merge( $this->fields[ $section_id ]['tabs'][ $tab_id ]['accordion'][ $accordion_id ]['fieldsets'][ $fieldset_id ], $fieldset_attrs );
				}

				$this->fields[ $section_id ]['tabs'][ $tab_id ]['accordion'][ $accordion_id ]['fieldsets'][ $fieldset_id ] = $fieldset_attrs;
			}
		}
	}

	/**
	 * Add fields.
	 *
	 * @param   string  $field_id      Field object.
	 * @param   array   $field_attrs   Fieldset attributes, e.g. array( 'title' => 'Title', 'class' => 'Some classes' )
	 * @param   string  $section_id    Section to add field to.
	 * @param   string  $fieldset_id   Fieldset to add field to.
	 * @param   string  $tab_id        Tab to add field to.
	 * @param   string  $accordion_id  Accordion to add field to.
	 *
	 * @return  void
	 */
	protected function add_field( $field_id, $field_attrs = null, $section_id = 'default', $fieldset_id = null, $tab_id = null, $accordion_id = null ) {
		if ( is_array( $field_id ) ) {
			foreach ( $field_id as $id => $attrs ) {
				// Build arguments
				$args   = array( $id, $attrs );
				$args[] = isset( $attrs['section_id'] )   ? $attrs['section_id']   : $section_id;
				$args[] = isset( $attrs['fieldset_id'] )  ? $attrs['fieldset_id']  : $fieldset_id;
				$args[] = isset( $attrs['tab_id'] )       ? $attrs['tab_id']       : $tab_id;
				$args[] = isset( $attrs['accordion_id'] ) ? $attrs['accordion_id'] : $accordion_id;

				// Add field
				call_user_func_array( array( $this, 'add_field' ), $args );
			}
		} else {
			// Prepare field attributes
			if ( ! isset( $field_attrs['name'] ) ) {
				$field_attrs['name'] = $field_id;
			}

			if ( ! empty( $this->name_space ) ) {
				$field_attrs['name'] = "{$this->name_space}[{$field_attrs['name']}]";
			}

			if ( ! isset( $field_attrs['text_domain'] ) && WR_LIBRARY_TEXTDOMAIN != $this->text_domain ) {
				$field_attrs['text_domain'] = $this->text_domain;
			}

			if ( strpos( $field_id, 'wr-form-field-' ) === false ){
				$field_id = "wr-form-field-{$field_id}";
			}

			if ( ! isset( $field_attrs['id'] ) ) {
				$field_attrs['id'] = $field_id;
			} else {
				$field_id = $field_attrs['id'];
			}

			// Instantiate field renderer
			$field = WR_Megamenu_Form_Field::get_instance( $field_attrs );

			if ( empty( $tab_id ) ) {
				if ( empty( $accordion_id ) ) {
					if ( empty( $fieldset_id ) ) {
						$this->fields[ $section_id ]['fields'][ $field_id ] = $field;
					} else {
						$this->fields[ $section_id ]['fieldsets'][ $fieldset_id ]['fields'][ $field_id ] = $field;
					}
				} else {
					if ( empty( $fieldset_id ) ) {
						$this->fields[ $section_id ]['accordion'][ $accordion_id ]['fields'][ $field_id ] = $field;
					} else {
						if ( isset( $this->fields[ $section_id ]['accordion'][ $accordion_id ]['fieldsets'][ $fieldset_id ] ) ) {
							$this->fields[ $section_id ]['accordion'][ $accordion_id ]['fieldsets'][ $fieldset_id ]['fields'][ $field_id ] = $field;
						} elseif ( isset( $this->fields[ $section_id ]['fieldsets'][ $fieldset_id ]['accordion'][ $accordion_id ] ) ) {
							$this->fields[ $section_id ]['fieldsets'][ $fieldset_id ]['accordion'][ $accordion_id ]['fields'][ $field_id ] = $field;
						}
					}
				}
			} else {
				if ( empty( $accordion_id ) ) {
					if ( empty( $fieldset_id ) ) {
						$this->fields[ $section_id ]['tabs'][ $tab_id ]['fields'][ $field_id ] = $field;
					} else {
						$this->fields[ $section_id ]['tabs'][ $tab_id ]['fieldsets'][ $fieldset_id ]['fields'][ $field_id ] = $field;
					}
				} else {
					if ( empty( $fieldset_id ) ) {
						$this->fields[ $section_id ]['tabs'][ $tab_id ]['accordion'][ $accordion_id ]['fields'][ $field_id ] = $field;
					} else {
						if ( isset( $this->fields[ $section_id ]['tabs'][ $tab_id ]['accordion'][ $accordion_id ]['fieldsets'][ $fieldset_id ] ) ) {
							$this->fields[ $section_id ]['tabs'][ $tab_id ]['accordion'][ $accordion_id ]['fieldsets'][ $fieldset_id ]['fields'][ $field_id ] = $field;
						} elseif ( isset( $this->fields[ $section_id ]['tabs'][ $tab_id ]['fieldsets'][ $fieldset_id ]['accordion'][ $accordion_id ] ) ) {
							$this->fields[ $section_id ]['tabs'][ $tab_id ]['fieldsets'][ $fieldset_id ]['accordion'][ $accordion_id ]['fields'][ $field_id ] = $field;
						}
					}
				}
			}
		}
	}
}