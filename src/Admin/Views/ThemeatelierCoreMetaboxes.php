<?php

namespace ThemeAtelier\ThemeAtelierCore\Admin\Views;

use ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes\THEMEATELIER_CORE;

if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.

class ThemeatelierCoreMetaboxes
{
	/**
	 * Layout Metabox function.
	 *
	 * @param string $prefix The meta-key for this metabox.
	 * @return void
	 */
	public static function section_metabox($prefix)
	{
		THEMEATELIER_CORE::createMetabox(
			$prefix,
			array(
				'title'        => esc_html__('Themeatelier Core', 'themeatelier-core'),
				'post_type'    => 'themeatelier-core',
				'show_restore' => false,
				'context'      => 'normal',
			)
		);

		//
		// Create a section
		THEMEATELIER_CORE::createSection($prefix, array(
			'fields' => array(
				array(
					'id'    	=> 'section',
					'type'  	=> 'select',
					'title' 	=> esc_html__('Select A Section', 'themeatelier-core'),
					'options'	=> array(
						'hero' => esc_html__('Hero', 'themeatelier-core'),
						'statistics' => esc_html__('Statistics', 'themeatelier-core'),
						'benefits' => esc_html__('Benefits', 'themeatelier-core'),
						'layout' => esc_html__('Layouts', 'themeatelier-core'),
						'features' => esc_html__('Features', 'themeatelier-core'),
						'cta_v2' => esc_html__('CTA V2', 'themeatelier-core'),
						'features_glance' => esc_html__('Features Glance', 'themeatelier-core'),
						'backend_screenshot' => esc_html__('Backend Screenshots', 'themeatelier-core'),
						'pricing' => esc_html__('Pricing', 'themeatelier-core'),
						'cta_v3' => esc_html__('CTA V3', 'themeatelier-core'),
						'faq' => esc_html__('FAQ', 'themeatelier-core'),
					),
				),
			)
		));
	}

	/**
	 * Option Metabox function
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function option_metabox($prefix)
	{
		THEMEATELIER_CORE::createMetabox(
			$prefix,
			array(
				'title'        	=> esc_html__('View Options', 'themeatelier-core'),
				'post_type'    	=> 'themeatelier-core',
				'show_restore' 	=> false,
				'nav'        	=> 'inline',
				'theme'        	=> 'light',
			)
		);
		//
		// Create a section
		THEMEATELIER_CORE::createSection($prefix, array(
			'fields' => array(
				array(
					'id'    => 'section_title',
					'type'  => 'text',
					'title' => esc_html__('Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'hero', 'any'),
				),
				array(
					'id'    => 'subtitle',
					'type'  => 'textarea',
					'title' => esc_html__('Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'hero', 'any'),
				),
				array(
					'id'    => 'button_01',
					'type'  => 'link',
					'title' => esc_html__('Button 01', 'themeatelier-core'),
					'dependency' => array('section', '==', 'hero', 'any'),
				),
				array(
					'id'    => 'button_02',
					'type'  => 'link',
					'title' => esc_html__('Button 02', 'themeatelier-core'),
					'dependency' => array('section', '==', 'hero', 'any'),
				),
				array(
					'id'    => 'money_back_guarantee',
					'type'  => 'wp_editor',
					'title' => esc_html__('Money-Back Guarantee Text', 'themeatelier-core'),
					'dependency' => array('section', '==', 'hero', 'any'),
				),
				array(
					'id'    => 'right_image',
					'type'  => 'media',
					'title' => esc_html__('Right Image', 'themeatelier-core'),
					'dependency' => array('section', '==', 'hero', 'any'),
				),
				array(
					'id'        => 'statistics_section',
					'type'      => 'group',
					'title'     => esc_html__('Statistics Items', 'themeatelier-core'),
					'dependency' => array('section', '==', 'statistics', 'any'),
					'fields'    => array(
						array(
							'id'    => 'statistics_title',
							'type'  => 'text',
							'title' => esc_html__('Title', 'themeatelier-core'),
						),
						array(
							'id'    => 'statistics_subtitle',
							'type'  => 'text',
							'title' => esc_html__('Subtitle', 'themeatelier-core'),
						),
						array(
							'id'    => 'statistics_icon',
							'type'  => 'wp_editor',
							'title' => esc_html__('Icon', 'themeatelier-core'),
						),
					),
				),
				array(
					'id'    => 'benefits_section_title',
					'type'  => 'text',
					'title' => esc_html__('Benefits Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'benefits', 'any'),
				),
				array(
					'id'        => 'benefits_items',
					'type'      => 'group',
					'title'     => esc_html__('Benefits Items', 'themeatelier-core'),
					'dependency' => array('section', '==', 'benefits', 'any'),
					'fields'    => array(
						array(
							'id'    => 'benefits_title',
							'type'  => 'text',
							'title' => esc_html__('Title', 'themeatelier-core'),
						),
						array(
							'id'    => 'benefits_icon',
							'type'  => 'icon',
							'title' => esc_html__('Icon', 'themeatelier-core'),
						),
						array(
							'id'    => 'benefits_description',
							'type'  => 'textarea',
							'title' => esc_html__('Description', 'themeatelier-core'),
						),
					),
				),
				array(
					'id'    => 'layout_section_title',
					'type'  => 'text',
					'title' => esc_html__('Layout Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'layout', 'any'),
				),
				array(
					'id'    => 'layout_section_subtitle',
					'type'  => 'text',
					'title' => esc_html__('Layout Section Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'layout', 'any'),
				),
				array(
					'id'        => 'layout_items',
					'type'      => 'group',
					'title'     => esc_html__('Layout Items', 'themeatelier-core'),
					'dependency' => array('section', '==', 'layout', 'any'),
					'fields'    => array(
						array(
							'id'    => 'layout_title',
							'type'  => 'text',
							'title' => esc_html__('Title', 'themeatelier-core'),
						),
						array(
							'id'    => 'layout_image',
							'type'  => 'media',
							'title' => esc_html__('Image', 'themeatelier-core'),
						),
					),
				),
				array(
					'id'    => 'features_section_title',
					'type'  => 'text',
					'title' => esc_html__('Features Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features', 'any'),
				),
				array(
					'id'    => 'features_section_subtitle',
					'type'  => 'text',
					'title' => esc_html__('Features Section Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features', 'any'),
				),
				array(
					'id'        => 'features_items',
					'type'      => 'group',
					'title'     => esc_html__('Features Items', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features', 'any'),
					'fields'    => array(
						array(
							'id'    => 'features_title',
							'type'  => 'text',
							'title' => esc_html__('Title', 'themeatelier-core'),
						),
						array(
							'id'    => 'features_description',
							'type'  => 'media',
							'title' => esc_html__('Image', 'themeatelier-core'),
						),
						array(
							'id'    => 'features_description',
							'type'  => 'wp_editor',
							'title' => esc_html__('Description', 'themeatelier-core'),
						),
						array(
							'id'    => 'features_link',
							'type'  => 'link',
							'title' => esc_html__('Live Link', 'themeatelier-core'),
						),
					),
				),
				array(
					'id'    => 'cta_v2_title',
					'type'  => 'text',
					'title' => esc_html__('Features Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'cta_v2', 'any'),
				),
				array(
					'id'    => 'cta_v2_subtitle',
					'type'  => 'text',
					'title' => esc_html__('Features Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'cta_v2', 'any'),
				),
				array(
					'id'    => 'cta_v2_link',
					'type'  => 'link',
					'title' => esc_html__('Button', 'themeatelier-core'),
					'dependency' => array('section', '==', 'cta_v2', 'any'),
				),
				array(
					'id'    => 'cta_v2_money_back_guarantee',
					'type'  => 'textarea',
					'title' => esc_html__('Money-Back Guarantee Text', 'themeatelier-core'),
					'dependency' => array('section', '==', 'cta_v2', 'any'),
				),
				array(
					'id'    => 'features_glance_section_title',
					'type'  => 'text',
					'title' => esc_html__('Features Glance Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features_glance', 'any'),
				),
				array(
					'id'    => 'features_glance_section_subtitle',
					'type'  => 'text',
					'title' => esc_html__('Features Glance Section Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features_glance', 'any'),
				),
				array(
					'id'        => 'features_glance_items',
					'type'      => 'group',
					'title'     => esc_html__('Features Glance Items', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features_glance', 'any'),
					'fields'    => array(
						array(
							'id'    => 'features_glance_description',
							'type'  => 'wp_editor',
							'title' => esc_html__('Description', 'themeatelier-core'),
						),
					),
				),

				// Backend Screenshots
				array(
					'id'    => 'backend_screenshot_section_title',
					'type'  => 'text',
					'title' => esc_html__('Backend Screenshot Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'backend_screenshot', 'any'),
				),
				array(
					'id'    => 'backend_screenshot_section_subtitle',
					'type'  => 'text',
					'title' => esc_html__('Backend Screenshot Section Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'backend_screenshot', 'any'),
				),
				array(
					'id'        => 'backend_screenshot_items',
					'type'      => 'group',
					'title'     => esc_html__('Backend Screenshot Items', 'themeatelier-core'),
					'dependency' => array('section', '==', 'backend_screenshot', 'any'),
					'fields'    => array(
						array(
							'id'    => 'backend_screenshot_image',
							'type'  => 'media',
							'title' => esc_html__('Backend Screenshot Image', 'themeatelier-core'),
						),
					),
				),

				// Pricing
				array(
					'id'    => 'pricing_section_title',
					'type'  => 'text',
					'title' => esc_html__('Pricing Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'pricing', 'any'),
				),
				array(
					'id'    => 'pricing_section_subtitle',
					'type'  => 'text',
					'title' => esc_html__('Pricing Section Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'pricing', 'any'),
				),
				array(
					'id'            => 'pricing_table',
					'type'          => 'tabbed',
					'title'         => esc_html__('Pricing Table', 'themeatelier-core'),
					'dependency' => array('section', '==', 'pricing', 'any'),
					'tabs'          => array(
						array(
							'title'     => esc_html__('Yearly', 'themeatelier-core'),
							'fields'    => array(
								array(
									'id'        => 'pricing_table_yearly',
									'type'      => 'group',
									'title'     => esc_html__('Pricing Table Yearly', 'themeatelier-core'),
									'fields'    => array(
										array(
											'id'    => 'yearly_title',
											'type'  => 'text',
											'title' => esc_html__('Yearly Title', 'themeatelier-core'),
										),
										array(
											'id'    => 'yearly_subtitle',
											'type'  => 'text',
											'title' => esc_html__('Yearly Subtitle', 'themeatelier-core'),
										),
										array(
											'id'    => 'yearly_price',
											'type'  => 'number',
											'title' => esc_html__('Yearly Price', 'themeatelier-core'),
										),
										array(
											'id'    => 'yearly_parches_button',
											'type'  => 'link',
											'title' => esc_html__('Yearly Parches Button', 'themeatelier-core'),
										),
										array(
											'id'    => 'yearly_features',
											'type'  => 'wp_editor',
											'title' => esc_html__('Yearly Features', 'themeatelier-core'),
										),
									),

									array(
										'id'    => 'yearly_description',
										'type'  => 'text',
										'title' => esc_html__('Description', 'themeatelier-core'),
									),
								),
							)
						),
						array(
							'title'     => esc_html__('Lifetime', 'themeatelier-core'),
							'fields'    => array(
								array(
									'id'        => 'pricing_table_lifetime',
									'type'      => 'group',
									'title'     => esc_html__('Pricing Table Lifetime', 'themeatelier-core'),
									'fields'    => array(
										array(
											'id'    => 'lifetime_title',
											'type'  => 'text',
											'title' => esc_html__('Lifetime Title', 'themeatelier-core'),
										),
										array(
											'id'    => 'lifetime_subtitle',
											'type'  => 'text',
											'title' => esc_html__('Lifetime Subtitle', 'themeatelier-core'),
										),
										array(
											'id'    => 'lifetime_price',
											'type'  => 'number',
											'title' => esc_html__('Lifetime Price', 'themeatelier-core'),
										),
										array(
											'id'    => 'lifetime_parches_button',
											'type'  => 'link',
											'title' => esc_html__('Lifetime Parches Button', 'themeatelier-core'),
										),
										array(
											'id'    => 'lifetime_features',
											'type'  => 'wp_editor',
											'title' => esc_html__('Lifetime Features', 'themeatelier-core'),
										),
									),
								),
								array(
									'id'    => 'lifetime_description',
									'type'  => 'text',
									'title' => esc_html__('Description', 'themeatelier-core'),
								),
							)
						),
					)
				),

				// CTA V3
				array(
					'id'    => 'cta_v3_title',
					'type'  => 'text',
					'title' => esc_html__('CTA Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'cta_v3', 'any'),
				),
				array(
					'id'    => 'cta_v3_description',
					'type'  => 'wp_editor',
					'title' => esc_html__('CTA Description', 'themeatelier-core'),
					'dependency' => array('section', '==', 'cta_v3', 'any'),
				),
				array(
					'id'    => 'cta_v3_payment_terms',
					'type'  => 'text',
					'title' => esc_html__('Payment Terms', 'themeatelier-core'),
					'dependency' => array('section', '==', 'cta_v3', 'any'),
				),
				array(
					'id'    => 'cta_v3_payment_type',
					'type'  => 'text',
					'title' => esc_html__('Payment Type', 'themeatelier-core'),
					'dependency' => array('section', '==', 'cta_v3', 'any'),
				),
				array(
					'id'    => 'cta_v3_payment_type_icon',
					'type'  => 'media',
					'title' => esc_html__('Payment Type Icon', 'themeatelier-core'),
					'dependency' => array('section', '==', 'cta_v3', 'any'),
				),

				// FAQ
				array(
					'id'    => 'faq_title',
					'type'  => 'text',
					'title' => esc_html__('FAQ Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'faq', 'any'),
				),
				array(
					'id'        => 'faq_items',
					'type'      => 'group',
					'title'     => esc_html__('FAQ Items', 'themeatelier-core'),
					'dependency' => array('section', '==', 'faq', 'any'),
					'fields'    => array(
						array(
							'id'    => 'faq_item_title',
							'type'  => 'text',
							'title' => esc_html__('FAQ Item Title', 'themeatelier-core'),
						),
						array(
							'id'    => 'faq_item_description',
							'type'  => 'wp_editor',
							'title' => esc_html__('FAQ Item Description', 'themeatelier-core'),
						),
					),
				),
			)
		));
	}

	public static function page_metabox($prefix)
	{
		THEMEATELIER_CORE::createMetabox(
			$prefix,
			array(
				'title'        => esc_html__('Themeatelier Core', 'themeatelier-core'),
				'post_type'    => 'download',
			)
		);

		THEMEATELIER_CORE::createSection(
			$prefix,
			array(
				'fields' => array(
					array(
						'id'	=> 'section_group',
						'type'           => 'group',
						'title'          => esc_html__('Select Section', 'themeatelier-core'),
						'button_title'  => esc_html__('New Section', 'statesman'),
						'accordion_title_prefix'  => true,
						'accordion_title_number'    => true,
						'accordion_title_auto'  => false,
						'fields'    => array(
							array(
								'id'	=> 'select_section',
								'type'  => 'select',
								'chosen'      => true,
								'title'  => esc_html__('Select Section', 'themeatelier-core'),
								'options'     => 'posts',
								'query_args'  => array(
									'post_type' => 'themeatelier-core'
								),
								'order' => 'ASC',
							),
						),
					),
					array(
						'id'    => 'change_nav_menu',
						'type'  => 'switcher',
						'title' => esc_html__('Would you like to choose the different nav menu on this page?', 'themeatelier-core'),
						'default' => false,
					),
					array(
						'id'    => 'select_nav_menu',
						'type'  => 'select',
						'title' => esc_html__('Choose Nav Menu', 'themeatelier-core'),
						'options'   => 'menus',
						'default'   => 'onepage-menu',
						'dependency' => array('change_nav_menu', '==', true, 'all'),
					),
					array(
						'id'    => 'color_settings',
						'type'  => 'color_group',
						'title' => esc_html__('Colors', 'themeatelier-core'),
						'options'   => array(
							'primary' 	=> esc_html__('Primary', 'themeatelier-core'),
							'secondary' => esc_html__('Secondary', 'themeatelier-core'),
							'dark' 		=> esc_html__('Dark', 'themeatelier-core'),
						),
						'default'   => array(
							'primary' 	=> '#0F8C7E',
							'secondary' => '#F0FDFA',
							'dark' 		=> '#111111',
						)
					),
				),
			)
		);
	}
}
