<?php

/**
 * The main class for Settings configurations.
 *
 * @package themeatelier-core
 * @subpackage themeatelier-core/admin/views
 */

namespace ThemeAtelier\ThemeAtelierCore\Admin\Views;

use ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes\THEMEATELIER_CORE;

if (! defined('ABSPATH')) {
    die;
} // Cannot access pages directly.

/**
 * Settings.
 */
class ThemeAtelierCoreSettings
{

    /**
     * Create a settings page.
     *
     * @param string $prefix The settings.
     * @return void
     */
    public static function settings($prefix)
    {

        $capability = themeatelier_core_dashboard_capability(); // TODO: filter is not working.

        THEMEATELIER_CORE::createOptions(
            $prefix,
            array(
                'menu_title'       => esc_html__('Settings', 'themeatelier-core'),
                'menu_parent'      => 'edit.php?post_type=themeatelier-core',
                'menu_type'        => 'submenu', // menu, submenu, options, theme, etc.
                'menu_slug'        => 'themeatelier-core-settings',
                'theme'            => 'light',
                'show_all_options' => false,
                'show_search'      => false,
                'show_footer'      => false,
                'show_bar_menu'    => false,
                'class'            => 'ta-pc-settings',
                'framework_title'  => esc_html__('ThemeAtelierCore', 'themeatelier-core'),
                'menu_capability'  => $capability,
            )
        );
    }
}
