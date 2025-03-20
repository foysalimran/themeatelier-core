<?php

/**
 * Handles the Themeatelier Core Support functionality.
 *
 * @package    Whatsapp chat support
 * @version    1.0
 * @author     ThemeAtelier
 * @website    https://themeatelier.net/
 */

namespace ThemeAtelier\ThemeAtelierCore\Frontend\Shortcode;

// use ThemeAtelier\ThemeAtelierCore\Frontend\CustomButtonsTemplates;

/**
 * Class CustomShortcode
 *
 * This class handles the custom shortcode functionality for WhatsApp chat buttons.
 *
 * @since 1.0.0
 */
class CustomShortcode {


	/**
	 * Handles the custom buttons shortcode rendering.
	 *
	 * This function is responsible for rendering custom WhatsApp buttons via shortcodes.
	 *
	 * @since 1.0.0
	 *
	 * @return string The HTML output for the custom WhatsApp buttons.
	 */
	public function ctw_custom_buttons_shortcode( $atts ) {
		// Function implementation goes here.
		$atts = shortcode_atts(
			array(
				'style'       => '1',
				'bg_color' 	  => true,
			),
			$atts
		);

		ob_start();

		// $button_obj = new CustomButtonsTemplates( $atts );

		// if ( ! empty( $atts['style'] ) ) {

		// 	// Style Switch
		// 	switch ( $atts['style'] ) {
		// 		case '1':
		// 			$button_obj->ctw_button_s1();
		// 			break;
		// 		case '2':
		// 			$button_obj->ctw_button_s2();
		// 			break;
		// 		default:
		// 			$button_obj->ctw_button_s1();
		// 			break;
		// 	}
		// }

		echo "Hello world!";

		return ob_get_clean();
	}
}
