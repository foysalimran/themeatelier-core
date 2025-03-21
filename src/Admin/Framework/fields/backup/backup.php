<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: backup
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'Themeatelier_Core_Field_backup' ) ) {
  class Themeatelier_Core_Field_backup extends Themeatelier_Core_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $unique = $this->unique;
      $nonce  = wp_create_nonce( 'THEMEATELIER_CORE_backup_nonce' );
      $export = add_query_arg( array( 'action' => 'themeatelier-core-export', 'unique' => $unique, 'nonce' => $nonce ), admin_url( 'admin-ajax.php' ) );

      echo wp_kses_post($this->field_before());

      echo '<textarea name="THEMEATELIER_CORE_import_data" class="themeatelier-core-import-data"></textarea>';
      echo '<button type="submit" class="button button-primary themeatelier-core-confirm themeatelier-core-import" data-unique="'. esc_attr( $unique ) .'" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html__( 'Import', 'themeatelier-core' ) .'</button>';
      echo '<hr />';
      echo '<textarea readonly="readonly" class="themeatelier-core-export-data">'. esc_attr( wp_json_encode( get_option( $unique ) ) ) .'</textarea>';
      echo '<a href="'. esc_url( $export ) .'" class="button button-primary themeatelier-core-export" target="_blank">'. esc_html__( 'Export & Download', 'themeatelier-core' ) .'</a>';
      echo '<hr />';
      echo '<button type="submit" name="THEMEATELIER_CORE_transient[reset]" value="reset" class="button themeatelier-core-warning-primary themeatelier-core-confirm themeatelier-core-reset" data-unique="'. esc_attr( $unique ) .'" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html__( 'Reset', 'themeatelier-core' ) .'</button>';

      echo wp_kses_post($this->field_after());

    }

  }
}
