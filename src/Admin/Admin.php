<?php

/**
 * The admin-facing functionality of the plugin.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package themeatelier-core
 * @subpackage themeatelier-core/src/Admin
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ThemeAtelierCore\Admin;

use ThemeAtelier\ThemeAtelierCore\Admin\Views\ThemeatelierCoreMetaboxes;

// use ThemeAtelier\ThemeAtelierCore\Admin\Views\Options;

/**
 * The admin class
 */
class Admin
{
    /**
     * The slug of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_slug   The slug of this plugin.
     */
    private $plugin_slug;

    /**
     * The min of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $min   The slug of this plugin.
     */
    private $min;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The class constructor.
     *
     * @param string $plugin_slug The slug of the plugin.
     * @param string $version Current version of the plugin.
     */
    function __construct($plugin_slug, $version)
    {
        $this->plugin_slug = $plugin_slug;
        $this->version     = $version;
        $this->min         = defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';
        
        ThemeatelierCoreMetaboxes::section_metabox('themeatelier_core_section');
        ThemeatelierCoreMetaboxes::option_metabox('themeatelier_core_options');
        ThemeatelierCoreMetaboxes::shortcode_metabox('shortcode');
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public static function enqueue_scripts($hook)
    {
        wp_enqueue_style('themeatelier-core-admin-style');
    }

    public function filter_themeatelier_core_admin_column()
    {
        $admin_columns['cb']         = '<input type="checkbox" />';
        $admin_columns['title']      = esc_html__('Title', 'themeatelier-core');
        $admin_columns['shortcode']  = esc_html__('Shortcode', 'themeatelier-core');
        $admin_columns['date']       = esc_html__('Date', 'themeatelier-core');

        return $admin_columns;
    }

    public function display_themeatelier_core_admin_fields($column, $post_id)
    {
        switch ($column) {
            case 'shortcode':
                $column_field = '<input  class="themeatelier_core_input" style="width: 230px;padding: 4px 8px;cursor: pointer;" type="text" onClick="this.select();" readonly="readonly" value="[themeatelier-core id=&quot;' . $post_id . '&quot;]"/> <div class="themeatelier-core-after-copy-text"><i class="icofont-check-circled"></i> ' . esc_html('Shortcode Copied to Clipboard!', 'themeatelier-core') . ' </div>';
                echo $column_field;
                break;
        } // end switch.
    }

}
