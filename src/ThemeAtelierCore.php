<?php

namespace ThemeAtelier\ThemeAtelierCore;

use ThemeAtelier\ThemeAtelierCore\Loader;
use ThemeAtelier\ThemeAtelierCore\Helpers\Helpers;
use ThemeAtelier\ThemeAtelierCore\Admin\Admin;
use ThemeAtelier\ThemeAtelierCore\Frontend\Frontend;
use ThemeAtelier\ThemeAtelierCore\Helpers\ThemeAtelierCorePostTypes;

// don't call the file directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * The main class of the plugin.
 *
 * Handle all the class and methods of the plugin.
 *
 * @author     ThemeAtelier <themeatelierbd@gmail.com>
 */
class ThemeAtelierCore
{
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name = THEMEATELER_CORE_BASENAME;
    /**
     * Plugin version
     *
     * @since    1.0.0
     * @access   protected
     * @var string
     */
    protected $version;

    /**
     * Plugin slug
     *
     * @since    1.0.0
     * @access   protected
     * @var string
     */
    protected $plugin_slug;

    /**
     * Main Loader.
     *
     * The loader that's responsible for maintaining and registering all hooks that empowers
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var object
     */
    protected $loader;
    /**
     * Constructor for the ThemeAtelierCore class.
     *
     * Sets up all the appropriate hooks and actions within the plugin.
     */
    public function __construct()
    {
        $this->version     = THEMEATELER_CORE_VERSION;
        $this->plugin_slug = 'themeatelier-core';
        $this->load_dependencies();
        $this->define_constants();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_common_hooks();
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The slug of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_slug()
    {
        return $this->plugin_slug;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('THEMEATELER_CORE_PLUGIN_NAME', $this->plugin_name);
        define('THEMEATELER_CORE_URL', plugins_url('', THEMEATELER_CORE_FILE));
        define('THEMEATELER_CORE_ASSETS', THEMEATELER_CORE_URL . '/src/assets/');
        define('THEMEATELER_CORE_ADMIN', THEMEATELER_CORE_URL . '/src/Admin');
    }

    public function redirect_to($plugin)
    {
        if (THEMEATELER_CORE_BASENAME === $plugin) {
            $redirect_url = esc_url(admin_url('admin.php?page=themeatelier-core'));
            exit(wp_kses_post(wp_safe_redirect($redirect_url)));
        }
    }

    /**
     * Load the plugin after all plugins are loaded.
     *
     * @return void
     */
    public function init_plugin()
    {
        do_action('themeatelier_core_loaded');
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Loader. Orchestrates the hooks of the plugin.
     * - Teamproi18n. Defines internationalization functionality.
     * - Admin. Defines all hooks for the admin area.
     * - Frontend. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        $this->loader = new Loader();
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public    = new Frontend($this->get_plugin_slug(), $this->get_version());
        $plugin_helpers   = new Helpers($this->get_plugin_slug(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 11 );
        $this->loader->add_action('wp_loaded', $plugin_helpers, 'register_all_scripts');
    }

    /**
     * Register common hooks.
     *
     * @since 1.0.0
     * @access private
     */
    private function define_common_hooks()
    {
        $common_hooks = new ThemeAtelierCorePostTypes(THEMEATELER_CORE_PLUGIN_NAME, THEMEATELER_CORE_VERSION);
        $this->loader->add_action('init', $common_hooks, 'register_themeatelier_core_post_type', 10);
    }

    /**
     * Register all of the hooks related to the admin dashboard functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin   = new Admin($this->get_plugin_slug(), $this->get_version());
        $plugin_helpers   = new Helpers($this->get_plugin_slug(), $this->get_version());

        $this->loader->add_action('wp_loaded', $plugin_helpers, 'register_all_scripts');
        $this->loader->add_filter('manage_themeatelier-core_posts_columns', $plugin_admin, 'filter_themeatelier_core_admin_column');
        $this->loader->add_action('manage_hemeatelier-core_posts_custom_column', $plugin_admin, 'display_themeatelier_core_admin_fields', 10, 2);
    }

    // Plugin settings in plugin list
    public function themeatelier_core_action_links(array $links)
    {
        $url           = get_admin_url() . 'admin.php?page=themeatelier-core';
        $settings_link = '<a href="' . esc_url($url) . '">' . esc_html__('Settings', 'themeatelier-core') . '</a>';
        $links[]       = $settings_link;
        return $links;
    }
}
