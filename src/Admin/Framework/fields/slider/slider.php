<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: slider
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'Themeatelier_Core_Field_slider' ) ) {
  class Themeatelier_Core_Field_slider extends Themeatelier_Core_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'max'  => 100,
        'min'  => 0,
        'step' => 1,
        'unit' => '',
      ) );

      $is_unit = ( ! empty( $args['unit'] ) ) ? ' themeatelier-core--is-unit' : '';

      echo wp_kses_post($this->field_before());

      echo '<div class="themeatelier-core--wrap">';
      echo '<div class="themeatelier-core-slider-ui"></div>';
      echo '<div class="themeatelier-core--input">';
      echo '<input type="number" name="'. esc_attr( $this->field_name() ) .'" value="'. esc_attr( $this->value ) .'"'. $this->field_attributes( array( 'class' => 'themeatelier-core-input-number'. esc_attr( $is_unit ) ) ) .' data-min="'. esc_attr( $args['min'] ) .'" data-max="'. esc_attr( $args['max'] ) .'" data-step="'. esc_attr( $args['step'] ) .'" step="any" />';
      echo ( ! empty( $args['unit'] ) ) ? '<span class="themeatelier-core--unit">'. esc_attr( $args['unit'] ) .'</span>' : '';
      echo '</div>';
      echo '</div>';

      echo wp_kses_post($this->field_after());

    }

    public function enqueue() {

      if ( ! wp_script_is( 'jquery-ui-slider' ) ) {
        wp_enqueue_script( 'jquery-ui-slider' );
      }

    }

    public function output() {

      $output    = '';
      $elements  = ( is_array( $this->field['output'] ) ) ? $this->field['output'] : array_filter( (array) $this->field['output'] );
      $important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
      $mode      = ( ! empty( $this->field['output_mode'] ) ) ? $this->field['output_mode'] : 'width';
      $unit      = ( ! empty( $this->field['unit'] ) ) ? $this->field['unit'] : 'px';

      if ( ! empty( $elements ) && isset( $this->value ) && $this->value !== '' ) {
        foreach ( $elements as $key_property => $element ) {
          if ( is_numeric( $key_property ) ) {
            if ( $mode ) {
              $output = implode( ',', $elements ) .'{'. $mode .':'. $this->value . $unit . $important .';}';
            }
            break;
          } else {
            $output .= $element .'{'. $key_property .':'. $this->value . $unit . $important .'}';
          }
        }
      }

      $this->parent->output_css .= $output;

      return $output;

    }

  }
}
