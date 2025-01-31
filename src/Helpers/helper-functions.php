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
