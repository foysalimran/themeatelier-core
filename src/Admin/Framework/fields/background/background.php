<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: background
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
use ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes\THEMEATELIER_CORE;

if ( ! class_exists( 'Themeatelier_Core_Field_background' ) ) {
  class Themeatelier_Core_Field_background extends Themeatelier_Core_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args                             = wp_parse_args( $this->field, array(
        'background_color'              => true,
        'background_image'              => true,
        'background_position'           => true,
        'background_repeat'             => true,
        'background_attachment'         => true,
        'background_size'               => true,
        'background_origin'             => false,
        'background_clip'               => false,
        'background_blend_mode'         => false,
        'background_gradient'           => false,
        'background_gradient_color'     => true,
        'background_gradient_direction' => true,
        'background_image_preview'      => true,
        'background_auto_attributes'    => false,
        'compact'                       => false,
        'background_image_library'      => 'image',
        'background_image_placeholder'  => esc_html__( 'Not selected', 'themeatelier-core' ),
      ) );

      if ( $args['compact'] ) {
        $args['background_color']           = false;
        $args['background_auto_attributes'] = true;
      }

      $default_value                    = array(
        'background-color'              => '',
        'background-image'              => '',
        'background-position'           => '',
        'background-repeat'             => '',
        'background-attachment'         => '',
        'background-size'               => '',
        'background-origin'             => '',
        'background-clip'               => '',
        'background-blend-mode'         => '',
        'background-gradient-color'     => '',
        'background-gradient-direction' => '',
      );

      $default_value = ( ! empty( $this->field['default'] ) ) ? wp_parse_args( $this->field['default'], $default_value ) : $default_value;

      $this->value = wp_parse_args( $this->value, $default_value );

      echo wp_kses_post($this->field_before());

      echo '<div class="themeatelier-core--background-colors">';

      //
      // Background Color
      if ( ! empty( $args['background_color'] ) ) {

        echo '<div class="themeatelier-core--color">';

        echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="themeatelier-core--title">'. esc_html__( 'From', 'themeatelier-core' ) .'</div>' : '';

        THEMEATELIER_CORE::field( array(
          'id'      => 'background-color',
          'type'    => 'color',
          'default' => $default_value['background-color'],
        ), $this->value['background-color'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Gradient Color
      if ( ! empty( $args['background_gradient_color'] ) && ! empty( $args['background_gradient'] ) ) {

        echo '<div class="themeatelier-core--color">';

        echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="themeatelier-core--title">'. esc_html__( 'To', 'themeatelier-core' ) .'</div>' : '';

        THEMEATELIER_CORE::field( array(
          'id'      => 'background-gradient-color',
          'type'    => 'color',
          'default' => $default_value['background-gradient-color'],
        ), $this->value['background-gradient-color'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Gradient Direction
      if ( ! empty( $args['background_gradient_direction'] ) && ! empty( $args['background_gradient'] ) ) {

        echo '<div class="themeatelier-core--color">';

        echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="themeatelier-core---title">'. esc_html__( 'Direction', 'themeatelier-core' ) .'</div>' : '';

        THEMEATELIER_CORE::field( array(
          'id'          => 'background-gradient-direction',
          'type'        => 'select',
          'options'     => array(
            ''          => esc_html__( 'Gradient Direction', 'themeatelier-core' ),
            'to bottom' => esc_html__( '&#8659; top to bottom', 'themeatelier-core' ),
            'to right'  => esc_html__( '&#8658; left to right', 'themeatelier-core' ),
            '135deg'    => esc_html__( '&#8664; corner top to right', 'themeatelier-core' ),
            '-135deg'   => esc_html__( '&#8665; corner top to left', 'themeatelier-core' ),
          ),
        ), $this->value['background-gradient-direction'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      echo '</div>';

      //
      // Background Image
      if ( ! empty( $args['background_image'] ) ) {

        echo '<div class="themeatelier-core--background-image">';

        THEMEATELIER_CORE::field( array(
          'id'          => 'background-image',
          'type'        => 'media',
          'class'       => 'themeatelier-core-assign-field-background',
          'library'     => $args['background_image_library'],
          'preview'     => $args['background_image_preview'],
          'placeholder' => $args['background_image_placeholder'],
          'attributes'  => array( 'data-depend-id' => $this->field['id'] ),
        ), $this->value['background-image'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      $auto_class   = ( ! empty( $args['background_auto_attributes'] ) ) ? ' themeatelier-core--auto-attributes' : '';
      $hidden_class = ( ! empty( $args['background_auto_attributes'] ) && empty( $this->value['background-image']['url'] ) ) ? ' themeatelier-core--attributes-hidden' : '';

      echo '<div class="themeatelier-core--background-attributes'. esc_attr( $auto_class . $hidden_class ) .'">';

      //
      // Background Position
      if ( ! empty( $args['background_position'] ) ) {

        THEMEATELIER_CORE::field( array(
          'id'              => 'background-position',
          'type'            => 'select',
          'options'         => array(
            ''              => esc_html__( 'Background Position', 'themeatelier-core' ),
            'left top'      => esc_html__( 'Left Top', 'themeatelier-core' ),
            'left center'   => esc_html__( 'Left Center', 'themeatelier-core' ),
            'left bottom'   => esc_html__( 'Left Bottom', 'themeatelier-core' ),
            'center top'    => esc_html__( 'Center Top', 'themeatelier-core' ),
            'center center' => esc_html__( 'Center Center', 'themeatelier-core' ),
            'center bottom' => esc_html__( 'Center Bottom', 'themeatelier-core' ),
            'right top'     => esc_html__( 'Right Top', 'themeatelier-core' ),
            'right center'  => esc_html__( 'Right Center', 'themeatelier-core' ),
            'right bottom'  => esc_html__( 'Right Bottom', 'themeatelier-core' ),
          ),
        ), $this->value['background-position'], $this->field_name(), 'field/background' );

      }

      //
      // Background Repeat
      if ( ! empty( $args['background_repeat'] ) ) {

        THEMEATELIER_CORE::field( array(
          'id'          => 'background-repeat',
          'type'        => 'select',
          'options'     => array(
            ''          => esc_html__( 'Background Repeat', 'themeatelier-core' ),
            'repeat'    => esc_html__( 'Repeat', 'themeatelier-core' ),
            'no-repeat' => esc_html__( 'No Repeat', 'themeatelier-core' ),
            'repeat-x'  => esc_html__( 'Repeat Horizontally', 'themeatelier-core' ),
            'repeat-y'  => esc_html__( 'Repeat Vertically', 'themeatelier-core' ),
          ),
        ), $this->value['background-repeat'], $this->field_name(), 'field/background' );

      }

      //
      // Background Attachment
      if ( ! empty( $args['background_attachment'] ) ) {

        THEMEATELIER_CORE::field( array(
          'id'       => 'background-attachment',
          'type'     => 'select',
          'options'  => array(
            ''       => esc_html__( 'Background Attachment', 'themeatelier-core' ),
            'scroll' => esc_html__( 'Scroll', 'themeatelier-core' ),
            'fixed'  => esc_html__( 'Fixed', 'themeatelier-core' ),
          ),
        ), $this->value['background-attachment'], $this->field_name(), 'field/background' );

      }

      //
      // Background Size
      if ( ! empty( $args['background_size'] ) ) {

        THEMEATELIER_CORE::field( array(
          'id'        => 'background-size',
          'type'      => 'select',
          'options'   => array(
            ''        => esc_html__( 'Background Size', 'themeatelier-core' ),
            'cover'   => esc_html__( 'Cover', 'themeatelier-core' ),
            'contain' => esc_html__( 'Contain', 'themeatelier-core' ),
            'auto'    => esc_html__( 'Auto', 'themeatelier-core' ),
          ),
        ), $this->value['background-size'], $this->field_name(), 'field/background' );

      }

      //
      // Background Origin
      if ( ! empty( $args['background_origin'] ) ) {

        THEMEATELIER_CORE::field( array(
          'id'            => 'background-origin',
          'type'          => 'select',
          'options'       => array(
            ''            => esc_html__( 'Background Origin', 'themeatelier-core' ),
            'padding-box' => esc_html__( 'Padding Box', 'themeatelier-core' ),
            'border-box'  => esc_html__( 'Border Box', 'themeatelier-core' ),
            'content-box' => esc_html__( 'Content Box', 'themeatelier-core' ),
          ),
        ), $this->value['background-origin'], $this->field_name(), 'field/background' );

      }

      //
      // Background Clip
      if ( ! empty( $args['background_clip'] ) ) {

        THEMEATELIER_CORE::field( array(
          'id'            => 'background-clip',
          'type'          => 'select',
          'options'       => array(
            ''            => esc_html__( 'Background Clip', 'themeatelier-core' ),
            'border-box'  => esc_html__( 'Border Box', 'themeatelier-core' ),
            'padding-box' => esc_html__( 'Padding Box', 'themeatelier-core' ),
            'content-box' => esc_html__( 'Content Box', 'themeatelier-core' ),
          ),
        ), $this->value['background-clip'], $this->field_name(), 'field/background' );

      }

      //
      // Background Blend Mode
      if ( ! empty( $args['background_blend_mode'] ) ) {

        THEMEATELIER_CORE::field( array(
          'id'            => 'background-blend-mode',
          'type'          => 'select',
          'options'       => array(
            ''            => esc_html__( 'Background Blend Mode', 'themeatelier-core' ),
            'normal'      => esc_html__( 'Normal', 'themeatelier-core' ),
            'multiply'    => esc_html__( 'Multiply', 'themeatelier-core' ),
            'screen'      => esc_html__( 'Screen', 'themeatelier-core' ),
            'overlay'     => esc_html__( 'Overlay', 'themeatelier-core' ),
            'darken'      => esc_html__( 'Darken', 'themeatelier-core' ),
            'lighten'     => esc_html__( 'Lighten', 'themeatelier-core' ),
            'color-dodge' => esc_html__( 'Color Dodge', 'themeatelier-core' ),
            'saturation'  => esc_html__( 'Saturation', 'themeatelier-core' ),
            'color'       => esc_html__( 'Color', 'themeatelier-core' ),
            'luminosity'  => esc_html__( 'Luminosity', 'themeatelier-core' ),
          ),
        ), $this->value['background-blend-mode'], $this->field_name(), 'field/background' );

      }

      echo '</div>';

      echo wp_kses_post($this->field_after());

    }

    public function output() {

      $output    = '';
      $bg_image  = array();
      $important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
      $element   = ( is_array( $this->field['output'] ) ) ? join( ',', $this->field['output'] ) : $this->field['output'];

      // Background image and gradient
      $background_color        = ( ! empty( $this->value['background-color']              ) ) ? $this->value['background-color']              : '';
      $background_gd_color     = ( ! empty( $this->value['background-gradient-color']     ) ) ? $this->value['background-gradient-color']     : '';
      $background_gd_direction = ( ! empty( $this->value['background-gradient-direction'] ) ) ? $this->value['background-gradient-direction'] : '';
      $background_image        = ( ! empty( $this->value['background-image']['url']       ) ) ? $this->value['background-image']['url']       : '';


      if ( $background_color && $background_gd_color ) {
        $gd_direction   = ( $background_gd_direction ) ? $background_gd_direction .',' : '';
        $bg_image[] = 'linear-gradient('. $gd_direction . $background_color .','. $background_gd_color .')';
        unset( $this->value['background-color'] );
      }

      if ( $background_image ) {
        $bg_image[] = 'url('. $background_image .')';
      }

      if ( ! empty( $bg_image ) ) {
        $output .= 'background-image:'. implode( ',', $bg_image ) . $important .';';
      }

      // Common background properties
      $properties = array( 'color', 'position', 'repeat', 'attachment', 'size', 'origin', 'clip', 'blend-mode' );

      foreach ( $properties as $property ) {
        $property = 'background-'. $property;
        if ( ! empty( $this->value[$property] ) ) {
          $output .= $property .':'. $this->value[$property] . $important .';';
        }
      }

      if ( $output ) {
        $output = $element .'{'. $output .'}';
      }

      $this->parent->output_css .= $output;

      return $output;

    }

  }
}
