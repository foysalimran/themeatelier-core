<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: icon
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'Themeatelier_Core_Field_icon' ) ) {
  class Themeatelier_Core_Field_icon extends Themeatelier_Core_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'button_title' => esc_html__( 'Add Icon', 'themeatelier-core' ),
        'remove_title' => esc_html__( 'Remove Icon', 'themeatelier-core' ),
      ) );

      echo wp_kses_post($this->field_before());

      $nonce  = wp_create_nonce( 'THEMEATELIER_CORE_icon_nonce' );
      $hidden = ( empty( $this->value ) ) ? ' hidden' : '';

      echo '<div class="themeatelier-core-icon-select">';
      echo '<span class="themeatelier-core-icon-preview'. esc_attr( $hidden ) .'"><i class="'. esc_attr( $this->value ) .'"></i></span>';
      echo '<a href="#" class="button button-primary themeatelier-core-icon-add" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html($args['button_title']) .'</a>';
      echo '<a href="#" class="button themeatelier-core-warning-primary themeatelier-core-icon-remove'. esc_attr( $hidden ) .'">'. wp_kses_post($args['remove_title']) .'</a>';
      echo '<input type="hidden" name="'. esc_attr( $this->field_name() ) .'" value="'. esc_attr( $this->value ) .'" class="themeatelier-core-icon-value"'. $this->field_attributes() .' />';
      echo '</div>';

      echo wp_kses_post($this->field_after());

    }

    public function enqueue() {
      add_action( 'admin_footer', array( 'Themeatelier_Core_Field_icon', 'add_footer_modal_icon' ) );
      add_action( 'customize_controls_print_footer_scripts', array( 'Themeatelier_Core_Field_icon', 'add_footer_modal_icon' ) );
    }

    public static function add_footer_modal_icon() {
    ?>
      <div id="themeatelier-core-modal-icon" class="themeatelier-core-modal themeatelier-core-modal-icon hidden">
        <div class="themeatelier-core-modal-table">
          <div class="themeatelier-core-modal-table-cell">
            <div class="themeatelier-core-modal-overlay"></div>
            <div class="themeatelier-core-modal-inner">
              <div class="themeatelier-core-modal-title">
                <?php esc_html_e( 'Add Icon', 'themeatelier-core' ); ?>
                <div class="themeatelier-core-modal-close themeatelier-core-icon-close"></div>
              </div>
              <div class="themeatelier-core-modal-header">
                <input type="text" placeholder="<?php esc_html_e( 'Search...', 'themeatelier-core' ); ?>" class="themeatelier-core-icon-search" />
              </div>
              <div class="themeatelier-core-modal-content">
                <div class="themeatelier-core-modal-loading"><div class="themeatelier-core-loading"></div></div>
                <div class="themeatelier-core-modal-load"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
    }

  }
}
