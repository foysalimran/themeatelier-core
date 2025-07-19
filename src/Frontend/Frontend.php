<?php

namespace ThemeAtelier\ThemeAtelierCore\Frontend;

use ThemeAtelier\ThemeAtelierCore\Helpers\ThemeatelierCoreLoopHtml;

// don't call the file directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * The Frontend class to manage all public facing stuffs.
 *
 * @since 1.0.0
 */
class Frontend
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
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name       The name of the plugin.
     * @param      string $version    The version of this plugin.
     */
    public function __construct()
    {
        $this->themeatelier_core_public_action();
    }

    public static function enqueue_scripts($hook)
    {

        if(is_single() && 'download' == get_post_type()) {
        wp_enqueue_style('ta-single-tailwind');
        wp_enqueue_style('ta-core-custom');
        wp_enqueue_script('ta-core-custom');
    }
    }

    private function themeatelier_core_public_action()
    {
        add_shortcode('themeatelier-core', array($this, 'themeatelier_core_shortcode_render'));
    }

    public function themeatelier_core_shortcode_render($attribute)
    {
        if (empty($attribute['id'])) {
            return;
        }
        $shortcode_id = $attribute['id'];

        // Preset Layouts.
        $section        = get_post_meta($shortcode_id, 'themeatelier_core_section', true);
        $view_options  = get_post_meta($shortcode_id, 'themeatelier_core_options', true);

        ob_start();
        ThemeatelierCoreLoopHtml::section_content($view_options, $section, $shortcode_id);
        return ob_get_clean();
    }
}
