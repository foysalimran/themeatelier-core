<?php

namespace ThemeAtelier\ThemeAtelierCore\Helpers;

// If this file is called directly, abort.
use ThemeAtelier\ThemeAtelierCore\Helpers\Helpers;

if (!defined('WPINC')) {
    die;
}

class ThemeatelierCoreLoopHtml
{
    public static function section_content($options, $section, $shortcode_id)
    {
        $section = isset($options['section']) ? $options['section'] : 'hero';

        if ('hero' === $section) {
            include Helpers::themeateleier_core_locate_template('hero.php');
        }
    }
}
