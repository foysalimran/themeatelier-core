<?php
/*
Plugin Name: 	Themeatelier Core
Plugin URI: 	https://themeatelier.net/
Description: 	Themeatelier Core
Version: 		1.0.4
Author:         ThemeAtelier
Author URI:     https://themeatelier.net/
Text Domain:    themeatelier-core
Domain Path:    /languages
*/

// Block Direct access
if (!defined('ABSPATH')) {
    die('You should not access this file directly!');
}

require_once __DIR__ . '/vendor/autoload.php';

use ThemeAtelier\ThemeAtelierCore\ThemeAtelierCore;

define('THEMEATELER_CORE_VERSION', '1.0.4');
define('THEMEATELER_CORE_FILE', __FILE__);
define('THEMEATELER_CORE_DIRNAME', dirname(__FILE__));
define('THEMEATELER_CORE_DIR_PATH', plugin_dir_path(__FILE__));
define('THEMEATELER_CORE_DIR_URL', plugin_dir_url(__FILE__));
define('THEMEATELER_CORE_BASENAME', plugin_basename(__FILE__));

function themeatelier_core_run()
{
    // Launch the plugin.
    $THEMEATELIER_CORE = new ThemeAtelierCore();
    $THEMEATELIER_CORE->run();
}

// kick-off the plugin
themeatelier_core_run();
