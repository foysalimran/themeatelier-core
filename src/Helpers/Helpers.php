<?php

namespace ThemeAtelier\ThemeAtelierCore\Helpers;

/**
 * The Helpers class to manage all public facing stuffs.
 *
 * @since 1.0.0
 */
class Helpers
{
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
	// public function __construct() {}

	public static function themeateleier_core_locate_template($template_name, $template_path = '', $default_path = '')
	{
		if (!$template_path) {
			$template_path = 'themeatelier-core/templates';
		}

		if (!$default_path) {
			$default_path = THEMEATELER_CORE_DIRNAME . '/src/Frontend/templates/';
		}
		$template = locate_template(trailingslashit($template_path) . $template_name);
		// Get default template.
		if (!$template) {
			$template = $default_path . $template_name;
		}
		// Return what we found.
		return $template;
	}

	/**
	 * Register the All scripts for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function register_all_scripts()
	{
		wp_register_style('icofont', THEMEATELER_CORE_ASSETS . 'css/icofont.min.css', array(), THEMEATELER_CORE_VERSION, 'all');
		wp_register_style('ta-single-tailwind', THEMEATELER_CORE_ASSETS . 'css/themeatelier-core.min.css', array(), THEMEATELER_CORE_VERSION, 'all');
		wp_register_style('ta-core-custom', THEMEATELER_CORE_ASSETS . 'css/themeatelier-core-custom.css', array(), THEMEATELER_CORE_VERSION, 'all');
		wp_register_script('ta-core-custom', THEMEATELER_CORE_ASSETS . 'js/themeatelier-core.js', array(), THEMEATELER_CORE_VERSION, 'all');
	}
}
