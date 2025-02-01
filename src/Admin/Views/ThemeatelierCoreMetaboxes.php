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
						'features_glance' => esc_html__('Features Glance', 'themeatelier-core'),
						'backend_screenshot' => esc_html__('Backend Screenshots', 'themeatelier-core'),
						'pricing' => esc_html__('Pricing', 'themeatelier-core'),
						'money_back' => esc_html__('Money Back', 'themeatelier-core'),
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
					'default' => esc_html__('Whatsapp Chat Help Will Allow Your Users To Connect You With WhatsApp.', 'themeatelier-core'),
				),
				array(
					'id'    => 'subtitle',
					'type'  => 'textarea',
					'title' => esc_html__('Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'hero', 'any'),
					'default' => esc_html__('It will help users & customers to contact the site owner and to ask for support with one click using their WhatsApp account.', 'themeatelier-core'),
				),
				array(
					'id'    => 'button_01',
					'type'  => 'link',
					'title' => esc_html__('Button 01', 'themeatelier-core'),
					'dependency' => array('section', '==', 'hero', 'any'),
					'default' => array(
						'url'    => '#pricing',
						'text' 	=> esc_html__('Get WhatsApp Chat Help Now', 'themeatelier-core'),
						'target' => '_self'
					),
				),
				array(
					'id'    => 'button_02',
					'type'  => 'link',
					'title' => esc_html__('Button 02', 'themeatelier-core'),
					'dependency' => array('section', '==', 'hero', 'any'),
					'default' => array(
						'url'    => 'https://wpchatplugins.com/whatsapp-chat-support',
						'text' 	=> esc_html__('Live Demo', 'themeatelier-core'),
						'target' => '_self'
					),
				),
				array(
					'id'    => 'money_back_guarantee',
					'type'  => 'wp_editor',
					'title' => esc_html__('Money-Back Guarantee Text', 'themeatelier-core'),
					'dependency' => array('section', '==', 'hero', 'any'),
					'default'	=> __('14-Day No Question Asked <a class="text-white border-b border-white border-dotted" href="https://themeatelier.net/refund-policy/" target="_blank" rel="noreferrer noopener">Refund Policy</a>', 'themeatelier-core'),
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
					'default' => array(
						array(
							'statistics_title'	=> esc_html__('99%', 'themeatelier-core'),
							'statistics_subtitle'	=> esc_html__('Customer Satisfaction', 'themeatelier-core'),
						),
						array(
							'statistics_title'	=> esc_html__('4.80', 'themeatelier-core'),
							'statistics_subtitle'	=> esc_html__('Based on 3 Reviews', 'themeatelier-core'),
						),
						array(
							'statistics_title'	=> esc_html__('24000+', 'themeatelier-core'),
							'statistics_subtitle'	=> esc_html__('All Time Downloads', 'themeatelier-core'),
						),
					),
				),
				array(
					'id'    => 'benefits_section_title',
					'type'  => 'text',
					'title' => esc_html__('Benefits Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'benefits', 'any'),
					'default' => __('Key Benefits: Why Should You Use <br><span class="demo_text_primary">WhatsApp Chat Help?</span>', 'themeatelier-core'),
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
					'default' => array(
						array(
							'benefits_title'	=> esc_html__('Single Chat Bubble', 'themeatelier-core'),
							'benefits_icon'	=> 'icofont-ui-text-chat',
							'benefits_description'	=> esc_html__('A fixed chat bubble with a fixed position on the display. On click which shows users an option to start chatting with you via Whatsapp also your details and active status.', 'themeatelier-core'),
						),
						array(
							'benefits_title'	=> esc_html__('Multi-user options', 'themeatelier-core'),
							'benefits_icon'	=> 'icofont-ui-chat',
							'benefits_description'	=> esc_html__('You can add plenty of different people as options for users to send messages and ask for help. Also can set availability time for each person. There are options to search by name and filter only the search name.', 'themeatelier-core'),
						),
					),
				),
				array(
					'id'    => 'layout_section_title',
					'type'  => 'text',
					'title' => esc_html__('Layout Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'layout', 'any'),
					'default' => __('Explore Your Perfect <span class="demo_text_primary">Chat Bubble Layouts</span>', 'themeatelier-core'),
				),
				array(
					'id'    => 'layout_section_subtitle',
					'type'  => 'text',
					'title' => esc_html__('Layout Section Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'layout', 'any'),
					'default' => __('Customize your WhatsApp chat support experience with a variety of chat bubble layouts to suit your style.', 'themeatelier-core'),
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
					'default' => array(
						array(
							'layout_title'	=> esc_html__('Single Form', 'themeatelier-core'),
							'layout_image'	=> array(
								'url'	=> get_stylesheet_directory_uri() . '/assets/images/wa-chat-help-ss/explore/agent-single-form.webp',
							),
						),
						array(
							'layout_title'	=> esc_html__('Single Agent', 'themeatelier-core'),
							'layout_image'	=> array(
								'url'	=>	get_stylesheet_directory_uri() . '/assets/images/wa-chat-help-ss/explore/agent-single.webp',
							),
						),
					),
				),
				array(
					'id'    => 'features_section_title',
					'type'  => 'text',
					'title' => esc_html__('Features Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features', 'any'),
					'default' => __('Main Features of <span class="demo_text_primary">WhatsApp Chat Help</span>', 'themeatelier-core'),
				),
				array(
					'id'    => 'features_section_subtitle',
					'type'  => 'text',
					'title' => esc_html__('Features Section Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features', 'any'),
					'default' => __('WhatsApp Chat Help provides extensive features and customization options, allowing you to create floating chat bubbles, WooCommerce buttons, and shortcode-enabled buttons for WhatsApp integration.', 'themeatelier-core'),
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
							'id'    => 'features_image_position',
							'type'  => 'button_set',
							'title' => esc_html__('Image Position', 'themeatelier-core'),
							'options' => array(
								'left' => esc_html__('Left', 'themeatelier-core'),
								'right' => esc_html__('Right', 'themeatelier-core'),
							),
							'default' => 'left',
						),
						array(
							'id'    => 'features_image',
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
					'default' => array(
						array(
							'features_title'	=> esc_html__('Floating Chat Bubbles', 'themeatelier-core'),
							'features_image_position'	=> 'left',
							'features_image'	=> get_template_directory_uri() . '/assets/images/wa-chat-help-ss/features/floating-chat.webp',
							'features_description'	=> __('<p class="mt-6 text-lg">
							Enhance user engagement with customizable floating chat bubbles that make WhatsApp interactions seamless. Adjust the design, position, and behavior to fit your website\'s style and provide effortless support or communication.
						</p>
						<ul class="features-list">
							<li><strong>Multiple Variations</strong>: Choose from four variations – <strong>Single With Form</strong>, <strong>Single Agent</strong>, <strong>Simple Button</strong>, and <strong>Multi-Agents</strong> – to suit your specific communication needs.</li>
							<li><strong>Customizable Design</strong>: Adjust colors, icons, and shapes to match your website’s branding.</li>
							<li><strong>Position Control</strong>: Place chat bubbles on any corner of the screen for optimal visibility.</li>
							<li><strong>Time-Based Availability</strong>: Schedule agents availability based on specific hours of weekdays.</li>
							<li><strong>Mobile-Friendly</strong>: Fully responsive design ensures smooth functionality on all devices.</li>
						</ul>', 'themeatelier-core'),
							'features_link'	=> array(
								'url'    => 'https://wpchatplugins.com/whatsapp-chat-support',
								'text'   => esc_html__('Live Demo', 'themeatelier-core'),
								'target' => '_blank'
							),
						),
						array(
							'features_title'	=> esc_html__('WooCommerce Button', 'themeatelier-core'),
							'features_image_position'	=> 'right',
							'features_image'	=> get_template_directory_uri() . '/assets/images/wa-chat-help-ss/features/whatsapp-quote.webp',
							'features_description'	=> __('<p class="mt-6 text-lg">
								Simplify customer inquiries with a customizable WooCommerce Quote Button that integrates seamlessly with WhatsApp. Allow users to request quotes directly from product pages, streamlining communication and boosting conversions.
							</p>
							<ul class="features-list">
								<li>
									<strong>Dynamic Quote Requests</strong>: Enable users to request product quotes directly from WooCommerce product pages.
								</li>
								<li><strong>Customizable Button Text</strong>: Personalize the button label to fit your store\'s tone.</li>
								<li><strong>Button Positioning</strong>: Position button on different places like before cart, after cart etc.</li>
							</ul>', 'themeatelier-core'),
							'features_link'	=> array(
								'url'    => 'https://wpchatplugins.com/whatsapp-chat-support',
								'text'   => esc_html__('Live Demo', 'themeatelier-core'),
								'target' => '_blank'
							),
						),
					),
				),
				array(
					'id'    => 'cta_v2_title',
					'type'  => 'text',
					'title' => esc_html__('Features Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features', 'any'),
					'default' => esc_html__('Collect Leads with WhatsApp Effortlessly', 'themeatelier-core'),
				),
				array(
					'id'    => 'cta_v2_subtitle',
					'type'  => 'text',
					'title' => esc_html__('Features Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features', 'any'),
					'default' => esc_html__('Engage with your customers anytime, anywhere, and never miss a potential lead! With our plugin, connecting with your audience has never been easier, ensuring you turn every interaction into an opportunity.', 'themeatelier-core'),
				),
				array(
					'id'    => 'cta_v2_link',
					'type'  => 'link',
					'title' => esc_html__('Button', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features', 'any'),
					'default'  => array(
						'url'    => '#pricing',
						'text'   => esc_html__('Get Chat Whatsapp Now', 'themeatelier-core'),
						'target' => '_self'
					),
				),
				array(
					'id'    => 'cta_v2_money_back_guarantee',
					'type'  => 'wp_editor',
					'title' => esc_html__('Money-Back Guarantee Text', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features', 'any'),
					'default'	=> __('14-Day No Question Asked <a class="text-white border-b border-white border-dotted" href="https://themeatelier.net/refund-policy/" target="_blank" rel="noreferrer noopener">Refund Policy</a>', 'themeatelier-core'),
				),
				array(
					'id'    => 'features_glance_section_title',
					'type'  => 'text',
					'title' => esc_html__('Features Glance Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features_glance', 'any'),
					'default' => esc_html__('Key Features at a Glance', 'themeatelier-core'),
				),
				array(
					'id'    => 'features_left_side_list',
					'type'  => 'wp_editor',
					'title' => esc_html__('Left Side List', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features_glance', 'any'),
					'default' => __('<li>
						<strong>Single agent support</strong> – This option will allow you to add a bubble with a single WhatsApp number for receiving messages/calls from the single agent.
					</li>
					<li>
						<strong>Multiple agents support</strong> – This option will allow you to add unlimited agents. So visitors can choose the option which they want to chat.
					</li>
					<li>
						<strong>Different whatsapp buttons</strong> – We provide a set of buttons to use anywhere on your website and all functionalities also can be set with each button.
					</li>
					<li>
						<strong>Exclude/include option</strong> – Exclude/include options for showing or hiding WhatsApp chat bubbles on specific pages
					</li>
					<li><strong>Floating Chat Options:</strong> Simple Button, Single Form, Single Agent, and Multi-Agent variations.</li>
					<li><strong>WhatsApp Number Integration:</strong> Easily add your WhatsApp number for seamless communication.</li>
					<li><strong>Timezone Settings:</strong> Adjust availability based on specific time zones.</li>
					<li><strong>Availability Settings:</strong> Configure chat availability to suit your schedule.</li>
					<li><strong>Customizable Agent Details:</strong> Add agent photos, names, and subtitles.</li>
					<li><strong>Bubble Header Content:</strong> Adjust content position for better user experience.</li>', 'themeatelier-core')
				),
				array(
					'id'    => 'features_right_side_list',
					'type'  => 'wp_editor',
					'title' => esc_html__('Right Side List', 'themeatelier-core'),
					'dependency' => array('section', '==', 'features_glance', 'any'),
					'default' => __('<li><strong>GDPR Compliance:</strong> Ensure privacy and compliance with GDPR standards.</li>
					<li><strong>Custom Placeholders:</strong> Set placeholders for agent names and messages.</li>
					<li><strong>Send Message Button Options:</strong> Customize the icon and text for the send message button.</li>
					<li><strong>Message Templates:</strong> Create predefined message templates for quick responses.</li>
					<li><strong>Button Customization:</strong> Style the bubble button, add icons, animations, and tooltips.</li>
					<li><strong>Page Visibility Control:</strong> Include or exclude pages for bubble visibility.</li>
					<li><strong>Auto Popup:</strong> Set bubbles to open automatically with animations and layouts.</li>
					<li><strong>Color and Positioning Options:</strong> Customize colors and button positions for different devices.</li>
					<li><strong>Shortcodes:</strong> Insert WhatsApp buttons anywhere with fully customizable shortcodes.</li>
					<li><strong>WooCommerce Integration:</strong> Add a button with custom styling to WooCommerce products.</li>
					<li><strong>Advanced Settings:</strong> Clean up data, add custom CSS/JS, create backups, and manage your license key.</li>', 'themeatelier-core')
				),

				// Backend Screenshots
				array(
					'id'    => 'backend_screenshot_section_title',
					'type'  => 'text',
					'title' => esc_html__('Backend Screenshot Section Title', 'themeatelier-core'),
					'dependency' => array('section', '==', 'backend_screenshot', 'any'),
					'default' => __('See Backend <span class="demo_text_primary">Screenshots</span>', 'themeatelier-core'),
				),
				array(
					'id'    => 'backend_screenshot_section_subtitle',
					'type'  => 'text',
					'title' => esc_html__('Backend Screenshot Section Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'backend_screenshot', 'any'),
					'default' => esc_html__('Get a wide range of powerful and easy-to-use features and customizations, as seen in the following backend screenshot.', 'themeatelier-core'),
				),
				array(
					'id'        => 'backend_screenshot_items',
					'type'      => 'group',
					'title'     => esc_html__('Backend Screenshot Items', 'themeatelier-core'),
					'accordion_title_prefix'  => true,
					'accordion_title_number'    => true,
					'accordion_title_auto'  => false,
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
					'default'	=>	esc_html__('Pricing Section Title', 'themeatelier-core')
				),
				array(
					'id'    => 'pricing_section_subtitle',
					'type'  => 'text',
					'title' => esc_html__('Pricing Section Subtitle', 'themeatelier-core'),
					'dependency' => array('section', '==', 'pricing', 'any'),
					'default'	=>	esc_html__('Pick a plan based on how many websites you need to use WhatsApp Chat Help.', 'themeatelier-core')
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
											'id' => 'is_yearly_popular',
											'type'	=> 'checkbox',
											'title'	=> esc_html__('Popular?', 'themeatelier-core'),
										),
										array(
											'id'    => 'yearly_features',
											'type'  => 'wp_editor',
											'title' => esc_html__('Yearly Features', 'themeatelier-core'),
										),
									),
									'default'   => array(
										array(
											'yearly_title'     => esc_html__('Single Site', 'themeatelier-core'),
											'yearly_subtitle'     => esc_html__('Best Choice for Individuals', 'themeatelier-core'),
											'yearly_price'     => 29,
											'yearly_parches_button'     => array(
												'url'    => 'https://themeatelier.net/checkout?edd_action=add_to_cart&download_id=534&edd_options[price_id]=1',
												'text'   => esc_html__('Buy Now', 'themeatelier-core'),
												'target' => '_self'
											),
											'is_yearly_popular'	=> false,
											'yearly_features'	=> __('<ul class="features-list">
												<li>
												<strong>Activation on 1 Website</strong>
												</li>
												<li>
												<strong>Standard Support for 1 Year</strong>
												</li>
												<li>
												<strong>Automatic Updates for 1 Year</strong>
												</li>
												<li>14-Day Moneyback Guarantee</li>
												<li>
												All Pro Features Included
												</li>
											</ul>', 'themeatelier-core')
										),
										array(
											'yearly_title'     => esc_html__('Five Sites', 'themeatelier-core'),
											'yearly_subtitle'     => esc_html__('Best Choice for Small Business and Freelancers', 'themeatelier-core'),
											'yearly_price'     => 99,
											'yearly_parches_button'     => array(
												'url'    => 'https://themeatelier.net/checkout?edd_action=add_to_cart&download_id=534&edd_options[price_id]=2',
												'text'   => esc_html__('Buy Now', 'themeatelier-core'),
												'target' => '_self'
											),
											'is_yearly_popular'	=> false,
											'yearly_features'	=> __('<ul class="features-list">
												<li>
													<strong>Activation on 5 Websites</strong>
												</li>
												<li>
													<strong>Priority Support for 1 Year</strong>
												</li>
												<li>
													<strong>Automatic Updates for 1 Year</strong>
												</li>
												<li>14-Day Moneyback Guarantee</li>
												<li>
													All Pro Features Included
												</li>
											</ul>', 'themeatelier-core')
										),
										array(
											'yearly_title'     => esc_html__('Unlimited Sites', 'themeatelier-core'),
											'yearly_subtitle'     => esc_html__('Best Choice for Agencies and Developers', 'themeatelier-core'),
											'yearly_price'     => 199,
											'yearly_parches_button'     => array(
												'url'    => 'https://themeatelier.net/checkout?edd_action=add_to_cart&download_id=534&edd_options[price_id]=3',
												'text'   => esc_html__('Buy Now', 'themeatelier-core'),
												'target' => '_self'
											),
											'is_yearly_popular'	=> false,
											'yearly_features'	=> __('<ul class="features-list">
												<li>
												<strong>Activation on 1 Website</strong>
												</li>
												<li>
												<strong>Standard Support for 1 Year</strong>
												</li>
												<li>
												<strong>Automatic Updates for 1 Year</strong>
												</li>
												<li>14-Day Moneyback Guarantee</li>
												<li>
												All Pro Features Included
												</li>
											</ul>', 'themeatelier-core')
										),
									),
								),
								array(
									'id'    => 'yearly_description',
									'type'  => 'text',
									'title' => esc_html__('Description', 'themeatelier-core'),
									'default' => esc_html__('A yearly plan allows you to get full 1 year updates & support.', 'themeatelier-core'),
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
											'id' => 'is_lifetime_popular',
											'type'	=> 'checkbox',
											'title'	=> esc_html__('Popular?', 'themeatelier-core'),
										),
										array(
											'id'    => 'lifetime_features',
											'type'  => 'wp_editor',
											'title' => esc_html__('Lifetime Features', 'themeatelier-core'),
										),
									),
									'default'   => array(
										array(
											'lifetime_title'     => esc_html__('Single Site', 'themeatelier-core'),
											'lifetime_subtitle'     => esc_html__('Best Choice for Individuals', 'themeatelier-core'),
											'lifetime_price'     => 129,
											'lifetime_parches_button'     => array(
												'url'    => 'https://themeatelier.net/checkout?edd_action=add_to_cart&download_id=534&edd_options[price_id]=1',
												'text'   => esc_html__('Buy Now', 'themeatelier-core'),
												'target' => '_self'
											),
											'is_lifetime_popular'	=> false,
											'lifetime_features'	=> __('<ul class="features-list">
												<li>
													<strong>Activation on 1 Website</strong>
												</li>
												<li>
													<strong>Standard Support for Lifetime</strong>
												</li>
												<li>
													<strong>Automatic Updates for Lifetime</strong>
												</li>
												<li>14-Day Moneyback Guarantee</li>
												<li>
													All Pro Features Included
												</li>
											</ul>', 'themeatelier-core')
										),
										array(
											'lifetime_title'     => esc_html__('Five Sites', 'themeatelier-core'),
											'lifetime_subtitle'     => esc_html__('Best Choice for Small Business and Freelancers', 'themeatelier-core'),
											'lifetime_price'     => 229,
											'lifetime_parches_button'     => array(
												'url'    => 'https://themeatelier.net/checkout?edd_action=add_to_cart&download_id=534&edd_options[price_id]=2',
												'text'   => esc_html__('Buy Now', 'themeatelier-core'),
												'target' => '_self'
											),
											'is_lifetime_popular'	=> false,
											'lifetime_features'	=> __('<ul class="features-list">
												<li>
													<strong>Activation on 5 Websites</strong>
												</li>
												<li>
													<strong>Priority Support for Lifetime</strong>
												</li>
												<li>
													<strong>Automatic Updates for Lifetime</strong>
												</li>
												<li>14-Day Moneyback Guarantee</li>
												<li>
													All Pro Features Included
												</li>
											</ul>', 'themeatelier-core')
										),
										array(
											'lifetime_title'     => esc_html__('Unlimited Sites', 'themeatelier-core'),
											'lifetime_subtitle'     => esc_html__('Best Choice for Agencies and Developers', 'themeatelier-core'),
											'lifetime_price'     => 399,
											'lifetime_parches_button'     => array(
												'url'    => 'https://themeatelier.net/checkout?edd_action=add_to_cart&download_id=534&edd_options[price_id]=3',
												'text'   => esc_html__('Buy Now', 'themeatelier-core'),
												'target' => '_self'
											),
											'is_lifetime_popular'	=> false,
											'lifetime_features'	=> __('<ul class="features-list">
												<li>
													<strong>Unlimited Websites</strong>
												</li>
												<li>
													<strong>Priority Support for Lifetime</strong>
												</li>
												<li>
													<strong>Automatic Updates for Lifetime</strong>
												</li>
												<li>14-Day Moneyback Guarantee</li>
												<li>
													All Pro Features Included
												</li>
											</ul>', 'themeatelier-core')
										),
									),
								),
								array(
									'id'    => 'lifetime_description',
									'type'  => 'text',
									'title' => esc_html__('Description', 'themeatelier-core'),
									'default' => __('A lifetime license entitles you to updates and support forever. It is a <strong>One-time Payment</strong>, not a subscription.', 'themeatelier-core'),
								),
							)
						),
					)
				),

				// Money Back
				array(
					'id'    => 'money_back_title',
					'type'  => 'text',
					'title' => esc_html__('CTA Title', 'themeatelier-core'),
					'default' => '14-Day Money-Back Guarantee – No Questions Asked',
					'dependency' => array('section', '==', 'money_back', 'any'),
				),
				array(
					'id'    => 'money_back_description',
					'type'  => 'wp_editor',
					'title' => esc_html__('CTA Description', 'themeatelier-core'),
					'default' => 'We are committed to your 100% satisfaction with our plugin and support. If our plugin doesn’t meet your needs, simply let us know. We’ll gladly issue a full refund within 14 days of your purchase, no questions asked. For more information, please review our <a class="border-b border-dotted text-font-color-light border-font-color-light" href="https://themeatelier.net/refund-policy">refund policy</a>.',
					'dependency' => array('section', '==', 'money_back', 'any'),
				),
				array(
					'id'    => 'money_back_payment_terms',
					'type'  => 'text',
					'title' => esc_html__('Payment Terms', 'themeatelier-core'),
					'default'	=> 'All prices are listed in USD. You can upgrade, downgrade, or cancel your plan anytime.',
					'dependency' => array('section', '==', 'money_back', 'any'),
				),
				array(
					'id'    => 'money_back_payment_type',
					'type'  => 'text',
					'title' => esc_html__('Payment Type', 'themeatelier-core'),
					'default'	=> 'Secure Payment with Paddle',
					'dependency' => array('section', '==', 'money_back', 'any'),
				),
				array(
					'id'    => 'money_back_payment_type_icon',
					'type'  => 'media',
					'title' => esc_html__('Payment Type Icon', 'themeatelier-core'),
					'default' => array(
						'url' => THEMEATELER_CORE_DIR_URL . 'src/assets/images/cards.svg',
					),
					'dependency' => array('section', '==', 'money_back', 'any'),
				),

				array(
					'id'    => 'docs_link',
					'type'  => 'link',
					'title' => esc_html__('Documentation link', 'themeatelier-core'),
					'dependency' => array('section', '==', 'money_back', 'any'),
				),

				// FAQ
				array(
					'id'    => 'faq_title',
					'type'  => 'text',
					'title' => esc_html__('FAQ Title', 'themeatelier-core'),
					'default'	=> esc_html__('Frequently Asked Questions', 'themeatelier-core'),
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
					'default'   => array(
						array(
							'faq_item_title'     => esc_html__('What is your refund policy?', 'themeatelier-core'),
							'faq_item_description'	=> __('We fully stand behind our plugins and are committed to delivering quality. However, we understand that not every plugin will be a perfect fit for everyone. If you’re not satisfied with your purchase, encounter any issues, or if there’s a problem we can’t resolve, we’re happy to offer a full 100% refund within 14 days of your original purchase—no questions asked.', 'themeatelier-core')
						),
						array(
							'faq_item_title'     => esc_html__('Can I use a ThemeAtelier plugins on more than one site?', 'themeatelier-core'),
							'faq_item_description'	=> __('When purchasing a ThemeAtelier plugin from CodeCanyon, the licensing terms are governed by CodeCanyon\'s standard licenses. According to these terms, each license permits the use of the plugin on a single end product, which typically translates to one website or domain. This means that to use the plugin on multiple sites, you would need to purchase separate licenses for each site.

It\'s important to note that CodeCanyon does not offer a developer or multi-site license for themes and code items. Therefore, even with an Extended License, the usage is still limited to a single end product and does not extend to multiple sites.', 'themeatelier-core')
						),
						array(
							'faq_item_title'     => esc_html__('Can I customize the plugin?', 'themeatelier-core'),
							'faq_item_description'	=> __('Our plugins are fully customizable, giving you complete control over the styling. Each plugin includes an easy-to-use settings panel, allowing you to adjust all features without needing to touch a single line of code.', 'themeatelier-core')
						),
						array(
							'faq_item_title'     => esc_html__('How often are plugins updated?', 'themeatelier-core'),
							'faq_item_description'	=> __('Plugin updates depend on several factors. Security patches and critical bug fixes are prioritized and released as quickly as possible. Updates that enhance our plugin framework and introduce new features are provided regularly.', 'themeatelier-core')
						),
						array(
							'faq_item_title'     => esc_html__('Are the plugins translation-ready?', 'themeatelier-core'),
							'faq_item_description'	=> __('Yes, ThemeAtelier plugins are fully translatable and have been tested with WPML, Polylang, Loco Translate, qTranslate-X, GTranslate, Google Language Translator, WPGlobus, and more.', 'themeatelier-core')
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
						'id'    => 'website_logo',
						'type'  => 'media',
						'title' => esc_html__('Website Logo', 'themeatelier-core'),
					),
					array(
						'id'    => 'item_logo',
						'type'  => 'media',
						'title' => esc_html__('Item Logo', 'themeatelier-core'),
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
