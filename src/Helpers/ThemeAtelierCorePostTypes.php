<?php

namespace ThemeAtelier\ThemeAtelierCore\Helpers;

if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.

/**
 * Custom post class to register the carousel.
 */
class ThemeAtelierCorePostTypes
{

	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since 2.2.0
	 */
	private static $instance;

	/**
	 * Path to the file.
	 *
	 * @since 2.2.0
	 *
	 * @var string
	 */
	public $file = __FILE__;

	/**
	 * Holds the base class object.
	 *
	 * @since 2.2.0
	 *
	 * @var object
	 */
	public $base;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since 2.2.0
	 * @static
	 * @return self Main instance.
	 */
	public static function instance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * ThemeAtelier Core post type
	 */
	public function register_themeatelier_core_post_type()
	{
		if (post_type_exists('themeatelier-core')) {
			return;
		}
		$capability = themeatelier_core_dashboard_capability();
		// Set the ThemeAtelier Core post type labels.
		$labels = apply_filters(
			'themeatelier_core_post_type_labels',
			array(
				'name'               => esc_html__('ThemeAtelier Core Section', 'themeatelier-core'),
				'singular_name'      => esc_html__('Section', 'themeatelier-core'),
				'menu_name'          => esc_html__('ThemeAtelier Core', 'themeatelier-core'),
				'all_items'          => esc_html__('All Sections', 'themeatelier-core'),
				'add_new'            => esc_html__('Add Section', 'themeatelier-core'),
				'add_new_item'       => esc_html__('Generate New Section', 'themeatelier-core'),
				'new_item'           => esc_html__('Generate New Section', 'themeatelier-core'),
				'edit_item'          => esc_html__('Edit Generated Section', 'themeatelier-core'),
				'view_item'          => esc_html__('View Generated Section', 'themeatelier-core'),
				'name_admin_bar'     => esc_html__('ThemeAtelier Core Generator', 'themeatelier-core'),
				'search_items'       => esc_html__('Search Generated Section', 'themeatelier-core'),
				'parent_item_colon'  => esc_html__('Parent Generated Section:', 'themeatelier-core'),
				'not_found'          => esc_html__('No Section found.', 'themeatelier-core'),
				'not_found_in_trash' => esc_html__('No Section found in Trash.', 'themeatelier-core')
			)
		);

		$args      = apply_filters(
			'themeatelier_core_post_type_args',
			array(
				'label'           => esc_html__('ThemeAtelier Core Section', 'themeatelier-core'),
				'description'     => esc_html__('ThemeAtelier Core Section', 'themeatelier-core'),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-edit-page',
				'hierarchical'    => false,
				'query_var'       => false,
				'menu_position'   => 5,
				'supports'        => array('title'),
				'capabilities'    => array(
					'publish_posts'       => $capability,
					'edit_posts'          => $capability,
					'edit_others_posts'   => $capability,
					'delete_posts'        => $capability,
					'delete_others_posts' => $capability,
					'read_private_posts'  => $capability,
					'edit_post'           => $capability,
					'delete_post'         => $capability,
					'read_post'           => $capability,
				),
				'capability_type' => 'post',
				// 'rewrite'         => true,
				'labels'          => $labels,
			)
		);

		register_post_type('themeatelier-core', $args);
	}
}
