<?php

/**
 * Framework setup.class file.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package    themeatelier-core
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes;

if (! class_exists('THEMEATELIER_CORE')) {
  class THEMEATELIER_CORE
  {

    // Default constants
    public static $premium  = true;
    public static $version  = '2.2.9';
    public static $dir      = '';
    public static $url      = '';
    public static $css      = '';
    public static $file     = '';
    public static $enqueue  = false;
    public static $webfonts = array();
    public static $subsets  = array();
    public static $inited   = array();
    public static $fields   = array();
    public static $args     = array(
      'admin_options'       => array(),
      'customize_options'   => array(),
      'metabox_options'     => array(),
      'nav_menu_options'    => array(),
      'profile_options'     => array(),
      'taxonomy_options'    => array(),
      'widget_options'      => array(),
      'comment_options'     => array(),
      'shortcode_options'   => array(),
    );

    // Shortcode instances
    public static $shortcode_instances = array();

    private static $instance = null;

    public static function init($file = __FILE__, $premium = true)
    {

      // Set file constant
      self::$file = $file;

      // Set file constant
      self::$premium = $premium;

      // Set constants
      self::constants();

      // Include files
      self::includes();

      if (is_null(self::$instance)) {
        self::$instance = new self();
      }

      return self::$instance;
    }

    // Initalize
    public function __construct()
    {

      // Init action
      do_action('THEMEATELIER_CORE_init');

      add_action('after_setup_theme', array('ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes\THEMEATELIER_CORE', 'setup'));
      add_action('init', array('ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes\THEMEATELIER_CORE', 'setup'));
      add_action('switch_theme', array('ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes\THEMEATELIER_CORE', 'setup'));
      add_action('admin_enqueue_scripts', array('ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes\THEMEATELIER_CORE', 'add_admin_enqueue_scripts'));
      add_action('wp_enqueue_scripts', array('ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes\THEMEATELIER_CORE', 'add_typography_enqueue_styles'), 80);
      add_action('wp_head', array('ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes\THEMEATELIER_CORE', 'add_custom_css'), 80);
      add_filter('admin_body_class', array('ThemeAtelier\ThemeAtelierCore\Admin\Framework\Classes\THEMEATELIER_CORE', 'add_admin_body_class'));
    }

    // Setup frameworks
    public static function setup()
    {

      // Setup admin option framework
      $params = array();
      if (class_exists('THEMEATELIER_CORE_Options') && ! empty(self::$args['admin_options'])) {
        foreach (self::$args['admin_options'] as $key => $value) {
          if (! empty(self::$args['sections'][$key]) && ! isset(self::$inited[$key])) {

            $params['args']     = $value;
            $params['sections'] = self::$args['sections'][$key];
            self::$inited[$key] = true;

            \THEMEATELIER_CORE_Options::instance($key, $params);

            if (! empty($value['show_in_customizer'])) {
              $value['output_css'] = false;
              $value['enqueue_webfont'] = false;
              self::$args['customize_options'][$key] = $value;
              self::$inited[$key] = null;
            }
          }
        }
      }

      // Setup metabox option framework
      $params = array();
      if (class_exists('THEMEATELIER_CORE_Metabox') && ! empty(self::$args['metabox_options'])) {
        foreach (self::$args['metabox_options'] as $key => $value) {
          if (! empty(self::$args['sections'][$key]) && ! isset(self::$inited[$key])) {

            $params['args']     = $value;
            $params['sections'] = self::$args['sections'][$key];
            self::$inited[$key] = true;

            \THEMEATELIER_CORE_Metabox::instance($key, $params);
          }
        }
      }

      do_action('themeatelier_core_loaded');
    }

    // Create options
    public static function createOptions($id, $args = array())
    {
      self::$args['admin_options'][$id] = $args;
    }

    // Create customize options
    public static function createCustomizeOptions($id, $args = array())
    {
      self::$args['customize_options'][$id] = $args;
    }

    // Create metabox options
    public static function createMetabox($id, $args = array())
    {
      self::$args['metabox_options'][$id] = $args;
    }

    // Create menu options
    public static function createNavMenuOptions($id, $args = array())
    {
      self::$args['nav_menu_options'][$id] = $args;
    }

    // Create shortcoder options
    public static function createShortcoder($id, $args = array())
    {
      self::$args['shortcode_options'][$id] = $args;
    }

    // Create taxonomy options
    public static function createTaxonomyOptions($id, $args = array())
    {
      self::$args['taxonomy_options'][$id] = $args;
    }

    // Create profile options
    public static function createProfileOptions($id, $args = array())
    {
      self::$args['profile_options'][$id] = $args;
    }

    // Create widget
    public static function createWidget($id, $args = array())
    {
      self::$args['widget_options'][$id] = $args;
      self::set_used_fields($args);
    }

    // Create comment metabox
    public static function createCommentMetabox($id, $args = array())
    {
      self::$args['comment_options'][$id] = $args;
    }

    // Create section
    public static function createSection($id, $sections)
    {
      self::$args['sections'][$id][] = $sections;
      self::set_used_fields($sections);
    }

    // Set directory constants
    public static function constants()
    {

      // We need this path-finder code for set URL of framework
      $dirname        = str_replace('//', '/', wp_normalize_path(dirname(dirname(self::$file))));
      $theme_dir      = str_replace('//', '/', wp_normalize_path(get_parent_theme_file_path()));
      $plugin_dir     = str_replace('//', '/', wp_normalize_path(WP_PLUGIN_DIR));
      $plugin_dir     = str_replace('/opt/bitnami', '/bitnami', $plugin_dir);
      $located_plugin = (preg_match('#' . self::sanitize_dirname($plugin_dir) . '#', self::sanitize_dirname($dirname))) ? true : false;
      $directory      = ($located_plugin) ? $plugin_dir : $theme_dir;
      $directory_uri  = ($located_plugin) ? WP_PLUGIN_URL : get_parent_theme_file_uri();
      $foldername     = str_replace($directory, '', $dirname);
      $protocol_uri   = (is_ssl()) ? 'https' : 'http';
      $directory_uri  = set_url_scheme($directory_uri, $protocol_uri);

      self::$dir = $dirname;
      self::$url = $directory_uri . $foldername;
    }

    // Include file helper
    public static function include_plugin_file($file, $load = true)
    {

      $path     = '';
      $file     = ltrim($file, '/');
      $override = apply_filters('THEMEATELIER_CORE_override', 'themeatelier-core-override');

      if (file_exists(get_parent_theme_file_path($override . '/' . $file))) {
        $path = get_parent_theme_file_path($override . '/' . $file);
      } elseif (file_exists(get_theme_file_path($override . '/' . $file))) {
        $path = get_theme_file_path($override . '/' . $file);
      } elseif (file_exists(self::$dir . '/' . $override . '/' . $file)) {
        $path = self::$dir . '/' . $override . '/' . $file;
      } elseif (file_exists(self::$dir . '/' . $file)) {
        $path = self::$dir . '/' . $file;
      }

      if (! empty($path) && ! empty($file) && $load) {

        global $wp_query;

        if (is_object($wp_query) && function_exists('load_template')) {

          load_template($path, true);
        } else {

          require_once($path);
        }
      } else {

        return self::$dir . '/' . $file;
      }
    }

    // Is active plugin helper
    public static function is_active_plugin($file = '')
    {
      return in_array($file, (array) get_option('active_plugins', array()));
    }

    // Sanitize dirname
    public static function sanitize_dirname($dirname)
    {
      return preg_replace('/[^A-Za-z]/', '', $dirname);
    }

    // Set url constant
    public static function include_plugin_url($file)
    {
      return esc_url(self::$url) . '/' . ltrim($file, '/');
    }

    // Include files
    public static function includes()
    {

      // Include common functions
      self::include_plugin_file('functions/actions.php');
      self::include_plugin_file('functions/helpers.php');
      self::include_plugin_file('functions/sanitize.php');
      self::include_plugin_file('functions/validate.php');

      // Include free version classes
      self::include_plugin_file('Classes/abstract.class.php');
      self::include_plugin_file('Classes/fields.class.php');
      self::include_plugin_file('Classes/THEMEATELIER_CORE_Options.php');
      self::include_plugin_file('Classes/THEMEATELIER_CORE_Metabox.php');

      // Include all framework fields
      $fields = apply_filters('THEMEATELIER_CORE_fields', array(
        'accordion',
        'background',
        'backup',
        'border',
        'button_set',
        'callback',
        'checkbox',
        'code_editor',
        'color',
        'color_group',
        'content',
        'date',
        'datetime',
        'dimensions',
        'fieldset',
        'gallery',
        'group',
        'heading',
        'icon',
        'image_select',
        'layout_preset',
        'link',
        'link_color',
        'map',
        'media',
        'notice',
        'number',
        'palette',
        'radio',
        'repeater',
        'section_tab',
        'select',
        'shortcode',
        'slider',
        'sortable',
        'sorter',
        'spacing',
        'spinner',
        'subheading',
        'submessage',
        'switcher',
        'tabbed',
        'text',
        'textarea',
        'typography',
        'upload',
        'wp_editor',
      ));

      if (! empty($fields)) {
        foreach ($fields as $field) {
          if (! class_exists('Themeatelier_Core_Field_' . $field) && class_exists('Themeatelier_Core_Fields')) {
            self::include_plugin_file('fields/' . $field . '/' . $field . '.php');
          }
        }
      }
    }

    // Set all of used fields
    public static function set_used_fields($sections)
    {

      if (! empty($sections['fields'])) {

        foreach ($sections['fields'] as $field) {

          if (! empty($field['fields'])) {
            self::set_used_fields($field);
          }

          if (! empty($field['tabs'])) {
            self::set_used_fields(array('fields' => $field['tabs']));
          }



          if (! empty($field['accordions'])) {
            self::set_used_fields(array('fields' => $field['accordions']));
          }

          if (! empty($field['elements'])) {
            self::set_used_fields(array('fields' => $field['elements']));
          }

          if (! empty($field['type'])) {
            self::$fields[$field['type']] = $field;
          }
        }
      }
    }

    // Enqueue admin and fields styles and scripts
    public static function add_admin_enqueue_scripts()
    {

      if (! self::$enqueue) {

        // Loads scripts and styles only when needed
        $wpscreen = get_current_screen();

        if (! empty(self::$args['admin_options'])) {
          foreach (self::$args['admin_options'] as $argument) {
            if (substr($wpscreen->id, -strlen($argument['menu_slug'])) === $argument['menu_slug']) {
              self::$enqueue = true;
            }
          }
        }

        if (! empty(self::$args['metabox_options'])) {
          foreach (self::$args['metabox_options'] as $argument) {
            if (in_array($wpscreen->post_type, (array) $argument['post_type'])) {
              self::$enqueue = true;
            }
          }
        }

        if (! empty(self::$args['taxonomy_options'])) {
          foreach (self::$args['taxonomy_options'] as $argument) {
            if (in_array($wpscreen->taxonomy, (array) $argument['taxonomy'])) {
              self::$enqueue = true;
            }
          }
        }

        if (! empty(self::$shortcode_instances)) {
          foreach (self::$shortcode_instances as $argument) {
            if (($argument['show_in_editor'] && $wpscreen->base === 'post') || $argument['show_in_custom']) {
              self::$enqueue = true;
            }
          }
        }

        if (! empty(self::$args['widget_options']) && ($wpscreen->id === 'widgets' || $wpscreen->id === 'customize')) {
          self::$enqueue = true;
        }

        if (! empty(self::$args['customize_options']) && $wpscreen->id === 'customize') {
          self::$enqueue = true;
        }

        if (! empty(self::$args['nav_menu_options']) && $wpscreen->id === 'nav-menus') {
          self::$enqueue = true;
        }

        if (! empty(self::$args['profile_options']) && ($wpscreen->id === 'profile' || $wpscreen->id === 'user-edit')) {
          self::$enqueue = true;
        }

        if (! empty(self::$args['comment_options']) && $wpscreen->id === 'comment') {
          self::$enqueue = true;
        }

        if ($wpscreen->id === 'tools_page_themeatelier-core-welcome') {
          self::$enqueue = true;
        }
      }

      if (! apply_filters('THEMEATELIER_CORE_enqueue_assets', self::$enqueue)) {
        return;
      }

      // Admin utilities
      wp_enqueue_media();

      // Wp color picker
      wp_enqueue_style('wp-color-picker');
      wp_enqueue_style('icofont');

      wp_enqueue_script('wp-color-picker');

      // Check for developer mode
      $min = (self::$premium && SCRIPT_DEBUG) ? '' : '.min';

      // Main style
      wp_enqueue_style('themeatelier-core', self::include_plugin_url('assets/css/style' . $min . '.css'), array(), self::$version, 'all');

      // Main RTL styles
      if (is_rtl()) {
        wp_enqueue_style('themeatelier-core-rtl', self::include_plugin_url('assets/css/style-rtl' . $min . '.css'), array(), self::$version, 'all');
      }

      // Custom style
      wp_enqueue_style('taf-custom', self::include_plugin_url('assets/css/taf-custom' . $min . '.css'), array(), self::$version, 'all');

      // Main scripts
      wp_enqueue_script('themeatelier-core-plugins', self::include_plugin_url('assets/js/plugins' . $min . '.js'), array(), self::$version, true);
      wp_enqueue_script('themeatelier-core', self::include_plugin_url('assets/js/main' . $min . '.js'), array('themeatelier-core-plugins'), self::$version, true);

      // Main variables
      wp_localize_script('themeatelier-core', 'THEMEATELIER_CORE_vars', array(
        'color_palette'     => apply_filters('THEMEATELIER_CORE_color_palette', array()),
        'i18n'              => array(
          'confirm'         => esc_html__('Are you sure?', 'themeatelier-core'),
          'typing_text'     => esc_html__('Please enter %s or more characters', 'themeatelier-core'),
          'searching_text'  => esc_html__('Searching...', 'themeatelier-core'),
          'no_results_text' => esc_html__('No results found.', 'themeatelier-core'),
        ),
      ));

      // Enqueue fields scripts and styles
      $enqueued = array();

      if (! empty(self::$fields)) {
        foreach (self::$fields as $field) {
          if (! empty($field['type'])) {
            $classname = 'Themeatelier_Core_Field_' . $field['type'];
            if (class_exists($classname) && method_exists($classname, 'enqueue')) {
              $instance = new $classname($field);
              if (method_exists($classname, 'enqueue')) {
                $instance->enqueue();
              }
              unset($instance);
            }
          }
        }
      }

      do_action('THEMEATELIER_CORE_enqueue');
    }

    // Add typography enqueue styles to front page
    public static function add_typography_enqueue_styles()
    {

      if (! empty(self::$webfonts)) {

        if (! empty(self::$webfonts['enqueue'])) {

          $query = array();
          $fonts = array();

          foreach (self::$webfonts['enqueue'] as $family => $styles) {
            $fonts[] = $family . ((! empty($styles)) ? ':' . implode(',', $styles) : '');
          }

          if (! empty($fonts)) {
            $query['family'] = implode('%7C', $fonts);
          }

          if (! empty(self::$subsets)) {
            $query['subset'] = implode(',', self::$subsets);
          }

          $query['display'] = 'swap';

          wp_enqueue_style('themeatelier-core-google-web-fonts', esc_url(add_query_arg($query, '//fonts.googleapis.com/css')), array(), null);
        }

        if (! empty(self::$webfonts['async'])) {

          $fonts = array();

          foreach (self::$webfonts['async'] as $family => $styles) {
            $fonts[] = $family . ((! empty($styles)) ? ':' . implode(',', $styles) : '');
          }

          wp_enqueue_script('themeatelier-core-google-web-fonts', esc_url('//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js'), array(), null);

          wp_localize_script('themeatelier-core-google-web-fonts', 'WebFontConfig', array('google' => array('families' => $fonts)));
        }
      }
    }

    // Add admin body class
    public static function add_admin_body_class($classes)
    {

      if (apply_filters('THEMEATELIER_CORE_fa4', false)) {
        $classes .= 'themeatelier-core-fa5-shims';
      }

      return $classes;
    }

    // Add custom css to front page
    public static function add_custom_css()
    {

      if (! empty(self::$css)) {
        echo '<style type="text/css">' . wp_kses_post(wp_strip_all_tags(self::$css)) . '</style>';
      }
    }

    // Add a new framework field
    public static function field($field = array(), $value = '', $unique = '', $where = '', $parent = '')
    {

      // Check for unallow fields
      if (! empty($field['_notice'])) {

        $field_type = $field['type'];

        $field            = array();
        $field['content'] = esc_html__('Oops! Not allowed.', 'themeatelier-core') . ' <strong>(' . esc_html($field_type) . ')</strong>';
        $field['type']    = 'notice';
        $field['style']   = 'danger';
      }

      $depend     = '';
      $visible    = '';
      $unique     = (! empty($unique)) ? $unique : '';
      $class      = (! empty($field['class'])) ? ' ' . esc_attr($field['class']) : '';
      $is_pseudo  = (! empty($field['pseudo'])) ? ' themeatelier-core-pseudo-field' : '';
      $field_type = (! empty($field['type'])) ? esc_attr($field['type']) : '';

      if (! empty($field['dependency'])) {

        $dependency      = $field['dependency'];
        $depend_visible  = '';
        $data_controller = '';
        $data_condition  = '';
        $data_value      = '';
        $data_global     = '';

        if (is_array($dependency[0])) {
          $data_controller = implode('|', array_column($dependency, 0));
          $data_condition  = implode('|', array_column($dependency, 1));
          $data_value      = implode('|', array_column($dependency, 2));
          $data_global     = implode('|', array_column($dependency, 3));
          $depend_visible  = implode('|', array_column($dependency, 4));
        } else {
          $data_controller = (! empty($dependency[0])) ? $dependency[0] : '';
          $data_condition  = (! empty($dependency[1])) ? $dependency[1] : '';
          $data_value      = (! empty($dependency[2])) ? $dependency[2] : '';
          $data_global     = (! empty($dependency[3])) ? $dependency[3] : '';
          $depend_visible  = (! empty($dependency[4])) ? $dependency[4] : '';
        }

        $depend .= ' data-controller="' . esc_attr($data_controller) . '"';
        $depend .= ' data-condition="' . esc_attr($data_condition) . '"';
        $depend .= ' data-value="' . esc_attr($data_value) . '"';
        $depend .= (! empty($data_global)) ? ' data-depend-global="true"' : '';

        $visible = (! empty($depend_visible)) ? ' themeatelier-core-depend-visible' : ' themeatelier-core-depend-hidden';
      }

      // These attributes has been sanitized above.
      echo '<div class="themeatelier-core-field themeatelier-core-field-' . esc_attr($field_type . $is_pseudo . $class . $visible) . '"' . wp_kses_post($depend) . '>';

      if (! empty($field_type)) {

        if (! empty($field['title'])) {
          $subtitle = (! empty($field['subtitle'])) ? '<p class="themeatelier-core-text-subtitle">' . $field['subtitle'] . '</p>' : '';
          $title_help = (! empty($field['title_help'])) ? '<span class="themeatelier-core-help themeatelier-core-title-help"><span class="themeatelier-core-help-text">' . $field['title_help'] . '</span> <span class="tooltip-icon"><img src="' . self::include_plugin_url('assets/images/info.svg') . '"></span></span>' : '';
          echo wp_kses_post('<div class="themeatelier-core-title"><h4>' . $field['title'] . $title_help . '</h4>' . $subtitle . '</div>');
        }

        echo (! empty($field['title'])) ? '<div class="themeatelier-core-fieldset">' : '';

        $value = (! isset($value) && isset($field['default'])) ? $field['default'] : $value;
        $value = (isset($field['value'])) ? $field['value'] : $value;

        $classname = 'Themeatelier_Core_Field_' . $field_type;

        if (class_exists($classname)) {
          $instance = new $classname($field, $value, $unique, $where, $parent);
          $instance->render();
        } else {
          echo '<p>' . esc_html__('Field not found!', 'themeatelier-core') . '</p>';
        }
      } else {
        echo '<p>' . esc_html__('Field not found!', 'themeatelier-core') . '</p>';
      }

      echo (! empty($field['title'])) ? '</div>' : '';
      echo '<div class="clear"></div>';
      echo '</div>';
    }
  }
}

THEMEATELIER_CORE::init(__FILE__);
