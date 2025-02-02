<?php

/**
 * 
 * @package    Themeatelier Core
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */

// Blocking direct access
if (!defined('ABSPATH')) {
    die();
}

/**
 * Themeatelier core dashboard capability.
 *
 * @return string
 */
function themeatelier_core_dashboard_capability()
{
    return apply_filters('themeatelier_core_dashboard_capability', 'manage_options');
}


class Custom_Nav_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"hidden top-12 lg:pt-6 lg:group-hover:pt-3 -left-8 lg:absolute group-hover:block lg:block lg:invisible group-hover:visible\">\n";
        $output .= "\n$indent<ul class=\"dropdown_menu !block bg-white lg:pb-2 lg:after:border-b-secondary after:z-50 min-w-[250px] rounded-md lg:opacity-0 group-hover:opacity-100 ease-linear duration-100 after:invisible after:opacity-0 group-hover:after:opacity-100 lg:after:visible after:absolute after:left-16 lg:after:border-[10px] after:-top-2 after:border-transparent lg:shadow-md lg:border border-solid border-secondary\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $class_names = join(' ', $item->classes ?? []);
        $output .= '<li class="' . esc_attr($class_names) . '">';
        $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title);
        if (in_array('menu-item-has-children', $item->classes)) {
            $output .= ' <i class="icofont-rounded-down"></i>';
        }
        $output .= '</a>';
    }
}
