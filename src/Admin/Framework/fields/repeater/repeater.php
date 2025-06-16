<?php
/**
 *
 * Field: repeater
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
use ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes\THEMEATELIER_CORE;

if ( ! class_exists( 'Themeatelier_Core_Field_repeater' ) ) {
  class Themeatelier_Core_Field_repeater extends Themeatelier_Core_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'max'          => 0,
        'min'          => 0,
        'button_title' => '<i class="icofont-plus"></i>',
      ) );

      if ( preg_match( '/'. preg_quote( '['. $this->field['id'] .']' ) .'/', $this->unique ) ) {

        echo '<div class="themeatelier-core-notice themeatelier-core-notice-danger">'. esc_html__( 'Error: Field ID conflict.', 'themeatelier-core' ) .'</div>';

      } else {

        echo wp_kses_post($this->field_before());

        echo '<div class="themeatelier-core-repeater-item themeatelier-core-repeater-hidden" data-depend-id="'. esc_attr( $this->field['id'] ) .'">';
        echo '<div class="themeatelier-core-repeater-content">';
        foreach ( $this->field['fields'] as $field ) {

          $field_default = ( isset( $field['default'] ) ) ? $field['default'] : '';
          $field_unique  = ( ! empty( $this->unique ) ) ? $this->unique .'['. $this->field['id'] .'][0]' : $this->field['id'] .'[0]';

          THEMEATELIER_CORE::field( $field, $field_default, '___'. $field_unique, 'field/repeater' );

        }
        echo '</div>';
        echo '<div class="themeatelier-core-repeater-helper">';
        echo '<div class="themeatelier-core-repeater-helper-inner">';
        echo '<i class="themeatelier-core-repeater-sort icofont-drag"></i>';
        echo '<i class="themeatelier-core-repeater-clone icofont-copy-invert"></i>';
        echo '<i class="themeatelier-core-repeater-remove themeatelier-core-confirm icofont-close" data-confirm="'. esc_html__( 'Are you sure to delete this item?', 'themeatelier-core' ) .'"></i>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        echo '<div class="themeatelier-core-repeater-wrapper themeatelier-core-data-wrapper" data-field-id="['. esc_attr( $this->field['id'] ) .']" data-max="'. esc_attr( $args['max'] ) .'" data-min="'. esc_attr( $args['min'] ) .'">';

        if ( ! empty( $this->value ) && is_array( $this->value ) ) {

          $num = 0;

          foreach ( $this->value as $key => $value ) {

            echo '<div class="themeatelier-core-repeater-item">';
            echo '<div class="themeatelier-core-repeater-content">';
            foreach ( $this->field['fields'] as $field ) {

              $field_unique = ( ! empty( $this->unique ) ) ? $this->unique .'['. $this->field['id'] .']['. $num .']' : $this->field['id'] .'['. $num .']';
              $field_value  = ( isset( $field['id'] ) && isset( $this->value[$key][$field['id']] ) ) ? $this->value[$key][$field['id']] : '';

              THEMEATELIER_CORE::field( $field, $field_value, $field_unique, 'field/repeater' );

            }
            echo '</div>';
            echo '<div class="themeatelier-core-repeater-helper">';
            echo '<div class="themeatelier-core-repeater-helper-inner">';
            echo '<i class="themeatelier-core-repeater-sort icofont-drag"></i>';
            echo '<i class="themeatelier-core-repeater-clone icofont-copy-invert"></i>';
            echo '<i class="themeatelier-core-repeater-remove themeatelier-core-confirm icofont-close" data-confirm="'. esc_html__( 'Are you sure to delete this item?', 'themeatelier-core' ) .'"></i>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            $num++;

          }

        }

        echo '</div>';

        echo '<div class="themeatelier-core-repeater-alert themeatelier-core-repeater-max">'. esc_html__( 'You cannot add more.', 'themeatelier-core' ) .'</div>';
        echo '<div class="themeatelier-core-repeater-alert themeatelier-core-repeater-min">'. esc_html__( 'You cannot remove more.', 'themeatelier-core' ) .'</div>';
        echo '<a href="#" class="button button-primary themeatelier-core-repeater-add">'. esc_html($args['button_title']) .'</a>';

        echo wp_kses_post($this->field_after());

      }

    }

    public function enqueue() {

      if ( ! wp_script_is( 'jquery-ui-sortable' ) ) {
        wp_enqueue_script( 'jquery-ui-sortable' );
      }

    }

  }
}
