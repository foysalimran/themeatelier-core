<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: content
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'Themeatelier_Core_Field_content' ) ) {
  class Themeatelier_Core_Field_content extends Themeatelier_Core_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      if ( ! empty( $this->field['content'] ) ) {

        echo $this->field['content'];

      }

    }

  }
}
