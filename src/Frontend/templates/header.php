<?php
  $item_logo = isset($options['item_logo']['url']) ? $options['item_logo']['url'] : '';
  $change_nav_menu = isset($options['change_nav_menu']) ? $options['change_nav_menu'] : '';
  $select_nav_menu = isset($options['select_nav_menu']) ? $options['select_nav_menu'] : '';
  ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="<?php echo esc_url($item_logo); ?>">
 
  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-P44ZGX9');
  </script>
  <!-- End Google Tag Manager -->
  <?php wp_head(); ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P44ZGX9"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</head>

<body <?php body_class(); ?>>

  <header class="cwp-header" style="z-index: 99" id="menu">
    <nav class="container flex flex-wrap items-center justify-between gap-2">
      <div class="items-center lg:flex">
        <div class="site-branding flex gap-1.5 items-center">
          <figure class="pr-2 border-r border-solid border-border-color">
            <a href="<?php echo site_url(); ?>">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/themeatelier-icon.svg" class="w-10 h-10" alt="">
            </a>
          </figure>
          <figure>
            <a href="<?php esc_url(get_the_permalink()); ?>">
              <img src="<?php echo esc_url($item_logo); ?>" class="object-contain w-10 h-10" alt="">
            </a>
          </figure>
        </div>
      </div>
      <button id="menu-button" type="button" class="inline-flex items-center ml-auto lg:hidden">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
        </svg>
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
      <div class="flex w-full ml-auto lg:flex lg:w-auto">

        <?php
        if ($change_nav_menu) {
          wp_nav_menu(array(
            'menu'           => $select_nav_menu,
            'menu_class'     => '',
            'container'      => false,
            'fallback_cb'    => '__return_false',
            'walker'         => new Custom_Nav_Walker(),
          ));
        }
        ?>
      </div>
    </nav>
  </header>
  <!--====== Header section end ======-->