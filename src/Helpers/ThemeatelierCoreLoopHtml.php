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
        $section = isset($section['section']) ? $section['section'] : 'hero';

        switch ($section) {
            case 'hero':
                include Helpers::themeateleier_core_locate_template('hero.php');
                break;
            case 'statistics':
                include Helpers::themeateleier_core_locate_template('statistics.php');
                break;
            case 'benefits':
                include Helpers::themeateleier_core_locate_template('benefits.php');
                break;
            case 'layout':
                include Helpers::themeateleier_core_locate_template('layouts.php');
                break;
            case 'features':
                include Helpers::themeateleier_core_locate_template('features.php');
                break;
            case 'cta_v2':
                include Helpers::themeateleier_core_locate_template('cta_v2.php');
                break;
            case 'features_glance':
                include Helpers::themeateleier_core_locate_template('features_glance.php');
                break;
            case 'backend_screenshot':
                include Helpers::themeateleier_core_locate_template('backend-screenshots.php');
                break;
            case 'pricing':
                include Helpers::themeateleier_core_locate_template('pricing.php');
                break;
            case 'cta_v3':
                include Helpers::themeateleier_core_locate_template('money-back.php');
                break;
            case 'faq':
                include Helpers::themeateleier_core_locate_template('faq.php');
                break;
        }
    }
}
