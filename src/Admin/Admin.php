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

        ThemeatelierCoreMetaboxes::page_metabox('page_metabox');
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

}
